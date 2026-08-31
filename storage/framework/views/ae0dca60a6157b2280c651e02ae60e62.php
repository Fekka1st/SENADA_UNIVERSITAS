<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-check fs-5 me-2"></i>
        <div>
            <strong>Sukses!</strong> <?php echo e(session('success')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-circle-x align-self-start fs-5 me-2"></i>
        <div>
            <strong>Gagal!</strong> <?php echo e(session('error')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif(session('info')): ?>
    <div class="alert alert-info alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
        <i class="ti ti-info-circle fs-5 me-2"></i>
        <div>
            <strong>Info!</strong> <?php echo e(session('info')); ?>

        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="ti ti-alert-triangle align-self-start fs-5 me-2"></i>
            <div class="flex-grow-1">
                <strong>Terjadi Kesalahan!</strong>
                <div class="mt-2">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php if(session('failures')): ?>
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-start">
            <i class="ti ti-alert-triangle align-self-start fs-5 me-2"></i>
            <div class="flex-grow-1">
                <strong>Gagal Import!</strong>
                <div class="mt-2">
                    <ul class="mb-0 ps-3">
                        <?php $__currentLoopData = session('failures'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $failure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($failure); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/alert.blade.php ENDPATH**/ ?>