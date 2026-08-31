<?php

namespace App\Http\Controllers;

use App\Models\kategori_mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    //

    public function index (){
        return view('master_data.kategori_mitra.index');
    }

    public function create(){
        return view('master_data.kategori_mitra.create');
    }
    public function edit($id)
    {
        $kategori = kategori_mitra::findOrFail($id);

        return view('master_data.kategori_mitra.edit', compact('kategori'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
       $validated = $request->validate([

        'nama_kategori' => [
            'required',
            'string',
            'max:255',
            'unique:kategori_mitra,nama_kategori',
        ],

        // Karena input type="color", ini sudah aman
        'warna_peta' => [
            'required',
            'string',
            'size:7',
            'starts_with:#',
        ],

        'keterangan' => [
            'nullable',
            'string',
            'max:500',
        ],

    ], [

        'nama_kategori.required' => 'Nama kategori wajib diisi.',
        'nama_kategori.unique'   => 'Nama kategori ini sudah terdaftar.',

        'warna_peta.required'    => 'Warna peta wajib dipilih.',
        'warna_peta.size'        => 'Format warna tidak valid.',
        'warna_peta.starts_with' => 'Format warna harus HEX. Contoh: #FF0000',

        'keterangan.max'         => 'Keterangan maksimal 500 karakter.',

    ]);

        DB::beginTransaction();
        try {
            // 2. Simpan Data
            kategori_mitra::create([
                'nama_kategori' => $request->nama_kategori,
                'warna_peta'    => $request->warna_peta,
                'keterangan'    => $request->keterangan,
            ]);

            DB::commit();

            // 3. Redirect dengan pesan sukses
            return redirect()
                ->route('master-data.kategori_mitra.index')
                ->with('success', 'Kategori mitra berhasil ditambahkan!');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error("Gagal tambah kategori: " . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'payload' => $request->all()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function getData()
    {
        $query = kategori_mitra::query()->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('warna_peta', function ($row) {
                // Menampilkan preview warna peta dalam bentuk lingkaran kecil
                return '
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="rounded-circle border shadow-sm"
                             style="background-color: ' . $row->warna_peta . '; width: 25px; height: 25px;"
                             data-bs-toggle="tooltip"
                             title="' . $row->warna_peta . '">
                        </div>
                    </div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-2">';

                // Tombol Edit
                $btn .= '<a href="' . route('master-data.kategori_mitra.edit', $row->id) . '"
                            class="btn btn-sm btn-warning"
                            data-bs-toggle="tooltip"
                            title="Edit Kategori">
                            <i class="ti ti-edit"></i>
                         </a>';

                // Tombol Delete (Memicu script btn-delete di blade)
                $btn .= '<button type="button"
                            class="btn btn-sm btn-danger btn-delete"
                            data-id="' . $row->id . '"
                            data-nama="' . $row->nama_kategori . '"
                            data-bs-toggle="tooltip"
                            title="Hapus Kategori">
                            <i class="ti ti-trash"></i>
                         </button>';

                $btn .= '</div>';
                return $btn;
            })
            ->editColumn('keterangan', function ($row) {
                return $row->keterangan ?? '<span class="text-muted italic">Tidak ada keterangan</span>';
            })
            ->rawColumns(['warna_peta', 'action', 'keterangan'])
            ->make(true);
    }
    public function update(Request $request, $id)
    {
        $kategori = kategori_mitra::findOrFail($id);
        $validated = $request->validate([

            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                'unique:kategori_mitra,nama_kategori,' . $kategori->id,
            ],

            'warna_peta' => [
                'required',
                'string',
                'size:7',
                'starts_with:#',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:500',
            ],

        ], [

            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori ini sudah terdaftar.',

            'warna_peta.required'    => 'Warna peta wajib dipilih.',
            'warna_peta.size'        => 'Format warna tidak valid.',
            'warna_peta.starts_with' => 'Format warna harus HEX.',

            'keterangan.max'         => 'Keterangan maksimal 500 karakter.',
        ]);


        DB::beginTransaction();

        try {
            $kategori->update([
                'nama_kategori' => $validated['nama_kategori'],
                'warna_peta'    => strtoupper($validated['warna_peta']),
                'keterangan'    => $validated['keterangan'],
            ]);
            DB::commit();
            return redirect()
                ->route('master-data.kategori_mitra.index')
                ->with('success', 'Kategori mitra berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update kategori mitra', [
                'error'   => $e->getMessage(),
                'user_id' => Auth::id(),
                'id'      => $id,
            ]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem.');
        }
    }

     public function destroy($id)
    {
        DB::beginTransaction();
        try {

            $kategori = kategori_mitra::findOrFail($id);

            if ($kategori->partners()->exists()) {
                return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh beberapa data mitra.');
            }
            $kategori->delete();

            DB::commit();

            return back()->with('success', 'Kategori mitra berhasil dihapus dari sistem.');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Gagal hapus kategori mitra', [
                'id'      => $id,
                'error'   => $e->getMessage(),
                'line'    => $e->getLine(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Gagal menghapus data. Terjadi kendala teknis pada server.');
        }
    }


}
