<x-app-layout>
    <x-slot:title>Tambah Mitra Strategis Baru</x-slot:title>
    <x-slot:breadcrumb>Tambah Mitra</x-slot:breadcrumb>
    <x-alert></x-alert>
    {{-- Leaflet CSS untuk Map --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <form action="{{ route('Manajemen-Mitra.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- KOLOM KIRI: DATA INSTANSI & LOKASI --}}
            <div class="col-lg-8">
                {{-- Card Informasi Utama --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-primary"><i class="ti ti-building me-2"></i>Informasi Instansi
                            Mitra</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nama Mitra <span class="text-danger">*</span></label>
                                <input type="text" name="nama_mitra"
                                    class="form-control @error('nama_mitra') is-invalid @enderror"
                                    value="{{ old('nama_mitra') }}" placeholder="Contoh: PT. Teknologi Nusantara"
                                    required>
                                @error('nama_mitra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kategori Mitra <span
                                        class="text-danger">*</span></label>
                                <select name="kategori_id"
                                    class="form-select select2 @error('kategori_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->id }}"
                                            {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="col-md-6">
                                <label class="form-label fw-bold">Negara <span class="text-danger">*</span></label>
                                <input type="text" name="negara" class="form-control" value="{{ old('negara', 'Indonesia') }}" required>
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark">Negara <span
                                        class="text-danger">*</span></label>
                                <select name="negara" id="selectNegara" class="form-select select2" required>
                                    <option value="">Cari Negara...</option>
                                    {{-- Jika sedang Edit, tampilkan value lamanya --}}
                                    @isset($mitra)
                                        <option value="{{ $mitra->negara }}" selected>{{ $mitra->negara }}</option>
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="ti ti-world"></i></span>
                                    <input type="url" name="website" class="form-control" placeholder="https://..."
                                        value="{{ old('website') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3" placeholder="Jl. Raya Utama No. 10...">{{ old('alamat_lengkap') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Geospasial / Map --}}
                <div class="card shadow-sm border-0">
                    <div
                        class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="ti ti-map-pin me-2"></i>Titik Koordinat Lokasi
                        </h5>
                        <span class="badge bg-light-success text-success border border-success border-opacity-10">Klik
                            pada peta</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Latitude</label>
                                <input type="text" name="latitude" id="lat" class="form-control bg-light"
                                    placeholder="-6.123456" value="{{ old('latitude') }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Longitude</label>
                                <input type="text" name="longtitude" id="lng" class="form-control bg-light"
                                    placeholder="106.123456" value="{{ old('longtitude') }}" readonly>
                            </div>
                        </div>
                        {{-- Area Map --}}
                        <div id="map" style="height: 400px; border-radius: 12px;" class="border shadow-sm"></div>
                        <div class="form-text mt-2 italic"><i class="ti ti-info-circle me-1"></i> Koordinat otomatis
                            terisi saat Anda memilih lokasi di peta.</div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DATA PIC & AKSI --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 border-top border-4 border-primary">
                    <div
                        class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="icon-shape bg-primary bg-opacity-10 text-white rounded-2 me-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                <i class="ti ti-user-plus fs-5"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark">Person In Charge (PIC)</h5>
                        </div>
                        <span class="badge bg-light text-muted border fw-medium px-3 py-2 rounded-pill"
                            style="font-size: 11px;">
                            <i class="ti ti-info-circle me-1"></i> Opsional / Dapat Dikosongkan
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap PIC </label>
                            <input type="text" name="nama_pic" class="form-control shadow-sm"
                                placeholder="Contoh: Budi Santoso" value="{{ old('nama_pic') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm"
                                placeholder="Contoh: Manager Legal" value="{{ old('jabatan') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Telp / WhatsApp </label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="ti ti-brand-whatsapp text-success"></i></span>
                                <input type="text" name="no_telp" class="form-control border-start-0"
                                    placeholder="0812..." value="{{ old('no_telp') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email_pic" class="form-control shadow-sm"
                                placeholder="email@pic.com" value="{{ old('email_pic') }}">
                        </div>

                        {{-- Status PIC Otomatis --}}
                        <input type="hidden" name="status_pic" value="1">
                        <div class="alert alert-primary py-2 small border-0 mb-0 mt-4">
                            <i class="ti ti-info-circle me-1"></i> Personil ini akan otomatis dijadikan sebagai
                            <strong>PIC Utama</strong> mitra ini.
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-2 shadow-sm">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Data Lengkap
                        </button>
                        <a href="{{ route('Manajemen-Mitra.index') }}" class="btn btn-light w-100 fw-bold py-2">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Leaflet JS & Map Script --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Init Map (Default Indonesia)
            var map = L.map('map').setView([-2.5489, 118.0149], 5);

            // 2. Tile Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            // 3. Click Function
            function onMapClick(e) {
                var lat = e.latlng.lat.toFixed(7);
                var lng = e.latlng.lng.toFixed(7);

                document.getElementById('lat').value = lat;
                document.getElementById('lng').value = lng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng, {
                        draggable: true
                    }).addTo(map);
                    marker.on('dragend', function(event) {
                        var position = marker.getLatLng();
                        document.getElementById('lat').value = position.lat.toFixed(7);
                        document.getElementById('lng').value = position.lng.toFixed(7);
                    });
                }
            }

            map.on('click', onMapClick);

            // 4. Locate user
            map.locate({
                setView: true,
                maxZoom: 16
            });
        });

        $('#selectNegara').select2({
        theme: 'bootstrap-5',
        placeholder: 'Cari Negara...',
        minimumInputLength: 2, // Mulai cari setelah ketik 2 huruf
        ajax: {
            url: function (params) {
                return 'https://restcountries.com/v3.1/name/' + params.term + '?fields=name';
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.name.common,
                            text: item.name.common
                        };
                    })
                };
            },
            cache: true
        }
    });
    </script>
</x-app-layout>
