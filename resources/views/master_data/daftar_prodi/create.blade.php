<x-app-layout>
    <x-slot:title>Tambah Program Studi</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <form action="{{ route('master-data.daftar_prodi.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        {{-- Nama Prodi --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_prodi" class="form-control @error('nama_prodi') is-invalid @enderror" value="{{ old('nama_prodi') }}" placeholder="Contoh: S1 Teknik Informatika">
                            @error('nama_prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Pilih Fakultas --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas_id" class="form-select @error('fakultas_id') is-invalid @enderror">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}" {{ old('fakultas_id', $selectedFakultasId) == $f->id ? 'selected' : '' }}>
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
                                    <div class="form-check border rounded p-2 px-3">
                                        <input class="form-check-input" type="radio" name="akreditasi" id="akred_{{ $loop->index }}" value="{{ $item }}" {{ old('akreditasi') == $item ? 'checked' : '' }}>
                                        <label class="form-check-label" for="akred_{{ $loop->index }}">{{ $item }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('akreditasi') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-dashed h-100">
                            <div class="card-body text-center">
                                <i class="ti ti-books text-primary" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 fw-bold">Panduan</h5>
                                <p class="small text-muted">Pastikan nama program studi sesuai dengan nomenklatur resmi universitas.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <hr>
                    <a href="{{ route('master-data.daftar_prodi.index') }}" class="btn btn-light px-4 me-2">Batal</a>
                    <button type="submit" class="btn btn-primary px-4">Simpan Prodi</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
