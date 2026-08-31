<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RuangLingkupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $ruanglingkup = [
            [
                'nama_ruanglingkup' => 'Bidang Pendidikan dan Pengajaran',
                'keterangan'        => 'Mencakup pertukaran pelajar, pengembangan kurikulum bersama, dosen tamu, dan program Merdeka Belajar Kampus Merdeka (MBKM).',
            ],
            [
                'nama_ruanglingkup' => 'Penelitian dan Pengembangan',
                'keterangan'        => 'Kolaborasi riset antar institusi, publikasi jurnal bersama, pemanfaatan laboratorium, serta pengembangan inovasi teknologi.',
            ],
            [
                'nama_ruanglingkup' => 'Pengabdian kepada Masyarakat',
                'keterangan'        => 'Program pemberdayaan desa, KKN tematik, penyuluhan masyarakat, dan penerapan hasil riset untuk solusi masalah sosial.',
            ],
            [
                'nama_ruanglingkup' => 'Pemanfaatan Sumber Daya Manusia',
                'keterangan'        => 'Program magang mahasiswa, rekrutmen lulusan (job fair), serta pelatihan peningkatan kompetensi staf dan dosen.',
            ],
            [
                'nama_ruanglingkup' => 'Penyelenggaraan Seminar dan Workshop',
                'keterangan'        => 'Kerjasama dalam mengadakan konferensi ilmiah internasional, webinar nasional, dan pelatihan teknis bersertifikasi.',
            ],
        ];

        DB::table('ruanglingkup')->insert($ruanglingkup);
    }
}
