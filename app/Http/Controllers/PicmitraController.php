<?php

namespace App\Http\Controllers;

use App\Models\mitra;
use App\Models\PicMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PicmitraController extends Controller
{
    //

    public function create($mitra_id){
        $mitra = Mitra::findOrFail($mitra_id);
        return view('manajemen-mitra.pic_mitra.create',compact('mitra'));
    }

    public function edit($id)
    {
        // Eager load mitra untuk menampilkan nama instansi di header
        $pic = PicMitra::with('mitra')->findOrFail($id);
        return view('manajemen-mitra.pic_mitra.edit', compact('pic'));
    }

    public function getData($mitra_id)
    {
        $query = PicMitra::where('mitra_id', $mitra_id)->orderBy('status_pic', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('pic_info', function ($row) {
                return '<div><div class="fw-bold text-dark">'.$row->nama_pic.'</div>'.
                    '<small class="text-muted">'.($row->jabatan ?? 'Staff').'</small></div>';
            })
            ->addColumn('kontak', function ($row) {
                return '<a href="https://wa.me/'.preg_replace('/[^0-9]/', '', $row->no_telp).'" target="_blank" class="text-success fw-bold small text-decoration-none">'.
                    '<i class="ti ti-brand-whatsapp me-1"></i>'.$row->no_telp.'</a>';
            })
            ->editColumn('status', function ($row) {
                if ($row->status_pic == 1) {
                    return '<span class="badge bg-primary-subtle text-primary border-primary border px-3 rounded-pill" style="font-size: 10px;">UTAMA</span>';
                }
                return '<span class="badge bg-light text-muted border px-3 rounded-pill" style="font-size: 10px;">PENDAMPING</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="btn-group border rounded-1 overflow-hidden shadow-sm">';
                $btn .= '<a href="'.route('Pic-Mitra.edit', $row->id).'" class="btn btn-white btn-sm border-0"><i class="ti ti-edit text-warning"></i></a>';
                if ($row->status_pic == 0) {
                    $btn .= '<button type="button" class="btn btn-white btn-sm border-0 btn-delete-pic" data-id="'.$row->id.'" data-nama="'.$row->nama_pic.'"><i class="ti ti-trash text-danger"></i></button>';
                }
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['pic_info', 'kontak', 'status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mitra_id'   => 'required|exists:mitra,id',
            'nama_pic'   => 'required|string|max:150',
            'no_telp'    => 'required|string|max:20',
            'email'      => 'nullable|email|max:100',
            'status_pic' => 'required|in:0,1',
            'jabatan'    => 'nullable|string|max:100',
            'alamat'     => 'nullable|string',
        ], [
            'mitra_id.exists'   => 'Instansi mitra tidak valid atau tidak ditemukan.',
            'nama_pic.required' => 'Nama lengkap personil wajib diisi.',
            'no_telp.required'  => 'Nomor WhatsApp aktif wajib diisi.',
            'status_pic.in'     => 'Status personil harus dipilih antara Utama atau Pendamping.',
        ]);

        return DB::transaction(function () use ($validated) {
            try {
                if ($validated['status_pic'] == 1) {
                    PicMitra::where('mitra_id', $validated['mitra_id'])
                            ->where('status_pic', 1)
                            ->update(['status_pic' => 0]);
                }
                $pic = PicMitra::create($validated);
                return redirect()
                    ->route('Manajemen-Mitra.show', $validated['mitra_id'])
                    ->with('success', "Personil **{$pic->nama_pic}** berhasil didaftarkan sebagai " .
                        ($pic->status_pic == 1 ? 'PIC Utama.' : 'Anggota Pendamping.'));
            } catch (\Exception $e) {
                Log::error("Gagal Simpan Data :  " . $e->getMessage());
                return back()
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan sistem. Gagal menyimpan data personil.');
            }
        });
    }

    public function update(Request $request, $id)
    {
        $pic = PicMitra::findOrFail($id);

        $validated = $request->validate([
            'mitra_id'   => 'required|exists:mitra,id',
            'nama_pic'   => 'required|string|max:150',
            'no_telp'    => 'required|string|max:20',
            'email'      => 'nullable|email|max:100',
            'status_pic' => 'required|in:0,1',
            'jabatan'    => 'nullable|string|max:100',
            'alamat'     => 'nullable|string',
        ], [
            'mitra_id.exists'   => 'Instansi mitra tidak valid atau tidak ditemukan.',
            'nama_pic.required' => 'Nama lengkap personil wajib diisi.',
            'no_telp.required'  => 'Nomor WhatsApp aktif wajib diisi.',
            'status_pic.in'     => 'Status personil harus dipilih antara Utama atau Pendamping.',
        ]);

        return DB::transaction(function () use ($validated, $pic) {
            try {
                if ($validated['status_pic'] == 1 && $pic->status_pic == 0) {
                    PicMitra::where('mitra_id', $pic->mitra_id)
                            ->where('status_pic', 1)
                            ->update(['status_pic' => 0]);
                }
                $pic->update($validated);
                return redirect()
                    ->route('Manajemen-Mitra.show', $pic->mitra_id)
                    ->with('success', "Data personil **{$pic->nama_pic}** berhasil diperbarui.");
            } catch (\Exception $e) {
                Log::error("PIC Update Error: " . $e->getMessage());
                return back()->withInput()->with('error', 'Gagal memperbarui data.');
            }
        });
    }

    public function destroy($id)
    {
        $pic = PicMitra::findOrFail($id);
        $mitraId = $pic->mitra_id;
        $nama = $pic->nama_pic;
        if ($pic->status_pic == 1) {
            return back()->with('error', "Gagal! **{$nama}** adalah PIC Utama. Tentukan PIC Utama baru terlebih dahulu sebelum menghapus personil ini.");
        }
        try {
            $pic->delete();
            return redirect()
                ->route('Manajemen-Mitra.show', $mitraId)
                ->with('success', "Personil **{$nama}** telah berhasil dihapus dari sistem.");
        } catch (\Exception $e) {
            Log::error("PIC Delete Error: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat menghapus data.');
        }
    }
}
