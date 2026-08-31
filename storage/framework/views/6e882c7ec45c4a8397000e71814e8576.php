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
     <?php $__env->slot('title', null, []); ?> Registrasi Dokumen MoA Baru <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Kerjasama / MoA / Registrasi Baru <?php $__env->endSlot(); ?>

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

        <form action="<?php echo e(route('berkas-MoA.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="row g-4">
                
                <div class="col-lg-8">

                    
                    <?php if(isset($mouSource)): ?>
                        <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-success border-4 bg-success bg-opacity-10">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm flex-shrink-0" style="width: 48px; height: 48px;">
                                    <i class="ti ti-link fs-4"></i>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <h6 class="fw-bold text-dark mb-0 fs-6">Turunan MoU Terkoneksi</h6>
                                        <span class="badge bg-success" style="font-size: 9px;">AUTO-FILL</span>
                                    </div>
                                    <p class="text-muted small mb-0">MoA ini secara otomatis terikat dengan MoU <strong class="text-dark"><?php echo e($mouSource->nomor_mou); ?></strong>.</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <div class="card border border-secondary-subtle shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="ti ti-gavel fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Identitas Legal & Payung Hukum</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Pilih Payung Hukum (MoU) <span class="text-danger">*</span></label>
                                    <?php if(isset($mouSource)): ?>
                                        <input type="hidden" name="mou_id" value="<?php echo e($mouSource->id); ?>">
                                        <div class="form-control bg-light border-0 py-2 px-3 d-flex align-items-center text-muted">
                                            <i class="ti ti-lock me-2 text-secondary"></i>
                                            <span class="fw-medium text-dark"><?php echo e($mouSource->nomor_berkas_mou); ?> - <?php echo e($mouSource->mitra->nama_mitra); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <select name="mou_id" class="form-select select2 border-0 bg-light py-2 px-3" required>
                                            <option value="">-- Cari Nomor MoU atau Nama Mitra --</option>
                                            <?php $__currentLoopData = $mous; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mouData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($mouData->id); ?>" <?php echo e(old('mou_id') == $mouData->id ? 'selected' : ''); ?>>
                                                    <?php echo e($mouData->nomor_berkas_mou); ?> - JUDUL MOU: <?php echo e($mouData->judul_mou); ?> - <?php echo e($mouData->mitra->nama_mitra ?? 'Mitra Tidak Diketahui'); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="col-md-5">
                                    <label class="form-label fw-bold small text-dark">Nomor Dokumen MoA <span class="text-danger">*</span></label>
                                    <input type="text" name="nomor_moa" class="form-control bg-light border-0 py-2 px-3" placeholder="Contoh: 01/MoA/2026" value="<?php echo e(old('nomor_moa')); ?>" required>
                                </div>
                                <div class="col-md-7">
                                    <label class="form-label fw-bold small text-dark">Judul / Perihal Kerja Sama <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_moa" class="form-control bg-light border-0 py-2 px-3" placeholder="Perjanjian tentang..." value="<?php echo e(old('judul_moa')); ?>" required>
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Ruang Lingkup <span class="text-danger">*</span></label>
                                    <select name="ruanglingkup_id" class="form-select select2 border-0 bg-light py-2 px-3" required>
                                        <option value="">-- Pilih --</option>
                                        <?php $__currentLoopData = $ruangLingkups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($rl->id); ?>" <?php echo e(old('ruanglingkup_id') == $rl->id ? 'selected' : ''); ?>><?php echo e($rl->nama_ruanglingkup); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Kode Lemari/Arsip (Opsional)</label>
                                    <input type="text" name="kode_berkas" class="form-control bg-light border-0 py-2 px-3" placeholder="Lokasi Hardcopy" value="<?php echo e(old('kode_berkas')); ?>">
                                </div>

                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Tanggal Mulai Berlaku <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="form-control bg-light border-0 py-2 px-3" value="<?php echo e(old('tanggal_mulai')); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Tanggal Berakhir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berakhir" class="form-control bg-light border-0 py-2 px-3" value="<?php echo e(old('tanggal_berakhir')); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card border border-secondary-subtle shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 me-2 d-flex align-items-center justify-content-center">
                                <i class="ti ti-target fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Detail Pelaksanaan & Finansial</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Nilai Finansial (Opsional)</label>
                                    <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-white border-end-0 border-secondary-subtle fw-bold text-success">Rp</span>
                                        <input type="number" name="nominal_finansial" class="form-control border-start-0 border-secondary-subtle py-2" placeholder="0" value="<?php echo e(old('nominal_finansial')); ?>" min="0">
                                    </div>
                                    <small class="text-muted" style="font-size: 10px;">Kosongkan jika non-finansial.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-dark">Sumber Dana (Opsional)</label>
                                    <input type="text" name="sumber_dana" class="form-control bg-light border-0 py-2 px-3" placeholder="Contoh: DIPA / CSR Mitra" value="<?php echo e(old('sumber_dana')); ?>">
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Tujuan & Output Kerjasama</label>
                                    <textarea name="tujuan_moa" class="form-control bg-light border-0 py-2 px-3" rows="3" placeholder="Target konkrit yang ingin dicapai..."><?php echo e(old('tujuan_moa')); ?></textarea>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold small text-dark">Hak & Kewajiban (Peran Pihak)</label>
                                    <textarea name="peran_tanggung_jawab" class="form-control bg-light border-0 py-2 px-3" rows="3" placeholder="Tugas masing-masing pihak..."><?php echo e(old('peran_tanggung_jawab')); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 20px;">

                        
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-dark border-0 p-3">
                                <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Lampiran Dokumen MoA (PDF)</h6>
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

                        
                        <div class="card border border-secondary-subtle shadow-sm rounded-4">
                            <div class="card-body p-4 text-center">
                                <i class="ti ti-device-floppy text-muted opacity-50 mb-3" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-dark mb-2">Simpan Registrasi MoA</h6>
                                <p class="small text-muted mb-4">Pastikan nominal finansial dan payung MoU sudah sesuai.</p>

                                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow-sm rounded-pill mb-2 hover-lift transition-all">
                                    Simpan Dokumen MoA
                                </button>
                                <a href="<?php echo e(route('berkas-MoA.index')); ?>" class="btn btn-light w-100 py-2 fw-bold text-muted rounded-pill hover-dark transition-all">
                                    Batal & Kembali
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <?php if(!isset($mouSource)): ?>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <?php endif; ?>

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
    <?php if(!isset($mouSource)): ?>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });
            });
        </script>
    <?php endif; ?>

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
                const fileArray = Array.from(files);e
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/kerjasama/berkas_moa/create.blade.php ENDPATH**/ ?>