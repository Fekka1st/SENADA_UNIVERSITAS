<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Edit Rencana Kerjasama <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Kerjasama / Rencana / Edit <?php $__env->endSlot(); ?>

    <div class="container-fluid">
        <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>

        <form action="<?php echo e(route('rencana-kerjasama.update', $rencana->id)); ?>" method="POST" enctype="multipart/form-data"
            id="mainForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row g-4">
                
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
                                        value="<?php echo e(old('judul_rencana', $rencana->judul_rencana)); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pilih Mitra Strategis <span
                                            class="text-danger">*</span></label>
                                    <select name="mitra_id" class="form-select select-mitra border-0 bg-light py-2"
                                        required>
                                        <option value="">-- Pilih Mitra --</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $mitras ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mitra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($mitra->id); ?>"
                                                <?php echo e(old('mitra_id', $rencana->mitra_id) == $mitra->id ? 'selected' : ''); ?>>
                                                <?php echo e($mitra->nama_mitra); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="" disabled>Data Mitra Belum Tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ruang Lingkup <span
                                            class="text-danger">*</span></label>
                                    <select name="ruanglingkup_id"
                                        class="form-select select-scope border-0 bg-light py-2" required>
                                        <option value="">-- Pilih Ruang Lingkup --</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $ruangLingkups ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($scope->id); ?>"
                                                <?php echo e(old('ruanglingkup_id', $rencana->ruanglingkup_id) == $scope->id ? 'selected' : ''); ?>>
                                                <?php echo e($scope->nama_ruanglingkup); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="" disabled>Data Ruang Lingkup Kosong</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi & Tujuan Rencana Kerjasama <span
                                            class="text-danger">*</span></label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="8" required><?php echo e(old('deskripsi', $rencana->deskripsi)); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-5">
                    <div class="sticky-top" style="top: 20px; z-index: 10;">
                        <?php if($rencana->status == 4 || $rencana->feedback_internal != null): ?>
                            <div class="card border-0 shadow-sm rounded-4 mb-4 border-top border-warning border-4">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-alert-circle text-warning fs-4 me-2"></i>
                                        <h6 class="fw-bold mb-0 text-dark">Catatan Revisi dari Admin</h6>
                                    </div>
                                    <div class="p-3 bg-warning bg-opacity-10 rounded-3 mt-3">
                                        <p class="small text-dark mb-0 fw-medium">"<?php echo e($rencana->feedback_internal); ?>"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

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
                                <a href="<?php echo e(route('rencana-kerjasama.index')); ?>"
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
                                <span class="badge bg-secondary" id="total-file-badge"><?php echo e($rencana->files->count()); ?>

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

                                
                                <div id="deleted-files-container"></div>

                                <h6 class="small fw-bold text-muted mb-3 text-uppercase" style="letter-spacing: 0.5px;">
                                    Daftar File</h6>
                                <div id="file-list-container" class="d-grid gap-2">

                                    
                                    <?php $__empty_1 = true; $__currentLoopData = $rencana->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="d-flex align-items-center p-2 bg-light rounded-3 border old-file-item"
                                            id="old-file-<?php echo e($file->id); ?>">
                                            <div
                                                class="bg-white p-2 rounded-2 me-3 text-danger shadow-sm border border-danger border-opacity-10">
                                                <i class="ti ti-file-type-pdf fs-4"></i>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-0 text-truncate small fw-bold text-dark"
                                                    title="<?php echo e($file->nama_file); ?>"><?php echo e($file->nama_file); ?></p>
                                                <span class="badge bg-secondary" style="font-size: 9px;">File
                                                    Tersimpan</span>
                                            </div>
                                            <div class="ms-2 d-flex gap-1">
                                                
                                                <a href="<?php echo e(route('rencana-kerjasama.view-file', $file->id)); ?>"
                                                    target="_blank"
                                                    class="btn btn-sm btn-outline-primary rounded-circle shadow-sm"
                                                    title="Lihat Dokumen">
                                                    <i class="ti ti-eye"></i>
                                                </a>
                                                
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger rounded-circle shadow-sm btn-delete-old"
                                                    data-id="<?php echo e($file->id); ?>" data-nama="<?php echo e($file->nama_file); ?>"
                                                    title="Hapus Dokumen">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <div id="no-file-state" class="text-center py-3 text-muted small">
                                            Belum ada file yang dilampirkan.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if (isset($component)) { $__componentOriginal9bb3a892d945664f458b28dbbf2a402e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.hapus','data' => ['id' => 'modalHapusFile','title' => 'Hapus Lampiran Dokumen','isDynamic' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.hapus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modalHapusFile','title' => 'Hapus Lampiran Dokumen','isDynamic' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $attributes = $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $component = $__componentOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>
    
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

    <?php $__env->startPush('scripts'); ?>
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
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/rencana_kerjasama/edit.blade.php ENDPATH**/ ?>