<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'tableId' => 'dataTable',
    'columns' => [],
    'hasCheckbox' => false,
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
    'tableId' => 'dataTable',
    'columns' => [],
    'hasCheckbox' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="table-responsive">
    <table id="<?php echo e($tableId); ?>" class="table align-middle datatable-bordered" style="width: 100%;">
        <thead class="table-light">
            <tr>
                <?php if($hasCheckbox): ?>
                    <th><input type="checkbox" id="checkAll"></th>
                <?php endif; ?>
                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($column !== null): ?>
                        <th><?php echo e($column); ?></th>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/datatable/wrapper.blade.php ENDPATH**/ ?>