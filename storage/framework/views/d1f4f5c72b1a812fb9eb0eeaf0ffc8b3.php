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
     <?php $__env->slot('title', null, []); ?> Ajukan Rencana Kerjasama <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Kerjasama / Rencana / Baru <?php $__env->endSlot(); ?>

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

        <form action="<?php echo e(route('rencana-kerjasama.store')); ?>" method="POST" enctype="multipart/form-data" id="mainForm">
            <?php echo csrf_field(); ?>

            <div class="row g-4">
                
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                                    <i class="ti ti-bulb fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Informasi Rencana</h5>
                                    <p class="text-muted small mb-0">Deskripsikan ide kerjasama yang ingin Anda ajukan.</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Judul Rencana Kerjasama <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_rencana" class="form-control bg-light border-0 py-2 px-3" placeholder="Contoh: Rencana Kerjasama Pelatihan Sertifikasi Cloud Computing" required value="<?php echo e(old('judul_rencana')); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pilih Mitra Strategis <span class="text-danger">*</span></label>
                                    <select name="mitra_id" class="form-select select-mitra border-0 bg-light py-2" required>
                                        <option value="">-- Pilih Mitra --</option>
                                        
                                        <?php $__empty_1 = true; $__currentLoopData = $mitras ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mitra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($mitra->id); ?>" <?php echo e(old('mitra_id') == $mitra->id ? 'selected' : ''); ?>>
                                                <?php echo e($mitra->nama_mitra); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="" disabled>Data Mitra Belum Tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                    <small class="text-muted" style="font-size: 11px;">
                                        Mitra tidak ada? <a href="<?php echo e(route('Manajemen-Mitra.create')); ?>" class="text-primary fw-bold">Tambah Mitra Baru</a>
                                    </small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ruang Lingkup <span class="text-danger">*</span></label>
                                    <select name="ruanglingkup_id" class="form-select select-scope border-0 bg-light py-2" required>
                                        <option value="">-- Pilih Ruang Lingkup --</option>
                                        <?php $__empty_1 = true; $__currentLoopData = $ruangLingkups ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scope): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($scope->id); ?>" <?php echo e(old('ruanglingkup_id') == $scope->id ? 'selected' : ''); ?>>
                                                <?php echo e($scope->nama_ruanglingkup); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <option value="" disabled>Data Ruang Lingkup Kosong</option>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Deskripsi & Tujuan Rencana Kerjasama <span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" class="form-control bg-light border-0 py-2 px-3" rows="8" placeholder="Jelaskan secara detail mengenai latar belakang, potensi manfaat bagi unit, dan target yang ingin dicapai..." required><?php echo e(old('deskripsi')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-5">
                    <div class="sticky-top" style="top: 20px; z-index: 10;">
                        
                        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                            <div class="card-body p-4 text-center">
                                
                                <div class="avatar avatar-xl bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 shadow-sm d-flex align-items-center justify-content-center animate__animated animate__pulse animate__infinite">
                                    <i class="ti ti-rocket fs-1"></i>
                                </div>

                                <h5 class="fw-bold text-dark">Finalisasi Rencana</h5>
                                <p class="text-muted small px-2">
                                    Pilih tindakan untuk melanjutkan pengajuan kerjasama Anda ke tahap berikutnya.
                                </p>

                                
                                <div class="bg-light p-3 rounded-4 mb-4 text-start border">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ti ti-circle-check text-success me-2"></i>
                                        <span class="small fw-bold">Data Terisi Otomatis</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ti ti-info-circle text-info me-2"></i>
                                        <span class="small text-muted">Draft dapat diedit kembali kapan saja.</span>
                                    </div>
                                </div>

                                <div class="d-grid gap-3">
                                    
                                    <button type="submit" name="status" value="proses_review" class="btn btn-primary py-3 fw-bold shadow rounded-pill d-flex align-items-center justify-content-center">
                                        <i class="ti ti-send me-2 fs-4"></i> Ajukan Review Sekarang
                                    </button>

                                    
                                    <button type="submit" name="status" value="draft" class="btn btn-outline-secondary py-2 fw-semibold rounded-pill border-2">
                                        <i class="ti ti-archive me-2"></i> Simpan sebagai Draft
                                    </button>
                                </div>

                                <hr class="my-4 opacity-25">

                                <a href="<?php echo e(route('rencana-kerjasama.index')); ?>" class="btn btn-link btn-sm text-muted text-decoration-none hover-danger">
                                    <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar
                                </a>
                            </div>
                        </div>

                        <style>
                            /* Tambahkan sedikit hover effect untuk tombol draft */
                            .btn-outline-secondary:hover {
                                background-color: #f8f9fa;
                                color: #6c757d;
                                border-color: #6c757d;
                                transform: translateY(-1px);
                            }
                            .hover-danger:hover {
                                color: #dc3545 !important;
                            }
                            .animate__pulse {
                                animation-duration: 2s;
                            }
                        </style>

                        
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark border-0 p-3">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran Dokumen (PDF)</h6>
                            </div>
                            <div class="card-body p-4">
                                <div id="upload-area" class="upload-drop-area p-4 border-2 border-dashed rounded-4 text-center cursor-pointer mb-3 position-relative">
                                    <input type="file" name="file_dokumen[]" id="fileInput" class="d-none" multiple accept="application/pdf">
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
                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; }
        .upload-drop-area { transition: all 0.3s ease; border-color: #dee2e6; background-color: #fbfbfb; }
        .upload-drop-area:hover { border-color: #3b82f6; background-color: #f8faff; }
        .cursor-pointer { cursor: pointer; }
        .avatar-xl { width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; }
        .file-item { animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }


    </style>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select-mitra, .select-scope').select2({
                theme: 'bootstrap-5',
                placeholder: 'Silakan pilih...',
                allowClear: true,
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/rencana_kerjasama/create.blade.php ENDPATH**/ ?>