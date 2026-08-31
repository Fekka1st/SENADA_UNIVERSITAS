<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'route',
    'showEditButton' => false,
    'showDeleteButton' => false,
    'editRoute' => null,
    'editPermission' => null,
    'deletePermission' => null,
    'deleteModalTarget' => '#modalHapus',
    'showDefaultSubmit' => true
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'route',
    'showEditButton' => false,
    'showDeleteButton' => false,
    'editRoute' => null,
    'editPermission' => null,
    'deletePermission' => null,
    'deleteModalTarget' => '#modalHapus',
    'showDefaultSubmit' => true
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="pt-3 pb-1 mt-4 border-top">
    <?php if(request()->routeIs($route . '.show')): ?>
        
        <div class="d-flex justify-content-between align-items-center gap-2">
            
            <a href="<?php echo e(route($route . '.index')); ?>" class="btn btn-secondary px-4">
                <i class="ti ti-arrow-left me-2"></i> Kembali
            </a>
            
            <div class="d-flex gap-2 align-items-center">
                
                <?php if($showEditButton && $editRoute && $editPermission): ?>
                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', $editPermission)): ?>
                        <a href="<?php echo e($editRoute); ?>" class="btn btn-warning">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                    <?php endif; ?>
                <?php endif; ?>

                
                <?php if($showDeleteButton && $deletePermission): ?>
                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', $deletePermission)): ?>
                        <button type="button" class="btn btn-danger" 
                                data-bs-toggle="modal"
                                data-bs-target="<?php echo e($deleteModalTarget); ?>">
                            <i class="ti ti-trash me-1"></i> Hapus
                        </button>
                    <?php endif; ?>
                <?php endif; ?>
                
                
                <?php echo e($actions ?? ''); ?>

            </div>
        </div>
    <?php else: ?>
        
        <div class="d-flex justify-content-between align-items-center gap-2">
            
            <?php if(request()->routeIs('profil.edit')): ?>
                <a href="<?php echo e(route('dashboard.index')); ?>" class="btn btn-secondary px-4">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
            <?php else: ?>
                <a href="<?php echo e(route($route . '.index')); ?>" class="btn btn-secondary px-4">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
            <?php endif; ?>

            <div class="d-flex gap-2 align-items-center">
                
                <?php if($showDefaultSubmit): ?>
                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                        <i class="ti ti-device-floppy me-2"></i>Simpan
                    </button>
                <?php endif; ?>
                
                
                <?php echo e($actions ?? ''); ?>

            </div>
        </div>
    <?php endif; ?>
</div>

<?php if($showDefaultSubmit): ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const forms = document.querySelectorAll('form');
            
            if (submitBtn && forms.length > 0) {
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        // Disable button untuk mencegah double submit
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
                        
                        // Enable kembali setelah 5 detik untuk mencegah stuck
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan';
                        }, 5000);
                    });
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/page-action-buttons.blade.php ENDPATH**/ ?>