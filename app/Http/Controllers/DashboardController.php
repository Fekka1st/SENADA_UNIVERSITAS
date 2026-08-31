<?php

namespace App\Http\Controllers;

use App\Models\kerjasama;
use App\Models\mitra;
use App\Models\User;
use App\Models\Pengaturan;
use App\Models\RencanaKerjasama;
use App\Models\repository_kerjasama;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(): View
    {
        try {
            $user = Auth::user();
            $pengaturan = Pengaturan::first() ?? new Pengaturan();

            return match ((int) $user->role) {
                1 => $this->dashboardSuperAdmin($user, $pengaturan),
                2 => $this->dashboardadmin($user,$pengaturan),
                4 => $this->dashboardProdi($user, $pengaturan), // sama dengan prodi
                5 => $this->dashboardProdi($user,$pengaturan),
            };

        } catch (\Throwable $e) {
            Log::error("Dashboard Error: " . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);
            abort(500, 'Maaf, terjadi kesalahan saat memuat dashboard. Tim teknis telah diberitahu.');
        }
    }

    private function dashboardadmin($user, $pengaturan)
    {
        $antrean_verifikasi = RencanaKerjasama::where('status', 1)->count();

        // 2. Hitung Total Mitra
        $total_mitra = mitra::count();

        // 3. Hitung Total Dokumen Disetujui (Akumulasi MoU + MoA + IA)
        $total_mou =2;
        $total_moa = 2;// Pastikan model ini sudah ada
        $total_ia  = 2; // Pastikan model ini sudah ada
        $total_disetujui = $total_mou + $total_moa + $total_ia;

        // 4. Ambil 5 Pengajuan Terbaru untuk Tabel
        // Kita ambil yang 'proses_review' agar Admin fokus ke yang belum dikerjakan
        $latest_pengajuan = RencanaKerjasama::with(['mitra', 'user.prodi'])
            ->where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        // 5. Kirim semua variabel ke View
        return view('dashboard.adminuniv', compact(
            'user',
            'pengaturan',
            'antrean_verifikasi',
            'total_mitra',
            'total_disetujui',
            'latest_pengajuan'
        ));
    }

    private function dashboardProdi($user,$pengaturan){
        $unitId = $user->fakultas_id;
        $today = now()->toDateString();

        // --- DATA REPOSITORY (ARSIP) ---
        $total_repo = repository_kerjasama::where('fakultas_id', $unitId)->count();

        $repo_aktif = repository_kerjasama::where('fakultas_id', $unitId)
            ->where('status', 1) // 1 = Aktif
            ->count();

        $repo_kadaluarsa = repository_kerjasama::where('fakultas_id', $unitId)
            ->where('status', 0) // 0 = Kadaluarsa
            ->count();

        // --- DATA KERJASAMA (PENGAJUAN/WORKFLOW) ---
        $total_pengajuan = KerjaSama::where('fakultas_id', $unitId)->count();

        $perlu_revisi = KerjaSama::where('fakultas_id', $unitId)
            ->where('status_kerjasama', 2) // 2 = Perlu Revisi
            ->count();

        $draft_saya = KerjaSama::with(['mitra'])
            ->where('fakultas_id', $unitId)
            ->whereIn('status_kerjasama', [0, 2]) // Draf atau Revisi
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->title = $item->judul_kerjasama;
                $item->status_label = ($item->status_kerjasama == 2) ? 'rejected' : 'draf';
                return $item;
            });

        $data = [
            'total_repo'        => $total_repo,
            'repo_aktif'        => $repo_aktif,
            'repo_kadaluarsa'   => $repo_kadaluarsa,
            'total_pengajuan'   => $total_pengajuan,
            'perlu_revisi'      => $perlu_revisi,
            'draft_saya'        => $draft_saya,
        ];

        return view('dashboard.prodi', compact('user', 'pengaturan') + $data);
    }

    private function dashboardOperator($user, $pengaturan)
    {
        $unitId = $user->fakultas_id;
        $today = now()->toDateString();

        // --- DATA REPOSITORY (ARSIP) ---
        $total_repo = repository_kerjasama::where('fakultas_id', $unitId)->count();

        $repo_aktif = repository_kerjasama::where('fakultas_id', $unitId)
            ->where('status', 1) // 1 = Aktif
            ->count();

        $repo_kadaluarsa = repository_kerjasama::where('fakultas_id', $unitId)
            ->where('status', 0) // 0 = Kadaluarsa
            ->count();

        // --- DATA KERJASAMA (PENGAJUAN/WORKFLOW) ---
        $total_pengajuan = KerjaSama::where('fakultas_id', $unitId)->count();

        $perlu_revisi = KerjaSama::where('fakultas_id', $unitId)
            ->where('status_kerjasama', 2) // 2 = Perlu Revisi
            ->count();

        $draft_saya = KerjaSama::with(['mitra'])
            ->where('fakultas_id', $unitId)
            ->whereIn('status_kerjasama', [0, 2]) // Draf atau Revisi
            ->latest('updated_at')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $item->title = $item->judul_kerjasama;
                $item->status_label = ($item->status_kerjasama == 2) ? 'rejected' : 'draf';
                return $item;
            });

        $data = [
            'total_repo'        => $total_repo,
            'repo_aktif'        => $repo_aktif,
            'repo_kadaluarsa'   => $repo_kadaluarsa,
            'total_pengajuan'   => $total_pengajuan,
            'perlu_revisi'      => $perlu_revisi,
            'draft_saya'        => $draft_saya,
        ];

        return view('dashboard.operator', compact('user', 'pengaturan') + $data);
    }

    private function dashboardSuperAdmin($user, $pengaturan)
    {

        $error_logs = [];
        $logPath = storage_path('logs/laravel.log');

        if (File::exists($logPath)) {

            $fileContent = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $fileContent = array_reverse($fileContent); // Balik agar yang terbaru di atas

            foreach ($fileContent as $line) {
                if (str_contains($line, '.ERROR:') && count($error_logs) < 5) {
                    preg_match('/^\[(?<date>.*)\]\s(?<env>\w+)\.(?<level>\w+):(?<message>.*)/', $line, $matches);

                    if (!empty($matches)) {
                        $error_logs[] = (object) [
                            'created_at' => \Carbon\Carbon::parse($matches['date']),
                            'message' => substr(trim($matches['message']), 0, 100) . '...'
                        ];
                    }
                }
                if (count($error_logs) >= 5) break;
            }
        }

        // 2. Hitung Disk Usage (Real)
        $diskTotal = disk_total_space(base_path());
        $diskFree = disk_free_space(base_path());
        $diskUsed = $diskTotal - $diskFree;
        $diskPercentage = $diskTotal > 0 ? round(($diskUsed / $diskTotal) * 100) : 0;

        // Helper local function untuk format bytes
        $formatBytes = function($bytes, $precision = 2) {
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, $precision) . ' ' . $units[$pow];
        };

        // 3. Hitung Database Size (Khusus MySQL)
        $db_size = '0 MB';
        try {
            $db_name = config('database.connections.mysql.database');
            // Query ke information_schema untuk menghitung size
            $result = DB::select("SELECT round(sum(data_length + index_length) / 1024 / 1024, 2) as size FROM information_schema.tables WHERE table_schema = ?", [$db_name]);
            if (!empty($result)) {
                $db_size = $result[0]->size . ' MB';
            }
        } catch (\Exception $e) {
            $db_size = 'N/A'; // Fallback jika bukan MySQL
        }

        // 4. Cek Last Backup (Cek folder storage/app/Laravel)
        $last_backup_date = '-';
        $backupPath = storage_path('app/backup-database'); // Pastikan path ini sama dengan di fungsi backup Anda

        if (File::exists($backupPath)) {
            $files = File::files($backupPath);
            if (count($files) > 0) {
                // Urutkan file berdasarkan waktu modifikasi terbaru
                usort($files, function($a, $b) {
                    return $b->getMTime() - $a->getMTime();
                });

                // Ambil waktu file paling baru dan format
                $last_backup_date = date('d M Y, H:i', $files[0]->getMTime());
            }
        }

        // 5. Ambil Activity Log (Jika pakai Spatie Activitylog)
        $recent_activities = [];
        if (class_exists(\Spatie\Activitylog\Models\Activity::class)) {
            $recent_activities = \Spatie\Activitylog\Models\Activity::latest()->take(5)->with('causer')->get();
        }

        // Data khusus Super Admin
        $data = [
            // Statistik User (Sesuaikan ID role: 1=SA, 2=Admin, 3=Pimpinan, 4=Operator)
            'total_users' => User::count(),
            'total_admin' => User::where('role', 2)->count(),
            'total_operator' => User::where('role', 4)->count(),
            'total_viewer' => User::where('role', 3)->count(),

            // System Vitals
            'server_status' => 'Online',
            'disk_percentage' => $diskPercentage,
            'disk_used' => $formatBytes($diskUsed),
            'disk_total' => $formatBytes($diskTotal),
            'db_size' => $db_size,
            'last_backup_date' => $last_backup_date,
            'app_is_down' => app()->isDownForMaintenance(),

            // Logs & Activities
            'error_logs' => $error_logs,
            'recent_activities' => $recent_activities,
        ];

        return view('dashboard.superadmin', compact('user', 'pengaturan') + $data);
    }

    public function optimize()
    {
        $user = Auth::user();
        if ((int) $user->role !== 1) {
            abort(403, 'Aksi ditolak. Hanya Super Admin yang diizinkan melakukan ini.');
        }

        try {
            Artisan::call('optimize:clear');
            Log::info("User ID {$user->id} melakukan Optimize App dari Dashboard.");
            return back()->with('success', 'Sistem berhasil di-refresh! Cache konfigurasi dan view telah dibersihkan.');
        } catch (\Exception $e) {
            Log::error("Optimize Failed: " . $e->getMessage());
            return back()->with('error', 'Gagal mengoptimasi sistem. Silakan hubungi tim IT.');
        }
    }

    public function clearLog()
    {
        $user = Auth::user();

        if ((int) $user->role !== 1) {
            abort(403, 'Hanya Super Admin yang dapat menghapus log.');
        }

        try {
            $logPath = storage_path('logs/laravel.log');
            if (File::exists($logPath)) {
                File::put($logPath, '');
                return back()->with('success', 'Log error berhasil dikosongkan.');
            }
            return back()->with('info', 'File log tidak ditemukan atau sudah kosong.');
        } catch (\Exception $e) {
            Log::error("Clear Log Failed: " . $e->getMessage());
            return back()->with('error', 'Gagal mengosongkan log. Periksa izin akses folder storage.');
        }
    }

    // private function dashboardAdminUniv($user, $pengaturan)
    // {
    //     // Data khusus Admin (Antrean verifikasi, dll)
    //     $data = [
    //         'antrean_verifikasi' => Cooperation::where('status', 'pending')->count(),
    //         'total_mitra'        => Partner::count(),
    //         // ... data lain ...
    //     ];

    //     return view('dashboard.admin', compact('user', 'pengaturan') + $data);
    // }

    // private function dashboardPimpinan($user, $pengaturan)
    // {
    //     // Data khusus Pimpinan (Grafik, KPI)
    //     $data = [
    //         'total_mou'   => Cooperation::where('status', 'approved')->count(),
    //         // ... data lain ...
    //     ];

    //     return view('dashboard.pimpinan', compact('user', 'pengaturan') + $data);
    // }




    private function dashboardDefault($user, $pengaturan)
    {

        return view('dashboard.default', compact('user', 'pengaturan'));
    }
}
