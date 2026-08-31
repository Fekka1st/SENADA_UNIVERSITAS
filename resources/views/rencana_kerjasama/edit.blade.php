<x-app-layout>
    <x-slot:title>Edit Rencana Kerjasama</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / Rencana / Edit</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <form action="{{ route('rencana-kerjasama.update', $rencana->id) }}" method="POST" enctype="multipart/form-data"
            id="mainForm">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- KOLOM KIRI: DETAIL RENCANA --}}
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-3 me-3">
                                    <i class="ti ti-edit fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Edit Rencana Kerjasama</h5>
                                    <p class="text-muted small mb-0">Perbarui informasi rencana pengajuan Anda.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Judul Rencana Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="judul_rencana"
                                        class="form-control bg-light border-0 py-2 px-3" required
                                        value="{{ old('judul_rencana', $rencana->judul_rencana) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pilih Mitra Strategis <span
                                            class="text-danger">*</span></label>
                                    <select name="mitra_id" class="form-select select-mitra border-0 bg-light py-2"
                                        required>
                                        <option value="">-- Pilih Mitra --</option>
                                        @forelse($mitras ?? [] as $mitra)
                                            <option value="{{ $mitra->id }}"
                                                {{ old('mitra_id', $rencana->mitra_id) == $mitra->id ? 'selected' : '' }}>
                                                {{ $mitra->nama_mitra }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Data Mitra Belum Tersedia</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ruang Lingkup <span
                                            class="text-danger">*</span></label>
                                    <select name="ruanglingkup_id"
                                        class="form-select select-scope border-0 bg-light py-2" required>
                                        <option value="">-- Pilih Ruang Lingkup --</option>
                                        @forelse($ruangLingkups ?? [] as $scope)
                                            <option value="{{ $scope->id }}"
                                                {{ old('ruanglingkup_id', $rencana->ruanglingkup_id) == $scope->id ? 'selected' : '' }}>
                                                {{ $scope->nama_ruanglingkup }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Data Ruang Lingkup Kosong</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi & Tujuan Rencana Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="8" required>{{ old('deskripsi', $rencana->deskripsi) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: STATUS & UPLOAD --}}
                <div class="col-lg-5">
                    <div class="sticky-top" style="top: 20px; z-index: 10;">
                        @if ($rencana->status == 4 || $rencana->feedback_internal != null)
                            <div class="card border-0 shadow-sm rounded-4 mb-4 border-top border-warning border-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-alert-circle text-warning fs-4 me-2"></i>
                                        <h6 class="fw-bold mb-0 text-dark">Catatan Revisi dari Admin</h6>
                                    </div>
                                    <div class="p-3 bg-warning bg-opacity-10 rounded-3 mt-3">
                                        <p class="small text-dark mb-0 fw-medium">"{{ $rencana->feedback_internal }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bold text-dark">Perbarui Rencana</h5>
                                <p class="text-muted small px-2">
                                    Simpan perubahan Anda atau ajukan kembali untuk di-review.
                                </p>

                                <div class="d-grid gap-3 mt-4">
                                    <button type="submit" name="status" value="proses_review"
                                        class="btn btn-primary py-3 fw-bold shadow rounded-pill d-flex align-items-center justify-content-center">
                                        <i class="ti ti-send me-2 fs-4"></i> Ajukan Kembali (Review)
                                    </button>
                                    <button type="submit" name="status" value="draft"
                                        class="btn btn-outline-secondary py-2 fw-semibold rounded-pill border-2">
                                        <i class="ti ti-device-floppy me-2"></i> Simpan Saja (Draft)
                                    </button>
                                </div>
                                <hr class="my-4 opacity-25">
                                <a href="{{ route('rencana-kerjasama.index') }}"
                                    class="btn btn-link btn-sm text-muted text-decoration-none hover-danger">
                                    <i class="ti ti-arrow-left me-1"></i> Batal & Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div
                                class="card-header bg-dark border-0 p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran
                                    Dokumen</h6>
                                <span class="badge bg-secondary" id="total-file-badge">{{ $rencana->files->count() }}
                                    File Tersimpan</span>
                            </div>
                            <div class="card-body p-4">

                                <div
                                    class="alert bg-light border border-info border-opacity-25 small text-muted rounded-3 p-3 mb-3">
                                    <i class="ti ti-info-circle me-1 text-info fs-5 align-middle"></i>
                                    Anda dapat melihat, menghapus file lama, atau menambahkan file baru. File baru akan
                                    <strong>ditambahkan</strong> tanpa menimpa file yang sudah ada.
                                </div>

                                <div id="upload-area"
                                    class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-4 position-relative">
                                    <input type="file" name="file_dokumen[]" id="fileInput" class="d-none" multiple
                                        accept="application/pdf">
                                    <div id="upload-placeholder">
                                        <i class="ti ti-cloud-upload fs-1 text-primary mb-2"></i>
                                        <p class="small fw-bold text-dark mb-0 mt-1">Klik atau Seret Berkas Baru ke Sini
                                        </p>
                                        <p class="text-muted mb-0" style="font-size: 11px;">Maksimal total 5 File PDF
                                            (Max 5MB/file)</p>
                                    </div>
                                </div>

                                {{-- Container untuk input hidden file yang akan dihapus --}}
                                <div id="deleted-files-container"></div>

                                <h6 class="small fw-bold text-muted mb-3 text-uppercase" style="letter-spacing: 0.5px;">
                                    Daftar File</h6>
                                <div id="file-list-container" class="d-grid gap-2">

                                    {{-- RENDER FILE LAMA DARI DATABASE --}}
                                    @forelse($rencana->files as $file)
                                        <div class="d-flex align-items-center p-2 bg-light rounded-3 border old-file-item"
                                            id="old-file-{{ $file->id }}">
                                            <div
                                                class="bg-white p-2 rounded-2 me-3 text-danger shadow-sm border border-danger border-opacity-10">
                                                <i class="ti ti-file-type-pdf fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-0 text-truncate small fw-bold text-dark"
                                                    title="{{ $file->nama_file }}">{{ $file->nama_file }}</p>
                                                <span class="badge bg-secondary" style="font-size: 9px;">File
                                                    Tersimpan</span>
                                            </div>
                                            <div class="ms-2 d-flex gap-1">
                                                {{-- Tombol Lihat (Sesuaikan route/path dengan struktur folder storage-mu) --}}
                                                <a href="{{ route('rencana-kerjasama.view-file', $file->id) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-primary rounded-circle shadow-sm"
                                                    title="Lihat Dokumen">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                {{-- Tombol Hapus --}}
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-circle shadow-sm btn-delete-old"
                                                    data-id="{{ $file->id }}" data-nama="{{ $file->nama_file }}"
                                                    title="Hapus Dokumen">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div id="no-file-state" class="text-center py-3 text-muted small">
                                            Belum ada file yang dilampirkan.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-modal.hapus id="modalHapusFile" title="Hapus Lampiran Dokumen" :isDynamic="true" />
    {{-- CSS & JS SAMA DENGAN CREATE --}}
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
    </style>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select-mitra, .select-scope').select2({
                    theme: 'bootstrap-5',
                    width: '100%'
                });

                const $uploadArea = $('#upload-area');
                const $fileInput = $('#fileInput');
                const $fileListContainer = $('#file-list-container');
                const $badgeTotal = $('#total-file-badge');

                const dataTransfer = new DataTransfer();

                function updateTotalBadge() {
                    const totalOld = $('.old-file-item').length;
                    const totalNew = $('.new-file-item').length;
                    const total = totalOld + totalNew;
                    $badgeTotal.text(`${total} File Dilampirkan`);

                    if (total > 0) $('#no-file-state').hide();
                    else $('#no-file-state').show();
                }

                let fileToDeleteId = null;
                let $rowToDelete = null;

                $(document).on('click', '.btn-delete-old', function() {
                    fileToDeleteId = $(this).data('id');
                    let fileName = $(this).data('nama');
                    $rowToDelete = $(`#old-file-${fileToDeleteId}`);

                    $('#modalHapusFileItemName').html(
                        `File: <strong>${fileName}</strong><br><small class="text-danger mt-1 d-block">File akan dihapus permanen saat Anda menyimpan perubahan form ini.</small>`
                        );
                    $('#modalHapusFileForm').removeAttr('action');

                    new bootstrap.Modal(document.getElementById('modalHapusFile')).show();
                });

                $(document).on('submit', '#modalHapusFileForm', function(e) {
                    e.preventDefault();

                    if (fileToDeleteId && $rowToDelete) {
                        $('#deleted-files-container').append(
                            `<input type="hidden" name="hapus_file_lama[]" value="${fileToDeleteId}">`);

                        $rowToDelete.fadeOut(300, function() {
                            $(this).remove();
                            updateTotalBadge();
                        });

                        let modalInstance = bootstrap.Modal.getInstance(document.getElementById(
                            'modalHapusFile'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        fileToDeleteId = null;
                        $rowToDelete = null;
                    }
                });

                $uploadArea.on('click', function(e) {
                    if (e.target !== $fileInput[0]) $fileInput.click();
                });

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    $uploadArea.on(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    $uploadArea.on(eventName, function() {
                        $uploadArea.addClass('dragover');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    $uploadArea.on(eventName, function() {
                        $uploadArea.removeClass('dragover');
                    });
                });

                $uploadArea.on('drop', function(e) {
                    handleFiles(e.originalEvent.dataTransfer.files);
                });

                $fileInput.on('change', function() {
                    handleFiles(this.files);
                });

                function handleFiles(files) {
                    const fileArray = Array.from(files);
                    const currentTotal = $('.old-file-item').length + dataTransfer.items.length;

                    if (currentTotal + fileArray.length > 5) {
                        alert('Maksimal total 5 file PDF yang diperbolehkan.');
                        return;
                    }

                    fileArray.forEach((file) => {
                        if (file.type !== 'application/pdf') {
                            alert(`File "${file.name}" bukan PDF!`);
                            return;
                        }
                        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
                        if (fileSizeMB > 5) {
                            alert(`File "${file.name}" terlalu besar (${fileSizeMB} MB).`);
                            return;
                        }
                        dataTransfer.items.add(file);
                        const fileId = Math.random().toString(36).substr(2, 9);

                        const fileItem = `
                <div class="d-flex align-items-center p-2 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25 new-file-item animate__animated animate__fadeIn" id="new-file-${fileId}">
                    <div class="bg-white p-2 rounded-2 me-3 text-primary shadow-sm">
                        <i class="ti ti-file-upload fs-4"></i>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="mb-0 text-truncate small fw-bold text-dark" title="${file.name}">${file.name}</p>
                        <span class="badge bg-primary" style="font-size: 9px;">File Baru Menunggu Disimpan (${fileSizeMB} MB)</span>
                    </div>
                    <div class="ms-2">
                        <button type="button" class="btn btn-sm btn-light text-danger rounded-circle border shadow-sm btn-remove-new" data-id="${fileId}" data-name="${file.name}" style="width: 32px; height: 32px; padding: 0; line-height: 30px;" title="Batal Unggah">
                            <i class="ti ti-x"></i>
                        </button>
                    </div>
                </div>
            `;
                        $('#no-file-state').hide();
                        $fileListContainer.append(fileItem);
                    });
                    $fileInput[0].files = dataTransfer.files;
                    updateTotalBadge();
                }

                $(document).on('click', '.btn-remove-new', function() {
                    let fileName = $(this).data('name');
                    let fileId = $(this).data('id');
                    for (let i = 0; i < dataTransfer.items.length; i++) {
                        if (dataTransfer.items[i].getAsFile().name === fileName) {
                            dataTransfer.items.remove(i);
                            break;
                        }
                    }

                    $fileInput[0].files = dataTransfer.files;
                    $(`#new-file-${fileId}`).fadeOut(200, function() {
                        $(this).remove();
                        updateTotalBadge();
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
