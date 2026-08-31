<?php

namespace App\Http\Controllers;

use App\Models\file_repositorykerjasama;
use App\Models\IndikatorKerja;
use App\Models\jenis_dokumen;
use App\Models\JenisKegiatan;
use App\Models\mitra;
use App\Models\repository_kerjasama;
use App\Models\SasaranKerja;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class RepositoryKerjasamaController extends Controller
{
    //
    public function index(){
        return view('Repository.index');
    }

    public function getData(Request $request)
    {
        $query = repository_kerjasama::with(['pihakTerlibat.mitra', 'jenisDokumen'])
            ->withSum('bentukKegiatan as total_nilai_kontrak', 'nilai_kontrak')
            ->where('fakultas_id', Auth::user()->fakultas_id);
        return DataTables::of($query)
            ->addIndexColumn()
            ->filterColumn('pj_info', function($query, $keyword) {
                $query->whereHas('pihakTerlibat', function($q) use ($keyword) {
                    $q->where('nama_penandatangan', 'like', "%{$keyword}%")
                    ->orWhereHas('mitra', function($m) use ($keyword) {
                        $m->where('nama_mitra', 'like', "%{$keyword}%");
                    });
                });
            })
            ->addColumn('dokumen_info', function ($row) {
                return '<div>
                            <span class="fw-bold text-dark d-block">' . $row->judul_kerjasama . '</span>
                            <small class="text-muted">' . ($row->nomor_dokumen ?? '-') . ' | ' . ($row->jenisDokumen->nama_jenis ?? '') . '</small>
                        </div>';
            })
            ->addColumn('pj_info', function ($row) {
                $pj = $row->pihakTerlibat->where('urutan_pihak', 2)->first() ?? $row->pihakTerlibat->first();

                return '<div>
                            <span class="d-block fw-semibold">' . ($pj->nama_penandatangan ?? '-') . '</span>
                            <small class="text-primary"><i class="ti ti-building-community me-1"></i>' . ($pj->mitra->nama_mitra ?? '-') . '</small>
                        </div>';
            })
            ->addColumn('masa_berlaku', function ($row) {
                $mulai = \Carbon\Carbon::parse($row->tanggal_mulai)->format('d/m/Y');
                $akhir = \Carbon\Carbon::parse($row->tanggal_berakhir)->format('d/m/Y');

                $isWarning = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($row->tanggal_berakhir), false) < 30;
                $color = $isWarning ? 'text-danger fw-bold' : 'text-muted';

                return '<small class="d-block text-muted">Mulai: ' . $mulai . '</small>
                        <small class="d-block ' . $color . '">Selesai: ' . $akhir . '</small>';
            })
            ->addColumn('nilai_kontrak', function ($row) {
                $totalNilai = $row->total_nilai_kontrak ?? 0;
                return '<span class="fw-bold text-dark">Rp ' . number_format($totalNilai, 0, ',', '.') . '</span>';
            })
            ->addColumn('status_label', function ($row) {
                if ($row->status == 1) {
                    return '<span class="badge bg-light-success text-success fw-bold px-3">Aktif</span>';
                }
                return '<span class="badge bg-light-danger text-danger fw-bold px-3">Kadaluarsa</span>';
            })
            ->addColumn('action', function ($row) {
                return '<div class="btn-group shadow-sm">
                            <a href="' . route('Repository_kerjasama.show', $row->id) . '" class="btn btn-sm btn-light border" title="Detail">
                                <i class="ti ti-eye text-primary"></i>
                            </a>
                            <a href="' . route('Repository_kerjasama.edit', $row->id) . '" class="btn btn-sm btn-light border" title="Edit">
                                <i class="ti ti-edit text-warning"></i>
                            </a>
                            <button type="button" class="btn btn-sm btn-light border btn-delete"
                                data-id="' . $row->id . '"
                                data-judul="' . $row->judul_kerjasama . '" title="Hapus">
                                <i class="ti ti-trash text-danger"></i>
                            </button>
                        </div>';
            })
            ->rawColumns(['dokumen_info', 'pj_info', 'masa_berlaku', 'nilai_kontrak', 'status_label', 'action'])
            ->make(true);
    }

    public function create()
    {
        $user = auth()->user();
        $mitras = mitra::orderBy('nama_mitra')->get();
        $jenisDokumens = jenis_dokumen::all();
        $namaFakultas = $user->fakultas->nama_fakultas ?? 'Universitas';

        $jenisKegiatans = JenisKegiatan::orderBy('nama_kegiatan', 'asc')->get();
        $sasaranKerjas = SasaranKerja::orderBy('nama_sasaran', 'asc')->get();

        return view('repository.create', compact(
            'mitras',
            'jenisDokumens',
            'namaFakultas',
            'jenisKegiatans',
            'sasaranKerjas'
        ));
    }

    public function getIndikatorBySasaran($sasaran_id)
    {
        $indikators = IndikatorKerja::where('sasaran_kerja_id', $sasaran_id)
                        ->orderBy('nama_indikator', 'asc')
                        ->get();
        return response()->json($indikators);
    }

    public function store(Request $request)
    {
        // 1. Validasi Super Ketat
        $request->validate([
            // Validasi Tabel Repository (Induk)
            'judul_kerjasama'   => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'jenis_dokumen_id'  => 'required|exists:jenis_dokumen,id',
            'nomor_dokumen'     => 'required|string|max:100|unique:repository_kerjasama,nomor_dokumen',
            'tanggal_mulai'     => 'required|date',
            'tanggal_berakhir'  => 'required|date|after_or_equal:tanggal_mulai',
            'status'            => 'required|in:0,1',

            // Validasi Array Pihak Terlibat (Minimal 1)
            'pihak'                      => 'required|array|min:1',
            'pihak.*.mitra_id'           => 'required|exists:mitra,id',
            'pihak.*.nama_perwakilan'    => 'required|string|max:255',
            'pihak.*.jabatan_perwakilan' => 'required|string|max:255',
            'pihak.*.nama_pic'           => 'nullable|string|max:255',
            'pihak.*.jabatan_pic'        => 'nullable|string|max:255',

            // --- PERUBAHAN: Validasi Array Kegiatan (Memanggil Master Data ID) ---
            'kegiatan'                       => 'required|array|min:1',
            'kegiatan.*.jenis_kegiatan_id'   => 'required|exists:jenis_kegiatan,id',
            'kegiatan.*.sasaran_kerja_id'    => 'required|exists:sasaran_kerja,id',
            'kegiatan.*.indikator_kerja_id'  => 'required|exists:indikator_kerja,id',
            'kegiatan.*.nilai_kontrak'       => 'nullable|numeric|min:0', // Titik/Ribuan sudah dihapus oleh JS sebelum submit
            'kegiatan.*.luaran'              => 'nullable|string',
            'kegiatan.*.keterangan'          => 'nullable|string',

            // Validasi File (Max 5, PDF Only, Max 5MB)
            'file_dokumen'      => 'nullable|array|max:5',
            'file_dokumen.*'    => 'file|mimes:pdf|max:5120',
        ], [
            // Custom Messages agar ramah pengguna (User Experience)
            'pihak.*.mitra_id.required'              => 'Instansi mitra harus dipilih.',
            'kegiatan.*.jenis_kegiatan_id.required'  => 'Jenis bentuk kegiatan wajib dipilih.',
            'kegiatan.*.sasaran_kerja_id.required'   => 'Sasaran kerja wajib dipilih.',
            'kegiatan.*.indikator_kerja_id.required' => 'Indikator kerja wajib dipilih.',
            'file_dokumen.*.mimes'                   => 'Semua lampiran dokumen harus berformat PDF.',
            'tanggal_berakhir.after_or_equal'        => 'Tanggal berakhir tidak boleh mendahului tanggal mulai.'
        ]);

        try {
            // Gunakan Database Transaction agar aman (Jika file gagal upload, data DB di-rollback otomatis)
            return DB::transaction(function () use ($request) {

                $user = auth()->user(); // Penulisan auth yang lebih direkomendasikan Laravel


                $repo = \App\Models\repository_kerjasama::create([
                    'jenis_dokumen_id' => $request->jenis_dokumen_id,
                    'fakultas_id'      => $user->fakultas_id, // Lock otomatis ke fakultas operator
                    'nomor_dokumen'    => $request->nomor_dokumen,
                    'judul_kerjasama'  => $request->judul_kerjasama,
                    'deskripsi'        => $request->deskripsi,
                    'tanggal_mulai'    => $request->tanggal_mulai,
                    'tanggal_berakhir' => $request->tanggal_berakhir,
                    'status'           => $request->status,
                ]);

                // B. Simpan Banyak Pihak (Looping Array)
                foreach ($request->pihak as $index => $p) {
                    $repo->pihakTerlibat()->create([
                        'mitra_id'                => $p['mitra_id'],
                        'urutan_pihak'            => $index + 1, // Cukup simpan 1, 2, 3...
                        'nama_penandatangan'      => $p['nama_perwakilan'],
                        'jabatan_penandatangan'   => $p['jabatan_perwakilan'],
                        'nama_penanggungjawab'    => $p['nama_pic'] ?? null,
                        'jabatan_penanggungjawab' => $p['jabatan_pic'] ?? null,
                    ]);
                }

                // C. --- PERUBAHAN: Simpan Banyak Bentuk Kegiatan (Master Data ID) ---
                foreach ($request->kegiatan as $index => $k) {
                    $repo->bentukKegiatan()->create([
                        // Tidak perlu manual isi repository_kerja_sama_id, karena sudah di-handle oleh relasi create()
                        'jenis_kegiatan_id'  => $k['jenis_kegiatan_id'],
                        'sasaran_kerja_id'   => $k['sasaran_kerja_id'],
                        'indikator_kerja_id' => $k['indikator_kerja_id'],
                        'nilai_kontrak'      => $k['nilai_kontrak'] ?? 0,
                        'luaran'             => $k['luaran'] ?? null,
                        'keterangan'         => $k['keterangan'] ?? null,
                    ]);
                }

                // D. Penanganan Multiple File Upload (Keamanan Tinggi)
                if ($request->hasFile('file_dokumen')) {
                    foreach ($request->file('file_dokumen') as $file) {
                        $originalName = $file->getClientOriginalName();
                        $extension    = $file->getClientOriginalExtension();
                        $fileSize     = $file->getSize();

                        // Simpan ke disk 'local' agar tidak bisa diakses via URL publik tanpa otentikasi
                        // File akan tersimpan di: storage/app/repository/2024/...
                        $path = $file->store('repository/' . date('Y'), 'local');

                        $repo->files()->create([
                            'nama_file' => $originalName,
                            'file_path' => $path,
                            'type_file' => $extension,
                            'size'      => $fileSize,
                        ]);
                    }
                }
                return redirect()->route('Repository_kerjasama.index')
                    ->with('success', 'Arsip kerjasama dan rincian kegiatannya berhasil diregistrasi.');
            });

        } catch (\Exception $e) {
            Log::error('Gagal simpan repository: ' . $e->getMessage() . ' di baris ' . $e->getLine());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $repository = repository_kerjasama::with([
            'jenisDokumen',
            'fakultas',
            'pihakTerlibat.mitra',
            'bentukKegiatan',
            'files'
        ])->findOrFail($id);
        if ($repository->fakultas_id !== Auth::user()->fakultas_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat dokumen ini.');
        }
        foreach ($repository->files as $file) {
            $file->signed_url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'Repository_kerjasama.view-file',
                now()->addMinutes(30),
                ['id' => $file->id]     // Parameter ID file
            );
        }

        return view('Repository.detail', compact('repository'));
    }

    public function edit($id)
    {
        $repository = repository_kerjasama::with(['pihakTerlibat', 'bentukKegiatan', 'files'])->findOrFail($id);
        $user = auth()->user();
        if ($user->role_id > 2 && $repository->fakultas_id !== $user->fakultas_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen kerjasama ini.');
        }
        $mitras = Mitra::orderBy('nama_mitra', 'asc')->get();
        $jenisDokumens = jenis_dokumen::all();

        $jenisKegiatans = JenisKegiatan::orderBy('nama_kegiatan', 'asc')->get();
        $sasaranKerjas = SasaranKerja::orderBy('nama_sasaran', 'asc')->get();
        return view('repository.edit', compact(
            'repository',
            'mitras',
            'jenisDokumens',
            'jenisKegiatans',
            'sasaranKerjas'
        ));
    }


    public function update(Request $request, $id)
    {
        $repository = repository_kerjasama::findOrFail($id);
        $user = auth()->user();

        if ($user->role_id > 2 && $repository->fakultas_id !== $user->fakultas_id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah dokumen kerjasama ini.');
        }

        // 2. Validasi (Sama dengan Store, tapi nomor_dokumen abaikan ID saat ini)
        $request->validate([
            'nomor_dokumen'              => 'required|string|max:100|unique:repository_kerjasama,nomor_dokumen,' . $id,
            'judul_kerjasama'            => 'required|string|max:255',
            'deskripsi'                  => 'nullable|string',
            'jenis_dokumen_id'           => 'required|exists:jenis_dokumen,id',
            'tanggal_mulai'              => 'required|date',
            'tanggal_berakhir'           => 'required|date|after_or_equal:tanggal_mulai',
            'status'                     => 'required|in:0,1',

            // Validasi Array Pihak Terlibat
            'pihak'                      => 'required|array|min:1',
            'pihak.*.mitra_id'           => 'required|exists:mitra,id',
            'pihak.*.nama_perwakilan'    => 'required|string|max:255',
            'pihak.*.jabatan_perwakilan' => 'required|string|max:255',
            'pihak.*.nama_pic'           => 'nullable|string|max:255',
            'pihak.*.jabatan_pic'        => 'nullable|string|max:255',

            // --- PERUBAHAN: Validasi Array Kegiatan (Memanggil Master Data ID) ---
            'kegiatan'                       => 'required|array|min:1',
            'kegiatan.*.jenis_kegiatan_id'   => 'required|exists:jenis_kegiatan,id',
            'kegiatan.*.sasaran_kerja_id'    => 'required|exists:sasaran_kerja,id',
            'kegiatan.*.indikator_kerja_id'  => 'required|exists:indikator_kerja,id',
            'kegiatan.*.nilai_kontrak'       => 'nullable|numeric|min:0', // Titik/Ribuan dihapus via JS
            'kegiatan.*.luaran'              => 'nullable|string',
            'kegiatan.*.keterangan'          => 'nullable|string',

            'file_dokumen.*'                 => 'nullable|file|mimes:pdf|max:5120',
        ], [
            'pihak.*.mitra_id.required'              => 'Instansi mitra harus dipilih.',
            'kegiatan.*.jenis_kegiatan_id.required'  => 'Jenis bentuk kegiatan wajib dipilih.',
            'kegiatan.*.sasaran_kerja_id.required'   => 'Sasaran kerja wajib dipilih.',
            'kegiatan.*.indikator_kerja_id.required' => 'Indikator kerja wajib dipilih.',
            'file_dokumen.*.mimes'                   => 'Lampiran harus berformat PDF.',
        ]);

        try {
            DB::transaction(function () use ($request, $repository) {
                $repository->update($request->only([
                    'jenis_dokumen_id', 'nomor_dokumen', 'judul_kerjasama',
                    'deskripsi', 'tanggal_mulai', 'tanggal_berakhir', 'status'
                ]));

                // B. Sinkronisasi Pihak Terlibat (Delete & Re-create)
                $repository->pihakTerlibat()->delete();
                foreach ($request->pihak as $index => $p) {
                    $repository->pihakTerlibat()->create([
                        'mitra_id'                => $p['mitra_id'],
                        'urutan_pihak'            => $index + 1,
                        'nama_penandatangan'      => $p['nama_perwakilan'],
                        'jabatan_penandatangan'   => $p['jabatan_perwakilan'],
                        'nama_penanggungjawab'    => $p['nama_pic'] ?? null,
                        'jabatan_penanggungjawab' => $p['jabatan_pic'] ?? null,
                    ]);
                }

                // C. --- PERUBAHAN: Sinkronisasi Bentuk Kegiatan (Delete & Re-create) ---
                $repository->bentukKegiatan()->delete();
                foreach ($request->kegiatan as $k) {
                    $repository->bentukKegiatan()->create([
                        'jenis_kegiatan_id'  => $k['jenis_kegiatan_id'],
                        'sasaran_kerja_id'   => $k['sasaran_kerja_id'],
                        'indikator_kerja_id' => $k['indikator_kerja_id'],
                        'nilai_kontrak'      => $k['nilai_kontrak'] ?? 0,
                        'luaran'             => $k['luaran'] ?? null,
                        'keterangan'         => $k['keterangan'] ?? null,
                    ]);
                }

                // D. Hapus File Lama yang dicentang User
                if ($request->has('delete_files')) {
                    foreach ($request->delete_files as $fileId) {
                        $fileEntry = file_repositorykerjasama::find($fileId);
                        if ($fileEntry) {
                            Storage::disk('local')->delete($fileEntry->file_path);
                            $fileEntry->delete();
                        }
                    }
                }

                // E. Upload Tambahan File Baru
                if ($request->hasFile('file_dokumen')) {
                    foreach ($request->file('file_dokumen') as $file) {
                        $path = $file->store('repository/' . date('Y'), 'local');
                        $repository->files()->create([
                            'nama_file' => $file->getClientOriginalName(),
                            'file_path' => $path,
                            'type_file' => $file->getClientOriginalExtension(),
                            'size'      => $file->getSize(),
                        ]);
                    }
                }
            });

            return redirect()->route('Repository_kerjasama.index')
                ->with('success', 'Dokumen kerjasama berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal update repository: ' . $e->getMessage() . ' di baris ' . $e->getLine());
            return back()->withInput()->with('error', 'Gagal memperbarui data: Terjadi kesalahan pada sistem. ' . $e->getMessage());
        }
    }


    public function viewFile($id)
    {
        $file = file_repositorykerjasama::with('repository')->findOrFail($id);

        if ($file->repository->fakultas_id !== auth()->user()->fakultas_id) {
            abort(403);
        }
        if (!\Storage::disk('local')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan di folder storage');
        }

        $path = \Storage::disk('local')->path($file->file_path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function getindikator($id){
        $data = IndikatorKerja::where('sasaran_kerja_id', $id)
                ->select('id', 'nama_indikator')
                ->get();
        return response()->json($data);
    }


    // SIMPAN DULU CODENYA
    // private function view(User $user, RepositoryKerjasama $repository)
    // {
    //     // 1. Role Super Admin atau Pimpinan LLDIKTI boleh lihat SEMUA
    //     if ($user->hasAnyRole(['super-admin', 'pimpinan-lldikti'])) {
    //         return true;
    //     }

    //     // 2. Role Operator Fakultas hanya boleh lihat jika fakultas_id cocok
    //     if ($user->hasRole('operator-fakultas')) {
    //         return $user->fakultas_id === $repository->fakultas_id;
    //     }
                // $this->authorize('view', $file->repository);  ini simpan di main function
    //     return false;
    // }

    public function destroy($id)
    {
        $repository = repository_kerjasama::findOrFail($id);

        if ($repository->files) {
            foreach ($repository->files as $file) {
                // jika ada file fisik, hapus juga dari storage
                // Storage::delete($file->path);
                $file->delete();
            }
        }

        if ($repository->pihakTerlibat) {
            $repository->pihakTerlibat()->delete();
        }

        if ($repository->bentukKegiatan) {
            $repository->bentukKegiatan()->delete();
        }


        $repository->delete();

        return redirect()->back()->with('success', 'Data kerjasama berhasil dihapus');
    }

}
