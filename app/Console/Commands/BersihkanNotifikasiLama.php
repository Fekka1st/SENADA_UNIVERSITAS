<?php

namespace App\Console\Commands;

use App\Services\NotifikasiService;
use Illuminate\Console\Command;

class BersihkanNotifikasiLama extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifikasi:bersihkan-lama';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bersihkan notifikasi lama untuk mengoptimalkan database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pembersihan notifikasi lama...');
        
        NotifikasiService::bersihkanNotifikasiLama();
        
        $this->info('Selesai membersihkan notifikasi lama.');
        return Command::SUCCESS;
    }
}
