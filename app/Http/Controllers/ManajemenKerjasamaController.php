<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\jenis_dokumen;
use App\Models\kerjasama;
use App\Models\KerjasamaFile;
use App\Models\mitra;
use App\Models\prodi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ManajemenKerjasamaController extends Controller
{
    public function index()
    {
        return view('manajemen-kerjasama.index');
    }

    public function getData(Request $request)
    {
        $query = Kerjasama::with(['mitra.kategori'])->select('kerja_sama.*');
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('dokumen_info', function ($row) {
                return '<div class="fw-bold text-dark">' . $row->kode_dokumen . '</div>' .
                       '<small class="text-muted">' . str()->limit($row->perihal, 50) . '</small>';
            })
            ->addColumn('mitra_nama', function ($row) {
                return $row->mitra->nama_mitra ?? '-';
            })
            ->editColumn('masa_berlaku', function ($row) {
                $start = Carbon::parse($row->tanggal_mulai)->format('d/m/Y');
                $end = Carbon::parse($row->tanggal_selesai)->format('d/m/Y');
                return '<small class="d-block">' . $start . ' s/d</small><span class="fw-bold">' . $end . '</span>';
            })
            ->addColumn('status_label', function ($row) {
                $today = Carbon::today();
                $expirationDate = Carbon::parse($row->tanggal_selesai);
                $diffDays = $today->diffInDays($expirationDate, false);
                if ($diffDays < 0) {
                    return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Expired</span>';
                } elseif ($diffDays <= 30) {
                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3">Expiring Soon</span>';
                } else {
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">Active</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group border rounded-1 overflow-hidden shadow-sm">';
                $btn .= '<a href="' . route('Manajemen-Kerjasama.show', $row->id) . '" class="btn btn-white btn-sm border-0"><i class="ti ti-eye text-info"></i></a>';
                $btn .= '<a href="' . route('Manajemen-Kerjasama.edit', $row->id) . '" class="btn btn-white btn-sm border-0"><i class="ti ti-edit text-warning"></i></a>';
                $btn .= '<button type="button" class="btn btn-white btn-sm border-0 btn-delete" data-id="' . $row->id . '" data-nomor="' . $row->nomor_dokumen . '"><i class="ti ti-trash text-danger"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('tgl_upload', function ($row) {
                return '<div class="text-dark small">' .
                    Carbon::parse($row->created_at)->translatedFormat('d M Y') .
                    '</div><small class="text-muted" style="font-size: 10px;">Pukul ' .
                    $row->created_at->format('H:i') . ' WIB</small>';
            })
            ->rawColumns(['dokumen_info', 'tgl_upload','masa_berlaku', 'status_label', 'action'])
            ->make(true);
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user->fakultas_id) {
            return back()->with('error', 'Akun Anda tidak terhubung dengan Fakultas manapun. Hub Admin Pusat');
        }

        $mitras = Mitra::orderBy('nama_mitra', 'asc')->get();
        $jenisDokumens = jenis_dokumen::all();
        $prodis = Prodi::where('fakultas_id', $user->fakultas_id)
                        ->orderBy('nama_prodi', 'asc')
                        ->get();

        $namaFakultas = $user->fakultas->nama_fakultas ?? 'Fakultas Tidak Terdefinisi';

        return view('Manajemen-Kerjasama.create', compact('mitras', 'jenisDokumens', 'prodis', 'namaFakultas'));
    }

    // public function getProdiByFakultas($fakultasId)
    // {
    //     $prodi = prodi::where('fakultas_id', $fakultasId)->get();
    //     return response()->json($prodi);
    // }

    public function getNextNomor($jenisId)
    {
        try {
            $jenisDoc = jenis_dokumen::findOrFail($jenisId);
            $kodeJenis = $jenisDoc->kode_inisial; // Misal: MoU
            $bulan = date('m');
            $tahun = date('Y');
            $lastDoc = Kerjasama::where('jenis_id', $jenisId)
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastDoc) {
                $parts = explode('/', $lastDoc->kode_dokumen);
                $lastNumber = intval(end($parts));
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $noUrut = str_pad($newNumber, 3, '0', STR_PAD_LEFT);
            $resultKode = "{$kodeJenis}/{$bulan}/{$tahun}/{$noUrut}";

            return response()->json([
                'status' => 'success',
                'kode' => $resultKode
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'mitra_id'         => 'required|exists:mitra,id',
            'jenis_dokumen_id' => 'required|exists:jenis_dokumen,id',
            'judul_kerjasama'  => 'required|string|max:255',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'prodi_id'         => 'required|exists:prodi,id',
            'deskripsi'        => 'nullable|string',
            'file_dokumen'     => 'required|array|min:1|max:10',
            'file_dokumen.*'   => 'file|mimes:pdf|max:5120',
        ], [
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh mendahului tanggal mulai.',
            'file_dokumen.*.max' => 'Ukuran file PDF tidak boleh lebih dari 5MB.',
        ]);
        $uploadedFiles = [];
        return DB::transaction(function () use ($request, &$uploadedFiles) {
            try {
                $user = auth::user();
                $now = Carbon::now();
                $jenisDoc = jenis_dokumen::lockForUpdate()->findOrFail($request->jenis_dokumen_id);
                $kodeJenis = $jenisDoc->kode_inisial;

                // Cari nomor terakhir di bulan dan tahun ini
                $lastDoc = Kerjasama::where('jenis_id', $request->jenis_dokumen_id)
                    ->whereYear('created_at', $now->year)
                    ->whereMonth('created_at', $now->month)
                    ->latest('id')
                    ->first();
                $nextNumber = 1;
                if ($lastDoc) {
                    $lastSequence = intval(substr($lastDoc->kode_dokumen, -3));
                    $nextNumber = $lastSequence + 1;
                }
                $kodeDokumenFinal = sprintf("%s/%02d/%d/%03d",
                    $kodeJenis,
                    $now->month,
                    $now->year,
                    $nextNumber
                );
                $status = ($request->action === 'pending') ? 1 : 0;
                $kerjasama = Kerjasama::create([
                    'mitra_id'         => $request->mitra_id,
                    'kode_dokumen'     => $kodeDokumenFinal,
                    'jenis_id'         => $request->jenis_dokumen_id,
                    'judul_kerjasama'  => $request->judul_kerjasama,
                    'tanggal_mulai'    => $request->tanggal_mulai,
                    'tanggal_selesai'  => $request->tanggal_selesai,
                    'prodi_id'         => $request->prodi_id,
                    'fakultas_id'      => $user->fakultas_id, // Terkunci otomatis dari User
                    'deskripsi'        => $request->deskripsi,
                    'status_kerjasama' => $status,
                    'nama_pengajuan'   => $user->id,
                ]);

                // 4. PROSES MULTI-UPLOAD FILE
                if ($request->hasFile('file_dokumen')) {
                    foreach ($request->file('file_dokumen') as $file) {
                        $originalName = $file->getClientOriginalName();
                        // Nama file aman: timestamp_random_slug.pdf
                        $safeName = time() . '_' . str()->random(8) . '.pdf';
                        // Simpan ke private storage (local)
                        $folderPath = "kerjasama/" . $now->year . "/" . $now->month;
                        $path = $file->storeAs($folderPath, $safeName, 'local');
                        // Catat path untuk keperluan cleanup jika error
                        $uploadedFiles[] = $path;
                        // Simpan ke tabel kerja_sama_file
                        $kerjasama->files()->create([
                            'nama_file' => $originalName,
                            'file_path' => $path,
                            'type_file' => $file->getClientMimeType(),
                            'size' => $file->getSize(),
                        ]);
                    }
                }

                $successMsg = ($status == 1)
                    ? "Dokumen <strong>$kodeDokumenFinal</strong> berhasil diajukan ke Universitas."
                    : "Draft kerjasama berhasil disimpan.";

                return redirect()->route('Manajemen-Kerjasama.index')->with('success', $successMsg);

            } catch (\Exception $e) {
                foreach ($uploadedFiles as $path) {
                    Storage::disk('local')->delete($path);
                }
                Log::error("Store Kerjasama Error: " . $e->getMessage(), [
                    'user_id' => auth::id(),
                    'request' => $request->all()
                ]);

                dd($e);

                // return back()->withInput()->with('error', 'Gagal memproses data. Silakan coba lagi.');
            }
        });
    }
}
