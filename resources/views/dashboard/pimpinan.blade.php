<x-app-layout>
    <x-slot:title>Dashboard Eksekutif</x-slot:title>

    {{-- Custom CSS untuk Dashboard Pimpinan --}}
    <style>
        .card-hover {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
        }
        .icon-shape-lg {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
        }
        .bg-gradient-primary-soft {
            background: linear-gradient(135deg, #e0e7ff 0%, #ffffff 100%);
        }
        .text-gradient-primary {
            background: linear-gradient(45deg, #4f46e5, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .map-preview-container {
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg');
            background-size: cover;
            background-position: center;
            height: 220px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
        }
        .map-overlay {
            background: rgba(17, 24, 39, 0.65);
            backdrop-filter: blur(2px);
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        .map-preview-container:hover .map-overlay {
            background: rgba(17, 24, 39, 0.5);
        }
        .progress-thin {
            height: 6px;
            border-radius: 10px;
            background-color: #f1f5f9;
        }
    </style>

    {{-- SECTION 1: KEY PERFORMANCE INDICATORS (KPI) --}}
    <div class="row mb-4 g-4">
        {{-- Widget 1: Total MoU --}}
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="text-uppercase fw-bold text-muted fs-7 ls-1 d-block mb-1">Total MoU</span>
                            <h2 class="display-6 fw-bolder mb-0 text-dark">{{ $total_mou ?? 0 }}</h2>
                        </div>
                        <div class="icon-shape-lg bg-indigo bg-opacity-10 text-indigo shadow-sm" style="background-color: #eef2ff; color: #4f46e5;">
                            <i class="ti ti-file-certificate fs-2"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-green-100 text-green-700 bg-light-success text-success px-2 py-1 rounded-pill me-2">
                            <i class="ti ti-check me-1"></i> Aktif
                        </span>
                        <small class="text-muted fs-7">Nota Kesepahaman</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Widget 2: Total MoA --}}
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="text-uppercase fw-bold text-muted fs-7 ls-1 d-block mb-1">Total MoA</span>
                            <h2 class="display-6 fw-bolder mb-0 text-dark">{{ $total_moa ?? 0 }}</h2>
                        </div>
                        <div class="icon-shape-lg bg-azure bg-opacity-10 text-azure shadow-sm" style="background-color: #e0f2fe; color: #0284c7;">
                            <i class="ti ti-files fs-2"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light-info text-info px-2 py-1 rounded-pill me-2">
                            <i class="ti ti-link me-1"></i> PKS
                        </span>
                        <small class="text-muted fs-7">Perjanjian Kerja Sama</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Widget 3: Total IA --}}
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm card-hover overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="text-uppercase fw-bold text-muted fs-7 ls-1 d-block mb-1">Implementasi (IA)</span>
                            <h2 class="display-6 fw-bolder mb-0 text-dark">{{ $total_ia ?? 0 }}</h2>
                        </div>
                        <div class="icon-shape-lg bg-teal bg-opacity-10 text-teal shadow-sm" style="background-color: #ecfdf5; color: #059669;">
                            <i class="ti ti-activity-heartbeat fs-2"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-light-success text-success px-2 py-1 rounded-pill me-2">
                            <i class="ti ti-chart-arrows-vertical me-1"></i> Realisasi
                        </span>
                        <small class="text-muted fs-7">Kegiatan Berjalan</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Widget 4: Mitra Aktif (Special Card) --}}
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm card-hover text-white overflow-hidden" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);">
                {{-- Background Pattern --}}
                <div class="position-absolute top-0 end-0 opacity-10 p-3">
                    <i class="ti ti-world fs-1" style="font-size: 8rem !important;"></i>
                </div>

                <div class="card-body p-4 position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="text-white text-opacity-75 text-uppercase fw-bold fs-7 ls-1 d-block mb-1">Mitra Bergabung</span>
                            <h2 class="display-6 fw-bolder mb-0 text-white">{{ $total_mitra ?? 0 }}</h2>
                        </div>
                        <div class="icon-shape-lg bg-white bg-opacity-25 text-white shadow-none">
                            <i class="ti ti-building-community fs-2"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-white text-opacity-75">
                        <small class="fs-7">Total Instansi & Industri</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 2: VISUALISASI DATA --}}
    <div class="row mb-4 g-4">
        {{-- Grafik Pertumbuhan --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Tren Kerja Sama</h5>
                            <small class="text-muted">Statistik pertumbuhan dokumen per bulan</small>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                <i class="ti ti-calendar me-1"></i> Tahun {{ date('Y') }}
                            </button>
                            <ul class="dropdown-menu shadow-sm border-0">
                                <li><a class="dropdown-item" href="#">2025</a></li>
                                <li><a class="dropdown-item" href="#">2024</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    {{-- Placeholder Grafik Chart.js --}}
                    <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded-3 p-5" style="height: 320px; border: 2px dashed #e2e8f0;">
                        <div class="text-center">
                            <div class="mb-3 p-3 bg-white rounded-circle shadow-sm d-inline-block">
                                <i class="ti ti-chart-bar fs-1 text-primary"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Analisis Tren Data</h6>
                            <p class="text-muted fs-7 mb-0 px-5">Area ini siap untuk integrasi Chart.js. Grafik akan menampilkan perbandingan MoU, MoA, dan IA.</p>
                        </div>
                        <canvas id="cooperationTrendChart" style="max-height: 300px; display: none;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigasi Peta Mini --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-header bg-white py-3 px-4 border-bottom border-light">
                    <h5 class="mb-0 fw-bold text-dark">Sebaran Mitra</h5>
                    <small class="text-muted">Distribusi geografis mitra kerja sama</small>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        <div class="map-preview-container">
                            <div class="map-overlay p-4 text-center">
                                <h5 class="text-white fw-bold mb-1">Peta Interaktif</h5>
                                <p class="text-white text-opacity-75 fs-7 mb-3">Lihat detail lokasi dan klaster mitra</p>
                                <a href="" class="btn btn-primary rounded-pill px-4 fw-bold shadow-lg hover-scale">
                                    <i class="ti ti-maximize me-2"></i> Buka Fullscreen
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-4 pt-2">
                        <h6 class="fw-bold mb-3 fs-7 text-uppercase text-muted spacing-1">Top Negara Mitra</h6>

                        {{-- List Negara dengan Progress Bar --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    <span class="fs-5 me-2">🇮🇩</span> <span class="fw-semibold fs-7 text-dark">Indonesia</span>
                                </div>
                                <span class="fs-7 fw-bold text-primary">85%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 85%"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    <span class="fs-5 me-2">🇯🇵</span> <span class="fw-semibold fs-7 text-dark">Jepang</span>
                                </div>
                                <span class="fs-7 fw-bold text-info">10%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 10%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="d-flex align-items-center">
                                    <span class="fs-5 me-2">🇲🇾</span> <span class="fw-semibold fs-7 text-dark">Malaysia</span>
                                </div>
                                <span class="fs-7 fw-bold text-warning">5%</span>
                            </div>
                            <div class="progress progress-thin">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 5%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION 3: TOP MITRA & DOWNLOAD --}}
    <div class="row g-4">
        {{-- Top 5 Mitra Strategis --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100 rounded-3">
                <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom border-light">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">Mitra Paling Aktif</h5>
                        <small class="text-muted">Top 5 mitra berdasarkan jumlah dokumen disetujui</small>
                    </div>
                    <a href="" class="btn btn-sm btn-light text-primary fw-bold rounded-pill px-3">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-uppercase fs-7 text-muted">
                                    <th class="ps-4 py-3" style="width: 50px;">#</th>
                                    <th>Nama Mitra</th>
                                    <th>Kategori</th>
                                    <th class="text-center">Dokumen</th>
                                    <th class="text-end pe-4">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Variable: $top_mitra (Collection) --}}
                                @forelse($top_mitra ?? [] as $index => $mitra)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="avatar avatar-sm rounded-circle bg-light text-dark fw-bold fs-7">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm rounded bg-primary-subtle text-primary fw-bold me-3">
                                                    {{ substr($mitra->name, 0, 1) }}
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bold text-dark">{{ $mitra->name }}</span>
                                                    <small class="text-muted text-truncate" style="max-width: 200px;">{{ $mitra->website ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-white text-secondary border border-secondary-subtle">
                                                {{ $mitra->category->name ?? 'Umum' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3">
                                                {{ $mitra->cooperations_count }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="#" class="btn btn-icon btn-sm btn-light text-muted">
                                                <i class="ti ti-chevron-right"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="mb-3 text-muted opacity-50">
                                                <i class="ti ti-database-off fs-1"></i>
                                            </div>
                                            <p class="text-muted mb-0">Belum ada data kerja sama yang disetujui.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Laporan Cepat --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 rounded-3 bg-gradient-primary-soft">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-shape-lg bg-white shadow-sm text-primary me-3 rounded-circle">
                            <i class="ti ti-file-analytics fs-2"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Laporan Cepat</h5>
                            <small class="text-muted">Unduh rekapitulasi data instan</small>
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <button class="btn btn-white border border-light shadow-sm p-3 text-start d-flex align-items-center card-hover">
                            <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                <i class="ti ti-calendar-stats fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark fs-6">Laporan Tahunan</div>
                                <div class="small text-muted">Rekap {{ date('Y') }} Lengkap</div>
                            </div>
                            <i class="ti ti-download text-muted"></i>
                        </button>

                        <button class="btn btn-white border border-light shadow-sm p-3 text-start d-flex align-items-center card-hover">
                            <div class="bg-success bg-opacity-10 text-success rounded p-2 me-3">
                                <i class="ti ti-building-arch fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-dark fs-6">Format Akreditasi</div>
                                <div class="small text-muted">Standar BAN-PT</div>
                            </div>
                            <i class="ti ti-download text-muted"></i>
                        </button>

                        <div class="mt-2 text-center">
                            <a href=" " class="text-decoration-none fw-bold text-primary fs-7 hover-underline">
                                Lihat Semua Opsi Laporan <i class="ti ti-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
