<x-app-layout>
    <x-slot:title>Tambah Master Data Jenis Kegiatan</x-slot:title>
    <x-slot:breadcrumb>Master Data / Jenis Kegiatan / Tambah</x-slot:breadcrumb>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="ti ti-category fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Registrasi Jenis Kegiatan</h5>
                            <p class="small text-muted mb-0">Tambahkan opsi bentuk kegiatan kerjasama baru ke dalam sistem.</p>
                        </div>
                    </div>

                    <hr class="opacity-10 mb-4">
                    <x-alert></x-alert>
                    <form action="{{ route('master-data.jenis_kegiatan.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Nama Jenis Kegiatan <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="ti ti-writing"></i></span>
                                    <input type="text" name="nama_kegiatan"
                                        class="form-control bg-light border-start-0 py-2 @error('nama_kegiatan') is-invalid @enderror"
                                        value="{{ old('nama_kegiatan') }}"
                                        placeholder="Contoh: Magang Mandiri, Pertukaran Mahasiswa..."
                                        autocomplete="off" required>
                                </div>
                                @error('nama_kegiatan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Keterangan / Deskripsi (Opsional)</label>
                                <textarea name="keterangan" rows="4"
                                    class="form-control bg-light py-3 shadow-sm rounded-3 @error('keterangan') is-invalid @enderror"
                                    placeholder="Jelaskan secara singkat cakupan jenis kegiatan ini...">{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <hr class="opacity-10 mb-4">
                            <a href="{{ route('master-data.jenis_kegiatan.index') }}" class="btn btn-light fw-bold px-4 me-2 rounded-pill hover-dark">
                                <i class="ti ti-arrow-left me-1"></i> Batal & Kembali
                            </a>
                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm hover-lift">
                                <i class="ti ti-device-floppy me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus { background-color: #fff !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1) !important; }
        .hover-dark:hover { background-color: #e2e8f0; color: #1e293b !important; transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important; transition: all 0.2s ease; }
    </style>

</x-app-layout>
