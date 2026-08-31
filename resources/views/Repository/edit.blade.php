<x-app-layout>
    <x-slot:title>Edit Arsip Repository - {{ $repository->nomor_dokumen }}</x-slot:title>
    <x-slot:breadcrumb>Repository / Kerjasama / Edit</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <form action="{{ route('Repository_kerjasama.update', $repository->id) }}" method="POST"
            enctype="multipart/form-data" id="mainForm">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- KOLOM KIRI: DATA UTAMA & PIHAK --}}
                <div class="col-lg-7">
                    {{-- CARD 1: INFORMASI UTAMA --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                    <i class="ti ti-edit fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">Informasi Dasar Kerjasama</h5>
                                    <p class="text-muted small mb-0">Perbarui identitas dokumen kerjasama ini.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Judul Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_kerjasama"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        value="{{ old('judul_kerjasama', $repository->judul_kerjasama) }}" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Deskripsi / Ringkasan</label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="3">{{ old('deskripsi', $repository->deskripsi) }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Jenis Dokumen <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_dokumen_id" class="form-select bg-light border-0 py-2" required>
                                        @foreach ($jenisDokumens as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ $repository->jenis_dokumen_id == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->nama_jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Nomor Dokumen <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nomor_dokumen"
                                        class="form-control bg-light border-0 py-2"
                                        value="{{ old('nomor_dokumen', $repository->nomor_dokumen) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tanggal Mulai <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control bg-light border-0 py-2"
                                        value="{{ $repository->tanggal_mulai }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Tanggal Berakhir <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berakhir"
                                        class="form-control bg-light border-0 py-2"
                                        value="{{ $repository->tanggal_berakhir }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DYNAMIC PARTIES --}}
                    <div id="pihak-container">
                        @foreach ($repository->pihakTerlibat as $index => $pihak)
                            <div class="card border-0 shadow-sm rounded-4 mb-4 pihak-item"
                                data-index="{{ $index }}">
                                <div
                                    class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                                            style="width: 35px; height: 35px;">
                                            <span class="fw-bold pihak-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 pihak-title">Pihak Ke - {{ $index + 1 }}</h5>
                                        </div>
                                    </div>
                                    @if ($index > 0)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger border-0 btnRemovePihak px-3">
                                            <i class="ti ti-trash me-1"></i> Hapus
                                        </button>
                                    @endif
                                </div>

                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark small">Instansi Mitra
                                                        <span class="text-danger">*</span></label>
                                                    <select name="pihak[{{ $index }}][mitra_id]"
                                                        class="form-select select-mitra border-0 bg-light py-2"
                                                        required>
                                                        @foreach ($mitras as $mitra)
                                                            <option value="{{ $mitra->id }}"
                                                                {{ $pihak->mitra_id == $mitra->id ? 'selected' : '' }}>
                                                                {{ $mitra->nama_mitra }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark small">Alamat
                                                        Instansi</label>
                                                    <input type="text"
                                                        name="pihak[{{ $index }}][alamat_instansi]"
                                                        class="form-control bg-light border-0 py-2"
                                                        value="{{ $pihak->alamat_instansi }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="p-3 rounded-4 bg-light bg-opacity-50">
                                                <h6 class="fw-bold mb-3 text-primary small"><i
                                                        class="ti ti-signature me-1"></i>Data Penandatangan</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold text-muted">Nama
                                                            Lengkap</label>
                                                        <input type="text"
                                                            name="pihak[{{ $index }}][nama_perwakilan]"
                                                            class="form-control border-0 bg-white py-2"
                                                            value="{{ $pihak->nama_penandatangan }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small fw-bold text-muted">Jabatan
                                                            Resmi</label>
                                                        <input type="text"
                                                            name="pihak[{{ $index }}][jabatan_perwakilan]"
                                                            class="form-control border-0 bg-white py-2"
                                                            value="{{ $pihak->jabatan_penandatangan }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="text-center mb-5">
                        <button type="button" id="btnAddPihak"
                            class="btn btn-outline-primary border-2 px-4 rounded-pill fw-bold hover-primary shadow-sm bg-white">
                            <i class="ti ti-plus me-2"></i> Tambah Pihak Baru
                        </button>
                    </div>
                </div>

                {{-- KOLOM KANAN: STATUS, UPLOAD, & KEGIATAN --}}
                <div class="col-lg-5">
                    {{-- STATUS & ACTION --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4 border-top border-primary border-4">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold text-dark mb-3">Simpan Perubahan</h5>
                            <select name="status"
                                class="form-select mb-3 text-center fw-bold border-2 border-primary">
                                <option value="1" {{ $repository->status == 1 ? 'selected' : '' }}>Status: AKTIF
                                </option>
                                <option value="0" {{ $repository->status == 0 ? 'selected' : '' }}>Status:
                                    KADALUARSA / DRAFT</option>
                            </select>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm mb-2">
                                <i class="ti ti-device-floppy me-2"></i> Perbarui Repository
                            </button>
                            <a href="{{ route('Repository_kerjasama.index') }}"
                                class="btn btn-link btn-sm text-muted">Kembali ke Daftar</a>
                        </div>
                    </div>

                    {{-- FILE MANAGEMENT --}}
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div
                            class="card-header bg-dark border-0 p-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Manajemen Berkas
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            {{-- LIST FILE LAMA --}}
                            @if ($repository->files->count() > 0)
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted mb-2">Berkas Saat Ini (Centang
                                        untuk hapus):</label>
                                    <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                                        @foreach ($repository->files as $file)
                                            <div
                                                class="list-group-item d-flex align-items-center justify-content-between py-2">
                                                <div class="d-flex align-items-center text-truncate me-2">
                                                    <i class="ti ti-file-type-pdf text-danger fs-4 me-2"></i>
                                                    <span
                                                        class="small text-dark text-truncate">{{ $file->nama_file }}</span>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="delete_files[]" value="{{ $file->id }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- UPLOAD BARU --}}
                            <div id="upload-area"
                                class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-3 bg-light">
                                <input type="file" name="file_dokumen[]" id="fileInput" class="d-none" multiple
                                    accept="application/pdf">
                                <i class="ti ti-cloud-upload fs-2 text-muted"></i>
                                <p class="small fw-bold mb-0 mt-2">Tambah Berkas PDF Baru</p>
                                <p class="text-muted small" style="font-size: 10px;">Drag & Drop berkas di sini</p>
                            </div>
                            <div id="file-list-container" class="d-grid gap-2"></div>
                        </div>
                    </div>

                    {{-- DYNAMIC ACTIVITIES --}}
                    <div id="kegiatan-container">
                        @foreach ($repository->bentukKegiatan as $index => $keg)
                            <div class="card border-0 shadow-sm rounded-4 mb-4 kegiatan-item"
                                data-index="{{ $index }}">
                                <div
                                    class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                                            style="width: 35px; height: 35px;">
                                            <span class="fw-bold kegiatan-number">{{ $index + 1 }}</span>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark kegiatan-label">Bentuk Kegiatan
                                                Ke-{{ $index + 1 }}</h5>
                                            <small class="text-muted">Rincian implementasi dan target luaran
                                                kegiatan.</small>
                                        </div>
                                    </div>
                                    @if ($index > 0)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger border-0 btnRemoveKegiatan px-3 hover-danger">
                                            <i class="ti ti-trash me-1"></i> Hapus
                                        </button>
                                    @endif
                                </div>

                                <div class="card-body p-4">
                                    <div class="row g-4">
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-category me-2 text-primary"></i> Jenis Bentuk Kegiatan
                                                <span class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[{{ $index }}][jenis_kegiatan_id]"
                                                class="form-select bg-light border-0 py-2 shadow-none" required>
                                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                                @foreach ($jenisKegiatans as $jk)
                                                    <option value="{{ $jk->id }}"
                                                        {{ $keg->jenis_kegiatan_id == $jk->id ? 'selected' : '' }}>
                                                        {{ $jk->nama_kegiatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Sasaran Kerja --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-target me-2 text-danger"></i> Sasaran Kerja <span
                                                    class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[{{ $index }}][sasaran_kerja_id]"
                                                class="form-select select-sasaran bg-light border-0 py-2 shadow-none"
                                                required>
                                                <option value="">-- Pilih Sasaran --</option>
                                                @foreach ($sasaranKerjas as $sasaran)
                                                    <option value="{{ $sasaran->id }}"
                                                        {{ $keg->sasaran_kerja_id == $sasaran->id ? 'selected' : '' }}>
                                                        {{ $sasaran->nama_sasaran }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- Indikator Kerja --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-chart-bar me-2 text-warning"></i> Indikator Kerja <span
                                                    class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[{{ $index }}][indikator_kerja_id]"
                                                class="form-select select-indikator bg-light border-0 py-2 shadow-none"
                                                required {{ $keg->sasaran_kerja_id ? '' : 'disabled' }}>
                                                <option value="">-- Pilih Sasaran Terlebih Dahulu --</option>
                                                {{-- Logika Edit: Ambil Indikator spesifik berdasarkan Sasaran Kerja yang tersimpan --}}
                                                @if ($keg->sasaran_kerja_id)
                                                    @php
                                                        $indikatorsLama = \App\Models\IndikatorKerja::where(
                                                            'sasaran_kerja_id',
                                                            $keg->sasaran_kerja_id,
                                                        )->get();
                                                    @endphp
                                                    @foreach ($indikatorsLama as $ind)
                                                        <option value="{{ $ind->id }}"
                                                            {{ $keg->indikator_kerja_id == $ind->id ? 'selected' : '' }}>
                                                            {{ $ind->nama_indikator }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        {{-- Nilai Kontrak --}}
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-report-money me-2 text-success"></i> Nilai Kontrak (Rp)
                                            </label>
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">Estimasi
                                                pembiayaan untuk kegiatan ini</small>
                                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                                <span
                                                    class="input-group-text bg-white border-end-0 border-secondary-subtle fw-bold text-success">Rp</span>
                                                {{-- Format rupiah awal dipanggil menggunakan number_format PHP --}}
                                                <input type="text"
                                                    name="kegiatan[{{ $index }}][nilai_kontrak]"
                                                    class="form-control border-start-0 border-secondary-subtle py-2 shadow-none format-rupiah"
                                                    placeholder="0"
                                                    value="{{ number_format($keg->nilai_kontrak, 0, ',', '.') }}">
                                            </div>
                                        </div>
                                        {{-- Luaran --}}
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-bulb me-2 text-info"></i> Luaran (Output)
                                            </label>
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">Hasil
                                                nyata / produk yang dihasilkan</small>
                                            <textarea name="kegiatan[{{ $index }}][luaran]" class="form-control bg-light border-0 shadow-none"
                                                rows="2" placeholder="Contoh: Jurnal ilmiah, modul ajar, dll...">{{ $keg->luaran }}</textarea>
                                        </div>
                                        {{-- Keterangan --}}
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-notes me-2 text-secondary"></i> Keterangan Tambahan
                                            </label>
                                            <textarea name="kegiatan[{{ $index }}][keterangan]" class="form-control bg-light border-0 shadow-none"
                                                rows="2" placeholder="Catatan tambahan spesifik mengenai pelaksanaan kegiatan ini...">{{ $keg->keterangan }}</textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <button type="button" id="btnAddKegiatan"
                        class="btn btn-outline-success w-100 border-2 dashed-border py-3 rounded-4 fw-bold bg-white mb-5 hover-lift">
                        <i class="ti ti-plus me-1"></i> Tambah Kegiatan
                    </button> --}}
                    <div class="text-center position-relative mb-5">
                        <div
                            class="position-absolute top-50 start-50 translate-middle w-100 border-bottom border-primary border-opacity-10">
                        </div>
                        <div class="position-relative text-center" style="z-index: 1;">
                            <button type="button" id="btnAddKegiatan"
                                class="btn btn-white border-success border-2 px-4 rounded-pill fw-bold text-success hover-success shadow-sm">
                                <i class="ti ti-plus me-2"></i> Tambah Bentuk Kegiatan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashed-border {
            border-style: dashed !important;
        }

        .upload-drop-area {
            transition: all 0.3s ease;
        }

        .upload-drop-area:hover {
            border-color: #3b82f6;
            background-color: #fff;
            transform: translateY(-2px);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
    </style>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // COUNTER AWAL BERDASARKAN JUMLAH DATA YANG ADA
                let uniqueId = {{ $repository->pihakTerlibat->count() }};
                let kegiatanUniqueId = {{ $repository->bentukKegiatan->count() }};

                function initSelect2(element) {
                    element.select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: 'Pilih Instansi Mitra...'
                    });
                }

                initSelect2($('.select-mitra'));

                // REFRESH NUMBERS PIHAK
                function refreshPihakNumbers() {
                    $('.pihak-item').each(function(index) {
                        const realNumber = index + 1;
                        $(this).find('.pihak-number').text(realNumber);
                        $(this).find('.pihak-title').text('Pihak Ke - ' + realNumber);

                        // Re-index names agar sinkron di Controller
                        $(this).find('select, input').each(function() {
                            let name = $(this).attr('name');
                            if (name) {
                                $(this).attr('name', name.replace(/pihak\[\d+\]/, 'pihak[' + index +
                                    ']'));
                            }
                        });
                    });
                }

                // REFRESH NUMBERS KEGIATAN
                function refreshKegiatanNumbers() {
                    $('.kegiatan-item').each(function(index) {
                        const realNumber = index + 1;
                        $(this).find('.kegiatan-number').text(realNumber);
                        $(this).find('.kegiatan-label').text('Bentuk Kegiatan Ke-' + realNumber);

                        $(this).find('input, textarea').each(function() {
                            let name = $(this).attr('name');
                            if (name) {
                                $(this).attr('name', name.replace(/kegiatan\[\d+\]/, 'kegiatan[' +
                                    index + ']'));
                            }
                        });
                    });
                }




                // TAMBAH PIHAK
                $('#btnAddPihak').click(function() {
                    let html = `
                <div class="card border-0 shadow-sm rounded-4 mb-4 pihak-item animate__animated animate__fadeInUp">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px;">
                                <span class="fw-bold pihak-number"></span>
                            </div>
                            <h5 class="fw-bold mb-0 text-dark pihak-title">Pihak Ke-</h5>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger border-0 btnRemovePihak px-3">Hapus</button>
                    </div>
                    <div class="card-body p-4 pt-2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Instansi Mitra *</label>
                                <select name="pihak[${uniqueId}][mitra_id]" class="form-select select-mitra border-0 bg-light py-2" required>
                                    <option></option>
                                    @foreach ($mitras as $mitra) <option value="{{ $mitra->id }}">{{ $mitra->nama_mitra }}</option> @endforeach
                                </select>
                            </div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Alamat Instansi</label><input type="text" name="pihak[${uniqueId}][alamat_instansi]" class="form-control bg-light border-0 py-2"></div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Nama Penandatangan *</label><input type="text" name="pihak[${uniqueId}][nama_perwakilan]" class="form-control bg-light border-0 py-2" required></div>
                            <div class="col-md-6"><label class="form-label small fw-bold">Jabatan Resmi *</label><input type="text" name="pihak[${uniqueId}][jabatan_perwakilan]" class="form-control bg-light border-0 py-2" required></div>
                        </div>
                    </div>
                </div>`;
                    const $el = $(html);
                    $('#pihak-container').append($el);
                    initSelect2($el.find('.select-mitra'));
                    uniqueId++;
                    refreshPihakNumbers();
                });

                // TAMBAH KEGIATAN
                $('#btnAddKegiatan').click(function() {
                    let html = `
                    <div class="card border-0 shadow-sm rounded-4 mb-4 kegiatan-item animate__animated animate__fadeInUp" data-index="${kegiatanUniqueId}">
                        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px;">
                                    <span class="fw-bold kegiatan-number"></span>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark kegiatan-label">Bentuk Kegiatan Ke-</h5>
                                    <small class="text-muted">Rincian implementasi dan target luaran kegiatan.</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger border-0 btnRemoveKegiatan px-3 hover-danger">
                                <i class="ti ti-trash me-1"></i> Hapus
                            </button>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-4">

                                {{-- Jenis Kegiatan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                        <i class="ti ti-category me-2 text-primary"></i> Jenis Bentuk Kegiatan <span class="text-danger ms-1">*</span>
                                    </label>
                                    <select name="kegiatan[${kegiatanUniqueId}][jenis_kegiatan_id]" class="form-select bg-light border-0 py-2 shadow-none" required>
                                        <option value="">-- Pilih Jenis Kegiatan --</option>
                                        @foreach ($jenisKegiatans as $jk)
                                            <option value="{{ $jk->id }}">{{ $jk->nama_kegiatan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Sasaran Kerja --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                        <i class="ti ti-target me-2 text-danger"></i> Sasaran Kerja <span class="text-danger ms-1">*</span>
                                    </label>
                                    <select name="kegiatan[${kegiatanUniqueId}][sasaran_kerja_id]" class="form-select select-sasaran bg-light border-0 py-2 shadow-none" required>
                                        <option value="">-- Pilih Sasaran --</option>
                                        @foreach ($sasaranKerjas as $sasaran)
                                            <option value="{{ $sasaran->id }}">{{ $sasaran->nama_sasaran }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Indikator Kerja --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                        <i class="ti ti-chart-bar me-2 text-warning"></i> Indikator Kerja <span class="text-danger ms-1">*</span>
                                    </label>
                                    <select name="kegiatan[${kegiatanUniqueId}][indikator_kerja_id]" class="form-select select-indikator bg-light border-0 py-2 shadow-none" required disabled>
                                        <option value="">-- Pilih Sasaran Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                {{-- Nilai Kontrak --}}
                                <div class="col-md-5">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                        <i class="ti ti-report-money me-2 text-success"></i> Nilai Kontrak (Rp)
                                    </label>
                                    <small class="text-muted d-block mb-2" style="font-size: 11px;">Estimasi pembiayaan untuk kegiatan ini</small>
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-white border-end-0 border-secondary-subtle fw-bold text-success">Rp</span>
                                        <input type="text" name="kegiatan[${kegiatanUniqueId}][nilai_kontrak]" class="form-control border-start-0 border-secondary-subtle py-2 shadow-none format-rupiah" placeholder="0" value="0">
                                    </div>
                                </div>

                                {{-- Luaran --}}
                                <div class="col-md-7">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                        <i class="ti ti-bulb me-2 text-info"></i> Luaran (Output)
                                    </label>
                                    <small class="text-muted d-block mb-2" style="font-size: 11px;">Hasil nyata / produk yang dihasilkan</small>
                                    <textarea name="kegiatan[${kegiatanUniqueId}][luaran]" class="form-control bg-light border-0 shadow-none" rows="2" placeholder="Contoh: Jurnal ilmiah, modul ajar, dll..."></textarea>
                                </div>

                                {{-- Keterangan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                        <i class="ti ti-notes me-2 text-secondary"></i> Keterangan Tambahan
                                    </label>
                                    <textarea name="kegiatan[${kegiatanUniqueId}][keterangan]" class="form-control bg-light border-0 shadow-none" rows="2" placeholder="Catatan tambahan spesifik mengenai pelaksanaan kegiatan ini..."></textarea>
                                </div>

                            </div>
                        </div>
                    </div>`;

                    $('#kegiatan-container').append(html);
                    kegiatanUniqueId++;
                    refreshKegiatanNumbers();
                });

                // HAPUS ITEM
                $(document).on('click', '.btnRemovePihak', function() {
                    $(this).closest('.pihak-item').remove();
                    refreshPihakNumbers();
                });
                $(document).on('click', '.btnRemoveKegiatan', function() {
                    $(this).closest('.kegiatan-item').remove();
                    refreshKegiatanNumbers();
                });
            });

            $(document).ready(function() {
                $(document).on('click', '#upload-area', function(e) {
                    // Mencegah trigger klik ganda jika yang diklik ternyata label di dalamnya
                    if (e.target.id !== 'fileInput') {
                        $('#fileInput').trigger('click');
                    }
                });

                // Handler saat file dipilih
                $(document).on('change', '#fileInput', function() {
                    const $container = $('#file-list-container');
                    $container.empty();

                    const files = Array.from(this.files);

                    if (files.length === 0) return;

                    // Validasi simpel sebelum tampil
                    files.forEach(file => {
                        if (file.type !== 'application/pdf') {
                            alert(`File "${file.name}" harus PDF!`);
                            return;
                        }

                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);

                        // Render preview yang lebih cakep
                        $container.append(`
                        <div class="p-2 bg-light rounded border small d-flex align-items-center animate__animated animate__fadeIn">
                            <div class="bg-white p-2 rounded-2 me-3 text-danger shadow-sm">
                                <i class="ti ti-file-type-pdf fs-4"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-0 text-truncate fw-bold text-dark">${file.name}</p>
                                <span class="text-muted" style="font-size: 10px;">${fileSizeMB} MB</span>
                            </div>
                            <div class="text-success ms-2">
                                <i class="ti ti-circle-check fs-5"></i>
                            </div>
                        </div>
                    `);
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
