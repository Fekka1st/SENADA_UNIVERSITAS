<?php

namespace App\Http\Controllers;

use App\Models\kategori_mitra;
use App\Models\mitra;
use App\Models\PicMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ManajemenMitraController extends Controller
{
    //
    public function index()
    {
        return view('manajemen-mitra.index');
    }

    public function getData()
    {

        $query = Mitra::with(['kategori', 'pics'])->latest();
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('kategori_nama', function ($row) {
                $warna = $row->kategori->warna_peta ?? '#6c757d';
                return '<span class="badge border" style="background-color: '.$warna.'20; color: '.$warna.'; border-color: '.$warna.'40;">'.
                        ($row->kategori->nama_kategori ?? '-').
                    '</span>';
            })
            ->editColumn('url_website', function ($row) {
                if (empty($row->url_website)) {
                    return '<span class="text-muted small"><i>Tidak memiliki website</i></span>';
                }
                return '<a href="'.$row->url_website.'" target="_blank" class="btn btn-xs btn-outline-primary px-2 py-1" style="font-size: 11px;">
                            <i class="ti ti-world me-1"></i> Kunjungi Website
                        </a>';
            })
            ->addColumn('pic_info', function ($row) {
                $picUtama = $row->pics->where('status_pic', 1)->first();
                if (!$picUtama) {
                    return '<span class="text-muted small italic">Belum ada PIC Utama</span>';
                }
                return '<div>
                            <span class="fw-bold">'.$picUtama->nama_pic.'</span>
                            <span class="badge bg-primary-subtle text-primary border-0 ms-1" style="font-size: 10px;">Utama</span><br>
                            <small class="text-muted"><i class="ti ti-phone me-1"></i>'.$picUtama->no_telp.'</small>
                        </div>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex justify-content-center gap-1">';
                // Tombol Detail
                $btn .= '<a href="'.route('Manajemen-Mitra.show', $row->id).'" class="btn btn-sm btn-info text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Lihat Detail & Lokasi"><i class="ti ti-eye"></i></a>';
                // Tombol Edit
                $btn .= '<a href="'.route('Manajemen-Mitra.edit', $row->id).'" class="btn btn-sm btn-warning text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" data-bs-toggle="tooltip" title="Edit Mitra"><i class="ti ti-edit"></i></a>';
                // Tombol Hapus
                $btn .= '<button type="button" class="btn btn-sm btn-danger btn-delete d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" data-id="'.$row->id.'" data-nama="'.$row->nama_mitra.'" data-bs-toggle="tooltip" title="Hapus Mitra"><i class="ti ti-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['kategori_nama', 'url_website','pic_info', 'action'])
            ->make(true);
    }

    public function create(){
        $kategori = kategori_mitra::orderBy('nama_kategori','asc')->get();
        return view('manajemen-mitra.create',compact('kategori'));
    }

    public function store(Request $request)
    {
            $request->validate([
            'nama_mitra'     => 'required|string|max:255|unique:mitra,nama_mitra,',
            'kategori_id'    => 'required|exists:kategori_mitra,id',
            'negara'         => 'required|string',
            'latitude'       => 'required|numeric',
            'longtitude'     => 'required|numeric',
            'nama_pic'       => 'nullable|string|max:50',
            'no_telp'        => 'nullable|string|max:15',
            ], [
            'nama_mitra.required' => 'Nama instansi mitra wajib diisi.',
            'nama_mitra.unique'   => 'Instansi ini sudah terdaftar, silakan gunakan nama lain.',
            'kategori_id.required' => 'Silakan pilih kategori mitra (Pemerintah/Swasta/dll).',
            'kategori_id.exists'   => 'Kategori yang dipilih tidak valid.',
            'negara.required'      => 'Kolom negara tidak boleh kosong.',
            'latitude.required'    => 'Titik lokasi pada peta belum ditentukan.',
            'latitude.numeric'     => 'Koordinat harus berupa angka.',
            'longtitude.required'  => 'Titik lokasi pada peta belum ditentukan.',
            'nama_pic.required'    => 'Nama lengkap PIC wajib diisi untuk keperluan kontak.',
            'no_telp.required'     => 'Nomor WhatsApp/Telepon PIC wajib diisi.',
            'no_telp.max'          => 'Nomor telepon maksimal 15 karakter.',
            'email_pic.email'      => 'Format email PIC tidak valid (contoh: user@mail.com).',
        ]);

        DB::beginTransaction();
        try {
            $mitra = Mitra::create([
                'nama_mitra'     => $request->nama_mitra,
                'kategori_id'    => $request->kategori_id,
                'negara'         => $request->negara,
                'alamat_lengkap' => $request->alamat_lengkap,
                'latitude'       => $request->latitude,
                'longtitude'     => $request->longtitude,
                'url_website'    => $request->website,

            ]);

            if ($request->filled('nama_pic')) {
                PicMitra::create([
                    'mitra_id'   => $mitra->id,
                    'nama_pic'   => $request->nama_pic,
                    'alamat'     => $request->alamat_lengkap,
                    'no_telp'    => $request->no_telp,
                    'jabatan'    => $request->jabatan,
                    'email'      => $request->email_pic,
                    'status_pic' => 1, // Set sebagai PIC Utama
                ]);
            }


            DB::commit();

            return redirect()
                ->route('Manajemen-Mitra.index')
                ->with('success', "Mitra {$mitra->nama_mitra} berhasil ditambahkan ke sistem.");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Mitra Store Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi gangguan pada server. Silakan coba lagi nanti.');
        }
    }

    public function edit($id)
    {
        // Eager load kategori dan pics (khusus yang statusnya utama)
        $mitra = mitra::with(['kategori', 'pics' => function($query) {
            $query->where('status_pic', 1);
        }])->findOrFail($id);

        $kategori = kategori_mitra::all();

        return view('Manajemen-Mitra.edit', compact('mitra', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $mitra = Mitra::findOrFail($id);

        // 1. Validasi Gabungan
        $request->validate([
            'nama_mitra'     => 'required|string|max:255|unique:mitra,nama_mitra,' . $id,
            'kategori_id'    => 'required|exists:kategori_mitra,id',
            'negara'         => 'required|string',
            'latitude'       => 'required|numeric',
            'longtitude'     => 'required|numeric',

            'nama_pic'       => 'required|string|max:50',
            'no_telp'        => 'required|string|max:15',
        ], [
            'nama_mitra.unique' => 'Nama mitra sudah terdaftar, silakan gunakan nama lain.',
            'latitude.required' => 'Titik lokasi pada peta wajib ditentukan.',
        ]);

        // 2. Transaksi Database untuk integritas data
        DB::beginTransaction();
        try {

            $mitra->update([
                'nama_mitra'     => $request->nama_mitra,
                'kategori_id'    => $request->kategori_id,
                'negara'         => $request->negara,
                'url_website'    => $request->url_website,
                'alamat_lengkap' => $request->alamat_lengkap,
                'latitude'       => $request->latitude,
                'longtitude'     => $request->longtitude,
            ]);


            $picUtama = PicMitra::where('mitra_id', $mitra->id)
                                ->where('status_pic', 1)
                                ->first();

            if ($picUtama) {
                $picUtama->update([
                    'nama_pic' => $request->nama_pic,
                    'no_telp'  => $request->no_telp,
                    'jabatan'  => $request->jabatan,
                    'email'    => $request->email_pic,
                    'alamat'   => $request->alamat_lengkap,
                ]);
            } else {

                PicMitra::create([
                    'mitra_id'   => $mitra->id,
                    'nama_pic'   => $request->nama_pic,
                    'no_telp'    => $request->no_telp,
                    'status_pic' => 1,
                ]);
            }

            DB::commit();
            return redirect()->route('Manajemen-Mitra.index')
                            ->with('success', "Data mitra {$mitra->nama_mitra} berhasil diperbarui.");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Update Mitra Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data mitra.');
        }
    }

    public function destroy($id)
    {
        $mitra = Mitra::findOrFail($id);
        DB::beginTransaction();
        try {
            $namaMitra = $mitra->nama_mitra;
            $mitra->pics()->delete();
            $mitra->delete();
            DB::commit();
            return back()->with('success', "Mitra {$namaMitra} dan seluruh data personilnya berhasil dihapus secara permanen.");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal Hapus Mitra ID {$id}: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data mitra.');
        }
    }

    public function show($id)
    {
        // Mengambil data mitra beserta list pics dan kategorinya
        $mitra = Mitra::with(['kategori', 'pics'])->findOrFail($id);

        return view('Manajemen-Mitra.detail', compact('mitra'));
    }


}
