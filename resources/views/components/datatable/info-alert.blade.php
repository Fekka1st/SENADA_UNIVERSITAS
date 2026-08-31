@props([
    'type' => 'info',
    'dismissible' => true,
    'icon' => 'ti-info-circle',
    'title' => 'Panduan:',
])

<div class="alert alert-{{ $type }} {{ $dismissible ? 'alert-dismissible' : '' }} fade show py-2 mb-3 position-relative">
    <small>
        <i class="ti {{ $icon }} me-1"></i>
        <strong>{{ $title }}</strong>
        {{ $slot }}
    </small>
    @if($dismissible)
        <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-2"
            data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
