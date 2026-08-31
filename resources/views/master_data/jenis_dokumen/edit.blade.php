<x-app-layout>
    <x-slot:title>Edit Jenis Dokumen: {{ $jenisDokumen->nama_jenis }}</x-slot:title>
    <x-slot:breadcrumb>Edit</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Form Edit Data --}}
            <form action="{{ route('master-data.jenis_dokumen.update', $jenisDokumen->id) }}" method="POST">
                @csrf
                @method('PUT')

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
                                            value="{{ old('kode_inisial', $jenisDokumen->kode_inisial) }}"
                                            placeholder="Contoh: MoU"
                                            autocomplete="off">
                                        @error('kode_inisial')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">Awalan untuk nomor otomatis.</small>
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
                                            value="{{ old('nama_jenis', $jenisDokumen->nama_jenis) }}"
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
                                placeholder="Jelaskan secara singkat kegunaan jenis dokumen ini...">{{ old('keterangan', $jenisDokumen->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        {{-- Informasi Panel Edit --}}
                        <div class="card border-dashed bg-light bg-opacity-50 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <i class="ti ti-edit text-warning" style="font-size: 3.5rem;"></i>
                                </div>
                                <h5 class="fw-bold">Mode Pembaruan</h5>
                                <p class="small text-muted mb-4">
                                    Anda sedang mengubah tipe dokumen <strong>{{ $jenisDokumen->nama_jenis }}</strong>.
                                </p>

                                <div class="p-3 bg-white rounded-3 border shadow-sm text-start mb-3">
                                    <small class="text-muted d-block mb-1 italic">Log Sistem:</small>
                                    <div class="small">
                                        <span class="d-block">Dibuat: <strong>{{ $jenisDokumen->created_at->format('d/m/Y') }}</strong></span>
                                        <span class="d-block">Update: <strong>{{ $jenisDokumen->updated_at->diffForHumans() }}</strong></span>
                                    </div>
                                </div>

                                <div class="alert alert-warning p-2 small mb-0">
                                    <i class="ti ti-alert-triangle me-1"></i> Perubahan <strong>Kode Inisial</strong> akan mempengaruhi nomor dokumen yang dibuat setelah ini.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.jenis_dokumen.index') }}" class="btn btn-light fw-bold px-4 me-2">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-white fw-bold px-4">
                            <i class="ti ti-refresh me-1"></i>Perbarui Data
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
