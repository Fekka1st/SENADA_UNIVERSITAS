<x-app-layout>
<x-slot:title>Log Aktivitas Sistem</x-slot:title>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        {{-- Alert Messages --}}
        <x-alert></x-alert>

        {{-- Filter Bar --}}
        <x-datatable.filter-bar
            searchId="customSearch"
            searchPlaceholder="Cari pengguna atau aktivitas..."
            :hasDateFilter="false"
            :hasExport="true"
            exportRoute="{{ route('log-activity.export') }}">

            {{-- Tombol Tambahan: Refresh --}}
            <x-slot name="additionalButtons">
                <button type="button" onclick="window.location.reload()" class="btn btn-light-secondary d-flex align-items-center gap-1 flex-shrink-0">
                    <i class="ti ti-refresh"></i>Refresh Data
                </button>
            </x-slot>
        </x-datatable.filter-bar>

        {{-- Per Page Selector --}}
        <x-datatable.per-page
            selectId="perPage"
            :options="[10, 25, 50, 100]"
            :default="10"
        />

        {{-- DataTable Wrapper --}}
        <x-datatable.wrapper
            tableId="logTable"
            :columns="[
                'No',
                'Pengguna',
                'Aksi',
                'Modul / Data',
                'Waktu',
                'Detail'
            ]"
            :hasCheckbox="false"
        />
    </div>
</div>

@php
    // Build columns configuration sesuai dengan data dari Controller
    $columnsConfig = [];

    $columnsConfig[] = [
        'data' => 'DT_RowIndex',
        'name' => 'DT_RowIndex',
        'orderable' => false,
        'searchable' => false,
        'width' => '50px',
        'className' => 'text-center all',
        'responsivePriority' => 1
    ];

    $columnsConfig[] = [
        'data' => 'user',
        'name' => 'causer.name', // Searchable via causer name
        'className' => 'all',
        'responsivePriority' => 2
    ];

    $columnsConfig[] = [
        'data' => 'aktivitas',
        'name' => 'description',
        'className' => 'text-center'
    ];

    $columnsConfig[] = [
        'data' => 'modul',
        'name' => 'subject_type',
        'className' => 'text-start'
    ];

    $columnsConfig[] = [
        'data' => 'waktu',
        'name' => 'created_at',
        'width' => '150px'
    ];

    $columnsConfig[] = [
        'data' => 'aksi',
        'name' => 'aksi',
        'orderable' => false,
        'searchable' => false,
        'width' => '80px',
        'className' => 'text-center'
    ];
@endphp

{{-- DataTable Scripts Component --}}
<x-datatable.scripts
    tableId="logTable"
    ajaxUrl="{{ route('log-activity.datatables') }}"
    :columns="$columnsConfig"
    :order="[[4, 'desc']]" {{-- Sort by waktu (index 4) Descending --}}
    :pageLength="10"
    searchId="customSearch"
    perPageId="perPage"
    :hasDateFilter="false"
    :hasExport="true"
/>

{{-- Modal Detail JSON (Modern Style) --}}
<div class="modal fade" id="modalDetailLog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold"><i class="ti ti-info-circle me-2 text-primary"></i>Metadata Perubahan Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-light-subtle">
                <div class="mb-3">
                    <span class="badge bg-primary-subtle text-primary mb-2">PROPERTIES</span>
                    <pre id="jsonViewer" class="bg-dark text-success p-4 rounded-3 border-0 shadow-sm" style="max-height: 450px; overflow-y: auto; font-family: 'Fira Code', monospace; font-size: 13px;"></pre>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary fw-bold px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Handle Detail --}}

<script>
    $(document).ready(function() {
        // Handle click pada tombol detail/eye
        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();

            // Ambil data properties dari atribut data-properties
            const properties = $(this).data('properties');

            // Format JSON agar enak dibaca (indentation 4 spaces)
            const formattedJson = JSON.stringify(properties, null, 4);

            // Masukkan ke dalam viewer
            $('#jsonViewer').text(formattedJson);

            // Tampilkan Modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetailLog'));
            modal.show();
        });

        // Re-initialize tooltips after DataTables draw
        $('#logTable').on('draw.dt', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

    });
</script>


</x-app-layout>
