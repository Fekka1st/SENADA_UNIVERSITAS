<x-app-layout>
    <x-slot:title>Pengaturan Aplikasi</x-slot:title>

    {{-- menampilkan pesan berhasil --}}
    <x-alert></x-alert>

    {{-- Header Card --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="ms-3">
                        <h4 class="mb-1 fw-bold">Pengaturan Aplikasi</h4>
                        <p class="text-muted mb-0">Informasi dan konfigurasi aplikasi</p>
                    </div>
                </div>
                @permission('pengaturan.edit')
                <div class="flex-shrink-0">
                    <a href="{{ route('pengaturan.edit') }}" class="btn btn-primary w-100 w-md-auto">
                        <i class="ti ti-edit me-2"></i>Ubah Pengaturan
                    </a>
                </div>
                @endpermission
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Informasi Aplikasi --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-info-circle me-2 text-primary"></i>Informasi Aplikasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Nama Aplikasi --}}
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Nama Aplikasi</label>
                                <p class="fw-semibold mb-0 fs-5">{{ $pengaturan->nama_aplikasi }}</p>
                            </div>
                        </div>

                        {{-- Kepanjangan --}}
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Kepanjangan Nama Aplikasi</label>
                                <p class="fw-semibold mb-0">{{ $pengaturan->kepanjangan_aplikasi }}</p>
                            </div>
                        </div>

                        {{-- Copyright --}}
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Copyright</label>
                                <p class="fw-semibold mb-0">{{ $pengaturan->nama_copyright }}</p>
                            </div>
                        </div>

                        {{-- Warna Tema --}}
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-2 d-block">Warna Tema Utama</label>
                                <div class="d-flex align-items-center">
                                    <div class="color-preview me-3"
                                        style="width: 50px; height: 50px; background-color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }}; border-radius: 10px; border: 2px solid #e0e6eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    </div>
                                    <div>
                                        <p class="fw-bold mb-0">{{ strtoupper($pengaturan->tema_warna_utama ?? '#14438B') }}</p>
                                        <small class="text-muted">Kode Warna Hex</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sosial Media --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-share-3 me-2 text-primary"></i>Sosial Media
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $socialMedias = [
                            [
                                'field' => 'sosmed_facebook',
                                'icon' => 'ti ti-brand-facebook',
                                'color' => '#1877F2',
                                'name' => 'Facebook',
                            ],
                            [
                                'field' => 'sosmed_twitter',
                                'icon' => 'ti ti-brand-x',
                                'color' => '#000000',
                                'name' => 'Twitter/X',
                            ],
                            [
                                'field' => 'sosmed_instagram',
                                'icon' => 'ti ti-brand-instagram',
                                'color' => '#E4405F',
                                'name' => 'Instagram',
                            ],
                            [
                                'field' => 'sosmed_youtube',
                                'icon' => 'ti ti-brand-youtube',
                                'color' => '#FF0000',
                                'name' => 'YouTube',
                            ],
                            [
                                'field' => 'sosmed_tiktok',
                                'icon' => 'ti ti-brand-tiktok',
                                'color' => '#000000',
                                'name' => 'TikTok',
                            ],
                        ];
                        $hasSocialMedia = false;
                        foreach ($socialMedias as $social) {
                            if (!empty($pengaturan->{$social['field']})) {
                                $hasSocialMedia = true;
                                break;
                            }
                        }
                    @endphp

                    @if($hasSocialMedia)
                        <div class="d-flex flex-column gap-3">
                            @foreach ($socialMedias as $social)
                                @if (!empty($pengaturan->{$social['field']}))
                                    <a href="{{ $pengaturan->{$social['field']} }}" target="_blank"
                                        class="social-media-item p-3 border rounded-3 text-decoration-none d-flex align-items-center">
                                        <div class="social-icon me-3" style="background-color: {{ $social['color'] }}15;">
                                            <i class="{{ $social['icon'] }} fs-3" style="color: {{ $social['color'] }};"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-0 fw-semibold text-dark">{{ $social['name'] }}</p>
                                            <small class="text-muted text-truncate d-block">
                                                {{ $pengaturan->{$social['field']} }}
                                            </small>
                                        </div>
                                        <i class="ti ti-external-link text-muted ms-2"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-share-off fs-1 text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada sosial media terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Aset Visual --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-photo me-2 text-primary"></i>Aset Visual
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        {{-- Logo Instansi --}}
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-building fs-2 text-primary"></i>
                                </div>
                                @php
                                    $logoInstansiPath = safe_image_url($pengaturan->logo_instansi, 'logo', 'images/logo.png');
                                @endphp
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px;">
                                    <img src="{{ $logoInstansiPath }}" class="img-fluid"
                                        style="max-height: 100px; max-width: 100%; object-fit: contain;"
                                        alt="Logo Instansi">
                                </div>
                                <h6 class="fw-semibold mb-1">Logo Instansi</h6>
                                <small class="text-muted">Ditampilkan di header aplikasi</small>
                            </div>
                        </div>

                        {{-- Favicon --}}
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-favicon fs-2 text-success"></i>
                                </div>
                                @php
                                    $faviconPath = safe_image_url($pengaturan->favicon, 'favicon', 'images/favicon.ico');
                                @endphp
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px;">
                                    <img src="{{ $faviconPath }}" class="img-fluid"
                                        style="max-height: 100px; max-width: 100%; object-fit: contain;"
                                        alt="Favicon">
                                </div>
                                <h6 class="fw-semibold mb-1">Favicon</h6>
                                <small class="text-muted">Icon browser tab</small>
                            </div>
                        </div>

                        {{-- Background Login --}}
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-photo-filled fs-2 text-info"></i>
                                </div>
                                @php
                                    $backgroundLoginPath = safe_image_url($pengaturan->background_login, 'background_login', 'images/background.jpg');
                                @endphp
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px; overflow: hidden;">
                                    <img src="{{ $backgroundLoginPath }}" class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                        alt="Background Login">
                                </div>
                                <h6 class="fw-semibold mb-1">Background Login</h6>
                                <small class="text-muted">Background halaman login</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .avatar-md {
            width: 60px;
            height: 60px;
        }

        .w-md-auto {
            width: 100% !important;
        }

        @media (min-width: 768px) {
            .w-md-auto {
                width: auto !important;
            }
        }

        .info-item {
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .social-media-item {
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .social-media-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            background-color: #f8f9fa;
        }

        .asset-card {
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .asset-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .asset-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 12px;
        }

        .color-preview {
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .color-preview:hover {
            transform: scale(1.1);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 767.98px) {
            .card-header h5 {
                font-size: 1rem;
            }

            .avatar-md {
                width: 50px;
                height: 50px;
            }

            .avatar-md i {
                font-size: 1.5rem !important;
            }

            h4.fw-bold {
                font-size: 1.25rem;
            }

            .asset-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    @endpush
</x-app-layout>
