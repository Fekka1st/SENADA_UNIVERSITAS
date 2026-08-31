<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nama' => 'Super Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'nama' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'nama' => 'Pimpinan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'nama' => 'Fakultas', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'nama' => 'Prodi', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'nama' => 'Legal', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            DB::table('role')->updateOrInsert(
                ['id' => $role['id']],
                $role
            );
        }
    }
}
