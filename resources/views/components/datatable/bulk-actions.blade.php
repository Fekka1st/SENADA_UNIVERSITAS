@props([
    'buttons' => [],
    'containerClass' => 'mt-3 mb-3 d-flex gap-2',
])

@if(!empty($buttons))
    <div class="{{ $containerClass }}">
        @foreach($buttons as $button)
            @php
                $hasPermission = !isset($button['permission']) || auth()->user()->hasPermission($button['permission']);
            @endphp
            
            @if($hasPermission)
                <button 
                    type="button" 
                    class="btn btn-{{ $button['color'] ?? 'primary' }}" 
                    data-bs-toggle="modal"
                    data-bs-target="#{{ $button['modal'] }}" 
                    id="{{ $button['id'] }}" 
                    disabled
                >
                    <i class="ti {{ $button['icon'] }} me-2"></i>{{ $button['label'] }}
                </button>
            @endif
        @endforeach
    </div>
@endif
