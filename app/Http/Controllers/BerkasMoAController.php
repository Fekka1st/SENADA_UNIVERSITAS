<?php

namespace App\Http\Controllers;

use App\Models\berkas_moa;
use App\Models\berkas_mou;
use App\Models\file_berkas_moa;
use App\Models\RuangLingkup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class BerkasMoAController extends Controller
{
    //

    public function index(){
        return view('kerjasama.berkas_moa.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Eager load relasi Mou, Mitra (dari Mou), dan hitung file
            $data = berkas_moa::with(['mou.mitra'])->withCount('files')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('mou_mitra', function($row) {
                    // Menggabungkan nama mitra dan nomor MoU
                    $mitra = $row->mou->mitra->nama_mitra ?? 'Mitra Tidak Ditemukan';
                    $mou = $row->mou->nomor_mou ?? '-';
                    return "<div class='d-flex flex-column'>
                                <span class='fw-bold text-dark text-truncate' style='max-width: 200px;' title='{$mitra}'>{$mitra}</span>
                                <small class='text-muted'><i class='ti ti-link me-1'></i>{$mou}</small>
                            </div>";
                })
                ->addColumn('judul_lengkap', function($row) {
                    $badgeFile = $row->files_count > 0 ? "<span class='badge bg-light text-muted border border-secondary-subtle px-2 py-1 ms-1'><i class='ti ti-paperclip'></i> {$row->files_count}</span>" : "";
                    return "<div class='d-flex flex-column'>
                                <span class='fw-bold text-dark text-truncate' style='max-width: 250px;' title='{$row->judul_moa}'>{$row->judul_moa}</span>
                                <div><span class='badge bg-light text-dark border border-secondary-subtle font-monospace px-2 py-1 mt-1'>{$row->nomor_moa}</span>{$badgeFile}</div>
                            </div>";
                })
                ->addColumn('masa_berlaku', function($row) {
                    $mulai = Carbon::parse($row->tanggal_mulai)->format('d M Y');
                    $akhir = Carbon::parse($row->tanggal_berakhir)->format('d M Y');
                    return "<span class='text-dark small'>{$mulai} - {$akhir}</span>";
                })
                ->addColumn('status_moa', function($row) {
                    $akhir = Carbon::parse($row->tanggal_berakhir)->endOfDay();
                    if (now()->gt($akhir)) {
                        return "<span class='badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1' style='font-size: 10px;'>KEDALUWARSA</span>";
                    }
                    return "<span class='badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1' style='font-size: 10px;'>AKTIF</span>";
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex justify-content-center gap-1">';

                    // Tombol Detail (Semua bisa lihat)
                    $btn .= '<a href="'.route('data-moa.show', $row->id).'" class="btn btn-sm btn-light text-primary hover-bg-primary transition-all rounded-circle" style="width: 32px; height: 32px;" title="Lihat Detail"><i class="ti ti-eye"></i></a>';

                    // Cek Hak Akses Edit/Delete (Asumsi Role 5 = Read Only)
                    if (auth()->user()->role_id != 5) {
                        $btn .= '<a href="'.route('data-moa.edit', $row->id).'" class="btn btn-sm btn-light text-warning hover-bg-warning transition-all rounded-circle" style="width: 32px; height: 32px;" title="Edit Data"><i class="ti ti-edit"></i></a>';
                        $btn .= '<button type="button" class="btn btn-sm btn-light text-danger hover-bg-danger transition-all rounded-circle btn-delete" style="width: 32px; height: 32px;" data-id="'.$row->id.'" data-judul="'.$row->nomor_moa.'" title="Hapus Data"><i class="ti ti-trash"></i></button>';
                    }

                    $btn .= '</div>';
                    return $btn;
                })
                // Izinkan HTML ter-render di kolom-kolom ini
                ->rawColumns(['mou_mitra', 'judul_lengkap', 'masa_berlaku', 'status_moa', 'action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {

        $mous = berkas_mou::with('mitra')->orderBy('nomor_berkas_mou', 'asc')->get();
        $ruangLingkups = RuangLingkup::orderBy('nama_ruanglingkup', 'asc')->get();

        $mouSource = null;
        if ($request->has('mou_id')) {
            // Jika ada parameter mou_id, cari data spesifiknya untuk mengunci form
            $mouSource = berkas_mou::with('mitra')->findOrFail($request->mou_id);
        }

        // 3. Lempar semua data ke view create.blade.php
        return view('kerjasama.berkas_moa.create', compact('mous', 'ruangLingkups', 'mouSource'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Super Ketat)
        $request->validate([
            'mou_id'               => 'required|exists:registrasi_mou,id',
            'ruanglingkup_id'      => 'required|exists:ruanglingkup,id', // Sesuaikan dengan nama tabel mastermu
            'nomor_moa'            => 'required|unique:registrasi_moa,nomor_moa',
            'judul_moa'            => 'required|string|max:255',
            'tanggal_mulai'        => 'required|date',
            'tanggal_berakhir'     => 'required|date|after:tanggal_mulai',
            'nominal_finansial'    => 'nullable|numeric|min:0', // Memastikan tidak ada nilai minus
            'sumber_dana'          => 'nullable|string|max:100',
            'tujuan_moa'           => 'nullable|string',
            'peran_tanggung_jawab' => 'nullable|string',
            'kode_berkas'          => 'nullable|string|max:50',

            // Validasi Multiple Files
            'file_moa'             => 'required|array|min:1|max:5',
            'file_moa.*'           => 'required|mimes:pdf|max:10240', // Wajib PDF, max 10MB per file
        ], [
            // Custom pesan bahasa Indonesia agar ramah user
            'nomor_moa.unique'   => 'Nomor MoA ini sudah pernah diregistrasi di sistem.',
            'file_moa.max'       => 'Maksimal lampiran yang diperbolehkan adalah 5 file.',
            'file_moa.*.mimes'   => 'Seluruh lampiran wajib berformat PDF.',
            'file_moa.*.max'     => 'Ukuran masing-masing file maksimal 10MB.'
        ]);

        DB::beginTransaction();
        try {
            // 2. Simpan Data Teks MoA
            $moa = berkas_moa::create([
                'user_id'              => auth()->id(), // Admin/Prodi yang sedang login
                'mou_id'               => $request->mou_id,
                'ruanglingkup_id'      => $request->ruanglingkup_id,
                'nomor_moa'            => $request->nomor_moa,
                'judul_moa'            => $request->judul_moa,
                'kode_berkas'          => $request->kode_berkas,
                'tanggal_mulai'        => $request->tanggal_mulai,
                'tanggal_berakhir'     => $request->tanggal_berakhir,
                'nominal_finansial'    => $request->nominal_finansial,
                'sumber_dana'          => $request->sumber_dana,
                'tujuan_moa'           => $request->tujuan_moa,
                'peran_tanggung_jawab' => $request->peran_tanggung_jawab,
            ]);

            // 3. Proses Upload Lampiran PDF (Multiple)
            if ($request->hasFile('file_moa')) {
                foreach ($request->file('file_moa') as $file) {
                    // Simpan file ke folder: storage/app/public/kerjasama/moa
                    $path = $file->store('kerjasama/moa', 'public');

                    file_berkas_moa::create([
                        'registrasi_moa_id' => $moa->id,
                        'nama_file'         => $file->getClientOriginalName(),
                        'file_path'         => $path,
                        'type_file'         => $file->getClientOriginalExtension(),
                        'size'              => $file->getSize(),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('data-moa.index')->with('success', 'Dokumen Perjanjian Kerja Sama (MoA) berhasil diregistrasi.');

        } catch (\Exception $e) {
           DB::rollBack();
           Log::error("Store MoA Error: " . $e->getMessage() . " di baris " . $e->getLine());
            return back()->withInput()->with('error', 'Gagal menyimpan data MoA: Terjadi kesalahan pada sistem.');
        }
    }
}
