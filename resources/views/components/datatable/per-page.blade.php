@props([
    'selectId' => 'perPage',
    'options' => [5, 10, 25, 50, 100],
    'default' => 5,
    'label' => 'Tampilkan',
    'suffix' => 'data per halaman',
])

<div class="d-flex align-items-center gap-2 mb-3">
    <label for="{{ $selectId }}" class="form-label mb-0">{{ $label }}</label>
    <select id="{{ $selectId }}" class="form-select form-select-sm" style="width: 70px;">
        @foreach($options as $option)
            <option value="{{ $option }}" {{ $option == $default ? 'selected' : '' }}>{{ $option }}</option>
        @endforeach
    </select>
    <span class="mb-0">{{ $suffix }}</span>
</div>
