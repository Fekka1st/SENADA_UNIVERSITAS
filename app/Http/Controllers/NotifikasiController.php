<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Services\NotifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class NotifikasiController extends Controller
{
    /**
     * Halaman daftar semua notifikasi
     */
    public function index(Request $request)
    {
        return view('notifikasi.index');
    }

    /**
     * DataTables endpoint untuk notifikasi
     */
    public function datatables(Request $request)
    {
        $user = Auth::user();
        
        $query = Notifikasi::where('user_id', $user->id);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'belum_dibaca') {
                $query->whereNull('dibaca_pada');
            } elseif ($request->status === 'sudah_dibaca') {
                $query->whereNotNull('dibaca_pada');
            }
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis') && $request->jenis !== '') {
            $query->where('jenis', $request->jenis);
        }

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('id', function ($row) {
                return $row->id;
            })
            ->addColumn('icon_display', function ($row) {
                return '<span class="' . $row->icon_class . '">
                            <i class="' . $row->icon . '"></i>
                        </span>';
            })
            ->addColumn('judul_display', function ($row) {
                return '<span class="fw-semibold">' . e($row->judul) . '</span>';
            })
            ->addColumn('pesan_display', function ($row) {
                return $row->pesan;
            })
            ->addColumn('waktu_display', function ($row) {
                return '<i class="ti ti-clock me-1"></i>' . $row->waktu_relatif;
            })
            ->addColumn('status_badge', function ($row) {
                if ($row->sudahDibaca()) {
                    return '<span class="badge bg-success">Dibaca</span>';
                } else {
                    return '<span class="badge bg-warning">Belum</span>';
                }
            })
            ->addColumn('action', function ($row) {
                $html = '';
                
                if ($row->url) {
                    $html .= '<a href="' . route('notifikasi.buka', $row->id) . '" class="btn btn-sm btn-primary m-1" data-bs-toggle="tooltip" data-bs-title="Buka">
                                <i class="ti ti-eye"></i>
                            </a>';
                }
                
                if (!$row->sudahDibaca()) {
                    $html .= '<button type="button" class="btn btn-sm btn-success m-1" data-bs-toggle="tooltip" data-bs-title="Tandai dibaca"
                                    onclick="tandaiSudahDibaca(' . $row->id . ')">
                                <i class="ti ti-check"></i>
                            </button>';
                }
                
                $html .= '<button type="button" class="btn btn-sm btn-danger m-1" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalHapusNotifikasi"
                                data-id="' . $row->id . '"
                                data-item-name="' . e($row->judul) . '"
                                data-route="' . route('notifikasi.hapus', $row->id) . '"
                                title="Hapus"
                                onclick="setupModalHapusNotifikasi(' . $row->id . ', \'' . e(str_replace("'", "\\'", $row->judul)) . '\')">
                            <i class="ti ti-trash"></i>
                        </button>';
                
                return $html;
            })
            ->addColumn('row_class', function ($row) {
                return !$row->sudahDibaca() ? 'table-light' : '';
            })
            ->addColumn('is_read', function ($row) {
                return $row->sudahDibaca() ? '1' : '0';
            })
            ->orderColumn('judul_display', function ($query, $order) {
                $query->orderBy('judul', $order);
            })
            ->orderColumn('waktu_display', function ($query, $order) {
                $query->orderBy('created_at', $order);
            })
            ->filterColumn('judul_display', function ($query, $keyword) {
                $query->where('judul', 'like', "%{$keyword}%");
            })
            ->filterColumn('pesan_display', function ($query, $keyword) {
                $query->where('pesan', 'like', "%{$keyword}%");
            })
            ->rawColumns(['icon_display', 'judul_display', 'pesan_display', 'waktu_display', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Get notifikasi terbaru untuk dropdown
     */
    public function getNotifikasiTerbaru()
    {
        $user = Auth::user();
        
        $notifikasi = NotifikasiService::getNotifikasiTerbaru($user->id, 10);
        $jumlahBelumDibaca = NotifikasiService::hitungBelumDibaca($user->id);

        return response()->json([
            'notifikasi' => $notifikasi->map(function ($n) {
                return [
                    'id' => $n->id,
                    'judul' => $n->judul,
                    'pesan' => $n->pesan,
                    'icon' => $n->icon,
                    'warna' => $n->warna,
                    'url' => $n->url,
                    'waktu_relatif' => $n->waktu_relatif,
                    'sudah_dibaca' => $n->sudahDibaca(),
                    'created_at' => $n->created_at->toISOString()
                ];
            }),
            'jumlah_belum_dibaca' => $jumlahBelumDibaca
        ]);
    }

    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function tandaiSudahDibaca(Request $request, $id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notifikasi->tandaiSudahDibaca();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sudah dibaca'
            ]);
        }

        return redirect()->back();
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function tandaiSemuaSudahDibaca()
    {
        NotifikasiService::tandaiSemuaSudahDibaca(Auth::id());

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi ditandai sudah dibaca'
        ]);
    }

    /**
     * Hapus notifikasi
     */
    public function hapus($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notifikasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }

    /**
     * Hapus semua notifikasi yang sudah dibaca
     */
    public function hapusSemuaSudahDibaca()
    {
        $deleted = Notifikasi::where('user_id', Auth::id())
            ->whereNotNull('dibaca_pada')
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} notifikasi berhasil dihapus"
        ]);
    }

    /**
     * Redirect ke URL notifikasi dan tandai sebagai dibaca
     */
    public function buka($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Tandai sebagai sudah dibaca
        $notifikasi->tandaiSudahDibaca();

        // Redirect ke URL yang sesuai
        if ($notifikasi->url) {
            return redirect($notifikasi->url);
        }

        return redirect()->route('dashboard.index');
    }

    /**
     * Get jumlah notifikasi belum dibaca untuk badge
     */
    public function getJumlahBelumDibaca()
    {
        $jumlah = NotifikasiService::hitungBelumDibaca(Auth::id());

        return response()->json([
            'jumlah' => $jumlah
        ]);
    }
}
