<x-app-layout>
    <x-slot:title>Tambah Personil PIC</x-slot:title>
    <x-slot:breadcrumb>Master Data / Mitra / Detail / Tambah PIC</x-slot:breadcrumb>

    <div class="container-fluid">
        {{-- CARD KONTEKS INSTANSI (HEADER) --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary bg-opacity-10 rounded-3 p-3 me-4">
                        <i class="ti ti-building-community fs-1 text-primary"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Mendaftarkan Personil Untuk:</h6>
                        <h2 class="fw-bold text-dark mb-0">{{ $mitra->nama_mitra }}</h2>
                        <div class="mt-2">
                            <span class="badge bg-light text-primary border border-primary border-opacity-25 px-3">
                                <i class="ti ti-category me-1"></i> {{ $mitra->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <span class="text-muted small ms-2"><i class="ti ti-world me-1"></i> {{ $mitra->negara }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CARD FORM UTAMA --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <x-alert></x-alert>

                <form action="{{ route('Pic-Mitra.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mitra_id" value="{{ $mitra->id }}">

                    <div class="row g-4">
                        {{-- KOLOM KIRI: INPUT DATA --}}
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-4 text-dark border-start border-4 border-primary ps-3">Formulir Identitas Personil</h5>

                            <div class="row">
                                {{-- Nama PIC --}}
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Nama Lengkap PIC <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-none">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-user"></i></span>
                                        <input type="text" name="nama_pic" class="form-control border-start-0 @error('nama_pic') is-invalid @enderror" value="{{ old('nama_pic') }}" placeholder="Masukkan nama lengkap personil..." required>
                                    </div>
                                    @error('nama_pic') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                {{-- Jabatan & Status PIC --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Jabatan / Posisi</label>
                                    <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Manager Operasional" value="{{ old('jabatan') }}">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Prioritas PIC <span class="text-danger">*</span></label>
                                    <select name="status_pic" class="form-select @error('status_pic') is-invalid @enderror" required>
                                        <option value="0" {{ old('status_pic') == 0 ? 'selected' : '' }}>Personil Pendamping</option>
                                        <option value="1" {{ old('status_pic') == 1 ? 'selected' : '' }}>Personil Utama (Primary Contact)</option>
                                    </select>
                                </div>

                                {{-- Kontak: WhatsApp & Email --}}
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-success"><i class="ti ti-brand-whatsapp"></i></span>
                                        <input type="text" name="no_telp" class="form-control border-start-0 @error('no_telp') is-invalid @enderror" placeholder="08123456789" value="{{ old('no_telp') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Email Resmi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail text-muted"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0" placeholder="email@perusahaan.com" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="col-12 mb-0">
                                    <label class="form-label fw-bold">Alamat Lengkap PIC</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-map-pin text-muted"></i></span>
                                        <textarea name="alamat"
                                            class="form-control border-start-0 @error('alamat') is-invalid @enderror"
                                            rows="3"
                                            placeholder="Masukkan alamat domisili atau kantor personil (Opsional)...">{{ old('alamat') }}</textarea>
                                    </div>
                                    <div class="form-text small italic">Sediakan Alamat Pribadi atau Kantor Cabang PIC Tersebut</div>
                                    @error('alamat') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: PANEL INFO --}}
                        <div class="col-md-4">
                            <div class="card border-dashed bg-light bg-opacity-25 h-100 border-2">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="ti ti-info-square-rounded text-primary fs-huge" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="fw-bold">Informasi Master PIC</h5>
                                    <p class="small text-muted mb-4">
                                        Pastikan data yang diinput valid karena akan digunakan untuk korespondensi resmi dan sistem notifikasi otomatis.
                                    </p>
                                    <div class="alert alert-primary border-0 small text-start shadow-sm">
                                        <i class="ti ti-alert-circle me-1"></i> Jika Anda memilih <strong>PIC Utama</strong>, sistem akan otomatis merubah PIC utama yang lama menjadi pendamping untuk instansi ini.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON AKSI --}}
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <hr class="opacity-10 mb-4">
                            <a href="{{ route('Manajemen-Mitra.show', $mitra->id) }}" class="btn btn-light fw-bold px-4 me-2">
                                <i class="ti ti-arrow-left me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary fw-bold px-4 shadow-sm">
                                <i class="ti ti-device-floppy me-1"></i>Simpan Data Personil
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
        .form-control:focus, .form-select:focus { border-color: #3b82f6; box-shadow: none; }
    </style>
</x-app-layout>
