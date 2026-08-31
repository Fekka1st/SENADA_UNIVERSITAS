<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class FakultasController extends Controller
{
    //
    public function index (){
        return view('master_data.daftar_fakultas.index');
    }

     public function create(){
        return view('master_data.daftar_fakultas.create');
    }

    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);

        return view('master_data.daftar_fakultas.edit', compact('fakultas'));
    }

    public function detail_prodi($fakultas_id){
        $fakultas = fakultas::find($fakultas_id);
        return view('master_data.daftar_fakultas.detail',compact('fakultas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_fakultas' => [
                'required',
                'string',
                'max:255',
                'unique:fakultas,nama_fakultas', // Memastikan tidak ada nama fakultas ganda
            ],
            'akreditasi' => [
                'required',
                'string',
                'in:A,B,C,Unggul,Baik Sekali,Baik', // Opsional: Membatasi pilihan akreditasi
            ],
        ], [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'nama_fakultas.unique'   => 'Nama fakultas ini sudah terdaftar.',
            'akreditasi.required'    => 'Status akreditasi wajib dipilih.',
            'akreditasi.in'          => 'Pilihan akreditasi tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            Fakultas::create([
                'nama_fakultas' => $request->nama_fakultas,
                'akreditasi_fakultas'    => $request->akreditasi,
            ]);
            DB::commit();
            return redirect()
                ->route('master-data.daftar_fakultas.index')
                ->with('success', 'Data fakultas berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal tambah fakultas: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'payload' => $request->all()
            ]);
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    public function getData()
    {
        $query = Fakultas::withCount('prodis')->latest();

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
            ->addColumn('jumlah_prodi', function ($row) {
                return '<span class="badge rounded-pill bg-primary">' . $row->prodis_count . ' Prodi</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';

                // Tombol Detail Prodi (Ikon Saja)
                $btn .= '<a href="' . route('master-data.daftar_fakultas.detail', ['fakultas_id' => $row->id]) . '"
                            class="btn btn-sm btn-outline-primary d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;"
                            data-bs-toggle="tooltip"
                            title="Lihat Daftar Prodi">
                            <i class="ti ti-list-details"></i>
                        </a>';

                // Tombol Edit
                $btn .= '<a href="' . route('master-data.daftar_fakultas.edit', $row->id) . '"
                            class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;"
                            data-bs-toggle="tooltip"
                            title="Edit Fakultas">
                            <i class="ti ti-edit"></i>
                        </a>';

                // Tombol Hapus
                $btn .= '<button type="button"
                            class="btn btn-sm btn-danger btn-delete d-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;"
                            data-id="' . $row->id . '"
                            data-nama="' . $row->nama_fakultas . '"
                            data-bs-toggle="tooltip"
                            title="Hapus Fakultas">
                            <i class="ti ti-trash"></i>
                        </button>';

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['akreditasi', 'jumlah_prodi', 'action'])
            ->make(true);
    }


    public function update(Request $request, $id)
    {
        $fakultas = Fakultas::findOrFail($id);

        $validated = $request->validate([
            'nama_fakultas' => [
                'required',
                'string',
                'max:255',
                'unique:fakultas,nama_fakultas,' . $fakultas->id, // Abaikan ID sendiri saat cek unique
            ],
            'akreditasi' => [
                'required',
                'string',
                'in:A,B,C,Unggul,Baik Sekali,Baik',
            ],
        ], [
            'nama_fakultas.required' => 'Nama fakultas wajib diisi.',
            'nama_fakultas.unique'   => 'Nama fakultas ini sudah terdaftar.',
            'akreditasi.required'    => 'Status akreditasi wajib dipilih.',
        ]);

        DB::beginTransaction();
        try {
            $fakultas->update([
                'nama_fakultas' => $validated['nama_fakultas'],
                'akreditasi_fakultas'    => $validated['akreditasi'],
            ]);

            DB::commit();

            return redirect()
                ->route('master-data.daftar_fakultas.index')
                ->with('success', 'Data fakultas berhasil diperbarui!');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal update fakultas', [
                'error'   => $e->getMessage(),
                'user_id' => Auth::id(),
                'id'      => $id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan sistem saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $fakultas = Fakultas::findOrFail($id);

            if ($fakultas->prodis()->exists()) {
                return back()->with('error', 'Fakultas tidak dapat dihapus karena masih memiliki Program Studi aktif.');
            }

            if ($fakultas->users()->exists()) {
                return back()->with('error', 'Fakultas tidak dapat dihapus karena masih terhubung dengan data User/Operator.');
            }

            if ($fakultas->kerjaSamas()->exists()) {
                return back()->with('error', 'Fakultas tidak dapat dihapus karena terdapat data Kerja Sama yang tercatat.');
            }

            $fakultas->delete();

            DB::commit();
            return back()->with('success', 'Data fakultas berhasil dihapus dari sistem.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal hapus fakultas', [
                'id'      => $id,
                'error'   => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return back()->with('error', 'Gagal menghapus data karena kendala teknis.');
        }
    }

}
