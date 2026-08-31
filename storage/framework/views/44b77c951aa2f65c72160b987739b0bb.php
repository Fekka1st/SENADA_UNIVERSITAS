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
     <?php $__env->slot('title', null, []); ?> Edit Program Studi: <?php echo e($prodi->nama_prodi); ?> <?php $__env->endSlot(); ?>
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

            
            <form action="<?php echo e(route('master-data.daftar_prodi.update', $prodi->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> 

                <div class="row">
                    <div class="col-md-8">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Nama Program Studi <span class="text-danger">*</span></label>
                            <input type="text" name="nama_prodi"
                                class="form-control <?php $__errorArgs = ['nama_prodi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama_prodi', $prodi->nama_prodi)); ?>"
                                placeholder="Contoh: S1 Teknik Informatika">
                            <?php $__errorArgs = ['nama_prodi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Fakultas <span class="text-danger">*</span></label>
                            <select name="fakultas_id" class="form-select <?php $__errorArgs = ['fakultas_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">-- Pilih Fakultas --</option>
                                <?php $__currentLoopData = $fakultas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($f->id); ?>" <?php echo e(old('fakultas_id', $prodi->fakultas_id) == $f->id ? 'selected' : ''); ?>>
                                        <?php echo e($f->nama_fakultas); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['fakultas_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Akreditasi Prodi <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3 flex-wrap">
                                <?php $__currentLoopData = ['Unggul', 'A', 'Baik Sekali', 'B', 'Baik', 'C']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check border rounded p-2 px-3 custom-option">
                                        <input class="form-check-input" type="radio" name="akreditasi"
                                            id="akred_<?php echo e($loop->index); ?>" value="<?php echo e($item); ?>"
                                            <?php echo e(old('akreditasi', $prodi->akreditasi_prodi) == $item ? 'checked' : ''); ?>>
                                        <label class="form-check-label cursor-pointer" for="akred_<?php echo e($loop->index); ?>">
                                            <?php echo e($item); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['akreditasi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <small class="text-danger d-block mt-2"><?php echo e($message); ?></small> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-dashed h-100">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <i class="ti ti-edit text-warning mb-3" style="font-size: 3rem;"></i>
                                <h5 class="fw-bold">Mode Edit</h5>
                                <p class="small text-muted">
                                    Anda sedang mengubah data program studi. Pastikan perubahan sudah sesuai dengan SK Akreditasi terbaru.
                                </p>
                                <div class="p-2 bg-white rounded border shadow-sm text-start mt-2">
                                    <small class="text-muted d-block">Terakhir diupdate:</small>
                                    <span class="fw-bold small"><?php echo e($prodi->updated_at->format('d M Y, H:i')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <hr class="opacity-10">
                    <a href="<?php echo e(route('master-data.daftar_prodi.index')); ?>" class="btn btn-light px-4 me-2 fw-bold">Batal</a>
                    <button type="submit" class="btn btn-warning text-white px-4 fw-bold">
                        <i class="ti ti-refresh me-1"></i>Perbarui Prodi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #dee2e6 !important; }
        .cursor-pointer { cursor: pointer; }
        .custom-option { transition: all 0.2s ease; }
        .custom-option:hover { background-color: #f8f9fa; border-color: #ffc107 !important; }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/daftar_prodi/edit.blade.php ENDPATH**/ ?>