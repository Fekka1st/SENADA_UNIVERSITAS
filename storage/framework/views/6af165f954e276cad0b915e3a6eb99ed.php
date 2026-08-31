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
     <?php $__env->slot('title', null, []); ?> Edit Fakultas: <?php echo e($fakultas->nama_fakultas); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Edit <?php $__env->endSlot(); ?>

    <div class="card">
        <div class="card-body">

            
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

            
            <form action="<?php echo e(route('master-data.daftar_fakultas.update', $fakultas->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> 

                <div class="row">
                    <div class="col-md-8">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Fakultas <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-school"></i></span>
                                <input type="text" name="nama_fakultas"
                                    class="form-control <?php $__errorArgs = ['nama_fakultas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('nama_fakultas', $fakultas->nama_fakultas)); ?>"
                                    placeholder="Contoh: Fakultas Teknik..."
                                    autocomplete="off">
                                <?php $__errorArgs = ['nama_fakultas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Akreditasi <span class="text-danger">*</span></label>
                            <div class="row g-3">
                                <?php $__currentLoopData = ['Unggul', 'A', 'Baik Sekali', 'B', 'Baik', 'C']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-4">
                                        
                                        <div class="form-check custom-option border rounded p-3 <?php $__errorArgs = ['akreditasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <input class="form-check-input" type="radio" name="akreditasi"
                                                id="akred_<?php echo e($loop->index); ?>" value="<?php echo e($item); ?>"
                                                <?php echo e(old('akreditasi', $fakultas->akreditasi_fakultas) == $item ? 'checked' : ''); ?>>
                                            <label class="form-check-label d-flex flex-column" for="akred_<?php echo e($loop->index); ?>">
                                                <span class="fw-bold"><?php echo e($item); ?></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['akreditasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        
                        <div class="card border-dashed bg-light bg-opacity-50 h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <i class="ti ti-edit text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="fw-bold">Mode Edit</h5>
                                <p class="small text-muted">
                                    Anda sedang mengubah data <strong><?php echo e($fakultas->nama_fakultas); ?></strong>.
                                    Perubahan akan langsung berdampak pada seluruh relasi Program Studi di bawahnya.
                                </p>
                                <div class="p-3 bg-white rounded-3 border shadow-sm text-start">
                                    <small class="text-muted d-block mb-1 italic">Terakhir diperbarui:</small>
                                    <span class="fw-bold small"><?php echo e($fakultas->updated_at->format('d M Y, H:i')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="<?php echo e(route('master-data.daftar_fakultas.index')); ?>" class="btn btn-light fw-bold px-4 me-2">
                            <i class="ti ti-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-white fw-bold px-4">
                            <i class="ti ti-refresh me-1"></i>Perbarui Fakultas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #dee2e6 !important; }
        .custom-option { cursor: pointer; transition: all 0.2s ease; }
        .custom-option:hover { background-color: #f8f9fa; border-color: #3b82f6 !important; }
        .form-check-input:checked + .form-check-label { color: #3b82f6; }
        .form-check-input:checked ~ .form-check-label .fw-bold { color: #3b82f6; }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/daftar_fakultas/edit.blade.php ENDPATH**/ ?>