<x-app-layout>
    <x-slot:title>Edit Ruang Lingkup: {{ $ruangLingkup->nama_ruanglingkup }}</x-slot:title>
    <x-slot:breadcrumb>Edit</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <form action="{{ route('master-data.ruang_lingkup.update', $ruangLingkup->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Ruang Lingkup --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Ruang Lingkup <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-layers-intersect"></i></span>
                                <input type="text" name="nama_ruanglingkup"
                                    class="form-control @error('nama_ruanglingkup') is-invalid @enderror"
                                    value="{{ old('nama_ruanglingkup', $ruangLingkup->nama_ruanglingkup) }}"
                                    placeholder="Contoh: Bidang Pendidikan"
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
                                placeholder="Jelaskan cakupan dari ruang lingkup ini...">{{ old('keterangan', $ruangLingkup->keterangan) }}</textarea>
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
                                    Perubahan pada nama ruang lingkup akan langsung tercermin pada seluruh dokumen kerja sama yang terkait.
                                </p>

                                <div class="p-3 bg-white rounded-3 border shadow-sm text-start mb-3">
                                    <small class="text-muted d-block mb-1 italic">Statistik:</small>
                                    <div class="small">
                                        {{-- Ganti kerjaSamas dengan nama relasi di model kamu --}}
                                        <span class="d-block">Digunakan oleh: <strong>{{ $ruangLingkup->kerjaSamas()->count() }} Dokumen</strong></span>
                                        <span class="d-block">Terakhir Update: <strong>{{ $ruangLingkup->updated_at->diffForHumans() }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="{{ route('master-data.ruang_lingkup.index') }}" class="btn btn-light fw-bold px-4 me-2">
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
        .border-dashed { border: 2px dashed #dee2e6 !important; }
    </style>
</x-app-layout>
