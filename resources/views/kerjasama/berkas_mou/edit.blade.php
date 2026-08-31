<x-app-layout>
    <x-slot:title>Edit Registrasi MoU</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoU / Edit / {{ $mou->nomor_mou }}</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <form action="{{ route('berkas-MoU.update', $mou->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                {{-- KOLOM KIRI: FORM UTAMA --}}
                <div class="col-lg-8">
                    {{-- SMART BANNER (Jika terhubung dengan Rencana Kerjasama) --}}
                    @if ($mou->rencana_id)
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-top border-success border-4">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10 text-white"
                                        style="width: 50px; height: 50px;">
                                        <i class="ti ti-link fs-3"></i>
                                    </div>
                                    <div class="ms-3 flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <h6 class="fw-bold text-dark mb-0 me-2">Data Terkoneksi Sistem</h6>
                                            <span class="badge bg-success rounded-pill"
                                                style="font-size: 10px;">TERKUNCI</span>
                                        </div>
                                        <p class="text-muted small mb-0" style="line-height: 1.5;">
                                            MoU ini berasal dari pengajuan <strong>Prodi
                                                {{ $mou->rencana->user->prodi->nama_prodi ?? '-' }}</strong>. Kolom
                                            Instansi Mitra tidak dapat diubah.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- CARD FORM INPUT --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div
                            class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold text-dark"><i class="ti ti-edit me-2 text-warning"></i>Perbarui
                                Detail Pengajuan MoU</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">

                                {{-- Instansi Mitra --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Instansi Mitra <span
                                            class="text-danger">*</span></label>
                                    @if ($mou->rencana_id)
                                        <input type="hidden" name="mitra_id" value="{{ $mou->mitra_id }}">
                                        <div
                                            class="form-control bg-light border-0 py-2 px-3 d-flex align-items-center text-muted">
                                            <i class="ti ti-lock me-2 text-secondary"></i>
                                            <span class="fw-medium text-dark">{{ $mou->mitra->nama_mitra }}</span>
                                        </div>
                                    @else
                                        <select name="mitra_id"
                                            class="form-select select-mitra border-0 bg-light py-2 px-3" required>
                                            <option value="">-- Pilih Instansi Mitra --</option>
                                            @foreach ($mitras as $mitra)
                                                <option value="{{ $mitra->id }}"
                                                    {{ old('mitra_id', $mou->mitra_id) == $mitra->id ? 'selected' : '' }}>
                                                    {{ $mitra->nama_mitra }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                {{-- Judul --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Judul / Kesepakatan Tentang
                                        <span class="text-danger">*</span></label>
                                    <textarea name="judul_mou" class="form-control bg-light border-0 py-2 px-3" rows="2" required>{{ old('judul_mou', $mou->judul_mou) }}</textarea>
                                </div>

                                {{-- Usulan Durasi & Kode Berkas --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-dark">Usulan Durasi Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <select name="usulan_durasi_tahun" class="form-select border-0 bg-light py-2 px-3"
                                        required>
                                        <option value="" disabled>-- Pilih Durasi --</option>
                                        <option value="1"
                                            {{ old('usulan_durasi_tahun', $mou->usulan_durasi_tahun) == '1' ? 'selected' : '' }}>
                                            1 Tahun</option>
                                        <option value="3"
                                            {{ old('usulan_durasi_tahun', $mou->usulan_durasi_tahun) == '3' ? 'selected' : '' }}>
                                            3 Tahun</option>
                                        <option value="5"
                                            {{ old('usulan_durasi_tahun', $mou->usulan_durasi_tahun) == '5' ? 'selected' : '' }}>
                                            5 Tahun (Standar MoU)</option>
                                    </select>
                                </div>


                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-dark">Ringkasan Poin
                                        Kerjasama</label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="4">{{ old('deskripsi', $mou->deskripsi_singkat) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: UPLOAD & SUBMIT --}}
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 20px;">

                        {{-- CARD UPLOAD --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                            <div
                                class="card-header bg-dark border-0 p-3 d-flex justify-content-between align-items-center">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Kelola
                                    Lampiran (PDF)</h6>
                                <span
                                    class="badge bg-secondary bg-opacity-25 border border-secondary text-light rounded-pill px-2">
                                    {{ $mou->files ? $mou->files->count() : 0 }} File Tersimpan
                                </span>
                            </div>
                            <div class="card-body p-4">

                                {{-- INFO SISTEM BARU --}}
                                <div
                                    class="alert bg-warning bg-opacity-10 border border-warning border-opacity-25 small text-dark rounded-4 p-3 mb-4 shadow-sm">
                                    <div class="d-flex">
                                        <i class="ti ti-info-circle text-primary fs-4 me-3 mt-1"></i>
                                        <div>
                                            <strong class="text-dark d-block mb-1">Pembaruan Sistem Lampiran!</strong>
                                            Anda dapat menghapus lampiran lama satu per satu menggunakan ikon tempat
                                            sampah.
                                            <br>Menambah file baru di kotak bawah <strong>tidak akan menghapus</strong>
                                            file lama yang sudah ada.
                                        </div>
                                    </div>
                                </div>

                                {{-- BAGIAN 1: LIST FILE LAMA (Bisa Dilihat & Dihapus) --}}
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;">File Tersimpan Saat Ini:
                                </h6>
                                <div id="existing-files-container" class="d-grid gap-2 mb-4">
                                    @if ($mou->files)
                                        @forelse($mou->files as $file)
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
                                                    {{-- Tombol Lihat Dokumen --}}
                                                    <a href="{{ route('berkas-MoU.view-file', $file->id) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary rounded-circle shadow-sm"
                                                        title="Lihat Dokumen">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    {{-- Tombol Hapus (Pemicu Modal) --}}
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger rounded-circle shadow-sm btn-delete-old"
                                                        data-id="{{ $file->id }}"
                                                        data-nama="{{ $file->nama_file }}" title="Hapus Dokumen">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div id="no-file-state" class="text-center py-3 text-muted small">
                                                Belum ada file yang dilampirkan.
                                            </div>
                                        @endforelse
                                    @endif
                                </div>

                                <hr class="border-secondary-subtle mb-4">
                                <div id="deleted-files-container"></div>
                                {{-- BAGIAN 2: AREA TAMBAH FILE BARU --}}
                                <h6 class="fw-bold text-dark mb-3" style="font-size: 13px;">Tambah Lampiran Baru
                                    (Opsional):</h6>
                                <div id="upload-area"
                                    class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-3 position-relative bg-light transition-all">
                                    <input type="file" name="file_mou[]" id="fileInput" class="d-none" multiple
                                        accept="application/pdf">
                                    <div id="upload-placeholder">
                                        <div class="d-flex justify-content-center mb-2">
                                            <div class="bg-white text-primary rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="ti ti-cloud-plus fs-3"></i>
                                            </div>
                                        </div>
                                        <p class="small fw-bold text-dark mb-0 mt-2">Klik atau Seret Berkas Baru ke
                                            Sini</p>
                                        <p class="text-muted mb-0" style="font-size: 11px;">Max 5 File PDF (10MB/file)
                                        </p>
                                    </div>
                                </div>

                                {{-- Wadah Preview Khusus File BARU --}}
                                <div id="new-file-list-container" class="d-grid gap-2"></div>

                                {{-- Tempat input hidden untuk ID file lama yang mau dihapus --}}
                                <div id="deleted-files-inputs"></div>

                            </div>
                        </div>

                        {{-- CARD SUBMIT --}}
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <i class="ti ti-device-floppy text-muted fs-1 mb-2"></i>
                                <h6 class="fw-bold text-dark mb-3">Simpan Perubahan</h6>
                                <p class="small text-muted mb-4">Data yang diubah akan langsung diterapkan ke sistem.
                                </p>

                                <button type="submit"
                                    class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-pill mb-2 transition-all hover-lift">
                                    Simpan Pembaruan
                                </button>
                                <a href="{{ route('berkas-MoU.show', $mou->id) }}"
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

    <x-modal.hapus id="modalHapusFile" title="Hapus Lampiran Dokumen" :isDynamic="true" />

    {{-- STYLES & SCRIPTS --}}
    @if (!$mou->rencana_id)
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
        @if (!$mou->rencana_id)
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select-mitra').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                });
            </script>
        @endif

        <script>
            $(document).ready(function() {
                let fileToDeleteId = null;
                let rowToDelete = null;

                // Membuka modal saat ikon tempat sampah diklik
                $(document).on('click', '.btn-delete-old', function() {
                    fileToDeleteId = $(this).data('id');
                    let fileName = $(this).data('nama');
                    rowToDelete = $(`#old-file-${fileToDeleteId}`);

                    $('#modalHapusFileItemName').html(
                        `File: <strong>${fileName}</strong><br><small class="text-danger mt-1 d-block">File akan dihapus permanen saat Anda menyimpan perubahan form ini.</small>`
                    );
                    $('#modalHapusFileForm').removeAttr('action');

                    new bootstrap.Modal(document.getElementById('modalHapusFile')).show();
                    console.log("ID file yang akan dihapus:", fileToDeleteId + rowToDelete);
                });

                // Mencegah modal melakukan submit HTTP, menggantinya dengan Deferred Deletion
                $(document).on('submit', '#modalHapusFileForm', function(e) {
                    e.preventDefault();

                    if (fileToDeleteId && rowToDelete) {
                        // Tambahkan input hidden untuk di-proses oleh Controller nanti
                        $('#deleted-files-container').append(
                            `<input type="hidden" name="hapus_file_lama[]" value="${fileToDeleteId}">`
                        );


                        // Hilangkan file dari tampilan UI
                        rowToDelete.fadeOut(300, function() {
                            $(this).remove();
                            updateTotalBadge();
                        });

                        // Tutup modal
                        let modalInstance = bootstrap.Modal.getInstance(document.getElementById(
                            'modalHapusFile'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }

                        fileToDeleteId = null;
                        rowToDelete = null;
                    }
                });

                // ==========================================
                // 2. LOGIKA DRAG & DROP FILE BARU (Tetap sama)
                // ==========================================
                const $uploadArea = $('#upload-area');
                const $fileInput = $('#fileInput');
                const $newFileListContainer = $('#new-file-list-container');

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
                    $newFileListContainer.empty();
                    const fileArray = Array.from(files);

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
                        if (fileSizeMB > 10) {
                            alert(`File "${file.name}" terlalu besar (${fileSizeMB} MB). Maksimal 10MB.`);
                            return;
                        }

                        const fileItem = `
                    <div class="d-flex align-items-center p-2 bg-primary bg-opacity-10 rounded-3 border border-primary border-opacity-25 animate__animated animate__fadeIn shadow-sm">
                        <div class="bg-white p-2 rounded-2 me-3 text-primary shadow-sm flex-shrink-0">
                            <i class="ti ti-file-type-pdf fs-4"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-0 text-truncate small fw-bold text-dark">${file.name}</p>
                            <span class="badge bg-primary text-white mt-1" style="font-size: 10px;">Berkas Baru (${fileSizeMB} MB)</span>
                        </div>
                        <div class="text-success ms-2 flex-shrink-0">
                            <i class="ti ti-circle-check fs-5"></i>
                        </div>
                    </div>
                `;
                        $newFileListContainer.append(fileItem);
                    });
                }
            });
        </script>
    @endpush
</x-app-layout>
