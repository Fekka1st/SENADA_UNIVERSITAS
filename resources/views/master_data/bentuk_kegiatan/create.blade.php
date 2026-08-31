<x-app-layout>
    <x-slot:title>Tambah Jenis Kegiatan</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <x-alert></x-alert>

            <form action="{{ route('master-data.jenis_kegiatan.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Jenis Kegiatan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Jenis Kegiatan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg shadow-none rounded-3 overflow-hidden border">
                                <span class="input-group-text bg-light border-0 text-muted px-4"><i class="ti ti-activity"></i></span>
                                <input type="text" name="nama_kegiatan"
                                    class="form-control bg-light border-0 fs-6 @error('nama_kegiatan') is-invalid @enderror"
                                    value="{{ old('nama_kegiatan') }}"
                                    placeholder="Contoh: Magang Mahasiswa / Riset Kolaboratif"
                                    autocomplete="off" required>
                            </div>
                            @error('nama_kegiatan')
                                <div class="text-danger small mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi/Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Keterangan / Deskripsi <span class="text-muted fw-normal small">(Opsional)</span></label>
                            <textarea name="keterangan" rows="5"
                                class="form-control bg-light border shadow-none rounded-3 p-3 @error('keterangan') is-invalid @enderror"
                                placeholder="Jelaskan secara singkat cakupan jenis kegiatan ini...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="text-danger small mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Informasi Panel --}}
                        <div class="card border-dashed bg-light bg-opacity-50 h-100 rounded-4">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                        <i class="ti ti-briefcase text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark">Bentuk Kegiatan</h5>
                                <p class="small text-muted mb-4 px-2">
                                    Jenis kegiatan merepresentasikan aktivitas konkret yang dilakukan dalam kerangka kerja sama.
                                </p>
                                <ul class="text-start small text-muted mb-4 px-3 list-unstyled">
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i><strong>MBKM:</strong> Pertukaran pelajar, magang, KKN Tematik.</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i><strong>Tridharma:</strong> Joint research, guest lecturer.</li>
                                    <li><i class="ti ti-check text-success me-2"></i><strong>Non-Akademik:</strong> Sponsorship, penyediaan fasilitas.</li>
                                </ul>
                                <div class="p-3 bg-white rounded-3 border shadow-sm mx-2">
                                    <small class="text-muted d-block mb-1">Status Penggunaan</small>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill">Pada Menu Repository</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.jenis_kegiatan.index') }}" class="btn btn-light fw-bold px-4 py-2 me-2 rounded-pill hover-dark border">
                            <i class="ti ti-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2 rounded-pill shadow-sm hover-lift">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Jenis Kegiatan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #cbd5e1 !important; }
        .hover-dark:hover { background-color: #e2e8f0; color: #0f172a !important; transition: all 0.2s ease; }
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; }
        .form-control:focus { background-color: #fff !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1) !important; }
    </style>
</x-app-layout>
