<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Notifikasi;
use App\Events\NotifikasiBaru;
use Illuminate\Console\Command;

class TestNotifikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notifikasi {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim notifikasi ke user tertentu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        $user = User::find($userId);
        if (!$user) {
            $this->error("User dengan ID {$userId} tidak ditemukan!");
            return Command::FAILURE;
        }

        $this->info("Mengirim test notifikasi ke user: {$user->nama_user}");

        // Buat notifikasi test
        $notifikasi = Notifikasi::create([
            'user_id' => $user->id,
            'jenis' => 'pengajuan_baru',
            'judul' => 'Test Notifikasi',
            'pesan' => 'Ini adalah test notifikasi real-time menggunakan Laravel Reverb',
            'data' => [
                'test' => true,
                'timestamp' => now()->toISOString()
            ]
        ]);

        // Broadcast notifikasi
        try {
            broadcast(new NotifikasiBaru($notifikasi))->toOthers();
            $this->info('Notifikasi berhasil dikirim dan di-broadcast!');
        } catch (\Exception $e) {
            $this->error('Error broadcasting notifikasi: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
