<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengaturan')->updateOrInsert(['id_pengaturan' => 1], [
            'id_pengaturan' => 1,
            'nama_aplikasi' => 'SIAD Nama PT - Web',
            'kepanjangan_aplikasi' => 'Sistem Informasi Administrasi Digital Nama PT - Web',
            'nama_copyright' => 'Nama Perguruan Tinggi',
            'tema_warna_utama' => '#14438B',
            'logo_instnasi' => null,
            'favicon' => null,
            'background_login' => null,
            'sosmed_facebook' => 'https://facebook.com/#',
            'sosmed_twitter' => 'https://twitter.com/#',
            'sosmed_instagram' => 'https://instagram.com/#',
            'sosmed_youtube' => 'https://youtube.com/#',
            'sosmed_tiktok' => 'https://tiktok.com/#',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}