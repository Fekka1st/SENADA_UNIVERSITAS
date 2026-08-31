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
     <?php $__env->slot('title', null, []); ?> Tambah Jenis Kegiatan <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Tambah <?php $__env->endSlot(); ?>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
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

            <form action="<?php echo e(route('master-data.jenis_kegiatan.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-8">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Jenis Kegiatan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-lg shadow-none rounded-3 overflow-hidden border">
                                <span class="input-group-text bg-light border-0 text-muted px-4"><i class="ti ti-activity"></i></span>
                                <input type="text" name="nama_kegiatan"
                                    class="form-control bg-light border-0 fs-6 <?php $__errorArgs = ['nama_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('nama_kegiatan')); ?>"
                                    placeholder="Contoh: Magang Mahasiswa / Riset Kolaboratif"
                                    autocomplete="off" required>
                            </div>
                            <?php $__errorArgs = ['nama_kegiatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Keterangan / Deskripsi <span class="text-muted fw-normal small">(Opsional)</span></label>
                            <textarea name="keterangan" rows="5"
                                class="form-control bg-light border shadow-none rounded-3 p-3 <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Jelaskan secara singkat cakupan jenis kegiatan ini..."><?php echo e(old('keterangan')); ?></textarea>
                            <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        
                        <div class="card border-dashed bg-light bg-opacity-50 h-100 rounded-4">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <div class="mb-3">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                        <i class="ti ti-briefcase text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark">Bentuk Kegiatan</h5>
                                <p class="small text-muted mb-4 px-2">
                                    Jenis kegiatan merepresentasikan aktivitas konkret yang dilakukan dalam kerangka kerja sama.
                                </p>
                                <ul class="text-start small text-muted mb-4 px-3 list-unstyled">
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i><strong>MBKM:</strong> Pertukaran pelajar, magang, KKN Tematik.</li>
                                    <li class="mb-2"><i class="ti ti-check text-success me-2"></i><strong>Tridharma:</strong> Joint research, guest lecturer.</li>
                                    <li><i class="ti ti-check text-success me-2"></i><strong>Non-Akademik:</strong> Sponsorship, penyediaan fasilitas.</li>
                                </ul>
                                <div class="p-3 bg-white rounded-3 border shadow-sm mx-2">
                                    <small class="text-muted d-block mb-1">Status Penggunaan</small>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 rounded-pill">Digunakan dalam Rincian Kegiatan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <hr class="opacity-10 mb-4">
                        <a href="<?php echo e(route('master-data.jenis_kegiatan.index')); ?>" class="btn btn-light fw-bold px-4 py-2 me-2 rounded-pill hover-dark border">
                            <i class="ti ti-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2 rounded-pill shadow-sm hover-lift">
                            <i class="ti ti-device-floppy me-2"></i>Simpan Jenis Kegiatan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .border-dashed { border: 2px dashed #cbd5e1 !important; }
        .hover-dark:hover { background-color: #e2e8f0; color: #0f172a !important; transition: all 0.2s ease; }
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; }
        .form-control:focus { background-color: #fff !important; border-color: #3b82f6 !important; box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1) !important; }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/bentuk_kegiatan/create.blade.php ENDPATH**/ ?>