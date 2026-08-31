<x-app-layout>
    <x-slot:title>Dashboard Ekosistem SENADA</x-slot:title>

    <style>
        /* Desain Latar Belakang & Efek Hero */
        .hero-banner {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            border-radius: 24px;
            position: relative;
            overflow: hidden;
        }
        .hero-pattern {
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* Kartu Statistik Profesional */
        .stat-card {
            border-radius: 20px;
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        }

        /* Ikon Dinamis */
        .icon-box-wrapper {
            width: 54px; height: 54px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 14px;
        }

        /* Pengumuman Glassmorphism */
        .announcement-card {
            background: #fff;
            border-left: 5px solid #3b82f6;
            border-radius: 16px;
        }
    </style>

    <div class="container-fluid pb-5">

        {{-- SECTION 1: HERO GREETING CARD --}}
        <div class="hero-banner p-4 p-md-5 mb-4 shadow-lg position-relative">
            <div class="hero-pattern"></div>
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-md-8 text-white">
                    <h1 class="display-5 fw-bold mb-2">Halo, {{ $user->nama_user }}!</h1>
                    <p class="fs-5 opacity-90 mb-0 text-white">Selamat datang kembali di sistem navigasi data kerjasama <strong>SENADA</strong>. Mari kelola arsip <strong>{{ $user->fakultas->nama_fakultas ?? 'Unit Kerja' }}</strong> hari ini.</p>
                </div>
                <div class="col-md-4 text-md-end mt-4 mt-md-0">
                    <div class="d-inline-block bg-white bg-opacity-30 p-3 rounded-4 backdrop-blur border border-white border-opacity-50 shadow-sm">
                        <h6 class="mb-1 small text-uppercase opacity-90 fw-bold spacing-1">Waktu Server (Real-time)</h6>
                        <h4 class="mb-0 fw-bold d-flex align-items-center justify-content-md-end">
                            <i class="ti ti-clock-play me-2"></i>
                            {{-- Kita beri ID di sini --}}
                            <span id="realtime-clock">{{ now()->translatedFormat('H:i:s') }}</span>
                            {{-- <span class="ms-2">WIB</span> --}}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: ALERT REVISI (Jika Ada) --}}
        <div class="container-fluid">
        {{-- SECTION 1: ALERT REVISI --}}
        @if($perlu_revisi > 0)
            <div class="alert alert-danger border-0 border-start border-4 border-danger shadow-sm d-flex align-items-center mb-4 bg-white" role="alert">
                <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-circle me-3">
                    <i class="ti ti-alert-triangle fs-3"></i>
                </div>
                <div class="flex-grow-1">
                    <h5 class="alert-heading fw-bold mb-1 text-danger">Tindakan Diperlukan!</h5>
                    <p class="mb-0 text-muted">Terdapat <strong>{{ $perlu_revisi }} pengajuan</strong> yang dikembalikan untuk direvisi. Mohon segera diperbaiki.</p>
                </div>
                <a href="#tabel-pekerjaan" class="btn btn-danger fw-bold rounded-pill px-4">Perbaiki</a>
            </div>
        @endif

        {{-- SECTION 2: STATS CARDS (REPOSITORY & PENGAJUAN) --}}
        <div class="row mb-4 g-3">
            {{-- Total Repository --}}
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="text-muted fw-semibold text-uppercase fs-7">Total Arsip</span>
                                <h2 class="fw-bolder mb-0 text-dark mt-2">{{ $total_repo }}</h2>
                            </div>
                            <div class="icon-shape-lg bg-light-primary text-primary">
                                <i class="ti ti-archive fs-3"></i>
                            </div>
                        </div>
                        <small class="text-muted">Seluruh dokumen repository</small>
                    </div>
                </div>
            </div>

            {{-- Repository Aktif --}}
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="text-muted fw-semibold text-uppercase fs-7">Arsip Aktif</span>
                                <h2 class="fw-bolder mb-0 text-success mt-2">{{ $repo_aktif }}</h2>
                            </div>
                            <div class="icon-shape-lg bg-light-success text-success">
                                <i class="ti ti-checkbox fs-3"></i>
                            </div>
                        </div>
                        <small class="text-muted">Dokumen masa berlaku aktif</small>
                    </div>
                </div>
            </div>

            {{-- Repository Kadaluarsa --}}
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="text-muted fw-semibold text-uppercase fs-7">Kadaluarsa</span>
                                <h2 class="fw-bolder mb-0 text-danger mt-2">{{ $repo_kadaluarsa }}</h2>
                            </div>
                            <div class="icon-shape-lg bg-light-danger text-danger">
                                <i class="ti ti-calendar-off fs-3"></i>
                            </div>
                        </div>
                        <small class="text-muted">Dokumen sudah berakhir</small>
                    </div>
                </div>
            </div>

            {{-- Total Pengajuan --}}
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm card-hover">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="text-muted fw-semibold text-uppercase fs-7">Total Pengajuan</span>
                                <h2 class="fw-bolder mb-0 text-info mt-2">{{ $total_pengajuan }}</h2>
                            </div>
                            <div class="icon-shape-lg bg-light-info text-info">
                                <i class="ti ti-file-export fs-3"></i>
                            </div>
                        </div>
                        <small class="text-muted">Proses pengajuan kerjasama</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 4: WORKSPACE & ACTION CENTER --}}
        <div class="row g-4">
            <div class="col-lg-8" id="tabel-pekerjaan">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <div class="card-header bg-white py-4 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-layout-list fs-3 text-primary me-3"></i>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Antrean Pekerjaan Saya</h5>
                                <p class="text-muted small mb-0">Draf pengajuan yang belum terselesaikan</p>
                            </div>
                        </div>
                        <a href="{{ route('Manajemen-Kerjasama.index') }}" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary">
                            Lihat Semua <i class="ti ti-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light-primary text-primary small fw-bold">
                                    <tr>
                                        <th class="ps-4 py-3">JUDUL DOKUMEN</th>
                                        <th>MITRA KERJASAMA</th>
                                        <th>STATUS</th>
                                        <th class="text-end pe-4">TINDAKAN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($draft_saya as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="fw-bold text-dark"><i class="ti ti-file-description me-2 text-muted"></i>{{ $item->title }}</div>
                                                <div class="text-muted smaller mt-1"><i class="ti ti-clock me-1"></i>Update: {{ $item->updated_at->diffForHumans() }}</div>
                                            </td>
                                            <td>
                                                <span class="text-dark small"><i class="ti ti-building-community me-1"></i>{{ $item->mitra->nama_mitra ?? '-' }}</span>
                                            </td>
                                            <td>
                                                @if($item->status_label == 'rejected')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2"><i class="ti ti-repeat me-1"></i>Revisi</span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-dark rounded-pill px-3 py-2"><i class="ti ti-pencil me-1"></i>Draf</span>
                                                @endif
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('Manajemen-Kerjasama.edit', $item->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <i class="ti ti-coffee fs-1 text-muted mb-3 d-block"></i>
                                                <h6 class="text-muted fw-bold">Waktunya Santai Sejenak!</h6>
                                                <p class="text-muted small">Tidak ada draf atau revisi yang menunggu.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- CARD: ACTION CENTER --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="mb-0 fw-bold text-uppercase text-muted small"><i class="ti ti-rocket me-2"></i>Aksi Cepat</h6>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="d-grid gap-3">
                            <a href="{{ route('Repository_kerjasama.create') }}" class="btn btn-white border border-2 border-primary text-primary p-3 rounded-4 stat-card text-start d-flex align-items-center">
                                <div class="icon-box-wrapper bg-primary text-white me-3" style="width: 42px; height: 42px;">
                                    <i class="ti ti-folder-plus fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Unggah Arsip</div>
                                    <small class="text-muted">Input ke Repository</small>
                                </div>
                            </a>
                            <a href="{{ route('Manajemen-Kerjasama.create') }}" class="btn btn-primary p-3 rounded-4 stat-card text-start d-flex align-items-center shadow-lg border-0">
                                <div class="icon-box-wrapper bg-white text-primary me-3" style="width: 42px; height: 42px;">
                                    <i class="ti ti-pencil-plus fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-white">Buat Pengajuan</div>
                                    <small class="text-white-50">Draft Kerjasama Baru</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- CARD: ANNOUNCEMENT (DIBUAT LEBIH MENARIK) --}}
                {{-- <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="p-2 bg-primary bg-opacity-10 text-primary rounded me-3">
                                <i class="ti ti-news fs-3"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Informasi Terbaru</h5>
                        </div>
                        <div class="p-3 bg-light rounded-4 border-start border-primary border-4 mb-3">
                            <p class="mb-2 fw-bold text-primary small"><i class="ti ti-bell me-1"></i>Peringatan Penginputan</p>
                            <p class="mb-0 text-dark small" style="line-height: 1.6;">
                                Batas akhir penginputan data kerja sama semester ini adalah <strong>30 Desember 2025</strong>. Pastikan dokumen <strong>IA</strong> sudah terunggah.
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-4 pt-3 border-top">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=Admin+Univ&background=random" class="rounded-circle me-2" width="24" alt="AV">
                                <span class="smaller text-muted fw-bold">Admin Universitas</span>
                            </div>
                            <span class="smaller text-muted italic">Hari ini</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.37.1/dist/tabler-icons.min.css">
    <script>
        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            if (!clockElement) return;
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            clockElement.textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>

</x-app-layout>
