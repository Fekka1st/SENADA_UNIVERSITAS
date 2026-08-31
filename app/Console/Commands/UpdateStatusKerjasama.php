<?php

namespace App\Console\Commands;

use App\Models\repository_kerjasama;
use Illuminate\Console\Command;

class UpdateStatusKerjasama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-status-kerjasama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = \Carbon\Carbon::now()->toDateString();
        $expiredCount = 0;
        $activatedCount = 0;

        repository_kerjasama::where('status', 1)
            ->where('tanggal_berakhir', '<', $today)
            ->chunkById(100, function ($items) use (&$expiredCount) {
                foreach ($items as $item) {
                    $item->update(['status' => 0]);
                    $expiredCount++;
                }
            });
        repository_kerjasama::where('status', 0)
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_berakhir', '>=', $today)
            ->chunkById(100, function ($items) use (&$activatedCount) {
                foreach ($items as $item) {
                    $item->update(['status' => 1]);
                    $activatedCount++;
                }
            });
        \Illuminate\Support\Facades\Log::info("Sistem Auto-Status: {$expiredCount} Kadaluarsa, {$activatedCount} Aktif.");

        $this->info("Proses selesai secara aman.");
    }
}
