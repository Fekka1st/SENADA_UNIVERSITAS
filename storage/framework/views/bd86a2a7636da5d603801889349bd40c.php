<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'text' => 'Simpan',
    'loadingText' => 'Menyimpan...',
    'icon' => 'ti-device-floppy',
    'class' => 'btn btn-primary px-4',
    'formId' => null,
    'type' => 'submit',
    'showSpinner' => true,
    'timeout' => 5000
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
    'text' => 'Simpan',
    'loadingText' => 'Menyimpan...',
    'icon' => 'ti-device-floppy',
    'class' => 'btn btn-primary px-4',
    'formId' => null,
    'type' => 'submit',
    'showSpinner' => true,
    'timeout' => 5000
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $uniqueId = 'auth-btn-' . uniqid();
?>

<button 
    type="<?php echo e($type); ?>" 
    <?php echo e($attributes->merge(['class' => $class])); ?>

    id="<?php echo e($uniqueId); ?>"
    data-loading-text="<?php echo e($loadingText); ?>"
    data-original-text="<?php echo e($text); ?>"
    data-icon="<?php echo e($icon); ?>"
    data-show-spinner="<?php echo e($showSpinner ? 'true' : 'false'); ?>"
    data-timeout="<?php echo e($timeout); ?>"
    <?php if($formId): ?> data-form-id="<?php echo e($formId); ?>" <?php endif; ?>
>
    <i class="ti <?php echo e($icon); ?> me-2"></i><?php echo e($text); ?>

</button>

<script>
(function() {
    const button = document.getElementById('<?php echo e($uniqueId); ?>');
    const formId = button.getAttribute('data-form-id');
    const form = formId ? document.getElementById(formId) : button.closest('form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const loadingText = button.getAttribute('data-loading-text');
            const originalText = button.getAttribute('data-original-text');
            const icon = button.getAttribute('data-icon');
            const showSpinner = button.getAttribute('data-show-spinner') === 'true';
            const timeout = parseInt(button.getAttribute('data-timeout')) || 5000;
            
            // Disable button dan ubah text
            button.disabled = true;
            
            if (showSpinner) {
                button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`;
            } else {
                button.innerHTML = `<i class="ti ${icon} me-2"></i>${loadingText}`;
            }
            
            // Enable kembali setelah timeout untuk mencegah stuck
            setTimeout(() => {
                button.disabled = false;
                button.innerHTML = `<i class="ti ${icon} me-2"></i>${originalText}`;
            }, timeout);
        });
    }
})();
</script><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/auth-buttons.blade.php ENDPATH**/ ?>