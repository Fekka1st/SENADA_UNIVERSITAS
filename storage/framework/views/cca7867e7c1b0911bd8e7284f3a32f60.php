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
     <?php $__env->slot('title', null, []); ?> Tambah Kerja Sama <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Kerja Sama / Tambah <?php $__env->endSlot(); ?>

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

        <form action="<?php echo e(route('Manajemen-Kerjasama.store')); ?>" method="POST" enctype="multipart/form-data" id="mainForm">
            <?php echo csrf_field(); ?>

            <div class="row g-4 align-items-stretch">
                
                <div class="col-md-8 d-flex">
                    <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                    <i class="ti ti-file-certificate fs-4 text-primary"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">Informasi Dokumen</h5>
                                    <small class="text-muted">Lengkapi detail dokumen untuk digenerate nomor otomatis.</small>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Instansi Mitra <span class="text-danger">*</span></label>
                                    <select name="mitra_id" id="selectMitra" class="form-select" required>
                                        <option></option>
                                        <?php $__currentLoopData = $mitras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mitra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($mitra->id); ?>"><?php echo e($mitra->nama_mitra); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Dokumen <span class="text-danger">*</span></label>
                                    <select name="jenis_dokumen_id" id="jenis_dokumen_id" class="form-select" required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <?php $__currentLoopData = $jenisDokumens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($jenis->id); ?>" data-kode="<?php echo e($jenis->kode_jenis); ?>">
                                                <?php echo e($jenis->nama_jenis); ?> - (<?php echo e($jenis->kode_inisial); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Preview Nomor Dokumen</label>
                                    <input type="text" id="preview_kode" class="form-control bg-light fw-bold text-primary" placeholder="Pilih jenis dokumen..." readonly>
                                    <small class="text-muted" style="font-size: 11px;">*Nomor urut final ditentukan saat simpan.</small>
                                </div>

                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted small">Fakultas Pengusul</label>
                                    <div class="p-2 border rounded-3 bg-light d-flex align-items-center">
                                        <i class="ti ti-school fs-4 text-primary me-2"></i>
                                        <span class="fw-bold text-dark"><?php echo e($namaFakultas); ?></span>
                                    </div>

                                </div>


                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Pilih Program Studi <span class="text-danger">*</span></label>
                                    <select name="prodi_id" class="form-select" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($prodi->id); ?>"><?php echo e($prodi->nama_prodi); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <small class="text-muted" style="font-size: 11px;">*Daftar prodi muncul sesuai fakultas Anda.</small>
                                </div>

                                
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Judul Kerjasama <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_kerjasama" class="form-control" placeholder="Tulis judul lengkap..." required>
                                </div>

                                
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Deskripsi / Ringkasan</label>
                                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                                </div>

                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_selesai" class="form-control" required>
                                </div>

                                
                                <div class="col-12">
                                    <label class="form-label fw-bold text-dark">Berkas Dokumen (PDF) <span class="text-danger">*</span></label>
                                    <div class="p-4 rounded-4 border border-2 border-dashed bg-light text-center cursor-pointer hover-effect" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <i class="ti ti-cloud-upload fs-1 text-primary mb-2"></i>
                                        <h6 class="fw-bold text-dark mb-0">Klik untuk Kelola Berkas</h6>
                                        <p class="small text-muted mb-0">Drag & Drop file PDF di dalam manager</p>
                                    </div>
                                    <div id="mainPageFileList" class="mt-3 d-grid gap-2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top p-4 text-end">
                            <a href="<?php echo e(route('Manajemen-Kerjasama.index')); ?>" class="btn btn-light me-2 border px-4">Batal</a>
                            <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2 px-4">Simpan Draft</button>
                            <button type="submit" name="action" value="pending" class="btn btn-primary px-4 shadow-sm">Ajukan ke Univ</button>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-4 d-flex">
                    <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
                        <div class="card-body p-4 text-center">
                            <i class="ti ti-shield-check text-primary mb-3" style="font-size: 3rem;"></i>
                            <h5 class="fw-bold text-dark">Panduan Input</h5>
                            <hr>
                            <div class="text-start">
                                <p class="small text-muted"><strong class="text-dark">Auto-Number:</strong> Sistem akan mengecek nomor terakhir secara real-time berdasarkan jenis dokumen yang dipilih.</p>
                                <p class="small text-muted"><strong class="text-dark">Unit:</strong> Pilih fakultas untuk memfilter daftar prodi yang tersedia.</p>
                                <p class="small text-muted"><strong class="text-dark">Berkas:</strong> Gunakan modal untuk upload hingga 10 file sekaligus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header border-0">
                            <h5 class="modal-title fw-bold"><i class="ti ti-cloud-upload text-primary me-2"></i>Upload Manager</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <div id="dropzone-area" class="dropzone-custom position-relative p-5 text-center rounded-4 border border-2 border-dashed bg-light overflow-hidden">
                                <input type="file" name="file_dokumen[]" id="fileInput" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" multiple accept=".pdf" style="z-index: 10;">
                                <div style="pointer-events: none;">
                                    <i class="ti ti-upload fs-1 text-primary mb-3"></i>
                                    <h5 class="fw-bold text-dark">Drag & Drop atau Klik di Sini</h5>
                                    <p class="text-muted small">Max 10 File (PDF, Max 5MB)</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label class="fw-bold small text-muted mb-2">Daftar File Terpilih:</label>
                                <div id="modalFileList" class="d-grid gap-2">
                                    <div class="text-center text-muted small py-3 fst-italic border rounded-3 bg-light">Belum ada file dipilih</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-primary px-4 rounded-pill" data-bs-dismiss="modal">Selesai</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .hover-effect:hover { background-color: #f1f5f9 !important; border-color: #3b82f6 !important; }
        .dropzone-custom { min-height: 250px; transition: 0.3s; }
        .dropzone-custom:hover { background-color: #eef2ff !important; border-color: #3b82f6 !important; }
        .cursor-pointer { cursor: pointer; }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // 1. SELECT2
            $('#selectMitra').select2({ theme: 'bootstrap-5', width: '100%', placeholder: 'Pilih Instansi Mitra', allowClear: true });

            $('#jenis_dokumen_id').change(function() {
                let id = $(this).val();
                let preview = $('#preview_kode');
                if (id) {
                    preview.val('Sedang mengecek nomor...');
                    $.get('/api/get-next-nomor/' + id, function(res) {
                        preview.val(res.kode);
                    });
                } else {
                    preview.val('');
                }
            });

            // 4. UPLOAD LOGIC
            const fileInput = $('#fileInput');
            const modalList = $('#modalFileList');
            const mainList = $('#mainPageFileList');
            const dropzone = $('#dropzone-area');

            fileInput.on('dragenter dragover', () => dropzone.addClass('bg-primary bg-opacity-10'));
            fileInput.on('dragleave drop', () => dropzone.removeClass('bg-primary bg-opacity-10'));

            fileInput.on('change', function() {
                let files = this.files;
                modalList.empty(); mainList.empty();

                if (files.length > 10) { alert('Maksimal 10 file!'); this.value = ""; return; }

                Array.from(files).forEach(file => {
                    if (file.size > 5*1024*1024) return alert(file.name + " kebesaran!");
                    let item = `
                        <div class="d-flex align-items-center p-2 bg-white border rounded-3 shadow-sm">
                            <i class="ti ti-file-type-pdf text-danger fs-3 me-3"></i>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="mb-0 text-truncate small fw-bold">${file.name}</h6>
                                <small class="text-muted" style="font-size: 10px;">${(file.size/1024/1024).toFixed(2)} MB</small>
                            </div>
                            <i class="ti ti-circle-check text-success fs-4"></i>
                        </div>`;
                    modalList.append(item); mainList.append(item);
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/Manajemen-Kerjasama/create.blade.php ENDPATH**/ ?>