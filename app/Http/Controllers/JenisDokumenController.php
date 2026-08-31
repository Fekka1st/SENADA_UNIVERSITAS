<?php

namespace App\Http\Controllers;

use App\Models\jenis_dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class JenisDokumenController extends Controller
{

    public function index()
    {
        return view('master_data.jenis_dokumen.index');
    }

    public function getData()
    {
        $query = jenis_dokumen::query()->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('keterangan', function ($row) {
                return $row->keterangan ?? '<span class="text-muted italic">Tidak ada keterangan</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';
                // Edit
                $btn .= '<a href="' . route('master-data.jenis_dokumen.edit', $row->id) . '"
                            class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Edit Jenis Dokumen">
                            <i class="ti ti-edit"></i></a>';

                // Delete
                $btn .= '<button type="button"
                            class="btn btn-sm btn-danger btn-delete d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;" data-id="'.$row->id.'" data-nama="'.$row->nama_jenis.'"
                            data-bs-toggle="tooltip" title="Hapus Jenis Dokumen">
                            <i class="ti ti-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['keterangan', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('master_data.jenis_dokumen.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis_dokumen,nama_jenis',
            ],
            'kode_inisial' => [
                'required',
                'string',
                'max:10',
                'unique:jenis_dokumen,kode_inisial',
            ],
            'keterangan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'kode_inisial.required' => 'Kode inisial wajib diisi.',
            'kode_inisial.unique'   => 'Kode inisial ini sudah digunakan oleh jenis dokumen lain.',
            'kode_inisial.max'      => 'Kode inisial maksimal 10 karakter (Contoh: MoU).',
            'nama_jenis.required' => 'Nama jenis dokumen wajib diisi.',
            'nama_jenis.unique'   => 'Jenis dokumen ini sudah terdaftar dalam sistem.',
            'keterangan.max'      => 'Keterangan tidak boleh lebih dari 500 karakter.',
        ]);

        DB::beginTransaction();
        try {
            jenis_dokumen::create([
                'kode_inisial' => $request->kode_inisial,
                'nama_jenis' => $request->nama_jenis,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            return redirect()
                ->route('master-data.jenis_dokumen.index')
                ->with('success', 'Jenis dokumen baru berhasil ditambahkan ke database!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal menambahkan jenis dokumen", [
                'user_id' => auth::id(),
                'error'   => $e->getMessage(),
                'payload' => $request->except(['_token']),
                'line'    => $e->getLine(),
                'file'    => $e->getFile()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kendala teknis saat menyimpan data. Silakan coba lagi nanti.');
        }
    }
    public function edit($id)
    {
        $jenisDokumen = jenis_dokumen::findOrFail($id);
        return view('master_data.jenis_dokumen.edit', compact('jenisDokumen'));
    }

    public function update(Request $request, $id)
    {
        $jenisDokumen = jenis_dokumen::findOrFail($id);
        $validated = $request->validate([
            'nama_jenis' => [
                'required',
                'string',
                'max:100',
                'unique:jenis_dokumen,nama_jenis,' . $id,
            ],
            'kode_inisial' => [
                'required',
                'string',
                'max:10',
                'unique:jenis_dokumen,kode_inisial',
            ],
            'keterangan' => [
                'nullable',
                'string',
                'max:500',
            ],
        ], [
            'kode_inisial.required' => 'Kode inisial wajib diisi.',
            'kode_inisial.unique'   => 'Kode inisial ini sudah digunakan oleh jenis dokumen lain.',
            'kode_inisial.max'      => 'Kode inisial maksimal 10 karakter (Contoh: MoU).',
            'nama_jenis.required' => 'Nama jenis dokumen wajib diisi.',
            'nama_jenis.unique'   => 'Nama jenis dokumen ini sudah terdaftar di sistem.',
            'keterangan.max'      => 'Keterangan tidak boleh lebih dari 500 karakter.',
        ]);

        DB::beginTransaction();
        try {
            $jenisDokumen->update([
                'kode_inisial' => $request->kode_inisial,
                'nama_jenis' => $request->nama_jenis,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            return redirect()
                ->route('master-data.jenis_dokumen.index')
                ->with('success', "Jenis dokumen {$jenisDokumen->nama_jenis} berhasil diperbarui!");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal memperbarui jenis dokumen", [
                'id'      => $id,
                'user_id' => auth::id(),
                'error'   => $e->getMessage(),
                'payload' => $request->except(['_token', '_method']),
                'line'    => $e->getLine()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kendala teknis saat memperbarui data. Silakan coba lagi nanti.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $jenisDokumen = jenis_dokumen::findOrFail($id);
            if ($jenisDokumen->kerjaSamas()->exists()) {
                return back()->with('error', "Gagal menghapus! Jenis dokumen '{$jenisDokumen->nama_jenis}' masih digunakan dalam data kerja sama.");
            }
            $jenisDokumen->delete();
            DB::commit();
            return back()->with('success', 'Jenis dokumen berhasil dihapus dari sistem.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal menghapus jenis dokumen", [
                'id'      => $id,
                'user_id' => auth::id(),
                'error'   => $e->getMessage()
            ]);
            return back()->with('error', 'Gagal menghapus data karena kendala teknis pada server.');
        }
    }

}
