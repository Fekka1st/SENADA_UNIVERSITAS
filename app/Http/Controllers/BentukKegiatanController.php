<?php

namespace App\Http\Controllers;

use App\Models\BentukKegiatan;
use App\Models\JenisKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Reverb\Loggers\Log;
use Yajra\DataTables\Facades\DataTables;

class BentukKegiatanController extends Controller
{
    //
    public function index(){
        return view('master_data.bentuk_kegiatan.index');
    }

    public function getData()
    {
        $query = JenisKegiatan::query()->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('keterangan', function ($row) {
             return $row->keterangan
                ? $row->keterangan
                : '<span class="text-muted fst-italic">Tidak ada keterangan</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';
                // Tombol Edit
                $btn .= '<a href="' . route('master-data.jenis_kegiatan.edit', $row->id) . '"
                            class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Edit Ruang Lingkup">
                            <i class="ti ti-edit"></i></a>';
                // Tombol Hapus
                $btn .= '<button type="button"
                            class="btn btn-sm btn-danger btn-delete d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-id="'.$row->id.'" data-nama="'.$row->nama_lingkup.'"
                            data-bs-toggle="tooltip" title="Hapus Ruang Lingkup">
                            <i class="ti ti-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['keterangan', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('master_data.bentuk_kegiatan.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_kegiatan' => [
                'required',
                'string',
                'max:150',
                'unique:ruanglingkup,nama_ruanglingkup',
            ],
            'keterangan' => 'nullable|string|max:500',
        ], [
            'nama_kegiatan.required' => 'Nama ruang lingkup wajib diisi.',
            'nama_kegiatan.unique'   => 'Nama ruang lingkup ini sudah ada.',
            'keterangan.max'         => 'Deskripsi maksimal 500 karakter.',
        ]);


        DB::beginTransaction();
        try {
            JenisKegiatan::create($validated);
            DB::commit();

            return redirect()->route('master-data.jenis_kegiatan.index')
                ->with('success', 'Ruang lingkup kerja sama berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal tambah ruang lingkup", [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'payload' => $request->except(['_token'])
            ]);
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $jenisKegiatan = JenisKegiatan::findOrFail($id);
        return view('master_data.jenis_kegiatan.edit', compact('jenisKegiatan'));
    }

    public function update(Request $request, $id)
    {
        $ruangLingkup = JenisKegiatan::findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:150|unique:ruanglingkup,nama_ruanglingkup,' . $id,
            'deskripsi'    => 'nullable|string|max:500',
        ], [
            'nama_kegiatan.required' => 'Nama ruang lingkup tidak boleh kosong.',
            'nama_kegiatan.unique'   => 'Nama ruang lingkup sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            $ruangLingkup->update($validated);
            DB::commit();

            return redirect()->route('master-data.jenis_kegiatan.index')
                ->with('success', "Jenis Kegiatan {$ruangLingkup->nama_lingkup} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal update Jenis Kegiatan", ['id' => $id, 'error' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ruangLingkup = JenisKegiatan::findOrFail($id);
            if ($ruangLingkup->kerjaSamas()->exists()) {
                return back()->with('error', 'Data tidak bisa dihapus karena sudah terikat dengan dokumen kerja sama.');
            }
            $ruangLingkup->delete();
            DB::commit();
            return back()->with('success', 'Jenis Kegiatan berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal hapus Jenis Kegiatan", ['id' => $id, 'error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kendala teknis saat menghapus data.');
        }
    }


}
