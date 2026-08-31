<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database 
                            {--max-backups=10 : Maksimal jumlah backup yang disimpan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database secara otomatis dan hapus backup lama';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = now();
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->info('🔄 Memulai proses backup database otomatis...');
        $this->info('⏰ Waktu mulai: ' . $startTime->format('d-m-Y H:i:s'));
        $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        try {
            // Step 1: Buat backup database
            $this->newLine();
            $this->info('📦 Step 1: Membuat backup database...');
            $backupFile = $this->createBackup();

            if (!$backupFile) {
                $this->error('❌ Gagal membuat backup database!');
                return Command::FAILURE;
            }

            $this->info('✅ Backup berhasil dibuat: ' . basename($backupFile));
            $this->info('📊 Ukuran file: ' . $this->formatBytes(filesize($backupFile)));

            // Step 2: Bersihkan backup lama
            $this->newLine();
            $this->info('🧹 Step 2: Membersihkan backup lama...');
            $maxBackups = (int) $this->option('max-backups');

            $deletedCount = $this->cleanOldBackups($maxBackups);

            if ($deletedCount > 0) {
                $this->info("✅ Berhasil menghapus {$deletedCount} backup lama");
            } else {
                $this->info('ℹ️  Tidak ada backup lama yang perlu dihapus');
            }

            // Step 3: Tampilkan ringkasan
            $this->newLine();
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('📈 RINGKASAN BACKUP');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            $backupPath = storage_path('app/backup-database');
            $backupFiles = glob($backupPath . '/*.sql.gz');
            $totalSize = array_sum(array_map('filesize', $backupFiles));

            $this->table(
                ['Informasi', 'Detail'],
                [
                    ['Total backup tersimpan', count($backupFiles) . ' file'],
                    ['Total ukuran backup', $this->formatBytes($totalSize)],
                    ['Backup terbaru', basename($backupFile)],
                    ['Waktu selesai', now()->format('d-m-Y H:i:s')],
                    ['Durasi proses', $startTime->diffForHumans(now(), true)],
                ]
            );

            $this->newLine();
            $this->info('✨ Backup database berhasil diselesaikan!');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            // Log aktivitas
            Log::info('Backup database otomatis berhasil', [
                'filename' => basename($backupFile),
                'size' => filesize($backupFile),
                'duration' => $startTime->diffInSeconds(now()) . ' detik',
                'deleted_old_backups' => $deletedCount
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());

            Log::error('Gagal backup database otomatis: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return Command::FAILURE;
        }
    }

    /**
     * Create database backup.
     */
    private function createBackup(): ?string
    {
        // Ambil konfigurasi database
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Buat nama file backup dengan timestamp
        $timestamp = date('d-m-Y_H.i.s');
        $filename = 'DB_AUTO_' . $timestamp . '.sql';
        $compressedFilename = $filename . '.gz';

        // Path untuk menyimpan backup
        $backupPath = storage_path('app/backup-database');

        // Buat folder backup jika belum ada
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        $sqlPath = $backupPath . '/' . $filename;
        $gzPath = $backupPath . '/' . $compressedFilename;

        // Tentukan path mysqldump berdasarkan OS
        $mysqldump = 'mysqldump'; // Default untuk Linux/Mac

        // Untuk Windows, cek beberapa kemungkinan path
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $possiblePaths = [
                'D:/Program/laragon/bin/mysql/mysql-8.4.3-winx64/bin/mysqldump.exe',
                'C:/xampp/mysql/bin/mysqldump.exe',
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $mysqldump = '"' . $path . '"';
                    $this->line('   🔍 Menggunakan mysqldump dari: ' . $path);
                    break;
                }
            }
        }

        // Progress bar untuk simulasi proses
        $bar = $this->output->createProgressBar(3);
        $bar->start();

        // Buat file konfigurasi temporary untuk kredensial (lebih aman)
        $tempConfigFile = $backupPath . '/.my.cnf.tmp';
        $configContent = "[client]\n";
        $configContent .= "user={$username}\n";
        $configContent .= "password={$password}\n";
        $configContent .= "host={$host}\n";
        $configContent .= "port={$port}\n";
        file_put_contents($tempConfigFile, $configContent);
        chmod($tempConfigFile, 0600); // Set permission agar hanya owner yang bisa baca

        // Command untuk mysqldump tanpa password di command line
        $command = sprintf(
            '%s --defaults-extra-file=%s --single-transaction --routines --triggers --add-drop-table --create-options %s > %s',
            $mysqldump,
            escapeshellarg($tempConfigFile),
            escapeshellarg($database),
            escapeshellarg($sqlPath)
        );

        $bar->advance();

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
            $this->warn('   ⚠️  mysqldump gagal, menggunakan metode alternatif PHP...');
            // Hapus file backup yang invalid jika ada
            if (file_exists($sqlPath)) {
                unlink($sqlPath);
            }
            $this->backupUsingPHP($sqlPath, $database);
        }

        $bar->advance();

        // Compress file SQL menggunakan gzip
        if (file_exists($sqlPath) && filesize($sqlPath) > 0) {
            $sqlContent = file_get_contents($sqlPath);
            $gzContent = gzencode($sqlContent, 9); // Level kompresi maksimal
            file_put_contents($gzPath, $gzContent);

            // Hapus file SQL yang tidak terkompress
            File::delete($sqlPath);

            $bar->advance();
            $bar->finish();
            $this->newLine();

            return $gzPath;
        }

        $bar->finish();
        $this->newLine();

        return null;
    }

    /**
     * Backup database using PHP (alternative method).
     */
    private function backupUsingPHP($sqlPath, $database)
    {
        $tables = DB::select('SHOW TABLES');
        $sql = "-- Database Backup (Auto Generated)\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: {$database}\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n";
        $sql .= "SET time_zone = '+00:00';\n\n";

        $tableCount = count($tables);
        $currentTable = 0;

        foreach ($tables as $table) {
            $currentTable++;
            $tableName = reset($table);

            // Progress indicator
            $this->line("   📋 Processing table {$currentTable}/{$tableCount}: {$tableName}");

            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "-- --------------------------------------------------------\n";
            $sql .= "-- Table structure for table `{$tableName}`\n";
            $sql .= "-- --------------------------------------------------------\n\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $rows = DB::table($tableName)->get();

            if ($rows->count() > 0) {
                $sql .= "-- --------------------------------------------------------\n";
                $sql .= "-- Dumping data for table `{$tableName}`\n";
                $sql .= "-- --------------------------------------------------------\n\n";

                // Batch insert untuk performa lebih baik
                $batchSize = 100;
                $chunks = $rows->chunk($batchSize);

                foreach ($chunks as $chunk) {
                    foreach ($chunk as $row) {
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
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        file_put_contents($sqlPath, $sql);
    }

    /**
     * Clean old backup files based on maximum number of backups.
     */
    private function cleanOldBackups(int $maxBackups): int
    {
        $backupPath = storage_path('app/backup-database');
        $files = glob($backupPath . '/*.sql.gz');

        if (empty($files)) {
            return 0;
        }

        // Urutkan berdasarkan waktu modifikasi (terbaru dulu)
        usort($files, function ($a, $b) {
            return filemtime($b) - filemtime($a);
        });

        $deletedCount = 0;

        foreach ($files as $index => $file) {
            // Hanya hapus jika melebihi jumlah maksimal backup
            // Aturan "30 hari" dihapus untuk mencegah kehilangan semua backup
            if ($index >= $maxBackups) {
                $filename = basename($file);
                $reason = "melebihi batas maksimal ({$maxBackups} backup)";
                // Ambil ukuran file SEBELUM dihapus
                $fileSize = filesize($file);
                $fileSizeFormatted = $this->formatBytes($fileSize);

                if (File::delete($file)) {
                    $this->line("   🗑️  Menghapus: {$filename} ({$fileSizeFormatted}) - {$reason}");
                    $deletedCount++;

                    Log::info('Backup lama dihapus', [
                        'filename' => $filename,
                        'reason' => $reason,
                        'size' => $fileSize
                    ]);
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Format bytes to human readable format.
     */
    private function formatBytes($bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}
