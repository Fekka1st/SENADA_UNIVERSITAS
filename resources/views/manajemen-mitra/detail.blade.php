<x-app-layout>
    <x-slot:title>Detail Mitra Strategis</x-slot:title>
    <x-slot:breadcrumb>Manajemen / Mitra / Detail / {{ $mitra->nama_mitra }}</x-slot:breadcrumb>
    <x-alert></x-alert>

    {{-- Leaflet CSS untuk Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="container-fluid">
        {{-- SECTION ATAS: DETAIL & MAPS --}}
        <div class="row g-4 mb-4">
            {{-- Card Detail Utama --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-layout-grid me-2 text-primary"></i>Informasi Instansi</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('Manajemen-Mitra.edit', $mitra->id) }}" class="btn btn-sm btn-light border fw-bold text-dark px-3">
                                <i class="ti ti-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12 mb-2">
                                <h3 class="fw-bold text-dark mb-1">{{ $mitra->nama_mitra }}</h3>
                                <div class="d-flex align-items-center gap-2">
                                    @php $warna = $mitra->kategori->warna_peta ?? '#6c757d'; @endphp
                                    <span class="badge border" style="background-color: {{ $warna }}15; color: {{ $warna }}; border-color: {{ $warna }}30;">
                                        {{ $mitra->kategori->nama_kategori ?? 'Umum' }}
                                    </span>
                                    <span class="text-muted small">|</span>
                                    <span class="text-muted small"><i class="ti ti-calendar me-1"></i>Terdaftar {{ $mitra->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Negara Asal</label>
                                <p class="text-dark mb-0 fw-semibold">{{ $mitra->negara }}</p>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Official Website</label>
                                @if($mitra->url_website)
                                    <a href="{{ $mitra->url_website }}" target="_blank" class="text-primary fw-bold text-decoration-none d-flex align-items-center">
                                        {{ str_replace(['https://', 'http://'], '', $mitra->url_website) }} <i class="ti ti-external-link ms-1 small"></i>
                                    </a>
                                @else
                                    <span class="text-muted small italic">Tidak tersedia</span>
                                @endif
                            </div>
                            <div class="col-12">
                                <hr class="my-1 opacity-25">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Alamat Lengkap</label>
                                <p class="text-dark mb-0 fs-6 lh-base">{{ $mitra->alamat_lengkap ?: 'Detail alamat belum dikonfigurasi.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Maps --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-map-2 text-success me-2"></i>Lokasi Geospasial</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="map" style="height: 100%; min-height: 300px; z-index: 1;"></div>
                    </div>
                    <div class="card-footer bg-white py-2 border-top-0">
                        <div class="d-flex justify-content-between small text-muted font-monospace">
                            <span>Lat: {{ $mitra->latitude }}</span>
                            <span>Lng: {{ $mitra->longtitude }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-users text-primary me-2"></i>Daftar Personil (PIC)</h5>
                        </div>
                        {{-- Gunakan Link ke Page Baru --}}

                    </div>
                    <div class="card-body">
                        {{-- Filter & Action Bar khusus PIC --}}
                        <x-datatable.filter-bar
                            searchId="searchPic"
                            searchPlaceholder="Cari Nama atau Jabatan..."
                            :hasDateFilter="false"
                            :hasExport="false">

                            <x-slot name="additionalButtons">
                                @permission('mitra.create')
                               <a href="{{ route('Pic-Mitra.create', $mitra->id) }}" class="btn btn-primary d-flex align-items-center gap-1">
                                    <i class="ti ti-plus"></i> Tambah PIC
                                </a>
                                @endpermission
                            </x-slot>
                        </x-datatable.filter-bar>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <x-datatable.per-page selectId="perPagePic" :default="5" />
                        </div>

                        <x-datatable.wrapper
                            tableId="picTable"
                            :columns="['No', 'Nama & Jabatan', 'WhatsApp', 'Email', 'Status', 'Aksi']"
                            :hasCheckbox="false"
                        />
                    </div>
                </div>
            </div>
        </div>

        @php
            $picColumnsConfig = [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
                ['data' => 'pic_info', 'name' => 'nama_pic', 'className' => 'fw-bold text-dark'],
                ['data' => 'kontak', 'name' => 'no_telp', 'className' => 'text-center'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'status', 'name' => 'status_pic', 'className' => 'text-center'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '100px', 'className' => 'text-center']
            ];
        @endphp

        <x-datatable.scripts
            tableId="picTable"
            ajaxUrl="{{ route('Pic-Mitra.getData', $mitra->id) }}"
            :columns="$picColumnsConfig"
            searchId="searchPic"
            perPageId="perPagePic"
        />

        {{-- Modal Hapus khusus PIC --}}
        <x-modal.hapus id="modalHapusPic" title="Hapus Personil PIC" :isDynamic="true" />

        <div class="mt-4 text-center">
            <a href="{{ route('Manajemen-Mitra.index') }}" class="btn btn-primary text-mute small">
                <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Utama
            </a>
        </div>
    </div>

    <script>
        $(document).on('click', '.btn-delete-pic', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $('#modalHapusPicItemName').text(nama);
            let url = '{{ route("Pic-Mitra.destroy", ":id") }}';
            $('#modalHapusPicForm').attr('action', url.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusPic')).show();
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $mitra->latitude ?? -2.5489 }};
            var lng = {{ $mitra->longtitude ?? 118.0149 }};

            var map = L.map('map', {
                scrollWheelZoom: false,
                zoomControl: false
            }).setView([lat, lng], 15);

            L.control.zoom({ position: 'topright' }).addTo(map);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <div style="font-family: sans-serif;">
                    <b style="font-size: 14px; color: #2c3e50;">{{ $mitra->nama_mitra }}</b><br>
                    <span style="font-size: 12px; color: #7f8c8d;">
                        <i class="ti ti-map-pin me-1"></i> {{ $mitra->alamat_lengkap }}
                    </span>
                </div>
            `).openPopup();
        });
    </script>

    <style>
        .avatar-simple { width: 34px; height: 34px; background: #f0f2f5; border: 1px solid #e1e4e8; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #5a6a85; font-size: 12px; }
        .bg-light-subtle { background-color: #fbfbfb; }
        .btn-white { background: #fff; }
        .btn-white:hover { background: #f8f9fa; }
        .table thead th { font-weight: 700; }
        .card-header { letter-spacing: 0.2px; }
    </style>
</x-app-layout>
