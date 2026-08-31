<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

// ============================================
// SCHEDULED TASKS - Template SIAD
// ============================================

// Bersihkan notifikasi lama setiap malam jam 2 dini hari
Schedule::command('notifikasi:bersihkan-lama')
    ->dailyAt('02:00')
    ->timezone('Asia/Jakarta');

// Backup database otomatis setiap 2 minggu sekali di hari Minggu dini hari jam 02:00
Schedule::command('backup:database --max-backups=10')
    ->weeklyOn(0, '02:00')  // Setiap hari Minggu jam 02:00 dini hari
    ->when(function () {
        // Jalankan hanya setiap 2 minggu sekali
        $weekNumber = now('Asia/Jakarta')->weekOfYear;
        return $weekNumber % 2 == 0; // Minggu genap dalam setahun
    })
    ->timezone('Asia/Jakarta')
    ->runInBackground()  // Jalankan di background agar tidak blocking
    ->withoutOverlapping()  // Hindari overlap jika proses sebelumnya masih berjalan
    ->onSuccess(function () {
        Log::info('Backup database otomatis berhasil dijadwalkan pada ' . now('Asia/Jakarta')->format('Y-m-d H:i:s'));
    })
    ->onFailure(function () {
        Log::error('Backup database otomatis gagal dijadwalkan pada ' . now('Asia/Jakarta')->format('Y-m-d H:i:s'));
    });

Schedule::command('kerjasama:update-status')
    ->timezone('Asia/Jakarta')
    ->daily()
    ->withoutOverlapping() 
    ->onOneServer();
