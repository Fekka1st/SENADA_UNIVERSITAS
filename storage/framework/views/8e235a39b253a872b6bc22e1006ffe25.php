<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'selectId' => 'perPage',
    'options' => [5, 10, 25, 50, 100],
    'default' => 5,
    'label' => 'Tampilkan',
    'suffix' => 'data per halaman',
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
    'selectId' => 'perPage',
    'options' => [5, 10, 25, 50, 100],
    'default' => 5,
    'label' => 'Tampilkan',
    'suffix' => 'data per halaman',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="d-flex align-items-center gap-2 mb-3">
    <label for="<?php echo e($selectId); ?>" class="form-label mb-0"><?php echo e($label); ?></label>
    <select id="<?php echo e($selectId); ?>" class="form-select form-select-sm" style="width: 70px;">
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($option); ?>" <?php echo e($option == $default ? 'selected' : ''); ?>><?php echo e($option); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <span class="mb-0"><?php echo e($suffix); ?></span>
</div>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/datatable/per-page.blade.php ENDPATH**/ ?>