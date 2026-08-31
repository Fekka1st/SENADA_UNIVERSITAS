
<x-app-layout>

    <x-slot:title>Dashboard</x-slot:title>

    {{-- Hero Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="ti ti-layout-dashboard text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Selamat Datang di {{ $pengaturan->nama_aplikasi ?? 'Sistem Informasi' }}</h2>
                    <p class="text-muted fs-5 mb-4">
                        Halo, <strong>{{ $user->nama_user }}</strong>!
                        <br>
                        Anda login sebagai <span class="badge bg-primary">{{ $user->roleModel->nama }}</span>
                    </p>

                    <div class="alert alert-info mx-auto" role="alert" style="max-width: 600px;">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Template Siap Digunakan</strong>
                        <p class="mb-0 mt-2">
                            Sistem ini telah dibersihkan dan siap dikembangkan untuk proyek baru Sistem Informasi Akademik Digital (SIAD).
                            Fitur core seperti authentication, permission, notifikasi, dan backup database tetap tersedia.
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">
                            <i class="ti ti-clock me-1"></i>
                            Login terakhir: {{ now()->format('d F Y, H:i') }} WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-users fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Total Users</h6>
                            <h3 class="mb-0">{{ \App\Models\User::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-shield-check fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Total Roles</h6>
                            <h3 class="mb-0">{{ \App\Models\Role::count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-bell fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Notifikasi Belum Dibaca</h6>
                            <h3 class="mb-0">{{ $user->jumlah_notifikasi_belum_dibaca }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>


