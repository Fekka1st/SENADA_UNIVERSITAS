<x-app-layout>
    <x-slot:title>Edit Personil PIC</x-slot:title>
    <x-slot:breadcrumb>Master Data / Mitra / Detail / Edit PIC</x-slot:breadcrumb>

    <div class="container-fluid">
        {{-- CARD KONTEKS INSTANSI (HEADER) --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3 me-4">
                        <i class="ti ti-user-edit fs-1 text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Memperbarui Personil Untuk:</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $pic->mitra->nama_mitra }}</h2>
                        <div class="mt-2 text-muted small">
                            <i class="ti ti-id me-1"></i> ID Personil: #{{ $pic->id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD FORM UTAMA --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <x-alert></x-alert>

                <form action="{{ route('Pic-Mitra.update', $pic->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Hidden mitra_id untuk keperluan logic di controller jika dibutuhkan --}}
                    <input type="hidden" name="mitra_id" value="{{ $pic->mitra_id }}">

                    <div class="row g-4">
                        {{-- KOLOM KIRI: INPUT DATA --}}
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-4 text-dark border-start border-4 border-warning ps-3">Formulir Pembaruan Identitas</h5>

                            <div class="row">
                                {{-- Nama PIC --}}
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Nama Lengkap PIC <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-none">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-user"></i></span>
                                        <input type="text" name="nama_pic" class="form-control border-start-0 @error('nama_pic') is-invalid @enderror" value="{{ old('nama_pic', $pic->nama_pic) }}" required>
                                    </div>
                                    @error('nama_pic') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Jabatan & Status PIC --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Jabatan / Posisi</label>
                                    <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pic->jabatan) }}">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Prioritas PIC <span class="text-danger">*</span></label>
                                    <select name="status_pic" class="form-select @error('status_pic') is-invalid @enderror" required>
                                        <option value="0" {{ old('status_pic', $pic->status_pic) == 0 ? 'selected' : '' }}>Personil Pendamping</option>
                                        <option value="1" {{ old('status_pic', $pic->status_pic) == 1 ? 'selected' : '' }}>Personil Utama (Primary Contact)</option>
                                    </select>
                                </div>

                                {{-- Kontak: WhatsApp & Email --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-success"><i class="ti ti-brand-whatsapp"></i></span>
                                        <input type="text" name="no_telp" class="form-control border-start-0 @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $pic->no_telp) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Email Resmi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail text-muted"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0" value="{{ old('email', $pic->email) }}">
                                    </div>
                                </div>

                                {{-- Alamat --}}
                                <div class="col-12 mb-0">
                                    <label class="form-label fw-bold">Alamat Lengkap PIC</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-map-pin text-muted"></i></span>
                                        <textarea name="alamat" class="form-control border-start-0" rows="3">{{ old('alamat', $pic->alamat) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: PANEL INFO --}}
                        <div class="col-md-4">
                            <div class="card border-dashed bg-light bg-opacity-25 h-100 border-2">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="ti ti-history text-warning fs-huge" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="fw-bold">Audit Data</h5>
                                    <p class="small text-muted mb-4">
                                        Setiap perubahan data personil akan tercatat dalam log sistem untuk keperluan audit kerjasama.
                                    </p>
                                    <div class="alert alert-warning border-0 small text-start shadow-sm">
                                        <i class="ti ti-alert-triangle me-1"></i> Jika Anda mengubah personil ini menjadi <strong>PIC Utama</strong>, sistem akan otomatis mendemosi PIC utama sebelumnya menjadi pendamping.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON AKSI --}}
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <hr class="opacity-10 mb-4">
                            <a href="{{ route('Manajemen-Mitra.show', $pic->mitra_id) }}" class="btn btn-light fw-bold px-4 me-2">
                                <i class="ti ti-arrow-left me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 shadow-sm text-white">
                                <i class="ti ti-refresh me-1"></i>Perbarui Personil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .border-dashed { border-style: dashed !important; }
        .icon-box { width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; }
        .form-control:focus, .form-select:focus { border-color: #f59e0b; box-shadow: none; }
    </style>
</x-app-layout>
