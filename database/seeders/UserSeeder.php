<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus users lama kecuali yang akan diupdate
        // Hapus constraint sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = [
            // SUPER ADMIN
            [
                'id' => 1,
                'nama_user' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('123'),
                'role' => 1, // Super Admin
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_user' => 'admin',
                'username' => 'admin',
                'password' => Hash::make('123'),
                'role' => 2, // Admin
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nama_user' => 'Rektor',
                'username' => 'Rektor',
                'password' => Hash::make('123'),
                'role' => 3, // Rektro atau Pimpinan
                'foto' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'id' => 4,
            //     'nama_user' => 'Operator',
            //     'username' => 'operator',
            //     'password' => Hash::make('123'),
            //     'role' => 4, // Operator
            //     'foto' => null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],

            // wajib di isi prodi_id dan fakultas_id untuk role prodi
            [
                'id' => 4,
                'nama_user' => 'Prodi',
                'username' => 'prodi',
                'password' => Hash::make('123'),
                'role' => 4, // Prodi
                'foto' => null,
                'prodi_id' => 1,
                'fakultas_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 5,
                'nama_user' => 'Fakultas',
                'username' => 'fakultas',
                'password' => Hash::make('123'),
                'role' => 5, // Prodi
                'foto' => null,
                'prodi_id' => 1,
                'fakultas_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
