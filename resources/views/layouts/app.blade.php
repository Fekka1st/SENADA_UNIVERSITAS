<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- tabler icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    {{-- jquery scrollbar CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/jquery.scrollbar@0.2.11/jquery.scrollbar.min.css" rel="stylesheet">
    {{-- Flatpickr CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('css/template/kaiadmin.min.css') }}">
    {{-- Custom Style CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- Dynamic Theme CSS Variables - hanya injeksi variable saja --}}
    <style>
        :root {
            --primary-color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }};
            --primary-dark: {{ darken_color($pengaturan->tema_warna_utama ?? '#14438B', 15) }};
            --primary-light: {{ lighten_color($pengaturan->tema_warna_utama ?? '#14438B', 90) }};
            --primary-subtle: {{ lighten_color($pengaturan->tema_warna_utama ?? '#14438B', 93) }};
            --primary-shadow: rgba({{ hexToRgb($pengaturan->tema_warna_utama ?? '#14438B') }}, 0.3);
        }

        /* Sidebar Section Collapse */
        .nav-section-toggle {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            color: #575962;
        }

        .nav-section-toggle:hover {
            background-color: #f8f9fa;
        }

        .nav-section-toggle .sidebar-mini-icon {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .nav-section-toggle .text-section {
            flex: 1;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin: 0;
            color: #6c757d;
        }

        .nav-section-toggle .caret {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-section-toggle .caret:before {
            content: "\f078";
            font-family: "tabler-icons";
            font-size: 12px;
        }

        .nav-section-toggle:not(.collapsed) .caret {
            transform: rotate(180deg);
        }

        .nav-section-toggle.collapsed .text-section {
            color: #6c757d;
        }

        /* Sidebar minimized state */
        .sidebar_minimize .nav-section-toggle .text-section,
        .sidebar_minimize .nav-section-toggle .caret {
            display: none;
        }

        /* Adjust section items when collapsed */
        .sidebar .collapse {
            transition: all 0.3s ease;
        }

        .sidebar .collapse .nav-item {
            margin-left: 0;
        }
    </style>

    {{-- Date Range Picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    {{-- Vite assets (Echo, etc) --}}
    @vite(['resources/js/app.js'])

    {{-- Styles stack --}}
    @stack('styles')

    {{-- jQuery Core --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="wrapper" data-user-id="{{ auth()->id() ?? 'guest' }}">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main --}}
        <div class="main-panel">
            {{-- Main Header --}}
            <div class="main-header">
                {{-- Main Hedaer Logo --}}
                <div class="main-header-logo">
                    {{-- Logo Header --}}
                    <x-logo-header></x-logo-header>
                </div>

                {{-- Navbar Header --}}
                @include('layouts.navbar-header')
            </div>

            {{-- Main Content --}}
            <div class="container">
                <div class="page-inner">
                    {{-- Page Title --}}
                    <div class="card card-body" style="background-color: var(--primary-color, #14438B)">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="d-sm-flex align-items-center justify-space-between">
                                    {{-- Title --}}
                                    <h4 class="d-flex align-items-center mb-2 mb-sm-0 card-title" style="color: #ffffff">
                                        {{ $title }}
                                    </h4>
                                    {{-- Breadcrumbs --}}
                                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb" class="ms-auto">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item d-flex align-items-center">
                                                <a href="{{ route('dashboard.index') }}" class="text-muted text-decoration-none d-flex">
                                                    <i class="ti ti-home fs-5" style="color: #ffffff"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item ps-1">
                                                <i class="ti ti-chevron-right align-middle op-7" style="color: #ffffff"></i>
                                            </li>
                                            <li class="breadcrumb-item ps-0" aria-current="page">
                                                <span class="badge fw-medium bg-light text-primary">
                                                    {{ $title }}
                                                </span>
                                            </li>
                                            @isset($breadcrumb)
                                            <li class="breadcrumb-item ps-0">
                                                <i class="ti ti-chevron-right align-middle op-7" style="color: #ffffff"></i>
                                            </li>
                                            <li class="breadcrumb-item ps-0" aria-current="page">
                                                <span class="badge fw-medium bg-light text-primary">
                                                    {{ $breadcrumb }}
                                                </span>
                                            </li>
                                            @endisset
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <footer class="footer">
                <div class="container-fluid">
                    {{-- link --}}

                    {{-- copyright --}}
                    <div class="copyright ms-auto">
                        &copy; {{ date('Y') }} {{ $pengaturan->nama_copyright }}. Hak cipta dilindungi.
                    </div>
                </div>
            </footer>
        </div>

        {{-- Modal logout --}}
        <x-modal.logout></x-modal.logout>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('.toggle-password');
                    const icon = this.querySelector('i');

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';

                    icon.classList.toggle('ti-eye');
                    icon.classList.toggle('ti-eye-off');
                });
            });
        });
    </script>

    {{-- jQuery Scrollbar --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery.scrollbar@0.2.11/jquery.scrollbar.min.js"></script>
    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>
    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    {{-- Template JS --}}
    <script src="{{ asset('js/template/kaiadmin.min.js') }}"></script>

    {{-- Custom Scripts --}}
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/image-preview.js') }}"></script>
    {{-- Expose base URLs and tokens for JS modules --}}
    <script>
        window.APP_BASE_URL = "{{ url('/') }}";
        window.NOTIF_BASE = "{{ url('/notifikasi') }}";
        window.CSRF_TOKEN = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
    </script>
    <script src="{{ asset('js/notifikasi-realtime.js') }}"></script>

    {{-- Persist Sidebar Scroll Position --}}
    <script src="{{ asset('js/sidebar-persist.js') }}"></script>

    {{-- Expose app routes for notifications to handle subfolder deployments --}}
    <script>
        window.NOTIF_URLS = {
            base: "{{ route('notifikasi.index') }}",
            terbaru: "{{ route('notifikasi.terbaru') }}",
            jumlah: "{{ route('notifikasi.jumlah-belum-dibaca') }}",
            tandaiSemua: "{{ route('notifikasi.tandai-semua-dibaca') }}",
            hapusSudahDibaca: "{{ route('notifikasi.hapus-sudah-dibaca') }}"
        };
    </script>

    {{-- Scripts stack --}}
    @stack('scripts')
</body>
</html>
</body>

</html>