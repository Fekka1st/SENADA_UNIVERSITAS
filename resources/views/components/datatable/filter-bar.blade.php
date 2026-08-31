@props([
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
])

<div class="d-sm-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    {{-- Search Box --}}
    <div class="position-relative me-3 mb-2 mb-sm-0">
        <input type="text" id="{{ $searchId }}" class="form-control ps-5" placeholder="{{ $searchPlaceholder }}"
            autocomplete="off">
        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-5 ms-3"></i>
    </div>

    {{-- Filter Tanggal dan Tombol Aksi --}}
    <div class="d-flex gap-2 align-items-center flex-wrap">
        @if($hasDateFilter)
            {{-- Filter Tanggal --}}
            <div class="d-flex align-items-center gap-2 flex-nowrap">
                <input type="text" id="{{ $dateFilterId }}" class="form-control"
                    placeholder="{{ $dateFilterPlaceholder }}" readonly>
                <button type="button" id="{{ $filterButtonId }}"
                    class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                    <i class="ti ti-filter"></i>Terapkan
                </button>
            </div>
        @endif

        {{-- Slot untuk tombol tambahan --}}
        {{ $additionalButtons ?? '' }}

        {{-- Tombol Export Excel --}}
        @if($hasExport)
            @if($exportPermission)
                @permission($exportPermission)
                    <a href="{{ $exportRoute }}" id="{{ $exportId }}"
                        class="btn btn-success d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-file-spreadsheet"></i>Export Excel
                    </a>
                @endpermission
            @else
                <a href="{{ $exportRoute }}" id="{{ $exportId }}"
                    class="btn btn-success d-flex align-items-center gap-1 flex-shrink-0">
                    <i class="ti ti-file-spreadsheet"></i>Export Excel
                </a>
            @endif
        @endif
    </div>
</div>

{{-- Slot untuk filter tambahan (seperti dropdown Penyusutan Akhir) --}}
{{ $additionalFilters ?? '' }}
