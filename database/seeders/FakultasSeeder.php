<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasSeeder extends Seeder
{

    public function run(): void
    {
        //

        $fakultas = [
            [
                'nama_fakultas' => 'Teknik',
                'akreditasi_fakultas'    => 'A', // Merah
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

        ];
        $prodi = [
            [
                'nama_prodi' => 'Teknik',
                'akreditasi_prodi'    => 'A', // Merah
                'fakultas_id' => 1,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],

        ];

        DB::table('fakultas')->insert($fakultas);
        DB::table('prodi')->insert($prodi);
    }
}
