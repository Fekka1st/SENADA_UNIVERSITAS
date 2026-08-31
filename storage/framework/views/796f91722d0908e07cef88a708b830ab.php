<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'modalHapus',
    'title' => 'Hapus Data',
    'itemName' => '',
    'deleteRoute' => '',
    'relatedCount' => 0,
    'relatedType' => '',
    'isSelfUser' => false,
    'isDynamic' => false  // Mode untuk server-side DataTables
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
    'id' => 'modalHapus',
    'title' => 'Hapus Data',
    'itemName' => '',
    'deleteRoute' => '',
    'relatedCount' => 0,
    'relatedType' => '',
    'isSelfUser' => false,
    'isDynamic' => false  // Mode untuk server-side DataTables
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="modal fade" id="<?php echo e($id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="<?php echo e($id); ?>Label" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="<?php echo e($id); ?>Label">
                    <i class="ti ti-trash me-1"></i> <?php echo e($title); ?>

                </h2>
            </div>
            <div class="modal-body">
                <?php if($isDynamic): ?>
                    
                    <p class="mb-2">
                        Anda yakin ingin menghapus <span class="fw-bold" id="<?php echo e($id); ?>ItemName"><?php echo e($itemName); ?></span>?
                    </p>
                    <div id="<?php echo e($id); ?>WarningRelated" class="alert alert-warning d-none">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data ini memiliki <span id="<?php echo e($id); ?>RelatedCount"></span> <?php echo e($relatedType); ?> terkait dan tidak dapat dihapus.
                    </div>
                    <p id="<?php echo e($id); ?>WarningDelete" class="text-danger small mb-0">
                        <i class="ti ti-alert-triangle me-1"></i>
                        Data yang sudah dihapus tidak dapat dikembalikan.
                    </p>
                <?php else: ?>
                    
                    <p class="mb-2">
                        Anda yakin ingin menghapus <span class="fw-bold"><?php echo e($itemName); ?></span>?
                    </p>
                    <?php if($isSelfUser): ?>
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Anda tidak dapat menghapus akun Anda sendiri.
                        </div>
                    <?php elseif($relatedCount > 0): ?>
                        <div class="alert alert-warning">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Data ini memiliki <?php echo e($relatedCount); ?> <?php echo e($relatedType); ?> terkait dan tidak dapat dihapus.
                        </div>
                    <?php else: ?>
                        <p class="text-danger small mb-0">
                            <i class="ti ti-alert-triangle me-1"></i>
                            Data yang sudah dihapus tidak dapat dikembalikan.
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                <?php if($isDynamic): ?>
                    
                    <form id="<?php echo e($id); ?>Form" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger" id="<?php echo e($id); ?>BtnSubmit">Ya, Hapus!</button>
                    </form>
                <?php else: ?>
                    
                    <?php if(!$isSelfUser && $relatedCount == 0): ?>
                        <form action="<?php echo e($deleteRoute); ?>" method="POST" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger">Ya, Hapus!</button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/modal/hapus.blade.php ENDPATH**/ ?>