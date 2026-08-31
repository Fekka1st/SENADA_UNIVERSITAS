<?php
    $sidebarMenu = config('sidebar');
?>

{{-- Sidebar Styles --}}
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}?v={{ filemtime(public_path('css/sidebar.css')) }}">

<style>
    /* Dynamic Theme Color Styles */
    .sidebar.sidebar-style-2 .nav .nav-item.submenu > a[data-bs-toggle="collapse"][aria-expanded="true"]::after {
        color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }};
    }

    .sidebar.sidebar-style-2 .nav .nav-item a:hover p,
    .sidebar.sidebar-style-2 .nav .nav-item a:hover i,
    .sidebar.sidebar-style-2 .nav .nav-item a:focus p,
    .sidebar.sidebar-style-2 .nav .nav-item a:focus i,
    .sidebar.sidebar-style-2 .nav .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] p,
    .sidebar.sidebar-style-2 .nav .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i {
        color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }} !important;
    }

    /* Parent submenu button background when child is active */
    .sidebar.sidebar-style-2 .nav .nav-item.submenu:has(.nav-collapse li a.active) > a {
        background: #f0f0f0;
    }

    .sidebar .nav.nav-primary > .nav-item a:focus i,
    .sidebar .nav.nav-primary > .nav-item a:hover i,
    .sidebar .nav.nav-primary > .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:focus i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:hover i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i {
        color: {{ $pengaturan->tema_warna_utama ?? '#14438B' }} !important;
    }

    /* Active state for main menu items (without submenu) */
    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active {
        background: {{ $pengaturan->tema_warna_utama ?? '#14438B' }} !important;
        box-shadow: 0 10px 15px -5px rgba({{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 1, 2))
        }}, {{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 3, 2))
        }}, {{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 5, 2))
        }}, 0.3);
    }

    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active p,
    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active i {
        color: #ffffff !important;
        font-weight: 500;
    }

    /* Submenu items hover and active states */
    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover {
        background: #f0f0f0;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover i {
        color: #575962;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active {
        background: {{ $pengaturan->tema_warna_utama ?? '#14438B' }};
        box-shadow: 0 10px 15px -5px rgba({{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 1, 2))
        }}, {{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 3, 2))
        }}, {{
            hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 5, 2))
        }}, 0.3);
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active i {
        color: #ffffff !important;
        font-weight: 500;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover {
        background: {{ $pengaturan->tema_warna_utama ?? '#14438B' }};
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover i {
        color: #ffffff !important;
    }

</style>

<div class="sidebar sidebar-style-2" data-background-color="white">
    {{-- Sidebar Logo --}}
    <div class="sidebar-logo">
        {{-- Logo Header --}}
        <x-logo-header logo="{{ $attributes['logo'] }}" />
    </div>

    {{-- Sidebar Menu --}}
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                @foreach($sidebarMenu as $index => $menu)
                    @if(isset($menu['type']) && $menu['type'] === 'header')
                    @php
                        $showHeader = true;
                        if (isset($menu['permission'])) {
                            if (strtolower($menu['permission']) === 'all') {
                                $showHeader = true;
                            } else {
                                $showHeader = auth()->user()->hasPermission($menu['permission']);
                            }
                        }
                        if ($showHeader && isset($menu['roles'])) {
                            $showHeader = in_array(auth()->user()->roleid, $menu['roles']);
                        }
                    @endphp

                    @if($showHeader)
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="ti ti-minus text-muted opacity-50"></i>
                            </span>
                            <h2 class="text-section fw-bold text-muted" style="font-size: 14px; letter-spacing: 1.2px;">
                                {{ strtoupper($menu['title']) }}
                            </h2>
                        </li>
                    @endif

                    @elseif(isset($menu['type']) && $menu['type'] === 'nosection')
                        {{-- Main menu without section (no children) --}}
                        @php
                            $show = true;
                            if (isset($menu['roles'])) {
                                $show = in_array(auth()->user()->roleid, $menu['roles']);
                            }
                            if (isset($menu['permission'])) {
                                $show = $show && auth()->user()->hasPermission($menu['permission']);
                            }
                        @endphp
                        @if($show)
                            <li class="nav-item">
                                <x-sidebar-link href="{{ route($menu['route']) }}" :active="request()->routeIs($menu['route'].'*')">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <p>{{ $menu['title'] }}</p>
                                </x-sidebar-link>
                            </li>
                        @endif
                    @elseif(isset($menu['section']))
                        @php
                            $showSection = true;
                            if (isset($menu['permission'])) {
                                if (is_array($menu['permission'])) {
                                    $showSection = false;
                                    foreach ($menu['permission'] as $perm) {
                                        if (auth()->user()->hasPermission($perm)) {
                                            $showSection = true;
                                            break;
                                        }
                                    }
                                } else {
                                    $showSection = auth()->user()->hasPermission($menu['permission']);
                                }
                            }

                            if (isset($menu['roles'])) {
                                $showSection = $showSection && in_array(auth()->user()->roleid, $menu['roles']);
                            }

                            // Collect child menus
                            $childMenus = [];
                            if ($showSection) {
                                for ($i = $index + 1; $i < count($sidebarMenu); $i++) {
                                    // Stop at next section or nosection item
                                    if (isset($sidebarMenu[$i]['section']) || (isset($sidebarMenu[$i]['type']) && $sidebarMenu[$i]['type'] === 'nosection')) {
                                        break;
                                    }

                                    $childMenu = $sidebarMenu[$i];

                                    // Only include items with type 'section' or without type attribute
                                    if (isset($childMenu['type']) && $childMenu['type'] !== 'section') {
                                        continue;
                                    }

                                    $showChild = true;

                                    if (isset($childMenu['roles'])) {
                                        $showChild = in_array(auth()->user()->roleid, $childMenu['roles']);
                                    }
                                    if (isset($childMenu['permission'])) {
                                        $showChild = $showChild && auth()->user()->hasPermission($childMenu['permission']);
                                    }

                                    if ($showChild && isset($childMenu['route']) && isset($childMenu['title'])) {
                                        $childMenus[] = $childMenu;
                                    }
                                }
                            }

                            $hasChildren = count($childMenus) > 0;
                            $sectionId = 'section-' . \Str::slug($menu['section']);
                        @endphp

                        @if($showSection && $hasChildren)
                            <li class="nav-item submenu">
                                <a data-bs-toggle="collapse" href="#{{ $sectionId }}" class="collapsed" aria-expanded="false">
                                    <i class="{{ $menu['icon'] ?? 'ti ti-dots' }}"></i>
                                    <p>{{ $menu['section'] }}</p>
                                </a>
                                <div class="collapse" id="{{ $sectionId }}">
                                    <ul class="nav nav-collapse">
                                        @foreach($childMenus as $childMenu)
                                            <li>
                                                <x-sidebar-link href="{{ route($childMenu['route']) }}" :active="request()->routeIs($childMenu['route'].'*')">
                                                    <i class="ti ti-point-filled"></i>
                                                    <p>{{ $childMenu['title'] }}</p>
                                                </x-sidebar-link>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @elseif($showSection && !$hasChildren)
                            {{-- Section header tanpa children (seperti sebelumnya) --}}
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="{{ $menu['icon'] ?? 'ti ti-dots' }}"></i>
                                </span>
                                <h4 class="text-section">{{ $menu['section'] }}</h4>
                            </li>
                        @endif
                    @elseif(isset($menu['route']) && isset($menu['title']))
                        @php
                            // Skip if menu has type 'section' (already rendered as child)
                            if (isset($menu['type']) && $menu['type'] === 'section') {
                                continue;
                            }

                            // Check if this menu is already rendered as child
                            $isChild = false;
                            for ($j = $index - 1; $j >= 0; $j--) {
                                if (isset($sidebarMenu[$j]['section'])) {
                                    // This menu belongs to a section
                                    $isChild = true;
                                    break;
                                }
                                // Stop if we hit a nosection item
                                if (isset($sidebarMenu[$j]['type']) && $sidebarMenu[$j]['type'] === 'nosection') {
                                    break;
                                }
                            }

                            // Skip if it's a child menu (already rendered in collapse)
                            if ($isChild) {
                                continue;
                            }

                            $show = true;
                            if (isset($menu['roles'])) {
                                $show = in_array(auth()->user()->roleid, $menu['roles']);
                            }
                            if (isset($menu['permission'])) {
                                $show = $show && auth()->user()->hasPermission($menu['permission']);
                            }
                        @endphp
                        @if($show)
                            <li class="nav-item">
                                <x-sidebar-link href="{{ route($menu['route']) }}" :active="request()->routeIs($menu['route'].'*')">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <p>{{ $menu['title'] }}</p>
                                </x-sidebar-link>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

{{-- Sidebar JavaScript --}}
<script src="{{ asset('js/sidebar.js') }}?v={{ filemtime(public_path('js/sidebar.js')) }}"></script>
