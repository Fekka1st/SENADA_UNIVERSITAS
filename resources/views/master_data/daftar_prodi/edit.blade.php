<x-app-layout>
    <x-slot:title>Edit Program Studi: {{ $prodi->nama_prodi }}</x-slot:title>
    <x-slot:breadcrumb>Edit</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            {{-- Action diarahkan ke route update dengan parameter ID --}}
            <form action="{{ route('master-data.daftar_prodi.update', $prodi->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Wajib untuk proses update --}}

                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Prodi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_prodi"
                                class="form-control @error('nama_prodi') is-invalid @enderror"
                                value="{{ old('nama_prodi', $prodi->nama_prodi) }}"
                                placeholder="Contoh: S1 Teknik Informatika">
                            @error('nama_prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Pilih Fakultas --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas_id" class="form-select @error('fakultas_id') is-invalid @enderror">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}" {{ old('fakultas_id', $prodi->fakultas_id) == $f->id ? 'selected' : '' }}>
                                        {{ $f->nama_fakultas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fakultas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Akreditasi --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Akreditasi Prodi <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3 flex-wrap">
                                @foreach(['Unggul', 'A', 'Baik Sekali', 'B', 'Baik', 'C'] as $item)
                                    <div class="form-check border rounded p-2 px-3 custom-option">
                                        <input class="form-check-input" type="radio" name="akreditasi"
                                            id="akred_{{ $loop->index }}" value="{{ $item }}"
                                            {{ old('akreditasi', $prodi->akreditasi_prodi) == $item ? 'checked' : '' }}>
                                        <label class="form-check-label cursor-pointer" for="akred_{{ $loop->index }}">
                                            {{ $item }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('akreditasi') <small class="text-danger d-block mt-2">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-dashed h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <i class="ti ti-edit text-warning mb-3" style="font-size: 3rem;"></i>
                                <h5 class="fw-bold">Mode Edit</h5>
                                <p class="small text-muted">
                                    Anda sedang mengubah data program studi. Pastikan perubahan sudah sesuai dengan SK Akreditasi terbaru.
                                </p>
                                <div class="p-2 bg-white rounded border shadow-sm text-start mt-2">
                                    <small class="text-muted d-block">Terakhir diupdate:</small>
                                    <span class="fw-bold small">{{ $prodi->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <hr class="opacity-10">
                    <a href="{{ route('master-data.daftar_prodi.index') }}" class="btn btn-light px-4 me-2 fw-bold">Batal</a>
                    <button type="submit" class="btn btn-warning text-white px-4 fw-bold">
                        <i class="ti ti-refresh me-1"></i>Perbarui Prodi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #dee2e6 !important; }
        .cursor-pointer { cursor: pointer; }
        .custom-option { transition: all 0.2s ease; }
        .custom-option:hover { background-color: #f8f9fa; border-color: #ffc107 !important; }
    </style>
</x-app-layout>
