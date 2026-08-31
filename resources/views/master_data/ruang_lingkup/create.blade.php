<x-app-layout>
    <x-slot:title>Tambah Ruang Lingkup</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <form action="{{ route('master-data.ruang_lingkup.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Ruang Lingkup --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Ruang Lingkup <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-layers-intersect"></i></span>
                                <input type="text" name="nama_ruanglingkup"
                                    class="form-control @error('nama_ruanglingkup') is-invalid @enderror"
                                    value="{{ old('nama_ruanglingkup') }}"
                                    placeholder="Contoh: Bidang Pendidikan / Penelitian"
                                    autocomplete="off">
                                @error('nama_ruanglingkup')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="keterangan" rows="5"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Jelaskan cakupan dari ruang lingkup ini...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Informasi Panel --}}
                        <div class="card border-dashed bg-light bg-opacity-50 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <i class="ti ti-category text-primary" style="font-size: 3.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Cakupan Kerja Sama</h5>
                                <p class="small text-muted mb-4">
                                    Ruang lingkup digunakan untuk mengelompokkan aktivitas dalam dokumen kerja sama.
                                </p>
                                <ul class="text-start small text-muted mb-4">
                                    <li><strong>Pendidikan:</strong> Pertukaran pelajar, magang, dll.</li>
                                    <li><strong>Penelitian:</strong> Riset bersama, publikasi.</li>
                                    <li><strong>Pengabdian:</strong> Kuliah kerja nyata, bakti sosial.</li>
                                </ul>
                                <div class="p-3 bg-white rounded-3 border shadow-sm">
                                    <small class="text-muted d-block mb-1">Status Relasi</small>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Many-to-Many Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.ruang_lingkup.index') }}" class="btn btn-light fw-bold px-4 me-2">
                            <i class="ti ti-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Ruang Lingkup
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #dee2e6 !important; }
    </style>
</x-app-layout>
