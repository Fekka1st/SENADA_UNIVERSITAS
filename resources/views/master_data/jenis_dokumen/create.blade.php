<x-app-layout>
    <x-slot:title>Tambah Jenis Dokumen</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Form Tambah Data --}}
            <form action="{{ route('master-data.jenis_dokumen.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            {{-- Kode Inisial Dokumen --}}
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Kode Inisial <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-hash"></i></span>
                                        <input type="text" name="kode_inisial"
                                            class="form-control @error('kode_inisial') is-invalid @enderror"
                                            value="{{ old('kode_inisial') }}"
                                            placeholder="Contoh: MoU"
                                            autocomplete="off">
                                        @error('kode_inisial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Digunakan sebagai awalan nomor dokumen.</small>
                                </div>
                            </div>

                            {{-- Nama Jenis Dokumen --}}
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Nama Jenis Dokumen <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-file-text"></i></span>
                                        <input type="text" name="nama_jenis"
                                            class="form-control @error('nama_jenis') is-invalid @enderror"
                                            value="{{ old('nama_jenis') }}"
                                            placeholder="Contoh: Memorandum of Understanding"
                                            autocomplete="off">
                                        @error('nama_jenis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                            <textarea name="keterangan" rows="5"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Jelaskan secara singkat kegunaan jenis dokumen ini...">{{ old('keterangan') }}</textarea>
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
                                    <i class="ti ti-info-square-rounded text-primary" style="font-size: 3.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Struktur Penomoran</h5>
                                <p class="small text-muted mb-4">
                                    Kode inisial yang Anda masukkan akan membentuk pola: <br>
                                    <span class="badge bg-dark mt-2">[KODE]/[BULAN ROMAWI]/[TAHUN]/[NOMOR]</span>
                                </p>
                                <ul class="text-start small text-muted mb-4">
                                    <li><strong>MoU:</strong> Nota Kesepahaman</li>
                                    <li><strong>MoA:</strong> Perjanjian Kerja Sama</li>
                                    <li><strong>IA:</strong> Rancangan Implementasi</li>
                                </ul>
                                <div class="p-3 bg-white rounded-3 border shadow-sm">
                                    <small class="text-muted d-block mb-1">Status Validasi</small>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Sistem Otomatis Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.jenis_dokumen.index') }}" class="btn btn-light fw-bold px-4 me-2">
                            <i class="ti ti-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Jenis Dokumen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed {
            border: 2px dashed #dee2e6 !important;
        }
    </style>
</x-app-layout>
