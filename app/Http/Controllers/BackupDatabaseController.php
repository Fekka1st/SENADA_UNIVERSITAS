<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BackupDatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backup-database.index');
    }

    /**
     * Get datatables data for backup files.
     */
    public function datatables(Request $request)
    {
        $backupPath = storage_path('app/backup-database');

        // Buat folder backup jika belum ada
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Ambil semua file backup
        $files = glob($backupPath . '/*.sql.gz');
        $backups = [];

        foreach ($files as $file) {
            $filename = basename($file);
            $backups[] = [
                'file' => $filename,
                'path' => $file,
                'waktu_backup' => filemtime($file),
                'ukuran' => filesize($file)
            ];
        }

        // Urutkan berdasarkan waktu backup (terbaru dulu)
        usort($backups, function($a, $b) {
            return $b['waktu_backup'] - $a['waktu_backup'];
        });

        return DataTables::of(collect($backups))
            ->addIndexColumn()
            ->addColumn('file', function ($data) {
                return '<span class="fw-medium">' . htmlspecialchars($data['file']) . '</span>';
            })
            ->addColumn('waktu_backup', function ($data) {
                // Format tanggal Indonesia: 15 Juni 2024 19:41:00
                $timestamp = $data['waktu_backup'];
                $bulan = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $tanggal = date('d', $timestamp);
                $bulanNama = $bulan[(int)date('m', $timestamp)];
                $tahun = date('Y', $timestamp);
                $waktu = date('H:i:s', $timestamp);

                return $tanggal . ' ' . $bulanNama . ' ' . $tahun . ' ' . $waktu;
            })
            ->addColumn('ukuran', function ($data) {
                // Format ukuran file
                $bytes = $data['ukuran'];
                if ($bytes >= 1073741824) {
                    return number_format($bytes / 1073741824, 2, '.', '') . ' GB';
                } elseif ($bytes >= 1048576) {
                    return number_format($bytes / 1048576, 2, '.', '') . ' MB';
                } elseif ($bytes >= 1024) {
                    return number_format($bytes / 1024, 2, '.', '') . ' KB';
                } else {
                    return $bytes . ' B';
                }
            })
            ->addColumn('aksi', function ($data) {
                $html = '<div class="d-flex gap-1 flex-nowrap">';

                // Get current user dengan type hint untuk IDE
                /** @var \App\Models\User $user */
                $user = Auth::user();

                // Tombol Download
                if ($user && $user->hasPermission('backup_database.download')) {
                    $html .= '<a href="' . route('backup-database.download', ['file' => urlencode($data['file'])]) . '"
                                 class="btn btn-sm btn-success"
                                 data-bs-toggle="tooltip"
                                 title="Download">
                                <i class="ti ti-download"></i>
                              </a>';
                }

                // Tombol Hapus
                if ($user && $user->hasPermission('backup_database.delete')) {
                    $html .= '<button type="button"
                                 class="btn btn-sm btn-danger btn-delete"
                                 data-file="' . htmlspecialchars($data['file']) . '"
                                 data-bs-toggle="tooltip"
                                 title="Hapus">
                                <i class="ti ti-trash"></i>
                              </button>';
                }

                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['file', 'aksi'])
            ->make(true);
    }

    /**
     * Create database backup.
     */
    public function backup(Request $request)
    {
        try {
            // Ambil konfigurasi database
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');

            // Buat nama file backup dengan timestamp
            $timestamp = date('d-m-Y_H.i.s');
            $filename = 'DB_' . $timestamp . '.sql';
            $compressedFilename = $filename . '.gz';

            // Path untuk menyimpan backup
            $backupPath = storage_path('app/backup-database');

            // Buat folder backup jika belum ada
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $sqlPath = $backupPath . '/' . $filename;
            $gzPath = $backupPath . '/' . $compressedFilename;

            // Tentukan path mysqldump berdasarkan OS
            $mysqldump = 'mysqldump'; // Default untuk Linux/Mac atau jika sudah ada di PATH

            // Untuk Windows dengan Laragon, cek beberapa kemungkinan path
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $possiblePaths = [
                    'D:/Program/laragon/bin/mysql/mysql-8.4.3-winx64/bin/mysqldump.exe',
                    'C:/xampp/mysql/bin/mysqldump.exe',
                ];

                foreach ($possiblePaths as $path) {
                    if (file_exists($path)) {
                        $mysqldump = '"' . $path . '"';
                        break;
                    }
                }
            }

            // Buat file konfigurasi temporary untuk kredensial (lebih aman & tidak ada warning)
            $tempConfigFile = $backupPath . '/.my.cnf.tmp';
            $configContent = "[client]\n";
            $configContent .= "user={$username}\n";
            $configContent .= "password={$password}\n";
            $configContent .= "host={$host}\n";
            $configContent .= "port={$port}\n";
            file_put_contents($tempConfigFile, $configContent);
            chmod($tempConfigFile, 0600); // Set permission agar hanya owner yang bisa baca

            // Command untuk mysqldump tanpa password di command line (menghindari warning)
            $command = sprintf(
                '%s --defaults-extra-file=%s --single-transaction --routines --triggers --add-drop-table --create-options %s > %s',
                $mysqldump,
                escapeshellarg($tempConfigFile),
                escapeshellarg($database),
                escapeshellarg($sqlPath)
            );

            // Eksekusi command
            $output = [];
            $return_var = 0;
            exec($command, $output, $return_var);

            // Hapus file konfigurasi temporary
            if (file_exists($tempConfigFile)) {
                unlink($tempConfigFile);
            }

            // Cek apakah backup berhasil dan tidak ada warning di file
            $backupValid = false;
            if (file_exists($sqlPath) && filesize($sqlPath) > 0) {
                // Cek apakah file dimulai dengan warning mysqldump
                $firstLine = fgets(fopen($sqlPath, 'r'));
                if (strpos($firstLine, 'mysqldump:') === false && strpos($firstLine, 'Warning') === false) {
                    $backupValid = true;
                }
            }

            if ($return_var !== 0 || !$backupValid) {
                // Jika gagal dengan mysqldump, coba metode alternatif menggunakan PHP
                Log::warning('mysqldump gagal, mencoba metode alternatif');

                // Hapus file backup yang invalid jika ada
                if (file_exists($sqlPath)) {
                    unlink($sqlPath);
                }

                // Metode alternatif: export menggunakan PHP
                $this->backupUsingPHP($sqlPath, $database);
            }

            // Compress file SQL menggunakan gzip
            if (file_exists($sqlPath) && filesize($sqlPath) > 0) {
                $sqlContent = file_get_contents($sqlPath);
                $gzContent = gzencode($sqlContent, 9); // Level kompresi maksimal
                file_put_contents($gzPath, $gzContent);

                // Hapus file SQL yang tidak terkompress
                if (file_exists($sqlPath)) {
                    unlink($sqlPath);
                }
            } else {
                throw new \Exception('File backup tidak berhasil dibuat atau kosong.');
            }

            // Log aktivitas
            Log::info('Backup database berhasil dibuat', [
                'user_id' => Auth::id(),
                'filename' => $compressedFilename,
                'size' => filesize($gzPath)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Backup database berhasil dibuat.',
                'filename' => $compressedFilename
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal membuat backup database: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat backup database: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Backup database using PHP (alternative method).
     */
    private function backupUsingPHP($sqlPath, $database)
    {
        $tables = DB::select('SHOW TABLES');
        $sql = "-- Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = reset($table);

            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "-- Table: {$tableName}\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $rows = DB::table($tableName)->get();

            if ($rows->count() > 0) {
                $sql .= "-- Data for table {$tableName}\n";

                foreach ($rows as $row) {
                    $values = [];
                    foreach ($row as $value) {
                        if (is_null($value)) {
                            $values[] = 'NULL';
                        } else {
                            $values[] = "'" . addslashes($value) . "'";
                        }
                    }
                    $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($sqlPath, $sql);
    }

    /**
     * Download backup file.
     */
    public function download(Request $request, $file)
    {
        try {
            $backupPath = storage_path('app/backup-database');
            $filePath = $backupPath . '/' . $file;

            // Validasi file
            if (!file_exists($filePath)) {
                return redirect()->route('backup-database.index')
                    ->with('error', 'File backup tidak ditemukan.');
            }

            // Validasi ekstensi file untuk keamanan
            if (!str_ends_with($file, '.sql.gz')) {
                return redirect()->route('backup-database.index')
                    ->with('error', 'File tidak valid.');
            }

            // Log aktivitas download
            Log::info('Download backup database', [
                'user_id' => Auth::id(),
                'filename' => $file
            ]);

            return response()->download($filePath, $file, [
                'Content-Type' => 'application/gzip',
            ]);

        } catch (\Exception $e) {
            Log::error('Gagal download backup: ' . $e->getMessage());

            return redirect()->route('backup-database.index')
                ->with('error', 'Gagal download backup database.');
        }
    }

    /**
     * Delete backup file.
     */
    public function destroy(Request $request, $file)
    {
        try {
            $backupPath = storage_path('app/backup-database');
            $filePath = $backupPath . '/' . $file;

            // Validasi file
            if (!file_exists($filePath)) {
                return redirect()->route('backup-database.index')
                    ->with('error', 'File backup tidak ditemukan.');
            }

            // Validasi ekstensi file untuk keamanan
            if (!str_ends_with($file, '.sql.gz')) {
                return redirect()->route('backup-database.index')
                    ->with('error', 'File tidak valid.');
            }

            // Hapus file
            unlink($filePath);

            // Log aktivitas
            Log::info('Hapus backup database', [
                'user_id' => Auth::id(),
                'filename' => $file
            ]);

            return redirect()->route('backup-database.index')
                ->with('success', 'Backup database berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Gagal hapus backup: ' . $e->getMessage());

            return redirect()->route('backup-database.index')
                ->with('error', 'Gagal menghapus backup database.');
        }
    }
}
