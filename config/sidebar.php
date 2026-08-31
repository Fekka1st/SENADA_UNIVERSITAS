<?php

return [

    // ALL ROLE HAVE AND CAN GO TO DASHBOARD BUT HAVE DIFFRENT VIEW PAGE BLADE

    [
        'type'  => 'header',
        'title' => 'MENU',
        'permission' => 'all',
        // 'roles' => [1, 2], // Opsional jika header ini mau dibatasi
    ],
    [
        'type' => 'nosection',
        'title' => 'Dashboard',
        'route' => 'dashboard.index',
        'icon' => 'ti ti-layout-dashboard',
    ],

    [
        'type'  => 'header',
        'title' => 'Rencana Pengajuan',
        'permission' => 'all',
        // 'roles' => [1, 2], // Opsional jika header ini mau dibatasi
    ],
    [
        'type' => 'nosection',
        'title' => 'Pengajuan Kerja Sama',
        'route' => 'rencana-kerjasama.create',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Daftar Pengajuan',
        'route' => 'rencana-kerjasama.index',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type'  => 'header',
        'title' => 'Analitik',
        'permission' => 'all',
        // 'roles' => [1, 2], // Opsional jika header ini mau dibatasi
    ],
     [
        'type' => 'nosection',
        'title' => 'GeoMitra',
        'route' => 'geomitra.index',
        'icon' => 'ti ti-layout-dashboard',
    ],
    [
        'type'  => 'header',
        'title' => 'Manajemen Kerja Sama',
        'permission' => 'all',
        // 'roles' => [1, 2], // Opsional jika header ini mau dibatasi
    ],
    [
        'type' => 'nosection',
        'title' => 'Berkas MoU',
        'route' => 'berkas-MoU.index',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Berkas MoA',
        'route' => 'berkas-MoA.index',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Berkas IA',
        'route' => 'rencana-kerjasama.index',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type'  => 'header',
        'title' => 'Menu Lainnya',
        'permission' => 'all',
        // 'roles' => [1, 2], // Opsional jika header ini mau dibatasi
    ],
    [
        'type' => 'nosection',
        'title' => 'Log Activity',
        'route' => 'log-activity.index',
        'permission' => 'log_activity.view',
        'icon' => 'ti ti-user',
    ],


    [  // harusnya superadmin only atau admin
        'type' => 'nosection',
        'title' => 'Jenis Kegiatan',
        'route' => 'master-data.jenis_kegiatan.index',
        'icon' => 'ti ti-layout-dashboard',
    ],
    // Master Data
    [
        'section' => 'Master Data',
        'permission' => [
            'kategori_mitra.view',
            'daftar_fakultas',
            'daftar_prodi.view',
            'jenis_dokumen.view',
        ],
        'icon' => 'ti ti-book',
    ],
    [
        'type' => 'section',
        'title' => 'Sasaran Kerja',
        'route' => 'master-data.sasaran_kerja.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'kategori_mitra.view',
    ],
    [
        'type' => 'section',
        'title' => 'Kategori Mitra',
        'route' => 'master-data.kategori_mitra.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'kategori_mitra.view',
    ],
    [
        'type' => 'section',
        'title' => 'Fakultas',
        'route' => 'master-data.daftar_fakultas.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'daftar_fakultas.view',
    ],
    [
        'type' => 'section',
        'title' => 'Prodi',
        'route' => 'master-data.daftar_prodi.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'daftar_prodi.view',
    ],
    [
        'type' => 'section',
        'title' => 'Jenis Dokumen',
        'route' => 'master-data.jenis_dokumen.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'jenis_dokumen.view',
    ],

    [
        'type' => 'section',
        'title' => 'Ruang Lingkup',
        'route' => 'master-data.ruang_lingkup.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'ruang_lingkup.view',
    ],

    // Operator
    [
        'type' => 'nosection',
        'title' => 'Manajemen Mitra',
        'route' => 'Manajemen-Mitra.index',
        'permission' => 'mitra.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Manajemen Kerja Sama',
        'route' => 'Manajemen-Kerjasama.index',
        'permission' => 'kerjasama.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Repository Kerja sama',
        'route' => 'Repository_kerjasama.index',
        'permission' => 'kerjasama.view',
        'icon' => 'ti ti-user',
    ],
    [
        'type' => 'nosection',
        'title' => 'Laporan Saya',
        'route' => 'Manajemen-Kerjasama.index',
        'permission' => '',
        'icon' => 'ti ti-user',
    ],




    //SUPERADMIN
    [
        'section' => 'Pengaturan',
        'permission' => [
            'role.view',
            'user.view',
            'pengaturan.view',
            'backup_database.view',
        ],
        'icon' => 'ti ti-settings',
    ],
    [
        'type' => 'section',
        'title' => 'Manajemen Role',
        'route' => 'role.index',
        'icon' => 'ti ti-recycle',
        'permission' => 'role.view',
    ],
    [
        'type' => 'section',
        'title' => 'Manajemen User',
        'route' => 'user.index',
        'icon' => 'ti ti-user',
        'permission' => 'user.view',
    ],
    [
        'type' => 'section',
        'title' => 'Pengaturan Aplikasi',
        'route' => 'pengaturan.index',
        'icon' => 'ti ti-user',
        'permission' => 'pengaturan.view',
    ],
    [
        'type' => 'section',
        'title' => 'Backup Database',
        'route' => 'backup-database.index',
        'icon' => 'ti ti-user',
        'permission' => 'backup_database.view',
    ],
];
