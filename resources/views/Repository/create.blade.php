<x-app-layout>
    <x-slot:title>Tambah Arsip Repository</x-slot:title>
    <x-slot:breadcrumb>Repository / Kerjasama / Tambah</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <form action="{{ route('Repository_kerjasama.store') }}" method="POST" enctype="multipart/form-data"
            id="mainForm">
            @csrf

            <div class="row g-4">
                {{-- KOLOM KIRI: DATA UTAMA --}}
                <div class="col-lg-6">
                    {{-- CARD 1: INFORMASI UTAMA --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                    <i class="ti ti-book-2 fs-4 text-white"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Informasi Dasar Kerjasama</h5>
                                    <p class="text-muted small mb-0">Lengkapi data identitas dokumen secara akurat.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Judul Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_kerjasama"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        placeholder="Tuliskan judul lengkap kerjasama..." required>
                                </div>

                                {{-- DESKRIPSI (LUAS) --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi / Ringkasan Kerjasama</label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="5"
                                        placeholder="Berikan deskripsi singkat mengenai poin-poin utama kerjasama ini..."></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Jenis Dokumen <span
                                            class="text-danger">*</span></label>
                                    <select name="jenis_dokumen_id" class="form-select bg-light border-0" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        @foreach ($jenisDokumens as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Dokumen <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nomor_dokumen" class="form-control bg-light border-0"
                                        placeholder="Nomor resmi dokumen..." required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Mulai <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="ti ti-calendar-event"></i></span>
                                        <input type="date" name="tanggal_mulai"
                                            class="form-control bg-light border-0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tanggal Berakhir <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i
                                                class="ti ti-calendar-time"></i></span>
                                        <input type="date" name="tanggal_berakhir"
                                            class="form-control bg-light border-0" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- DYNAMIC PARTIES --}}
                    <div id="pihak-container">
                        {{-- Pihak 1 (Mandatory - Biasanya Pihak Internal/Instansi Anda) --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 pihak-item" data-index="0">
                            <div
                                class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                                        style="width: 35px; height: 35px;">
                                        <span class="fw-bold pihak-number">1</span>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Pihak Ke - 1</h5>
                                        <small class="text-muted">Informasi instansi dan perwakilan penandatangan
                                            utama.</small>
                                    </div>
                                </div>
                                {{-- Pihak 1 tidak memiliki tombol hapus karena mandatory --}}
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">
                                    {{-- SECTION: PROFIL INSTANSI --}}
                                    <div class="col-12">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Instansi Mitra <span
                                                        class="text-danger">*</span></label>
                                                <select name="pihak[0][mitra_id]"
                                                    class="form-select select-mitra border-0 bg-light py-2" required>
                                                    <option></option>
                                                    @foreach ($mitras as $mitra)
                                                        <option value="{{ $mitra->id }}">{{ $mitra->nama_mitra }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark">Alamat Instansi</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light border-0"><i
                                                            class="ti ti-map-pin text-muted"></i></span>
                                                    <input type="text" name="pihak[0][alamat_instansi]"
                                                        class="form-control bg-light border-0 py-2"
                                                        placeholder="Lokasi kantor instansi...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECTION: PENANDATANGAN --}}
                                    <div class="col-12">
                                        <div class="p-3 rounded-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="ti ti-signature fs-5 text-primary me-2"></i>
                                                <h6 class="fw-bold mb-0 text-primary">Data Penandatangan (Signatory)
                                                </h6>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted">Nama Lengkap &
                                                        Gelar <span class="text-danger">*</span></label>
                                                    <input type="text" name="pihak[0][nama_perwakilan]"
                                                        class="form-control border-0 bg-white shadow-sm py-2"
                                                        placeholder="Contoh: Dr. Aris Wahyu, M.T." required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted">Jabatan Resmi
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="pihak[0][jabatan_perwakilan]"
                                                        class="form-control border-0 bg-white shadow-sm py-2"
                                                        placeholder="Contoh: Direktur Operasional" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- SECTION: PIC (OPTIONAL) --}}
                                    <div class="col-12">
                                        <div class="p-3 rounded-4">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="ti ti-user-cog fs-5 text-secondary me-2"></i>
                                                <h6 class="fw-bold mb-0 text-secondary">Penanggung Jawab Teknis (PIC)
                                                    <span
                                                        class="badge bg-white text-muted fw-normal ms-2 border">Opsional</span>
                                                </h6>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted">Nama PIC</label>
                                                    <input type="text" name="pihak[0][nama_pic]"
                                                        class="form-control border-0 bg-white shadow-sm py-2"
                                                        placeholder="Nama perwakilan teknis">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted">Jabatan
                                                        PIC</label>
                                                    <input type="text" name="pihak[0][jabatan_pic]"
                                                        class="form-control border-0 bg-white shadow-sm py-2"
                                                        placeholder="Posisi/Unit kerja">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL TAMBAH --}}
                    <div class="position-relative mb-5">
                        <div
                            class="position-absolute top-50 start-50 translate-middle w-100 border-bottom border-primary border-opacity-10">
                        </div>
                        <div class="position-relative text-center" style="z-index: 1;">
                            <button type="button" id="btnAddPihak"
                                class="btn btn-white border-primary border-2 px-4 rounded-pill fw-bold text-primary hover-primary shadow-sm">
                                <i class="ti ti-plus me-2"></i> Tambah Pihak Kerjasama
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: STATUS & UPLOAD --}}
                <div class="col-lg-6">
                    <div class="" style="top: 20px;">
                        {{-- STATUS CARD --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-body p-4 text-center">
                                <div
                                    class="avatar avatar-xl bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3">
                                    <i class="ti ti-upload fs-1"></i>
                                </div>
                                <h5 class="fw-bold">Publikasi Arsip</h5>
                                <p class="text-muted small">Data akan diverifikasi oleh sistem setelah proses simpan
                                    selesai.</p>

                                <select name="status"
                                    class="form-select mb-3 text-center fw-bold border-2 border-primary">
                                    <option value="1">Status: AKTIF</option>
                                    <option value="0">Status: KADALUARSA</option>
                                </select>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm">
                                    <i class="ti ti-device-floppy me-2"></i> Simpan Repository
                                </button>
                                <a href="{{ route('Repository_kerjasama.index') }}"
                                    class="btn btn-link btn-sm text-muted mt-2">Batalkan Input</a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark border-0 p-3">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran
                                    Dokumen (PDF)</h6>
                            </div>
                            <div class="card-body p-4">
                                <div id="upload-area"
                                    class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-3 position-relative">
                                    <input type="file" name="file_dokumen[]" id="fileInput" class="d-none"
                                        multiple accept="application/pdf">

                                    <div id="upload-placeholder">
                                        <i class="ti ti-cloud-upload fs-1 text-muted"></i>
                                        <p class="small fw-bold mb-0 mt-2">Klik atau Seret Berkas ke Sini</p>
                                        <p class="text-muted" style="font-size: 10px;">Max 5 File PDF (Max 5MB/file)
                                        </p>
                                    </div>
                                </div>
                                <div id="file-list-container" class="d-grid gap-2">
                                </div>
                            </div>
                        </div>
                        {{-- CARD BENTUK KEGIATAN --}}
                        <div id="kegiatan-container">
                            <div class="card border-0 shadow-sm rounded-4 mb-4 kegiatan-item" data-index="0">
                                <div
                                    class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                                            style="width: 35px; height: 35px;">
                                            <span class="fw-bold kegiatan-number">1</span>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-dark kegiatan-label">Bentuk Kegiatan Ke-1</h5>
                                            <small class="text-muted">Rincian implementasi dan target luaran
                                                kegiatan.</small>
                                        </div>
                                    </div>
                                    {{-- Tombol hapus disembunyikan untuk kegiatan pertama jika wajib minimal satu --}}
                                </div>

                                <div class="card-body p-4">
                                    <div class="row g-4"> {{-- Menggunakan g-4 agar jarak antar baris lebih lega --}}

                                        {{-- BARIS 1: Jenis Kegiatan (Penting, full width) --}}
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-category me-2 text-primary"></i> Jenis Bentuk Kegiatan
                                                <span class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[0][jenis_kegiatan_id]"
                                                class="form-select bg-light border-0 py-2 shadow-none" required>
                                                <option value="">-- Pilih Jenis Kegiatan --</option>
                                                @foreach ($jenisKegiatans as $jk)
                                                    <option value="{{ $jk->id }}">{{ $jk->nama_kegiatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- BARIS 2: Sasaran & Indikator (Saling bersebelahan karena berkaitan) --}}
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-target me-2 text-danger"></i> Sasaran Kerja <span
                                                    class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[0][sasaran_kerja_id]"
                                                class="form-select select-sasaran bg-light border-0 py-2 shadow-none"
                                                required>
                                                <option value="">-- Pilih Sasaran --</option>
                                                @foreach ($sasaranKerjas as $sasaran)
                                                    <option value="{{ $sasaran->id }}">{{ $sasaran->nama_sasaran }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-2">
                                                <i class="ti ti-chart-bar me-2 text-warning"></i> Indikator Kerja <span
                                                    class="text-danger ms-1">*</span>
                                            </label>
                                            <select name="kegiatan[0][indikator_kerja_id]"
                                                class="form-select select-indikator bg-light border-0 py-2 shadow-none"
                                                required disabled>
                                                <option value="">-- Pilih Sasaran Terlebih Dahulu --</option>
                                            </select>
                                        </div>

                                        {{-- BARIS 3: Nilai Kontrak & Luaran --}}
                                        <div class="col-md-5">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-report-money me-2 text-success"></i> Nilai Kontrak (Rp)
                                            </label>
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">Estimasi
                                                pembiayaan untuk kegiatan ini</small>
                                            <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                                <span
                                                    class="input-group-text bg-white border-end-0 border-secondary-subtle fw-bold text-success">Rp</span>
                                                <input type="text" name="kegiatan[0][nilai_kontrak]"
                                                    class="form-control border-start-0 border-secondary-subtle py-2 shadow-none format-rupiah"
                                                    placeholder="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-bulb me-2 text-info"></i> Luaran (Output)
                                            </label>
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">Hasil
                                                nyata / produk yang dihasilkan</small>
                                            <textarea name="kegiatan[0][luaran]" class="form-control bg-light border-0 shadow-none" rows="2"
                                                placeholder="Contoh: Jurnal ilmiah, modul ajar, dll..."></textarea>
                                        </div>

                                        {{-- BARIS 4: Keterangan (Full width) --}}
                                        <div class="col-12">
                                            <label class="form-label fw-bold text-dark d-flex align-items-center mb-1">
                                                <i class="ti ti-notes me-2 text-secondary"></i> Keterangan Tambahan
                                            </label>
                                            <textarea name="kegiatan[0][keterangan]" class="form-control bg-light border-0 shadow-none" rows="2"
                                                placeholder="Catatan tambahan spesifik mengenai pelaksanaan kegiatan ini..."></textarea>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Tambah Kegiatan --}}
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
            border-color: #dee2e6;
        }

        .upload-drop-area:hover {
            border-color: #3b82f6;
            background-color: #f8faff;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .avatar-xl {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .file-item {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hover-primary:hover {
            background-color: #3b82f6 !important;
            color: white !important;
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }

        .pihak-item {
            transition: transform 0.3s ease;
        }

        .dashed-border {
            border: 2px dashed #dee2e6 !important;
        }

        .hover-success:hover {
            background-color: #198754 !important;
            color: white !important;
            transform: translateY(-2px);
            transition: all 0.2s ease;
        }
    </style>


    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                let kegiatanUniqueId = 1;

                function refreshKegiatanNumbers() {
                    $('.kegiatan-item').each(function(index) {
                        let visualNumber = index + 1;
                        $(this).find('.kegiatan-number').text(visualNumber);
                        $(this).find('.kegiatan-label').text('Bentuk Kegiatan Ke-' + visualNumber);
                        $(this).find('input, textarea, select').each(function() {
                            let nameAttr = $(this).attr('name');
                            if (nameAttr) {
                                let newName = nameAttr.replace(/kegiatan\[\d+\]/, 'kegiatan[' + index +
                                    ']');
                                $(this).attr('name', newName);
                            }
                        });
                    });
                }
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
                                    {{-- Note: Memiliki class 'select-indikator' agar terdeteksi oleh AJAX --}}
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

                    // Render ke HTML
                    $('#kegiatan-container').append(html);
                    kegiatanUniqueId++;
                    refreshKegiatanNumbers();
                });

                // Handler Hapus Kegiatan
                $(document).on('click', '.btnRemoveKegiatan', function() {
                    $(this).closest('.kegiatan-item').fadeOut(300, function() {
                        $(this).remove();
                        refreshKegiatanNumbers();
                    });
                });

                $(document).on('input', '.format-rupiah', function() {
                    let val = $(this).val();
                    let clean = val.replace(/\D/g, '');
                    if (clean) {
                        $(this).val(parseInt(clean, 10).toLocaleString('id-ID'));
                    } else {
                        $(this).val('');
                    }
                });
                $('form').on('submit', function() {
                    $('.format-rupiah').each(function() {
                        let val = $(this).val();
                        $(this).val(val.replace(/\./g, ''));
                    });
                    $(this).find('button[type="submit"]').prop('disabled', true).html(
                        '<i class="ti ti-loader ti-spin me-2"></i> Menyimpan...');
                });

                // ==========================================
                // LOGIK DINAMIS PIHAK (SMART RE-INDEXING)
                // ==========================================
                let uniqueId = 1; // Untuk ID internal array agar tidak bentrok
                function refreshPihakNumbers() {
                    $('.pihak-item').each(function(index) {
                        const realNumber = index + 1;
                        $(this).find('.pihak-number').text(realNumber);
                        $(this).find('.pihak-title').text('Pihak Ke -' + realNumber);
                    });
                }

                function initSelect2(element) {
                    element.select2({
                        theme: 'bootstrap-5',
                        placeholder: 'Pilih Instansi Mitra...',
                        allowClear: true,
                        width: '100%'
                    });
                }
                initSelect2($('.select-mitra'));


                $('#btnAddPihak').click(function() {
                    let html = `
            <div class="card border-0 shadow-sm rounded-4 mb-4 pihak-item animate__animated animate__fadeInUp">
                {{-- HEADER PIHAK --}}
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 35px; height: 35px;">
                            <span class="fw-bold pihak-number"></span>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark pihak-title">Pihak Ke-</h5>
                            <small class="text-muted">Informasi instansi dan perwakilan mitra pendukung.</small>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger border-0 btnRemovePihak px-3">
                        <i class="ti ti-trash me-1"></i> Hapus Pihak
                    </button>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        {{-- SECTION: PROFIL INSTANSI --}}
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Instansi Mitra <span class="text-danger">*</span></label>
                                    <select name="pihak[${uniqueId}][mitra_id]" class="form-select select-mitra border-0 bg-light py-2" required>
                                        <option></option>
                                        @foreach ($mitras as $mitra)
                                            <option value="{{ $mitra->id }}">{{ $mitra->nama_mitra }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Alamat Instansi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="ti ti-map-pin text-muted"></i></span>
                                        <input type="text" name="pihak[${uniqueId}][alamat_instansi]" class="form-control bg-light border-0 py-2" placeholder="Lokasi kantor instansi...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: PENANDATANGAN --}}
                        <div class="col-12">
                            <div class="p-3 rounded-4 ">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="ti ti-signature fs-5 text-primary me-2"></i>
                                    <h6 class="fw-bold mb-0 text-primary">Data Penandatangan (Signatory)</h6>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Nama Lengkap & Gelar <span class="text-danger">*</span></label>
                                        <input type="text" name="pihak[${uniqueId}][nama_perwakilan]" class="form-control border-0 bg-white shadow-sm py-2" placeholder="Nama Penandatangan" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Jabatan Resmi <span class="text-danger">*</span></label>
                                        <input type="text" name="pihak[${uniqueId}][jabatan_perwakilan]" class="form-control border-0 bg-white shadow-sm py-2" placeholder="Jabatan Penandatangan" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: PIC (OPTIONAL) --}}
                        <div class="col-12">
                            <div class="p-3 rounded-4 ">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="ti ti-user-cog fs-5 text-secondary me-2"></i>
                                    <h6 class="fw-bold mb-0 text-secondary">Penanggung Jawab Teknis (PIC) <span class="badge bg-white text-muted fw-normal ms-2 border">Opsional</span></h6>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Nama PIC</label>
                                        <input type="text" name="pihak[${uniqueId}][nama_pic]" class="form-control border-0 bg-white shadow-sm py-2" placeholder="Nama perwakilan teknis">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Jabatan PIC</label>
                                        <input type="text" name="pihak[${uniqueId}][jabatan_pic]" class="form-control border-0 bg-white shadow-sm py-2" placeholder="Posisi/Unit kerja">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

                    const $newPihak = $(html);
                    $('#pihak-container').append($newPihak);
                    initSelect2($newPihak.find('.select-mitra'));

                    uniqueId++;
                    refreshPihakNumbers();
                });
                $(document).on('click', '.btnRemovePihak', function() {
                    $(this).closest('.pihak-item').fadeOut(300, function() {
                        $(this).remove();
                        refreshPihakNumbers();
                    });
                });

                // logika upload file
                const $uploadArea = $('#upload-area');
                const $fileInput = $('#fileInput');
                const $fileListContainer = $('#file-list-container');

                // 1. FITUR KLIK: Picu input file saat div diklik
                $uploadArea.on('click', function(e) {
                    // Mencegah trigger ganda jika yang diklik adalah input itu sendiri (meski d-none)
                    if (e.target !== $fileInput[0]) {
                        $fileInput.click();
                    }
                });

                // 2. FITUR DRAG & DROP: Menangani interaksi seret-lepas
                // Mencegah perilaku default browser (seperti membuka PDF di tab baru)
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    $uploadArea.on(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                // Efek visual saat file diseret di atas area
                ['dragenter', 'dragover'].forEach(eventName => {
                    $uploadArea.on(eventName, function() {
                        $uploadArea.addClass('border-primary bg-primary bg-opacity-10');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    $uploadArea.on(eventName, function() {
                        $uploadArea.removeClass('border-primary bg-primary bg-opacity-10');
                    });
                });

                // Menangani file yang dijatuhkan (Dropped)
                $uploadArea.on('drop', function(e) {
                    const files = e.originalEvent.dataTransfer.files;
                    handleFiles(files);

                    // Penting: Masukkan file hasil drop ke dalam element input
                    $fileInput[0].files = files;
                });

                // Menangani file dari klik (Selected via Dialog)
                $fileInput.on('change', function() {
                    handleFiles(this.files);
                });

                // 3. FUNGSI RENDER: Menampilkan daftar file secara profesional
                function handleFiles(files) {
                    $fileListContainer.empty();
                    const fileArray = Array.from(files);

                    // Validasi Maksimal 5 File
                    if (fileArray.length > 5) {
                        alert('Maksimal hanya 5 file PDF yang diperbolehkan.');
                        $fileInput.val(''); // Reset input
                        return;
                    }

                    fileArray.forEach((file) => {
                        // Validasi Tipe File (PDF Only)
                        if (file.type !== 'application/pdf') {
                            alert(`File "${file.name}" bukan PDF!`);
                            return;
                        }

                        // Validasi Ukuran (Max 5MB)
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        if (fileSizeMB > 5) {
                            alert(`File "${file.name}" terlalu besar (${fileSizeMB} MB). Maksimal 5MB.`);
                            return;
                        }

                        // Render Preview Item
                        const fileItem = `
                        <div class="d-flex align-items-center p-2 bg-light rounded-3 border animate__animated animate__fadeIn">
                            <div class="bg-white p-2 rounded-2 me-3 text-danger shadow-sm">
                                <i class="ti ti-file-type-pdf fs-4"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="mb-0 text-truncate small fw-bold text-dark">${file.name}</p>
                                <span class="text-muted" style="font-size: 10px;">${fileSizeMB} MB</span>
                            </div>
                            <div class="text-success ms-2">
                                <i class="ti ti-circle-check fs-5"></i>
                            </div>
                        </div>
                    `;
                        $fileListContainer.append(fileItem);
                    });
                }
            });
        </script>

        <script>
            $(document).ready(function() {
                $(document).on('change', '.select-sasaran', function() {
                    let sasaranId = $(this).val();
                    let $indikatorSelect = $(this).closest('.row').find('.select-indikator');

                    $indikatorSelect.html('<option value="">Loading...</option>').prop('disabled', true);

                    if (sasaranId) {
                        $.ajax({

                            // Tambahkan garis miring '/' di awal URL agar rutenya absolut dan tidak error saat diakses dari sub-folder
                            url: '/Repository_kerjasama/get-indikator/' + sasaranId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $indikatorSelect.empty();

                                // Jika ternyata sasaran ini belum punya indikator di database
                                if (data.length === 0) {
                                    $indikatorSelect.append(
                                        '<option value="">-- Tidak ada indikator untuk sasaran ini --</option>'
                                    );
                                } else {
                                    $indikatorSelect.append(
                                        '<option value="">-- Pilih Indikator --</option>');

                                    // Karena response sekarang adalah Array, $.each akan berjalan dengan sempurna
                                    $.each(data, function(key, value) {
                                        $indikatorSelect.append('<option value="' + value
                                            .id + '">' + value.nama_indikator +
                                            '</option>');
                                    });
                                }

                                $indikatorSelect.prop('disabled',
                                    false); // Aktifkan kembali dropdown
                            },
                            error: function() {
                                $indikatorSelect.html(
                                    '<option value="">-- Terjadi Kesalahan --</option>');
                            }
                        });
                    } else {
                        $indikatorSelect.html('<option value="">-- Pilih Sasaran Terlebih Dahulu --</option>')
                            .prop('disabled', true);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
