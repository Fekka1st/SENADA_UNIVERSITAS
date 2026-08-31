<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_inisial' => 'MoU',
                'nama_jenis'   => 'Memorandum of Understanding',
                'keterangan'   => 'Nota kesepahaman yang bersifat umum dan tidak mengikat secara operasional.',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'kode_inisial' => 'MoA',
                'nama_jenis'   => 'Memorandum of Agreement',
                'keterangan'   => 'Perjanjian kerja sama yang lebih spesifik mengenai hak dan kewajiban para pihak.',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
            [
                'kode_inisial' => 'IA',
                'nama_jenis'   => 'Implementation Arrangement',
                'keterangan'   => 'Dokumen teknis pelaksanaan kegiatan (Implementation Arrangement).',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ],
        ];
        DB::table('jenis_dokumen')->insert($data);
    }
}
