<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permissions')->truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Definisi permissions - Core System Only
        $permissions = [
            // Dashboard Module
            ['name' => 'dashboard.view', 'display_name' => 'Lihat Dashboard', 'module' => 'dashboard'],


            // Log Activity
            ['name' => 'log_activity.view', 'display_name' => 'Lihat Log Aktifitas', 'module' => 'logactivity'],
            ['name' => 'log_activity.export', 'display_name' => 'Cetak Excel Log Aktifitas', 'module' => 'logactivity'],

            // Role Management Module
            ['name' => 'role.view', 'display_name' => 'Lihat Role', 'module' => 'role'],
            ['name' => 'role.create', 'display_name' => 'Buat Role', 'module' => 'role'],
            ['name' => 'role.edit', 'display_name' => 'Edit Role', 'module' => 'role'],
            ['name' => 'role.delete', 'display_name' => 'Hapus Role', 'module' => 'role'],

            // User Management Module
            ['name' => 'user.view', 'display_name' => 'Lihat User', 'module' => 'user'],
            ['name' => 'user.create', 'display_name' => 'Buat User', 'module' => 'user'],
            ['name' => 'user.edit', 'display_name' => 'Edit User', 'module' => 'user'],
            ['name' => 'user.delete', 'display_name' => 'Hapus User', 'module' => 'user'],

            // Pengaturan Module
            ['name' => 'pengaturan.view', 'display_name' => 'Lihat Pengaturan', 'module' => 'pengaturan'],
            ['name' => 'pengaturan.edit', 'display_name' => 'Edit Pengaturan', 'module' => 'pengaturan'],

            // Backup Database Module
            ['name' => 'backup_database.view', 'display_name' => 'Lihat Backup Database', 'module' => 'backup_database'],
            ['name' => 'backup_database.create', 'display_name' => 'Buat Backup Database', 'module' => 'backup_database'],
            ['name' => 'backup_database.download', 'display_name' => 'Download Backup Database', 'module' => 'backup_database'],
            ['name' => 'backup_database.delete', 'display_name' => 'Hapus Backup Database', 'module' => 'backup_database'],

            // Profile Module
            ['name' => 'profile.edit', 'display_name' => 'Edit Profil', 'module' => 'profile'],
            ['name' => 'password.change', 'display_name' => 'Ubah Password', 'module' => 'profile'],

            // Verification Data Module
            ['name' => 'verification.view_queue', 'display_name' => 'Antrian Pengajuan', 'module' => 'verification'],
            ['name' => 'verification.view_history', 'display_name' => 'Riwayat Pengajuan', 'module' => 'verification'],

            // Manajemen Mitra
            ['name' => 'mitra.view', 'display_name' => 'Manajemen Mitra', 'module' => 'mitra'],
            ['name' => 'mitra.delete', 'display_name' => 'Hapus Mitra', 'module' => 'mitra'],
            ['name' => 'mitra.edit', 'display_name' => 'Edit Mitra', 'module' => 'mitra'],
            ['name' => 'mitra.create', 'display_name' => 'Tambah Mitra', 'module' => 'mitra'],
            ['name' => 'mitra.detail', 'display_name' => 'Detail Mitra', 'module' => 'mitra'],

            // Manajemen Pengajuan Rencana Kerjasama (Tahap Diskusi/Rencana)
            ['name' => 'rencana_kerjasama.view', 'display_name' => 'Lihat Rencana Kerjasama', 'module' => 'rencana_kerjasama'],
            ['name' => 'rencana_kerjasama.create', 'display_name' => 'Tambah Rencana Kerjasama', 'module' => 'rencana_kerjasama'],
            ['name' => 'rencana_kerjasama.edit', 'display_name' => 'Edit Rencana Kerjasama', 'module' => 'rencana_kerjasama'],
            ['name' => 'rencana_kerjasama.delete', 'display_name' => 'Hapus Rencana Kerjasama', 'module' => 'rencana_kerjasama'],
            ['name' => 'rencana_kerjasama.feedback', 'display_name' => 'Berikan Feedback Rencana', 'module' => 'rencana_kerjasama'],

            // Manajemen berkas_moun MoU (Final Dokumen)
            ['name' => 'berkas_mou.view', 'display_name' => 'Lihat Pengajuan MoU', 'module' => 'berkas_mou'],
            ['name' => 'berkas_mou.create', 'display_name' => 'Tambah/Finalisasi MoU', 'module' => 'berkas_mou'],
            ['name' => 'berkas_mou.edit', 'display_name' => 'Edit Pengajuan MoU', 'module' => 'berkas_mou'],
            ['name' => 'berkas_mou.delete', 'display_name' => 'Hapus Pengajuan MoU', 'module' => 'berkas_mou'],

            // Manajemen Pengajuan MoA (Fakultas)
            ['name' => 'berkas_moa.view', 'display_name' => 'Lihat Pengajuan MoA', 'module' => 'berkas_moa'],
            ['name' => 'berkas_moa.create', 'display_name' => 'Tambah Pengajuan MoA', 'module' => 'berkas_moa'],
            ['name' => 'berkas_moa.edit', 'display_name' => 'Edit Pengajuan MoA', 'module' => 'berkas_moa'],
            ['name' => 'berkas_moa.delete', 'display_name' => 'Hapus Pengajuan MoA', 'module' => 'berkas_moa'],

            // Manajemen Implementation Arrangement (IA / Kegiatan)
            ['name' => 'berkas_ia.view', 'display_name' => 'Lihat Kegiatan (IA)', 'module' => 'berkas_ia'],
            ['name' => 'berkas_ia.create', 'display_name' => 'Tambah Kegiatan (IA)', 'module' => 'berkas_ia'],
            ['name' => 'berkas_ia.edit', 'display_name' => 'Edit Kegiatan (IA)', 'module' => 'berkas_ia'],
            ['name' => 'berkas_ia.delete', 'display_name' => 'Hapus Kegiatan (IA)', 'module' => 'berkas_ia'],

            // Manajemen Kerja Sama
            ['name' => 'kerjasama.view', 'display_name' => 'Manajemen kerjasama', 'module' => 'kerjasama'],
            ['name' => 'kerjasama.delete', 'display_name' => 'Hapus kerjasama', 'module' => 'kerjasama'],
            ['name' => 'kerjasama.edit', 'display_name' => 'Edit kerjasama', 'module' => 'kerjasama'],
            ['name' => 'kerjasama.create', 'display_name' => 'Tambah kerjasama', 'module' => 'kerjasama'],
            ['name' => 'kerjasama.detail', 'display_name' => 'Detail kerjasama', 'module' => 'kerjasama'],

             // Manajemen Repository
            ['name' => 'repository.view', 'display_name' => 'Manajemen repository', 'module' => 'repository'],
            ['name' => 'repository.delete', 'display_name' => 'Hapus repository', 'module' => 'repository'],
            ['name' => 'repository.edit', 'display_name' => 'Edit repository', 'module' => 'repository'],
            ['name' => 'repository.create', 'display_name' => 'Tambah repository', 'module' => 'repository'],
            ['name' => 'repository.detail', 'display_name' => 'Detail repository', 'module' => 'repository'],
            //Master Data Modul

            // Kategori_Mitra , Ruang_Lingkup, Jenis_Dokumen, Daftar_Fakultas, Daftar_Prodi
            ['name' => 'kategori_mitra.view', 'display_name' => 'Manajemen kategori_mitra', 'module' => 'masterdata'],
            ['name' => 'kategori_mitra.delete', 'display_name' => 'Hapus kategori_mitra', 'module' => 'masterdata'],
            ['name' => 'kategori_mitra.edit', 'display_name' => 'Edit kategori_mitra', 'module' => 'masterdata'],
            ['name' => 'kategori_mitra.create', 'display_name' => 'Tambah kategori_mitra', 'module' => 'masterdata'],

            ['name' => 'ruang_lingkup.view', 'display_name' => 'Manajemen ruang_lingkup', 'module' => 'masterdata'],
            ['name' => 'ruang_lingkup.delete', 'display_name' => 'Hapus ruang_lingkup', 'module' => 'masterdata'],
            ['name' => 'ruang_lingkup.edit', 'display_name' => 'Edit ruang_lingkup', 'module' => 'masterdata'],
            ['name' => 'ruang_lingkup.create', 'display_name' => 'Tambah ruang_lingkup', 'module' => 'masterdata'],

            ['name' => 'jenis_dokumen.view', 'display_name' => 'Manajemen jenis_dokumen', 'module' => 'masterdata'],
            ['name' => 'jenis_dokumen.delete', 'display_name' => 'Hapus jenis_dokumen', 'module' => 'masterdata'],
            ['name' => 'jenis_dokumen.edit', 'display_name' => 'Edit jenis_dokumen', 'module' => 'masterdata'],
            ['name' => 'jenis_dokumen.create', 'display_name' => 'Tambah jenis_dokumen', 'module' => 'masterdata'],

            ['name' => 'daftar_fakultas.view', 'display_name' => 'Manajemen daftar_fakultas', 'module' => 'masterdata'],
            ['name' => 'daftar_fakultas.delete', 'display_name' => 'Hapus daftar_fakultas', 'module' => 'masterdata'],
            ['name' => 'daftar_fakultas.edit', 'display_name' => 'Edit daftar_fakultas', 'module' => 'masterdata'],
            ['name' => 'daftar_fakultas.create', 'display_name' => 'Tambah daftar_fakultas', 'module' => 'masterdata'],
            ['name' => 'daftar_fakultas.detail', 'display_name' => 'Cek Daftar Prodi Fakultas', 'module' => 'masterdata'],

            ['name' => 'daftar_prodi.view', 'display_name' => 'Manajemen daftar_prodi', 'module' => 'masterdata'],
            ['name' => 'daftar_prodi.delete', 'display_name' => 'Hapus daftar_prodi', 'module' => 'masterdata'],
            ['name' => 'daftar_prodi.edit', 'display_name' => 'Edit daftar_prodi', 'module' => 'masterdata'],
            ['name' => 'daftar_prodi.create', 'display_name' => 'Tambah daftar_prodi', 'module' => 'masterdata'],

            //Laporan Laporan Saya ( Per fakultas ), Laporan Peta Sebaran Mitra, Membuat Laporan ( Khusus Univ bisa juga buat rektor)
            //Peta Navigasi
            // Direktori Mitra
            // Profile Fakultas


        ];

        // Insert permissions
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Assign permissions ke role berdasarkan sistem saat ini
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles()
    {
        // Role 1: Super Admin - Full Access
        $superAdmin = Role::find(1);
        if ($superAdmin) {
            $allPermissions = Permission::all()->pluck('id')->toArray();
            $superAdmin->permissions()->sync($allPermissions);
        }

        // Role 2: Admin Universitas
        $admin = Role::find(2);
        if ($admin) {
            $admin->permissions()->sync([
                Permission::where('name', 'dashboard.view')->first()->id,
                Permission::where('name', 'role.view')->first()->id,
                Permission::where('name', 'role.create')->first()->id,
                Permission::where('name', 'role.edit')->first()->id,
                Permission::where('name', 'user.view')->first()->id,
                Permission::where('name', 'user.create')->first()->id,
                Permission::where('name', 'user.edit')->first()->id,
                Permission::where('name', 'pengaturan.view')->first()->id,
                Permission::where('name', 'pengaturan.edit')->first()->id,
                Permission::where('name', 'backup_database.view')->first()->id,
                Permission::where('name', 'backup_database.create')->first()->id,
                Permission::where('name', 'backup_database.download')->first()->id,
                Permission::where('name', 'profile.edit')->first()->id,
                Permission::where('name', 'password.change')->first()->id,

                Permission::where('name','daftar_fakultas.view')->first()->id,
                Permission::where('name','daftar_prodi.view')->first()->id,
                Permission::where('name','repository.view')->first()->id,
                // Permission::where('name','kerjasama.view')->first()->id,
                Permission::where('name','mitra.view')->first()->id,
                Permission::where('name','rencana_kerjasama.view')->first()->id,
                Permission::where('name','berkas_mou.view')->first()->id,
                Permission::where('name','berkas_moa.view')->first()->id,
                Permission::where('name','berkas_ia.view')->first()->id,
            ]);
        }

        // Role 3: Rektor
        $user = Role::find(3);
        if ($user) {
            $user->permissions()->sync([
                Permission::where('name', 'dashboard.view')->first()->id,
                Permission::where('name', 'profile.edit')->first()->id,
                Permission::where('name', 'password.change')->first()->id,

                Permission::where('name', 'repository.view')->first()->id,
                Permission::where('name','mitra.view')->first()->id,
                Permission::where('name','rencana_kerjasama.view')->first()->id,
                Permission::where('name','berkas_mou.view')->first()->id,
                Permission::where('name','berkas_moa.view')->first()->id,
                Permission::where('name','berkas_ia.view')->first()->id,
            ]);
        }

        // Role 4: Prodi
        $guest = Role::find(4);
        if ($guest) {
            $guest->permissions()->sync([
                Permission::where('name', 'dashboard.view')->first()->id,
                Permission::where('name', 'profile.edit')->first()->id,
                Permission::where('name', 'password.change')->first()->id,
                Permission::where('name', 'mitra.view')->first()->id,
                Permission::where('name', 'mitra.delete')->first()->id,
                Permission::where('name', 'mitra.edit')->first()->id,
                Permission::where('name', 'mitra.create')->first()->id,
                Permission::where('name', 'mitra.detail')->first()->id,
                Permission::where('name', 'kerjasama.view')->first()->id,
                Permission::where('name', 'kerjasama.delete')->first()->id,
                Permission::where('name', 'kerjasama.edit')->first()->id,
                Permission::where('name', 'kerjasama.create')->first()->id,
                Permission::where('name', 'kerjasama.detail')->first()->id,
                Permission::where('name', 'repository.view')->first()->id,
                Permission::where('name', 'repository.delete')->first()->id,
                Permission::where('name', 'repository.edit')->first()->id,
                Permission::where('name', 'repository.create')->first()->id,
                Permission::where('name', 'repository.detail')->first()->id,
            ]);
        }

        //Role Prodi
        // $prodi = Role::find(4);
        // if ($prodi) {
        //     $prodiPermissions = Permission::whereIn('module', [
        //         'dashboard',
        //         'profile',
        //         'mitra',
        //         'rencana_kerjasama',
        //         'berkas_moa',
        //         'berkas_ia',
        //         'berkas_mou'
        //     ])->pluck('id')->toArray();

            // Tambahkan akses View saja untuk MoU (Level Universitas)
            // $viewMouId = Permission::where('name', 'berkas_mou.view')->first()->id;
            // $prodiPermissions[] = $viewMouId;
            // $prodi->permissions()->sync($prodiPermissions);
        // }
    }
}
