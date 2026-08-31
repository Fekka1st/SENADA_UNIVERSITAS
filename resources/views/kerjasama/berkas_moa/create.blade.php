<x-app-layout>
    <x-slot:title>Registrasi Dokumen MoA Baru</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoA / Registrasi Baru</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>
        <form action="{{ route('berkas-MoA.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                {{-- KOLOM KIRI: FORM DATA --}}
                <div class="col-lg-8">

                    {{-- SMART BANNER (Muncul jika form dibuka dari halaman Detail MoU) --}}
                    @if (isset($mouSource))
                        <div
                            class="card border-0 shadow-sm rounded-4 mb-4 border-start border-success border-4 bg-success bg-opacity-10">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm flex-shrink-0"
                                    style="width: 48px; height: 48px;">
                                    <i class="ti ti-link fs-4"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold text-dark mb-0 fs-6">Turunan MoU Terkoneksi</h6>
                                        <span class="badge bg-success" style="font-size: 9px;">AUTO-FILL</span>
                                    </div>
                                    <p class="text-muted small mb-0">MoA ini secara otomatis terikat dengan MoU <strong
                                            class="text-dark">{{ $mouSource->nomor_mou }}</strong>.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- CARD 1: IDENTITAS LEGAL --}}
                    <div class="card border border-secondary-subtle shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center">
                            <div
                                class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="ti ti-gavel fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Identitas Legal & Payung Hukum</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                {{-- Pilih Payung MoU --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Pilih Payung Hukum (MoU) <span
                                            class="text-danger">*</span></label>
                                    @if (isset($mouSource))
                                        <input type="hidden" name="mou_id" value="{{ $mouSource->id }}">
                                        <div
                                            class="form-control bg-light border-0 py-2 px-3 d-flex align-items-center text-muted">
                                            <i class="ti ti-lock me-2 text-secondary"></i>
                                            <span class="fw-medium text-dark">{{ $mouSource->nomor_berkas_mou }} -
                                                {{ $mouSource->mitra->nama_mitra }}</span>
                                        </div>
                                    @else
                                        <select name="mou_id" class="form-select select2 border-0 bg-light py-2 px-3"
                                            required>
                                            <option value="">-- Cari Nomor MoU atau Nama Mitra --</option>
                                            @foreach ($mous as $mouData)
                                                <option value="{{ $mouData->id }}"
                                                    {{ old('mou_id') == $mouData->id ? 'selected' : '' }}>
                                                    {{ $mouData->nomor_berkas_mou }} - JUDUL MOU:
                                                    {{ $mouData->judul_mou }} -
                                                    {{ $mouData->mitra->nama_mitra ?? 'Mitra Tidak Diketahui' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                {{-- Nomor & Judul --}}
                                <div class="col-md-5">
                                    <label class="form-label fw-bold small text-dark">Nomor Dokumen MoA <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nomor_moa"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        placeholder="Contoh: 01/MoA/2026" value="{{ old('nomor_moa') }}" required>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label fw-bold small text-dark">Judul / Perihal Kerja Sama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_moa"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        placeholder="Perjanjian tentang..." value="{{ old('judul_moa') }}" required>
                                </div>

                                {{-- Ruang Lingkup & Arsip --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Ruang Lingkup <span
                                            class="text-danger">*</span></label>
                                    <select name="ruanglingkup_id"
                                        class="form-select select2 border-0 bg-light py-2 px-3" required>
                                        <option value="">-- Pilih --</option>
                                        @foreach ($ruangLingkups as $rl)
                                            <option value="{{ $rl->id }}"
                                                {{ old('ruanglingkup_id') == $rl->id ? 'selected' : '' }}>
                                                {{ $rl->nama_ruanglingkup }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Kode Lemari/Arsip
                                        (Opsional)</label>
                                    <input type="text" name="kode_berkas"
                                        class="form-control bg-light border-0 py-2 px-3" placeholder="Lokasi Hardcopy"
                                        value="{{ old('kode_berkas') }}">
                                </div>

                                {{-- Tanggal --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Tanggal Mulai Berlaku <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        value="{{ old('tanggal_mulai') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Tanggal Berakhir <span
                                            class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berakhir"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        value="{{ old('tanggal_berakhir') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: DETAIL TEKNIS & FINANSIAL --}}
                    <div class="card border border-secondary-subtle shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center">
                            <div
                                class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="ti ti-target fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Detail Pelaksanaan & Finansial</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                {{-- Finansial --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Nilai Finansial (Opsional)</label>
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                        <span
                                            class="input-group-text bg-white border-end-0 border-secondary-subtle fw-bold text-success">Rp</span>
                                        <input type="number" name="nominal_finansial"
                                            class="form-control border-start-0 border-secondary-subtle py-2"
                                            placeholder="0" value="{{ old('nominal_finansial') }}" min="0">
                                    </div>
                                    <small class="text-muted" style="font-size: 10px;">Kosongkan jika
                                        non-finansial.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Sumber Dana (Opsional)</label>
                                    <input type="text" name="sumber_dana"
                                        class="form-control bg-light border-0 py-2 px-3"
                                        placeholder="Contoh: DIPA / CSR Mitra" value="{{ old('sumber_dana') }}">
                                </div>

                                {{-- Text Area --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Tujuan & Output Kerjasama</label>
                                    <textarea name="tujuan_moa" class="form-control bg-light border-0 py-2 px-3" rows="3"
                                        placeholder="Target konkrit yang ingin dicapai...">{{ old('tujuan_moa') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Hak & Kewajiban (Peran
                                        Pihak)</label>
                                    <textarea name="peran_tanggung_jawab" class="form-control bg-light border-0 py-2 px-3" rows="3"
                                        placeholder="Tugas masing-masing pihak...">{{ old('peran_tanggung_jawab') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: UPLOAD & SUBMIT --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 20px;">

                        {{-- CARD UPLOAD --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark border-0 p-3">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran
                                    Dokumen MoA (PDF)</h6>
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

                        {{-- CARD SUBMIT --}}
                        <div class="card border border-secondary-subtle shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <i class="ti ti-device-floppy text-muted opacity-50 mb-3"
                                    style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-dark mb-2">Simpan Registrasi MoA</h6>
                                <p class="small text-muted mb-4">Pastikan nominal finansial dan payung MoU sudah
                                    sesuai.</p>

                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-pill mb-2 hover-lift transition-all">
                                    Simpan Dokumen MoA
                                </button>
                                <a href="{{ route('berkas-MoA.index') }}"
                                    class="btn btn-light w-100 py-2 fw-bold text-muted rounded-pill hover-dark transition-all">
                                    Batal & Kembali
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- STYLES & SCRIPTS --}}
    @if (!isset($mouSource))
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @endif

    <style>
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-drop-area {
            transition: all 0.3s ease;
            border-color: #dee2e6;
            background-color: #fbfbfb;
        }

        .upload-drop-area:hover {
            border-color: #3b82f6;
            background-color: #f8faff;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .avatar-xl {
            width: 70px;
            height: 70px;
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
    </style>

    @push('scripts')
        @if (!isset($mouSource))
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                });
            </script>
        @endif

        <script>
            $(document).ready(function() {
                // logika upload file
                const $uploadArea = $('#upload-area');
                const $fileInput = $('#fileInput');
                const $fileListContainer = $('#file-list-container');
                $uploadArea.on('click', function(e) {
                    if (e.target !== $fileInput[0]) {
                        $fileInput.click();
                    }
                });
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    $uploadArea.on(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
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
                $uploadArea.on('drop', function(e) {
                    const files = e.originalEvent.dataTransfer.files;
                    handleFiles(files);
                    $fileInput[0].files = files;
                });
                $fileInput.on('change', function() {
                    handleFiles(this.files);
                });

                function handleFiles(files) {
                    $fileListContainer.empty();
                    const fileArray = Array.from(files);
                    e
                    if (fileArray.length > 5) {
                        alert('Maksimal hanya 5 file PDF yang diperbolehkan.');
                        $fileInput.val('');
                        return;
                    }

                    fileArray.forEach((file) => {
                        if (file.type !== 'application/pdf') {
                            alert(`File "${file.name}" bukan PDF!`);
                            return;
                        }
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        if (fileSizeMB > 5) {
                            alert(`File "${file.name}" terlalu besar (${fileSizeMB} MB). Maksimal 5MB.`);
                            return;
                        }
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
    @endpush
</x-app-layout>
