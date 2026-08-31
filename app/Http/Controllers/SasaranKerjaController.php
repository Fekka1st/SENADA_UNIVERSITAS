<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKerja;
use App\Models\SasaranKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Reverb\Loggers\Log;
use Yajra\DataTables\DataTables;

class SasaranKerjaController extends Controller
{

    public function index(){
        return view('master_data.sasaran_kerja.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = SasaranKerja::withCount('indikatorKerja')->latest();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('jumlah_indikator', function($row) {
                    $count = $row->indikator_kerja_count ?? 0;
                    $color = $count > 0 ? 'primary' : 'danger';

                    return '<span class="badge bg-'.$color.' bg-opacity-10 text-'.$color.' fw-bold px-3">' . $count . ' Indikator</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group shadow-sm">';

                    $btn .= '<a href="'.route('master-data.sasaran_kerja.show', $row->id).'" class="btn btn-sm btn-light border" title="Detail & Indikator">
                                <i class="ti ti-list-details text-primary"></i>
                            </a>';

                    $btn .= '<a href="'.route('master-data.sasaran_kerja.edit', $row->id).'" class="btn btn-sm btn-light border" title="Edit">
                                <i class="ti ti-edit text-warning"></i>
                            </a>';

                    $btn .= '<button type="button" class="btn btn-sm btn-light border btn-delete"
                                data-id="'.$row->id.'"
                                data-nama="'.$row->nama_sasaran.'"
                                title="Hapus">
                                <i class="ti ti-trash text-danger"></i>
                            </button>';

                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['jumlah_indikator', 'action'])
                ->make(true);
        }
    }

    public function create(){
        return view('master_data.sasaran_kerja.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
            'keterangan'   => 'nullable|string',
            'indikator'                  => 'nullable|array',
            'indikator.*.nama_indikator' => 'required_with:indikator|string|max:255',
            'indikator.*.keterangan'     => 'nullable|string',
        ], [
            'nama_sasaran.required' => 'Nama Sasaran Kerja wajib diisi.',
            'indikator.*.nama_indikator.required_with' => 'Nama indikator tidak boleh kosong jika baris indikator ditambahkan.',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $sasaran = SasaranKerja::create([
                    'nama_sasaran' => $request->nama_sasaran,
                    'keterangan'   => $request->keterangan,
                ]);
                if ($request->has('indikator') && is_array($request->indikator)) {
                    foreach ($request->indikator as $item) {
                        if (!empty($item['nama_indikator'])) {
                            $sasaran->indikatorKerja()->create([
                                'nama_indikator' => $item['nama_indikator'],
                                'keterangan'     => $item['keterangan'] ?? null,
                            ]);
                        }
                    }
                }
                return redirect()->route('master-data.sasaran_kerja.index')
                    ->with('success', 'Master Data Sasaran Kerja dan Indikatornya berhasil disimpan.');
            });
        } catch (\Exception $e) {
            Log::error('Gagal simpan Sasaran Kerja: ' . $e->getMessage() . ' di baris ' . $e->getLine());

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data: ' . $e->getMessage());
        }
    }


    public function edit($id){
        $sasaranKerja = SasaranKerja::find($id)->first();
        return view('master_data.sasaran_kerja.edit',compact('sasaranKerja'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sasaran' => 'required|string|max:255',
            'keterangan'   => 'nullable|string',
        ], [
            'nama_sasaran.required' => 'Nama Sasaran Kerja wajib diisi.',
        ]);
        try {
            $sasaran = SasaranKerja::findOrFail($id);
            $sasaran->update([
                'nama_sasaran' => $request->nama_sasaran,
                'keterangan'   => $request->keterangan,
            ]);
            return redirect()->route('master-data.sasaran_kerja.index')
                ->with('success', 'Data Sasaran Kerja berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Gagal update Sasaran Kerja: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $sasaran = SasaranKerja::findOrFail($id);
            DB::transaction(function () use ($sasaran) {
                $sasaran->indikatorKerja()->delete();
                $sasaran->delete();
            });
            return redirect()->route('master-data.sasaran_kerja.index')
                ->with('success', 'Master Data Sasaran Kerja dan seluruh indikator di dalamnya telah dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal hapus Sasaran Kerja: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus data: Terjadi kendala teknis pada server.');
        }
    }

    public function show($id)
    {
        $sasaranKerja = SasaranKerja::with(['indikatorKerja' => function($q) {
            $q->latest();
        }])->findOrFail($id);
        return view('master_data.sasaran_kerja.detail', compact('sasaranKerja'));
    }

    public function storeIndikator(Request $request, $id)
    {
        $request->validate([
            'nama_indikator' => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
        ]);

        $sasaran = SasaranKerja::findOrFail($id);
        $sasaran->indikatorKerja()->create($request->all());

        return back()->with('success', 'Indikator baru berhasil ditambahkan.');
    }

    public function destroyIndikator($id)
    {
        $indikator = IndikatorKerja::findOrFail($id);
        $indikator->delete();

        return back()->with('success', 'Indikator berhasil dihapus.');
    }

    public function updateIndikator(Request $request, $id)
    {
        $request->validate([
            'nama_indikator' => 'required|string|max:255',
            'keterangan'     => 'nullable|string',
        ]);

        $indikator = IndikatorKerja::findOrFail($id);
        $indikator->update($request->all());

        return back()->with('success', 'Indikator berhasil diperbarui.');
    }
}
