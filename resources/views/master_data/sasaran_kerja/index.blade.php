<x-app-layout>
    <x-slot:title>Master Data - Sasaran Kerja</x-slot:title>
    <x-slot:breadcrumb>Master Data / Sasaran Kerja</x-slot:breadcrumb>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian sasaran kerja..."
                :hasDateFilter="false"
                :hasExport="false">

                {{-- Tombol Tambah --}}
                <x-slot name="additionalButtons">
                    {{-- Sesuaikan nama permission-nya dengan sistemmu --}}

                    <a href="{{ route('master-data.sasaran_kerja.create') }}" class="btn btn-primary d-flex align-items-center gap-2 flex-shrink-0 shadow-sm rounded-pill px-3">
                        <i class="ti ti-plus"></i> Tambah Sasaran Kerja
                    </a>
                 
                </x-slot>
            </x-datatable.filter-bar>

            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Per Page Selector --}}
                <x-datatable.per-page
                    selectId="perPage"
                    :options="[5, 10, 25, 50, 100]"
                    :default="10"
                />
                <div class="text-muted small d-none d-md-block">
                    <i class="ti ti-info-circle me-1"></i> Daftar master data target/sasaran dari kegiatan kerjasama
                </div>
            </div>

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="sasaranKerjaTable"
                :columns="[
                    'No',
                    'Nama Sasaran Kerja',
                    'Jumlah Indikator',
                    'Keterangan',
                    'Aksi'
                ]"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        // Build columns configuration
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
            'data' => 'nama_sasaran',
            'name' => 'nama_sasaran',
            'className' => 'fw-bold text-dark all',
            'responsivePriority' => 2
        ];
        $columnsConfig[] = [
            'data' => 'jumlah_indikator',
            'name' => 'indikator_kerja_count',
            'className' => 'text-center',
            'searchable' => false
        ];
        $columnsConfig[] = [
            'data' => 'keterangan',
            'name' => 'keterangan',
            'className' => 'text-muted'
        ];

        $columnsConfig[] = [
            'data' => 'action',
            'name' => 'action',
            'orderable' => false,
            'searchable' => false,
            'width' => '100px',
            'className' => 'text-center'
        ];
    @endphp


    <x-datatable.scripts
        tableId="sasaranKerjaTable"
        ajaxUrl="{{ route('master-data.sasaran_kerja.getData') }}"
        :columns="$columnsConfig"
        :order="[[1, 'asc']]"
        :pageLength="10"
        searchId="customSearch"
        perPageId="perPage"
        :hasDateFilter="false"
        :hasExport="false"
    />

    {{-- Modal Hapus menggunakan komponen dengan mode dynamic --}}
    <x-modal.hapus
        id="modalHapusSasaranKerja"
        title="Hapus Sasaran Kerja"
        :isDynamic="true"
    />

    {{-- Script untuk Aksi --}}
    <script>
        $(document).ready(function() {
            // Handle click pada tombol delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                // Update modal content
                $('#modalHapusSasaranKerjaItemName').text(nama);

                // Update form action - sesuaikan dengan route destroy
                const deleteUrl = '{{ route("master-data.sasaran_kerja.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusSasaranKerjaForm').attr('action', deleteUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusSasaranKerja'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips setelah DataTables draw
            $('#sasaranKerjaTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>
</x-app-layout>
