<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $pengaturan->kepanjangan_aplikasi}}">
    <meta name="author" content="{{ $pengaturan->nama_copyright }}">

    {{-- Title --}}
    <title>{{ $title }} - {{ $pengaturan->nama_aplikasi }}</title>

    {{-- Favicon icon --}}
    @php
        $faviconPath = safe_image_url($pengaturan->favicon ?? null, 'favicon', 'images/favicon.ico');
    @endphp
    <link rel="shortcut icon" href="{{ $faviconPath }}" type="image/x-icon">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- tabler icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    {{-- Custom stylesheet --}}
    <link type="text/css" rel="stylesheet" href="{{ asset('css/error-page.css') }}" />

    {{-- Dynamic Theme CSS Variables --}}
    <style>
        :root {
            --primary-color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }};
            --primary-dark: {{ darken_color($pengaturan->tema_warna_utama ?? '#14438B', 15) }};
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            opacity: 0.85;
            z-index: 1;
        }

        .error-container {
            background-image: url('{{ safe_image_url($pengaturan->background_login ?? null, 'background_login', 'images/background.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="bg-pattern"></div>
        <div class="error-content">
            <div class="error-box">
                {{-- Logo Section --}}
                <div class="logo-section">
                    <div class="logo">
                        <img src="{{ safe_image_url($pengaturan->logo_instnasi ?? null, 'logo', 'images/logo.png') }}" alt="Logo {{ $pengaturan->nama_aplikasi }}">
                    </div>
                </div>

                {{-- Error Code --}}
                <div class="error-code">
                    <h1>{{ $errorcode }}</h1>
                </div>

                {{-- Error Message --}}
                <div class="error-message">
                    <h2>{{ $errortitle }}</h2>
                    <p>{{ $slot }}</p>
                </div>

                {{-- Action Button --}}
                <div class="error-action">
                    <a href="{{ route('dashboard.index') }}" class="btn-dashboard">
                        <i class="fas fa-home"></i>
                        Kembali ke Dashboard
                    </a>
                </div>

                {{-- Social Media Links --}}
                @php
                    $hasSocialMedia = $pengaturan->sosmed_facebook || $pengaturan->sosmed_twitter || $pengaturan->sosmed_instagram || $pengaturan->sosmed_youtube || $pengaturan->sosmed_tiktok;
                @endphp

                @if ($hasSocialMedia)
                    <div class="social-links">
                        @if ($pengaturan->sosmed_facebook)
                            <a href="{{ $pengaturan->sosmed_facebook }}" target="_blank" class="social-icon facebook" title="Facebook">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                        @endif

                        @if ($pengaturan->sosmed_twitter)
                            <a href="{{ $pengaturan->sosmed_twitter }}" target="_blank" class="social-icon twitter" title="Twitter/X">
                                <i class="ti ti-brand-x"></i>
                            </a>
                        @endif

                        @if ($pengaturan->sosmed_instagram)
                            <a href="{{ $pengaturan->sosmed_instagram }}" target="_blank" class="social-icon instagram" title="Instagram">
                                <i class="ti ti-brand-instagram"></i>
                            </a>
                        @endif

                        @if ($pengaturan->sosmed_youtube)
                            <a href="{{ $pengaturan->sosmed_youtube }}" target="_blank" class="social-icon youtube" title="YouTube">
                                <i class="ti ti-brand-youtube"></i>
                            </a>
                        @endif

                        @if ($pengaturan->sosmed_tiktok)
                            <a href="{{ $pengaturan->sosmed_tiktok }}" target="_blank" class="social-icon tiktok" title="TikTok">
                                <i class="ti ti-brand-tiktok"></i>
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Footer --}}
                <div class="error-footer">
                    <p>&copy; {{ date('Y') }} {{ $pengaturan->nama_copyright }}. Hak cipta dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
