<x-app-layout>
    <x-slot:title>Tambah Fakultas</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">

            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Form Tambah Data --}}
            <form action="{{ route('master-data.daftar_fakultas.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Fakultas --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Fakultas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-school"></i></span>
                                <input type="text" name="nama_fakultas"
                                    class="form-control @error('nama_fakultas') is-invalid @enderror"
                                    value="{{ old('nama_fakultas') }}"
                                    placeholder="Contoh: Fakultas Teknik, Fakultas Ekonomi & Bisnis..."
                                    autocomplete="off">
                                @error('nama_fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Akreditasi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Akreditasi <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                @foreach(['Unggul', 'A', 'Baik Sekali', 'B', 'Baik', 'C'] as $item)
                                    <div class="col-md-4">
                                        <div class="form-check custom-option border rounded p-3 @error('akreditasi') border-danger @enderror">
                                            <input class="form-check-input" type="radio" name="akreditasi"
                                                id="akred_{{ $loop->index }}" value="{{ $item }}"
                                                {{ old('akreditasi') == $item ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex flex-column" for="akred_{{ $loop->index }}">
                                                <span class="fw-bold">{{ $item }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('akreditasi')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Informasi Panel --}}
                        <div class="card border-dashed bg-light bg-opacity-50 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <i class="ti ti-info-circle text-primary" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Informasi Master Data</h5>
                                <p class="small text-muted">
                                    Menambahkan data fakultas akan memungkinkan Anda untuk mengelola Program Studi (Prodi) di bawah naungan fakultas ini nantinya.
                                </p>
                                <div class="p-3 bg-white rounded-3 border shadow-sm">
                                    <small class="text-muted d-block mb-1">Status Database</small>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Ready to Sync</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.daftar_fakultas.index') }}" class="btn btn-light fw-bold px-4 me-2">
                            <i class="ti ti-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4">
                            <i class="ti ti-device-floppy me-1"></i>Simpan Fakultas
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
        .custom-option {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .custom-option:hover {
            background-color: #f8f9fa;
            border-color: #3b82f6 !important;
        }
        .form-check-input:checked + .form-check-label {
            color: #3b82f6;
        }
        .form-check-input:checked ~ .form-check-label .fw-bold {
            color: #3b82f6;
        }
    </style>

</x-app-layout>
