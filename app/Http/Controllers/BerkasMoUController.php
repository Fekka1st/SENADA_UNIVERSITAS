<?php

namespace App\Http\Controllers;

use App\Models\berkas_mou;
use App\Models\Data_MoU;
use App\Models\file_berkas_mou;
use App\Models\mitra;
use App\Models\RencanaKerjasama;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BerkasMoUController extends Controller
{

    public function index()
    {
        return view('kerjasama.berkas_mou.index');
    }


    public function getData()
    {
        $query = Data_MoU::with(['mitra', 'user'])->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('mitra_nama', function ($row) {
                return $row->mitra->nama_mitra ?? '-';
            })
            ->addColumn('masa_berlaku', function ($row) {
                $tglMulai = $row->tanggal_mulai->format('d/m/Y');
                $tglSelesai = $row->tanggal_berakhir->format('d/m/Y');
                return '<small class="fw-bold">'.$tglMulai.'</small> s/d <small class="fw-bold">'.$tglSelesai.'</small>';
            })
            ->editColumn('nomor_berkas_mou', function ($row) {
                // Jika nomor MoU masih kosong, tampilkan badge keterangan
                if (empty($row->nomor_berkas_mou)) {
                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.75rem;"><i class="ti ti-clock-hour-4 me-1"></i>Menunggu Register</span>';
                }
                return '<span class="fw-bold text-dark">' . $row->nomor_berkas_mou . '</span>';
            })
            ->editColumn('status_mou', function ($row) {
                // Logic auto-expired jika status aktif (1) tapi tanggalnya sudah lewat
                $isExpired = now()->gt($row->tanggal_berakhir);

                if ($row->status_mou == 0) {
                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Menunggu Approve</span>';
                }

                if ($row->status_mou == 2 || $isExpired) {
                    return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Expired</span>';
                }

                return '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Aktif</span>';
            })
            ->addColumn('action', function ($row) {
            $user = auth()->user();
            $btn = '<div class="d-flex justify-content-center align-items-center gap-2">';

            if ($user->role == 4) {
                $btn .= '<a href="'.route('berkas-MoU.show', $row->id).'" class="btn btn-sm btn-info text-white shadow-sm d-inline-flex align-items-center text-nowrap" title="Lihat Detail">
                            <i class="ti ti-eye me-1 fs-6"></i> Detail
                        </a>';

                if ($row->status_mou == 3) {
                    $btn .= '<a href="'.route('berkas-MoU.edit', $row->id).'" class="btn btn-sm btn-warning text-white shadow-sm d-inline-flex align-items-center" title="Edit Revisi">
                                <i class="ti ti-edit fs-6"></i>
                            </a>';
                    $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete shadow-sm d-inline-flex align-items-center" data-id="'.$row->id.'" data-judul="'.$row->judul_mou.'" title="Hapus Pengajuan">
                                <i class="ti ti-trash fs-6"></i>
                            </button>';
                }
            }
            elseif (in_array($user->role, [1, 2])) {
                $btn .= '<a href="'.route('berkas-MoU.show', $row->id).'" class="btn btn-sm btn-info text-white shadow-sm d-inline-flex align-items-center text-nowrap" title="Review Dokumen">
                            <i class="ti ti-file-search me-1 fs-6"></i> Review
                        </a>';
            }

            $btn .= '</div>';
            return $btn;
        })
            ->rawColumns(['masa_berlaku', 'status_mou', 'action','nomor_berkas_mou'])
            ->make(true);
    }

    /**
     * Form Registrasi MoU Baru (Hanya Admin)
     */
    public function create(Request $request)
    {
        $mitras = Mitra::orderBy('nama_mitra', 'asc')->get();
        $rencanaSource = null;
        if ($request->has('rencana_id')) {
            $rencanaSource = RencanaKerjasama::with(['mitra', 'user.prodi'])->findOrFail($request->rencana_id);
        }
        return view('kerjasama.berkas_mou.create', compact('mitras', 'rencanaSource'));
    }

    /**
     * Simpan Data MoU
     */
    public function store(Request $request)
    {
        $request->validate([
            'rencana_id'          => 'nullable|exists:pengajuan_rencana,id',
            'mitra_id'            => 'required|exists:mitra,id',

            'judul_mou'           => 'required|string|max:255',
            'usulan_durasi_tahun' => 'required|integer', // Tambahan validasi usulan

            // Dibuat nullable, diisi nanti saat finalisasi dokumen fisik
            'tanggal_mulai'       => 'nullable|date',
            'tanggal_berakhir'    => 'nullable|date|after_or_equal:tanggal_mulai',

            'kode_berkas'         => 'nullable|string|max:50',
            'deskripsi'           => 'nullable|string',

            // Validasi Multiple Files
            'file_mou'            => 'required|array|min:1|max:5',
            'file_mou.*'          => 'required|mimes:pdf|max:10240',
        ], [
            'file_mou.max'        => 'Maksimal lampiran yang diperbolehkan adalah 5 file.',
            'file_mou.*.mimes'    => 'Seluruh lampiran wajib berformat PDF.',
            'file_mou.*.max'      => 'Ukuran masing-masing file maksimal 10MB.'
        ]);

        DB::beginTransaction();
        try {
            $mou = berkas_mou::create([
                'user_id'             => auth()->id(),
                'rencana_id' => $request->rencana_id,
                'mitra_id'            => $request->mitra_id,

                'judul_mou'           => $request->judul_mou,
                'kode_berkas'         => $request->kode_berkas,
                'usulan_durasi_tahun' => $request->usulan_durasi_tahun,

                'tanggal_mulai'       => $request->tanggal_mulai,
                'tanggal_berakhir'    => $request->tanggal_berakhir,
                'deskripsi_singkat'   => $request->deskripsi,

                'status_mou'          => 0,
                'pejabat_penandatangan'=> null,
                'file_mou_final'      => null,
                'catatan_admin'       => null,
            ]);

            // 3. Proses Upload Multiple Files
            if ($request->hasFile('file_mou')) {
                foreach ($request->file('file_mou') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension    = $file->getClientOriginalExtension();
                    $size         = $file->getSize();

                    $path = $file->store('kerjasama/mou', 'public');

                    file_berkas_mou::create([
                        'registrasimou_id' => $mou->id,
                        'nama_file'        => $originalName,
                        'file_path'        => $path,
                        'type_file'        => $extension,
                        'size'             => $size,
                    ]);
                }
            }
            DB::commit();

            return redirect()->route('berkas-MoU.index')->with('success', 'Draf dokumen MoU berhasil diregistrasi dan Menunggu Finalisasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Store MoU Error: " . $e->getMessage() . " di baris " . $e->getLine());
            return back()->withInput()->with('error', 'Gagal menyimpan data MoU: Terjadi kesalahan sistem.');
        }
    }

    public function show($id)
    {
        $mou = berkas_mou::with([
            'mitra',
            'user',
            'rencana.user.prodi',
            'files'
        ])->findOrFail($id);
        return view('kerjasama.berkas_mou.detail', compact('mou'));
    }

    public function edit($id)
    {
        $mou = berkas_mou::with(['mitra', 'rencana.user.prodi', 'files'])->findOrFail($id);
        $mitras = Mitra::orderBy('nama_mitra', 'asc')->get();
        return view('kerjasama.berkas_mou.edit', compact('mou', 'mitras'));
    }


    public function update(Request $request, $id)
    {
        $mou = berkas_mou::with('files')->findOrFail($id);

        $request->validate([
            'mitra_id'            => 'required|exists:mitra,id',
            'judul_mou'           => 'required|string|max:255',
            'usulan_durasi_tahun' => 'required|integer',
            'tanggal_mulai'       => 'nullable|date',
            'tanggal_berakhir'    => 'nullable|date|after_or_equal:tanggal_mulai',
            'kode_berkas'         => 'nullable|string|max:50',
            'deskripsi'           => 'nullable|string',

            // Validasi File Baru
            'file_mou'            => 'nullable|array|max:5',
            'file_mou.*'          => 'mimes:pdf|max:10240',

            // Validasi File Lama yang akan dihapus
            'hapus_file_lama'     => 'nullable|array',
            'hapus_file_lama.*'   => 'exists:file_registrasi_mou,id'
        ], [
            'file_mou.max'        => 'Maksimal total lampiran tambahan adalah 5 file.',
            'file_mou.*.mimes'    => 'Seluruh lampiran wajib berformat PDF.',
            'file_mou.*.max'      => 'Ukuran masing-masing file baru maksimal 10MB.'
        ]);

        DB::beginTransaction();
        try {
            // Siapkan data update utama
            $dataUpdate = [
                'mitra_id'            => $request->mitra_id,
                'judul_mou'           => $request->judul_mou,
                'kode_berkas'         => $request->kode_berkas,
                'usulan_durasi_tahun' => $request->usulan_durasi_tahun,
                'deskripsi_singkat'   => $request->deskripsi,
            ];
            if ($mou->status_mou == 3) {
                $dataUpdate['status_mou'] = 0;
            }
            $mou->update($dataUpdate);

            if ($request->has('hapus_file_lama')) {
                foreach ($request->hapus_file_lama as $fileId) {
                    $fileLama = file_berkas_mou::where('registrasimou_id', $mou->id)->find($fileId);
                    if ($fileLama) {
                        Storage::disk('public')->delete($fileLama->file_path);
                        $fileLama->delete();
                    }
                }
            }

            // 2. PROSES TAMBAH FILE BARU (Jika Ada)
            if ($request->hasFile('file_mou')) {
                foreach ($request->file('file_mou') as $file) {
                    $path = $file->store('kerjasama/mou', 'public');
                    file_berkas_mou::create([
                        'registrasimou_id' => $mou->id, // Pastikan foreign key ini sesuai DB kamu
                        'nama_file'         => $file->getClientOriginalName(),
                        'file_path'         => $path,
                        'type_file'         => $file->getClientOriginalExtension(),
                        'size'              => $file->getSize(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('berkas-MoU.show', $mou->id)->with('success', 'Data dokumen MoU berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Update MoU Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data MoU: Terjadi kesalahan sistem.');
        }
    }

    /**
     * Menghapus Data MoU beserta semua file lampirannya
     */
    public function destroy($id)
    {
        // 1. Cari data MoU beserta relasi file-nya
        $mou = berkas_mou::with('files')->findOrFail($id);

        DB::beginTransaction();
        try {
            // 2. Bersihkan File Fisik di Storage Server
            if ($mou->files->isNotEmpty()) {
                foreach ($mou->files as $file) {
                    // Hapus file PDF-nya dari folder storage/app/public/kerjasama/mou
                    Storage::disk('public')->delete($file->file_path);
                    // Hapus record file tersebut dari tabel database
                    $file->delete();
                }
            }
            // 3. Hapus Record Utama MoU
            $mou->delete();
            DB::commit();
            return redirect()->route('data-mou.index')->with('success', 'Dokumen MoU beserta seluruh lampirannya berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Delete MoU Error: " . $e->getMessage() . " pada baris " . $e->getLine());
            return back()->with('error', 'Gagal menghapus dokumen MoU: Terjadi kesalahan sistem.');
        }
    }


    public function updateFeedback(Request $request, $id)
    {
        $mou = berkas_mou::findOrFail($id);

        $rules = [
            'status_mou'    => 'required|in:1,3',
            'catatan_admin' => 'required|string',
        ];

        if ($request->status_mou == 1) {
            $rules['nomor_berkas_mou']      = 'required|string|max:100';
            $rules['pejabat_penandatangan'] = 'required|string|max:150';
            if (empty($mou->file_mou_final)) {
                $rules['file_mou_final']    = 'required|file|mimes:pdf|max:10240';
            } else {
                $rules['file_mou_final']    = 'nullable|file|mimes:pdf|max:10240';
            }
        }

        $request->validate($rules, [
            'file_mou_final.required' => 'File final MoU wajib diunggah untuk tahap finalisasi.',
            'file_mou_final.mimes'    => 'File final MoU harus berformat PDF.',
            'file_mou_final.max'      => 'Ukuran file final maksimal 10MB.',
        ]);

        DB::beginTransaction();
        try {
            $dataUpdate = [
                'status_mou'    => $request->status_mou,
                'catatan_admin' => $request->catatan_admin,
            ];

            if ($request->status_mou == 1) {
                $sekarang = Carbon::now();
                $durasiTahun = (int) $mou->usulan_durasi_tahun ?: 5;
                $berakhir = $sekarang->copy()->addYears($durasiTahun)->toDateString();

                $dataUpdate['tanggal_mulai']         = $sekarang->toDateString();
                $dataUpdate['tanggal_berakhir']      = $berakhir;
                $dataUpdate['nomor_berkas_mou']      = $request->nomor_berkas_mou;
                $dataUpdate['pejabat_penandatangan'] = $request->pejabat_penandatangan;

                if ($request->hasFile('file_mou_final')) {
                    if ($mou->file_mou_final && Storage::disk('public')->exists($mou->file_mou_final)) {
                        Storage::disk('public')->delete($mou->file_mou_final);
                    }
                    $path = $request->file('file_mou_final')->store('kerjasama/mou_final', 'public');
                    $dataUpdate['file_mou_final'] = $path;
                }
            }
            else {
                $dataUpdate['tanggal_mulai']         = null;
                $dataUpdate['tanggal_berakhir']      = null;
                $dataUpdate['nomor_berkas_mou']      = null;
                $dataUpdate['pejabat_penandatangan'] = null;

                if ($mou->file_mou_final && Storage::disk('public')->exists($mou->file_mou_final)) {
                    Storage::disk('public')->delete($mou->file_mou_final);
                    $dataUpdate['file_mou_final'] = null;
                }
            }

            $mou->update($dataUpdate);

            DB::commit();

            $pesan = $request->status_mou == 1
                ? 'Dokumen MoU berhasil difinalisasi dan diterbitkan secara resmi.'
                : 'Dokumen dikembalikan ke Prodi dengan catatan revisi.';

            return back()->with('success', $pesan);

        } catch (\Exception $e) {
           DB::rollBack();
           Log::error("Update Feedback MoU Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses dokumen.');
        }
    }

    public function viewFile($id)
    {
        $file = file_berkas_mou::findOrFail($id);
        $path = storage_path('app/public/' . $file->file_path);
        if (!file_exists($path)) {
            return back()->with('error', 'Mohon maaf, file fisik tidak ditemukan atau telah terhapus dari server.');
        }
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function viewFileFinal($id)
{
    $mou = berkas_mou::findOrFail($id);
    $path = storage_path('app/public/' . $mou->file_mou_final);

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
    ]);
}


}
