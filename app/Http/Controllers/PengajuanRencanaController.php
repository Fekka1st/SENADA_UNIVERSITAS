<?php

namespace App\Http\Controllers;

use App\Models\FileRencanaKerjasama;
use App\Models\mitra;
use App\Models\RencanaKerjasama;
use App\Models\RuangLingkup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PengajuanRencanaController extends Controller
{
    //
    public function index()
    {
        return view('rencana_kerjasama.index');
    }

    public function getData()
    {
        $user = auth()->user();

        // Memanggil fungsi berdasarkan role
        return match ((int) $user->role) {
            4       => $this->prodi_data($user), // Role Prodi
            default => $this->admin_data($user), // Role Admin/Biro/Lainnya
        };
    }

    /**
     * Logika DataTables untuk Admin / Universitas
     */
    private function admin_data($user)
    {
        // Admin melihat semua data yang masuk (biasanya yang statusnya bukan draft)
        $query = RencanaKerjasama::with(['mitra', 'user.prodi'])->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('mitra_nama', fn($row) => $row->mitra->nama_mitra ?? '-')
            ->editColumn('status', fn($row) => $this->formatStatus($row->status))
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';
                // Tombol Review (Secara fungsi sama dengan Detail, tapi label beda untuk UX Admin)
                $btn .= '<a href="'.route('rencana-kerjasama.show', $row->id).'" class="btn btn-sm btn-primary shadow-sm" title="Review Pengajuan">
                            <i class="ti ti-checklist me-1"></i> Review
                        </a>';
                // // Jika sudah disetujui dan belum ada MoU, Admin bisa langsung klik Registrasi (Opsional)
                // if ($row->status == 2 && !$row->registrasi_mou_exists) {
                //     $btn .= '<a href="'.route('berkas-MoU.create', ['rencana_id' => $row->id]).'" class="btn btn-sm btn-success shadow-sm">
                //                 <i class="ti ti-file-certificate"></i> Buat MoU
                //             </a>';
                // }
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    /**
     * Logika DataTables untuk Unit / Prodi
     */
    private function prodi_data($user)
    {
        // Prodi hanya melihat milik sendiri
        $query = RencanaKerjasama::with(['mitra', 'user.prodi'])
            ->where('prodi_id', $user->prodi_id)
            ->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('mitra_nama', fn($row) => $row->mitra->nama_mitra ?? '-')
            ->editColumn('status', fn($row) => $this->formatStatus($row->status))
            ->addColumn('action', function ($row) {
    $btn = '<div class="d-flex justify-content-center align-items-center gap-2">';

    // Tombol Detail
    $btn .= '<a href="'.route('rencana-kerjasama.show', $row->id).'" class="btn btn-sm btn-info text-white shadow-sm d-inline-flex align-items-center text-nowrap" title="Lihat Detail">
                <i class="ti ti-eye me-1 fs-6"></i> Detail
             </a>';

    // Edit & Hapus
    if (in_array($row->status, [0, 4])) {
        $btn .= '<a href="'.route('rencana-kerjasama.edit', $row->id).'" class="btn btn-sm btn-warning text-white shadow-sm d-inline-flex align-items-center" title="Edit">
                    <i class="ti ti-edit fs-6"></i>
                 </a>';
        $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete shadow-sm d-inline-flex align-items-center" data-id="'.$row->id.'" title="Hapus">
                    <i class="ti ti-trash fs-6"></i>
                 </button>';
    }

    // Tombol MoU
    if ($row->status == 2) {
        if ($row->mou) {
            $btn .= '<a href="'.route('berkas-MoU.show', $row->mou->id).'" class="btn btn-sm btn-primary text-white shadow-sm d-inline-flex align-items-center text-nowrap" title="Lihat Detail MoU">
                        <i class="ti ti-certificate me-1 fs-6"></i> Lihat MoU
                     </a>';
        } else {
            $btn .= '<a href="'.route('berkas-MoU.create', ['rencana_id' => $row->id]).'" class="btn btn-sm btn-success text-white shadow-sm d-inline-flex align-items-center text-nowrap" title="Tindak Lanjuti ke MoU">
                        <i class="ti ti-file-plus me-1 fs-6"></i> Buat MoU
                     </a>';
        }
    }

    $btn .= '</div>';
    return $btn;
})
            ->rawColumns(['status', 'action'])
            ->make(true);
    }




    public function upadatefeedback(Request $request, $id)
    {
        if (auth()->user()->role == 5) {
            abort(403, 'Akses Ditolak. Anda tidak memiliki wewenang untuk memverifikasi dokumen.');
        }

        $request->validate([
            // Hanya izinkan angka 2 (Setuju), 3 (Tolak), atau 4 (Revisi)
            'status' => 'required|in:2,3,4',
            'feedback_internal' => 'string',
        ], [
            'status.in' => 'Tindakan sistem tidak valid.',
            'feedback_internal.required' => 'Catatan/alasan verifikasi wajib diisi untuk pihak pengaju.',
        ]);
        $rencana = RencanaKerjasama::findOrFail($id);
        $rencana->update([
            'status' => $request->status,
            'feedback_internal' => $request->feedback_internal,
        ]);

        $pesanSukses = match ((string) $request->status) {
            '2' => 'Kerja bagus! Rencana kerjasama telah DISETUJUI.',
            '3' => 'Rencana kerjasama telah DITOLAK. Pesan telah diteruskan ke pihak pengaju.',
            '4' => 'Dokumen dikembalikan ke pengaju untuk direvisi.',
            default => 'Status pengajuan berhasil diperbarui.'
        };

        // 6. Kembalikan Admin ke halaman detail dengan alert sukses
        return redirect()->route('rencana-kerjasama.show', $id)->with('success', $pesanSukses);
    }


    public function create()
    {
        $mitras = mitra::orderBy('nama_mitra', 'asc')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama_ruanglingkup','asc')->get();
        return view('rencana_kerjasama.create', compact('mitras','ruangLingkups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mitra_id' => 'required|exists:mitra,id',
            'judul_rencana' => 'required|string|max:255',
            'deskripsi' => 'required',
            'file_dokumen.*' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:5120', // Max 5MB per file
        ]);

        DB::beginTransaction();
        try {
            $rencana = RencanaKerjasama::create([
                'mitra_id' => $request->mitra_id,
                'user_id' => Auth::user()->id,
                'prodi_id' => Auth::user()->prodi_id,
                'fakultas_id' => Auth::user()->fakultas_id,
                'ruanglingkup_id' => $request->ruanglingkup_id,
                'judul_rencana' => $request->judul_rencana,
                'deskripsi' => $request->deskripsi,
                'status' => 1 , // Langsung ke Proses Review
            ]);

            // Handle Multiple Files
           if ($request->hasFile('file_dokumen')) {
                foreach ($request->file('file_dokumen') as $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $path = $file->store('rencana_kerjasama/lampiran', 'public');
                    FileRencanaKerjasama::create([
                        'pengajuanrencana_id' => $rencana->id, // Foreign Key
                        'nama_file' => $originalName,
                        'file_path' => $path,
                        'type_file' => $extension, // Hasil: pdf / docx / jpg
                        'size'      => $size,      // Hasil: integer (bytes)
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('rencana-kerjasama.index')->with('success', 'Rencana kerjasama berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            Log::error("Store Rencana Error: " . $e->getMessage());
            // return back()->withInput()->with('error', 'Gagal menyimpan rencana.');
        }
    }

    public function show($id)
    {
        // Ambil data beserta semua relasi yang dibutuhkan
        $rencana = RencanaKerjasama::with([
            'mitra.kategori',
            'ruangLingkup',
            'files',
            'user.prodi',
            'user.fakultas'
        ])->findOrFail($id);

        // Logic Security: Hanya pemilik atau Admin yang bisa lihat
        if (auth()->user()->role_id == 5 && $rencana->prodi_id != auth()->user()->prodi_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen prodi lain.');
        }

        return view('rencana_kerjasama.detail', compact('rencana'));
    }

    public function updateFeedback(Request $request, $id)
    {
        // Khusus Role Admin/Biro untuk memberikan catatan menarik/tidak
        $request->validate([
            'feedback_internal' => 'required|string',
            'status' => 'required|in:2,3' // 2: Setuju, 3: Tolak
        ]);

        $rencana = RencanaKerjasama::findOrFail($id);
        $rencana->update([
            'feedback_internal' => $request->feedback_internal,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Feedback berhasil dikirim.');
    }

    public function destroy($id)
    {
        $rencana = RencanaKerjasama::findOrFail($id);

        DB::beginTransaction();
        try {
            // Hapus file fisik dari storage
            foreach ($rencana->files as $file) {
                Storage::disk('public')->delete($file->file_path);
            }

            $rencana->files()->delete(); // Hapus record di DB
            $rencana->delete();

            DB::commit();
            return back()->with('success', 'Rencana kerjasama berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data.');
        }
    }


    /**
     * Tampilkan Form Edit
     */
    public function edit($id)
    {
        $rencana = RencanaKerjasama::with(['files'])->findOrFail($id);

        // Security: Pastikan Prodi hanya mengedit miliknya sendiri
        if (auth()->user()->role == 5 && $rencana->prodi_id != auth()->user()->prodi_id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Validasi Status: Hanya Draft (0) atau Perlu Revisi (4) yang boleh diedit
        if (!in_array($rencana->status, [0, 4, 'draft'])) {
            return redirect()->route('rencana-kerjasama.index')
                ->with('error', 'Dokumen ini sedang diproses atau sudah final dan tidak dapat diedit.');
        }

        $mitras = Mitra::orderBy('nama_mitra', 'asc')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama_ruanglingkup', 'asc')->get();

        return view('rencana_kerjasama.edit', compact('rencana', 'mitras', 'ruangLingkups'));
    }

    /**
     * Proses Update Data
     */
    public function update(Request $request, $id)
    {
        $rencana = RencanaKerjasama::with('files')->findOrFail($id);

        if (auth()->user()->role == 5 && $rencana->prodi_id != auth()->user()->prodi_id) {
            abort(403);
        }

        $request->validate([
            'judul_rencana'    => 'required|string|max:255',
            'mitra_id'         => 'required|exists:mitra,id',
            'ruanglingkup_id'  => 'required|exists:ruanglingkup,id',
            'deskripsi'        => 'required|string',
            'status'           => 'required|in:draft,proses_review,0,1',
            'file_dokumen.*'   => 'nullable|mimes:pdf|max:5120',
            'hapus_file_lama'  => 'nullable|array'
        ]);

        $statusMap = ['draft' => 0, 'proses_review' => 1];
        $newStatus = is_numeric($request->status) ? $request->status : ($statusMap[$request->status] ?? 0);

        $rencana->update([
            'judul_rencana'   => $request->judul_rencana,
            'mitra_id'        => $request->mitra_id,
            'ruanglingkup_id' => $request->ruanglingkup_id,
            'deskripsi'       => $request->deskripsi,
            'status'          => $newStatus,
        ]);

        if ($request->has('hapus_file_lama')) {
            foreach ($request->hapus_file_lama as $fileId) {
                $fileLama = FileRencanaKerjasama::find($fileId);
                if ($fileLama) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($fileLama->file_path);
                    $fileLama->delete();
                }
            }
        }

        if ($request->hasFile('file_dokumen')) {
            foreach ($request->file('file_dokumen') as $file) {
                $path = $file->store('rencana_kerjasama/lampiran', 'public');
                FileRencanaKerjasama::create([
                    'pengajuanrencana_id' => $rencana->id,
                    'nama_file'           => $file->getClientOriginalName(),
                    'file_path'           => $path,
                    'type_file'           => $file->getClientOriginalExtension(),
                    'size'                => $file->getSize(),
                ]);
            }
        }

        $pesan = $newStatus == 1 ? 'Pengajuan revisi berhasil dikirim ke Admin.' : 'Draft berhasil diperbarui.';
        return redirect()->route('rencana-kerjasama.index')->with('success', $pesan);
    }


    private function formatStatus($status)
    {
        $map = [
            0 => ['text' => 'Draft', 'class' => 'bg-secondary'],
            1 => ['text' => 'Proses Review', 'class' => 'bg-info'],
            2 => ['text' => 'Disetujui', 'class' => 'bg-success'],
            3 => ['text' => 'Ditolak', 'class' => 'bg-danger'],
            4 => ['text' => 'Perlu Revisi', 'class' => 'bg-warning text-dark'],
        ];

        $s = $map[$status] ?? $map[0];
        return '<span class="badge '.$s['class'].' border-0 shadow-sm px-3 rounded-pill">'.$s['text'].'</span>';
    }

    public function viewFile($id)
    {

        $file = FileRencanaKerjasama::with('pengajuanRencana')->findOrFail($id);
        $user = auth()->user();

        if (in_array($user->role, [4, 5])) {
            if ($file->pengajuanRencana->fakultas_id !== $user->fakultas_id) {
                abort(403, 'Akses Ditolak: Anda tidak memiliki izin untuk melihat dokumen dari fakultas lain.');
            }
        }
        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File fisik tidak ditemukan di dalam storage server.');
        }

        $path = Storage::disk('public')->path($file->file_path);

        return response()->file($path, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
