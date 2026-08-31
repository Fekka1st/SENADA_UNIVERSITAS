<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use App\Models\prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProdiController extends Controller
{
    //
    public function index()
    {
        return view('master_data.daftar_prodi.index');
    }

    public function getData(Request $request)
    {
        $query = prodi::with('fakultas')
            ->join('fakultas', 'prodi.fakultas_id', '=', 'fakultas.id')
            ->select('prodi.*', 'fakultas.nama_fakultas as nama_fakultas_tabel');

        // Jika ada fakultas_id, filter berdasarkan fakultas tersebut (untuk halaman detail)
        if ($request->filled('fakultas_id')) {
            $query->where('prodi.fakultas_id', $request->fakultas_id);
        } else {
            // Jika tidak ada filter, urutkan berdasarkan nama fakultas
            $query->orderBy('nama_fakultas', 'ASC')
                  ->orderBy('prodi.nama_prodi', 'ASC');
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('akreditasi', function ($row) {
                $badgeClass = match(strtoupper($row->akreditasi)) {
                    'A', 'UNGGUL' => 'bg-success',
                    'B', 'BAIK SEKALI' => 'bg-info',
                    'C', 'BAIK' => 'bg-secondary',
                    default => 'bg-light text-dark border'
                };
                return '<span class="badge ' . $badgeClass . '">' . $row->akreditasi . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';

                $btn .= '<a href="' . route('master-data.daftar_prodi.edit', $row->id) . '"
                            class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Edit Prodi">
                            <i class="ti ti-edit"></i></a>';

                $btn .= '<button type="button"
                            class="btn btn-sm btn-danger btn-delete d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-id="'.$row->id.'" data-nama="'.$row->nama_prodi.'"
                            data-bs-toggle="tooltip" title="Hapus Prodi">
                            <i class="ti ti-trash"></i></button>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['akreditasi', 'action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();
        $selectedFakultasId = $request->query('fakultas_id');

        return view('master_data.daftar_prodi.create', compact('fakultas', 'selectedFakultasId'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_prodi' => [
                'required',
                'string',
                'max:255',
            ],
            'akreditasi' => [
                'required',
                'string',
                'in:Unggul,A,Baik Sekali,B,Baik,C',
            ],
            'fakultas_id' => [
                'required',
                'exists:fakultas,id',
            ],
        ], [
            'nama_prodi.required'  => 'Nama program studi wajib diisi.',
            'akreditasi.required'   => 'Status akreditasi wajib dipilih.',
            'akreditasi.in'         => 'Pilihan akreditasi tidak valid.',
            'fakultas_id.required'  => 'Fakultas harus dipilih.',
            'fakultas_id.exists'    => 'Fakultas yang dipilih tidak terdaftar di sistem.',
        ]);

        DB::beginTransaction();
        try {

            prodi::create([
                'nama_prodi'  => $request->nama_prodi,
                'akreditasi_prodi'   => $request->akreditasi,
                'fakultas_id'  => $request->fakultas_id,
            ]);

            DB::commit();


            return redirect()
                ->route('master-data.daftar_prodi.index')
                ->with('success', 'Program Studi baru berhasil ditambahkan!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal tambah prodi: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'payload' => $request->except(['_token']),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $fakultas = Fakultas::orderBy('nama_fakultas', 'asc')->get();
        return view('master_data.daftar_prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $prodi = Prodi::findOrFail($id);
        $validated = $request->validate([
            'nama_prodi' => [
                'required',
                'string',
                'max:255',
            ],
            'akreditasi' => [
                'required',
                'string',
                'in:Unggul,A,Baik Sekali,B,Baik,C',
            ],
            'fakultas_id' => [
                'required',
                'exists:fakultas,id',
            ],
        ], [
            'nama_prodi.required'  => 'Nama program studi tidak boleh kosong.',
            'akreditasi.required'   => 'Status akreditasi wajib dipilih.',
            'akreditasi.in'         => 'Pilihan status akreditasi tidak valid.',
            'fakultas_id.required'  => 'Pilihan fakultas wajib diisi.',
            'fakultas_id.exists'    => 'Fakultas yang dipilih tidak valid atau tidak ditemukan.',
        ]);

        DB::beginTransaction();
        try {

            $prodi->update([
                'nama_prodi'  => $request->nama_prodi,
                'akreditasi_prodi'   => $request->akreditasi,
                'fakultas_id'  => $request->fakultas_id,
            ]);

            DB::commit();


            return redirect()
                ->route('master-data.daftar_prodi.index')
                ->with('success', "Data program studi {$prodi->nama_prodi} berhasil diperbarui!");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal update data prodi", [
                'prodi_id' => $id,
                'user_id'  => auth::id(),
                'error'    => $e->getMessage(),
                'payload'  => $request->except(['_token', '_method']),
                'line'     => $e->getLine(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kendala teknis saat memperbarui data. Silakan hubungi administrator.');
        }
    }
}
