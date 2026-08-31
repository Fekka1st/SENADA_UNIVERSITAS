<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'searchId' => 'customSearch',
    'searchPlaceholder' => 'Pencarian...',
    'dateFilterId' => 'filterTanggal',
    'dateFilterPlaceholder' => 'Pilih Rentang Tanggal',
    'filterButtonId' => 'btnTerapkanFilter',
    'hasDateFilter' => true,
    'hasExport' => false,
    'exportId' => 'btnExport',
    'exportRoute' => '#',
    'exportPermission' => null,
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
    'searchId' => 'customSearch',
    'searchPlaceholder' => 'Pencarian...',
    'dateFilterId' => 'filterTanggal',
    'dateFilterPlaceholder' => 'Pilih Rentang Tanggal',
    'filterButtonId' => 'btnTerapkanFilter',
    'hasDateFilter' => true,
    'hasExport' => false,
    'exportId' => 'btnExport',
    'exportRoute' => '#',
    'exportPermission' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="d-sm-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    
    <div class="position-relative me-3 mb-2 mb-sm-0">
        <input type="text" id="<?php echo e($searchId); ?>" class="form-control ps-5" placeholder="<?php echo e($searchPlaceholder); ?>"
            autocomplete="off">
        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
    </div>

    
    <div class="d-flex gap-2 align-items-center flex-wrap">
        <?php if($hasDateFilter): ?>
            
            <div class="d-flex align-items-center gap-2 flex-nowrap">
                <input type="text" id="<?php echo e($dateFilterId); ?>" class="form-control"
                    placeholder="<?php echo e($dateFilterPlaceholder); ?>" readonly>
                <button type="button" id="<?php echo e($filterButtonId); ?>"
                    class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                    <i class="ti ti-filter"></i>Terapkan
                </button>
            </div>
        <?php endif; ?>

        
        <?php echo e($additionalButtons ?? ''); ?>


        
        <?php if($hasExport): ?>
            <?php if($exportPermission): ?>
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', $exportPermission)): ?>
                    <a href="<?php echo e($exportRoute); ?>" id="<?php echo e($exportId); ?>"
                        class="btn btn-success d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-file-spreadsheet"></i>Export Excel
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e($exportRoute); ?>" id="<?php echo e($exportId); ?>"
                    class="btn btn-success d-flex align-items-center gap-1 flex-shrink-0">
                    <i class="ti ti-file-spreadsheet"></i>Export Excel
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>


<?php echo e($additionalFilters ?? ''); ?>

<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/datatable/filter-bar.blade.php ENDPATH**/ ?>