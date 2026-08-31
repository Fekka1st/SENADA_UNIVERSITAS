@props([
    'text' => 'Simpan',
    'loadingText' => 'Menyimpan...',
    'icon' => 'ti-device-floppy',
    'class' => 'btn btn-primary px-4',
    'formId' => null,
    'type' => 'submit',
    'showSpinner' => true,
    'timeout' => 5000
])

@php
    $uniqueId = 'auth-btn-' . uniqid();
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => $class]) }}
    id="{{ $uniqueId }}"
    data-loading-text="{{ $loadingText }}"
    data-original-text="{{ $text }}"
    data-icon="{{ $icon }}"
    data-show-spinner="{{ $showSpinner ? 'true' : 'false' }}"
    data-timeout="{{ $timeout }}"
    @if($formId) data-form-id="{{ $formId }}" @endif
>
    <i class="ti {{ $icon }} me-2"></i>{{ $text }}
</button>

<script>
(function() {
    const button = document.getElementById('{{ $uniqueId }}');
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
</script>