<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     * 
     * NOTE: Di Laravel 11, scheduling dipindahkan ke routes/console.php
     * Method ini dikosongkan untuk menghindari duplikasi.
     * Lihat: routes/console.php untuk semua scheduled tasks.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Scheduled tasks sekarang didefinisikan di routes/console.php
        // Menggunakan Schedule facade (Laravel 11 style)
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
