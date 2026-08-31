<x-app-layout>
    <x-slot:title>Edit Mitra: {{ $mitra->nama_mitra }}</x-slot:title>
    <x-slot:breadcrumb>Edit Mitra</x-slot:breadcrumb>
    <x-alert></x-alert>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <form action="{{ route('Manajemen-Mitra.update', $mitra->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            {{-- KOLOM KIRI: INFORMASI MITRA & LOKASI --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-warning"><i class="ti ti-edit me-2"></i>Informasi Instansi Mitra</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nama Mitra <span class="text-danger">*</span></label>
                                <input type="text" name="nama_mitra" class="form-control @error('nama_mitra') is-invalid @enderror" value="{{ old('nama_mitra', $mitra->nama_mitra) }}" required>
                                @error('nama_mitra') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kategori Mitra <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select select2" required>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id }}" {{ (old('kategori_id', $mitra->kategori_id) == $kat->id) ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Negara <span class="text-danger">*</span></label>
                                <input type="text" name="negara" class="form-control" value="{{ old('negara', $mitra->negara) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-world"></i></span>
                                    <input type="url" name="url_website" class="form-control" placeholder="https://..." value="{{ old('url_website', $mitra->url_website) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3">{{ old('alamat_lengkap', $mitra->alamat_lengkap) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Map Card --}}
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="ti ti-map-pin me-2"></i>Sesuaikan Lokasi</h5>
                        <span class="badge bg-light-warning text-warning border border-warning border-opacity-10">Geser marker atau klik peta</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Latitude</label>
                                <input type="text" name="latitude" id="lat" class="form-control bg-light" value="{{ old('latitude', $mitra->latitude) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Longitude</label>
                                <input type="text" name="longtitude" id="lng" class="form-control bg-light" value="{{ old('longtitude', $mitra->longtitude) }}" readonly>
                            </div>
                        </div>
                        <div id="map" style="height: 400px; border-radius: 12px;" class="border shadow-sm"></div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: DATA PIC UTAMA & AKSI --}}
            <div class="col-lg-4">
                @php
                    // Ambil PIC Utama dari relasi hasMany (status_pic = 1)
                    $picUtama = $mitra->pics->where('status_pic', 1)->first();
                @endphp
                <div class="card shadow-sm border-0 border-top border-4 border-warning">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-user-edit me-2 text-warning"></i>Edit PIC Utama</h5>
                    </div>
                    <div class="card-body">
                        {{-- ID PIC tersembunyi untuk proses update --}}
                        <input type="hidden" name="pic_id" value="{{ $picUtama->id ?? '' }}">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap PIC <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pic" class="form-control shadow-sm" value="{{ old('nama_pic', $picUtama->nama_pic ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm" value="{{ old('jabatan', $picUtama->jabatan ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Telp / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="ti ti-brand-whatsapp text-success"></i></span>
                                <input type="text" name="no_telp" class="form-control border-start-0" value="{{ old('no_telp', $picUtama->no_telp ?? '') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email_pic" class="form-control shadow-sm" value="{{ old('email_pic', $picUtama->email ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-3">
                        <button type="submit" class="btn btn-warning text-white w-100 fw-bold py-2 mb-2 shadow-sm">
                            <i class="ti ti-refresh me-1"></i>Perbarui Data Mitra
                        </button>
                        <a href="{{ route('Manajemen-Mitra.index') }}" class="btn btn-light w-100 fw-bold py-2">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Map Script --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil titik koordinat dari database
            var savedLat = {{ $mitra->latitude ?? -6.123456 }};
            var savedLng = {{ $mitra->longtitude ?? 106.123456 }};

            // 1. Init Map fokus ke lokasi tersimpan
            var map = L.map('map').setView([savedLat, savedLng], 15);

            // 2. Tile Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 3. Tambahkan Marker di lokasi tersimpan (Bisa digeser)
            var marker = L.marker([savedLat, savedLng], {draggable: true}).addTo(map);

            function updateCoords(lat, lng) {
                document.getElementById('lat').value = lat.toFixed(7);
                document.getElementById('lng').value = lng.toFixed(7);
            }

            // Update saat marker digeser
            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                updateCoords(position.lat, position.lng);
            });

            // Update saat peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });
        });
    </script>
</x-app-layout>
