<x-app-layout>
    <x-slot:title>Registrasi MoU Baru</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoU / Registrasi</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <form action="{{ route('berkas-MoU.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- HIDDEN INPUT UNTUK RELASI KE RENCANA (Jika Ada) --}}
            <input type="hidden" name="rencana_id" value="{{ $rencanaSource->id ?? '' }}">

            <div class="row g-4">
                {{-- KOLOM KIRI: FORM DATA MoU --}}
                <div class="col-lg-8">

                    {{-- SMART BANNER: Info Sumber Data --}}
                @if(isset($rencanaSource))
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-success border-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-white" style="width: 50px; height: 50px;">
                                        <i class="ti ti-link fs-3"></i>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="fw-bold text-dark mb-0 me-2">Pengisian Data Otomatis</h6>
                                            <span class="badge bg-success rounded-pill" style="font-size: 10px;">AUTO-FILL</span>
                                        </div>
                                        <p class="text-muted small mb-0" style="line-height: 1.5;">
                                            Form ini mengambil data dari rencana pengajuan <strong class="text-dark">"{{ $rencanaSource->judul_rencana }}"</strong> (Prodi {{ $rencanaSource->user->prodi->nama_prodi ?? '-' }}).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                @else
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-primary border-start  border-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-white" style="width: 50px; height: 50px;">
                                        <i class="ti ti-link fs-3"></i>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="fw-bold text-dark mb-0 me-2">Pengisian Data Manual</h6>
                                            <span class="badge bg-primary rounded-pill" style="font-size: 10px;">MANUAL-FILL</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                @endif

                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-file-text me-2 text-primary"></i>Informasi Dokumen MoU</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Instansi Mitra <span class="text-danger">*</span></label>
                                    @if(isset($rencanaSource))
                                        {{-- Jika dari Rencana, tampilkan text biasa (Readonly UI), tapi tetap kirim ID-nya --}}
                                        <input type="hidden" name="mitra_id" value="{{ $rencanaSource->mitra_id }}">
                                        <div class="form-control bg-light border-0 d-flex align-items-center text-muted fw-bold">
                                            <i class="ti ti-building me-2"></i> {{ $rencanaSource->mitra->nama_mitra }}
                                            <span class="badge bg-secondary ms-auto">Terkunci (Sesuai Pengajuan)</span>
                                        </div>
                                    @else
                                        {{-- Jika Manual, tampilkan Select2 --}}
                                        <select name="mitra_id" class="form-select select-mitra border-0 bg-light" required>
                                            <option value="">-- Cari Instansi Mitra --</option>
                                            @foreach($mitras as $mitra)
                                                <option value="{{ $mitra->id }}" {{ old('mitra_id') == $mitra->id ? 'selected' : '' }}>
                                                    {{ $mitra->nama_mitra }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold small">Judul / Tentang <span class="text-danger">*</span></label>
                                    <textarea name="judul_mou" class="form-control bg-light border-0" rows="2" placeholder="Kesepakatan Bersama Tentang..." required>{{ old('judul_mou', $rencanaSource->judul_rencana ?? '') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Usulan Durasi Kerjasama <span class="text-danger">*</span></label>
                                    <select name="usulan_durasi_tahun" class="form-select border-0 bg-light py-2" required>
                                        <option value="" selected disabled>-- Pilih Durasi --</option>
                                        <option value="1" {{ old('usulan_durasi_tahun') == '1' ? 'selected' : '' }}>1 Tahun</option>
                                        <option value="3" {{ old('usulan_durasi_tahun') == '3' ? 'selected' : '' }}>3 Tahun</option>
                                        <option value="5" {{ old('usulan_durasi_tahun') == '5' ? 'selected' : '' }}>5 Tahun (Standar MoU)</option>
                                    </select>
                                    <small class="text-muted mt-1 d-block" style="font-size: 11px;">
                                        <i class="ti ti-info-circle me-1"></i>Estimasi waktu berlakunya payung hukum kerjasama.
                                    </small>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-bold small">Ringkasan Kesepakatan </label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0" rows="4" placeholder="Tuliskan poin-poin penting dari MoU ini agar mudah dicari...">{{ old('deskripsi', $rencanaSource->deskripsi ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: UPLOAD & SUBMIT --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 20px; z-index: 10;">
                        {{-- UPLOAD FILE UTAMA --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark border-0 p-3">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran Dokumen (PDF)</h6>
                            </div>
                            <div class="card-body p-4">
                                <div id="upload-area" class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-3 position-relative">
                                    <input type="file" name="file_mou[]" id="fileInput" class="d-none" multiple accept="application/pdf">
                                    <div id="upload-placeholder">
                                        <i class="ti ti-cloud-upload fs-1 text-muted"></i>
                                        <p class="small fw-bold mb-0 mt-2">Klik atau Seret Berkas ke Sini</p>
                                        <p class="text-muted" style="font-size: 10px;">Max 5 File PDF (Max 5MB/file)</p>
                                    </div>
                                </div>
                                <div id="file-list-container" class="d-grid gap-2">
                                </div>
                            </div>
                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bold text-dark mb-2">Simpan Registrasi</h5>
                                <p class="text-muted small mb-4">Pastikan nomor dan masa berlaku sudah sesuai dengan fisik dokumen.</p>

                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow d-flex align-items-center justify-content-center">
                                    <i class="ti ti-device-floppy me-2 fs-5"></i> Simpan Dokumen MoU
                                </button>

                                <hr class="my-3 opacity-25">

                                <a href="{{ route('berkas-MoU.index') }}" class="btn btn-light text-muted w-100 rounded-pill fw-bold">
                                    Batal & Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- DEPENDENSI SELECT2 UNTUK MITRA --}}
        <style>
            .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
            .upload-drop-area { transition: all 0.3s ease; border-color: #dee2e6; background-color: #fbfbfb; }
            .upload-drop-area:hover { border-color: #3b82f6; background-color: #f8faff; }
            .cursor-pointer { cursor: pointer; }
            .avatar-xl { width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; }
            .file-item { animation: fadeIn 0.3s ease; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select-mitra').select2({
                    theme: 'bootstrap-5',
                    placeholder: '-- Cari & Pilih Instansi Mitra --',
                    width: '100%'
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
        @endpush

</x-app-layout>
