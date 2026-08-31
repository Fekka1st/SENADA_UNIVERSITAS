<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriMitra extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'nama_kategori' => 'Instansi Pemerintah',
                'warna_peta'    => '#e74c3c', // Merah
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Perusahaan Swasta',
                'warna_peta'    => '#3498db', // Biru
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Perguruan Tinggi',
                'warna_peta'    => '#f1c40f', // Kuning
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Lembaga Non-Profit (NGO)',
                'warna_peta'    => '#2ecc71', // Hijau
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'nama_kategori' => 'Badan Usaha Milik Negara (BUMN)',
                'warna_peta'    => '#9b59b6', // Ungu
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        DB::table('kategori_mitra')->insert($categories);
    }
}
