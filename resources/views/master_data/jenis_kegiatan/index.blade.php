<x-app-layout>
    <x-slot:title>Master Data - Jenis Kegiatan</x-slot:title>
    <x-slot:breadcrumb>Master Data / Jenis Kegiatan</x-slot:breadcrumb>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian jenis kegiatan..."
                :hasDateFilter="false"
                :hasExport="false">

                {{-- Tombol Tambah --}}
                <x-slot name="additionalButtons">
                    {{-- Sesuaikan nama permission-nya dengan sistemmu --}}
                    @permission('jenis_kegiatan.create')
                    <a href="{{ route('master-data.jenis_kegiatan.create') }}" class="btn btn-primary d-flex align-items-center gap-2 flex-shrink-0 shadow-sm rounded-pill px-3">
                        <i class="ti ti-plus"></i> Tambah Jenis Kegiatan
                    </a>
                    @endpermission
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
                    <i class="ti ti-info-circle me-1"></i> Daftar master data bentuk kegiatan kerjasama
                </div>
            </div>

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="jenisKegiatanTable"
                :columns="[
                    'No',
                    'Nama Jenis Kegiatan',
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
            'data' => 'nama_kegiatan',
            'name' => 'nama_kegiatan',
            'className' => 'fw-bold text-dark all',
            'responsivePriority' => 2
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

    {{-- DataTable Scripts Component --}}
    <x-datatable.scripts
        tableId="jenisKegiatanTable"
        ajaxUrl="{{ route('master-data.jenis_kegiatan.getData') }}"
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
        id="modalHapusJenisKegiatan"
        title="Hapus Jenis Kegiatan"
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
                $('#modalHapusJenisKegiatanItemName').text(nama);

                // Update form action - sesuaikan dengan route destroy
                const deleteUrl = '{{ route("master-data.jenis_kegiatan.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusJenisKegiatanForm').attr('action', deleteUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusJenisKegiatan'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips setelah DataTables draw
            $('#jenisKegiatanTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>
</x-app-layout>
