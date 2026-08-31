<?php

namespace App\Http\Controllers;

use App\Exports\LogActivityExport;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class LogActivityController extends Controller
{
    //
     public function index(): View
    {
        return view('log_activity.index');
    }


    public function datatables(Request $request)
    {
        $data = Activity::with('causer')->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $name = $row->causer->name ?? 'Sistem';
                $role = $row->causer->roleModel->nama ?? '-';

                $foto = $row->causer->foto ?? 'default.png';

                return '
                    <div class="d-flex align-items-center">
                        <img src="'.asset('storage/users/'.$foto).'" class="rounded-circle me-2" width="35" height="35" onerror="this.src=\'https://ui-avatars.com/api/?name='.urlencode($name).'&background=random\'">
                        <div>
                            <h6 class="mb-0 fs-3 fw-bold">'.$name.'</h6>
                            <small class="text-muted">'.$role.'</small>
                        </div>
                    </div>';
            })
            ->addColumn('aktivitas', function ($row) {
                $badgeColor = match($row->description) {
                    'created' => 'success',
                    'updated' => 'info',
                    'deleted' => 'danger',
                    'login'   => 'primary',
                    default   => 'secondary'
                };
                return '<span class="badge bg-light-'.$badgeColor.' text-'.$badgeColor.' border-0 text-uppercase fw-bold">'.$row->description.'</span>';
            })
            ->addColumn('modul', function ($row) {
                $subject = $row->subject_type ? class_basename($row->subject_type) : 'System';
                return '<div>
                            <span class="text-dark fw-medium">'.$subject.'</span>
                            <br><small class="text-muted">ID: '.($row->subject_id ?? '-').'</small>
                        </div>';
            })
            ->addColumn('waktu', function ($row) {
                return '<div>
                            '.$row->created_at->format('d M Y').'
                            <br><small class="text-muted">'.$row->created_at->diffForHumans().'</small>
                        </div>';
            })
            ->addColumn('aksi', function ($row) {
                return '
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-light-primary text-primary btn-detail"
                            data-id="'.$row->id.'"
                            data-properties=\''.json_encode($row->properties).'\'
                            data-bs-toggle="tooltip" title="Lihat Detail JSON">
                            <i class="ti ti-eye fs-5"></i>
                        </button>
                    </div>';
            })
            ->rawColumns(['user', 'aktivitas', 'modul', 'waktu', 'aksi'])
            ->make(true);
    }

    public function exportExcel()
    {
        $fileName = 'Log_Aktivitas_' . Carbon::now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new LogActivityExport, $fileName);
    }
}
