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
     <?php $__env->slot('title', null, []); ?> Edit Personil PIC <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Master Data / Mitra / Detail / Edit PIC <?php $__env->endSlot(); ?>

    <div class="container-fluid">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning bg-opacity-10 rounded-3 p-3 me-4">
                        <i class="ti ti-user-edit fs-1 text-warning"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">Memperbarui Personil Untuk:</h6>
                        <h2 class="fw-bold text-dark mb-0"><?php echo e($pic->mitra->nama_mitra); ?></h2>
                        <div class="mt-2 text-muted small">
                            <i class="ti ti-id me-1"></i> ID Personil: #<?php echo e($pic->id); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
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

                <form action="<?php echo e(route('Pic-Mitra.update', $pic->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <input type="hidden" name="mitra_id" value="<?php echo e($pic->mitra_id); ?>">

                    <div class="row g-4">
                        
                        <div class="col-md-8">
                            <h5 class="fw-bold mb-4 text-dark border-start border-4 border-warning ps-3">Formulir Pembaruan Identitas</h5>

                            <div class="row">
                                
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Nama Lengkap PIC <span class="text-danger">*</span></label>
                                    <div class="input-group shadow-none">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-user"></i></span>
                                        <input type="text" name="nama_pic" class="form-control border-start-0 <?php $__errorArgs = ['nama_pic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_pic', $pic->nama_pic)); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['nama_pic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Jabatan / Posisi</label>
                                    <input type="text" name="jabatan" class="form-control" value="<?php echo e(old('jabatan', $pic->jabatan)); ?>">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Prioritas PIC <span class="text-danger">*</span></label>
                                    <select name="status_pic" class="form-select <?php $__errorArgs = ['status_pic'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="0" <?php echo e(old('status_pic', $pic->status_pic) == 0 ? 'selected' : ''); ?>>Personil Pendamping</option>
                                        <option value="1" <?php echo e(old('status_pic', $pic->status_pic) == 1 ? 'selected' : ''); ?>>Personil Utama (Primary Contact)</option>
                                    </select>
                                </div>

                                
                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">No. WhatsApp <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-success"><i class="ti ti-brand-whatsapp"></i></span>
                                        <input type="text" name="no_telp" class="form-control border-start-0 <?php $__errorArgs = ['no_telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_telp', $pic->no_telp)); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">Email Resmi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-mail text-muted"></i></span>
                                        <input type="email" name="email" class="form-control border-start-0" value="<?php echo e(old('email', $pic->email)); ?>">
                                    </div>
                                </div>

                                
                                <div class="col-12 mb-0">
                                    <label class="form-label fw-bold">Alamat Lengkap PIC</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="ti ti-map-pin text-muted"></i></span>
                                        <textarea name="alamat" class="form-control border-start-0" rows="3"><?php echo e(old('alamat', $pic->alamat)); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div class="card border-dashed bg-light bg-opacity-25 h-100 border-2">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <i class="ti ti-history text-warning fs-huge" style="font-size: 3rem;"></i>
                                    </div>
                                    <h5 class="fw-bold">Audit Data</h5>
                                    <p class="small text-muted mb-4">
                                        Setiap perubahan data personil akan tercatat dalam log sistem untuk keperluan audit kerjasama.
                                    </p>
                                    <div class="alert alert-warning border-0 small text-start shadow-sm">
                                        <i class="ti ti-alert-triangle me-1"></i> Jika Anda mengubah personil ini menjadi <strong>PIC Utama</strong>, sistem akan otomatis mendemosi PIC utama sebelumnya menjadi pendamping.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <hr class="opacity-10 mb-4">
                            <a href="<?php echo e(route('Manajemen-Mitra.show', $pic->mitra_id)); ?>" class="btn btn-light fw-bold px-4 me-2">
                                <i class="ti ti-arrow-left me-1"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning fw-bold px-4 shadow-sm text-white">
                                <i class="ti ti-refresh me-1"></i>Perbarui Personil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .border-dashed { border-style: dashed !important; }
        .icon-box { width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; }
        .form-control:focus, .form-select:focus { border-color: #f59e0b; box-shadow: none; }
    </style>
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/manajemen-mitra/pic_mitra/edit.blade.php ENDPATH**/ ?>