<x-app-layout>
    <x-slot:title>Kategori Mitra</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian kategori..."
                :hasDateFilter="false"
                :hasExport="false">

                {{-- Tombol Tambah --}}
                <x-slot name="additionalButtons">
                    @permission('kategori_mitra.create')
                    <a href="{{ route('master-data.kategori_mitra.create') }}" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-plus"></i>Tambah Kategori
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page Selector --}}
            <x-datatable.per-page
                selectId="perPage"
                :options="[5, 10, 25, 50, 100]"
                :default="10"
            />

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="kategoriTable"
                :columns="[
                    'No',
                    'Nama Kategori',
                    'Warna Peta',
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
            'data' => 'nama_kategori',
            'name' => 'nama_kategori',
            'className' => 'all',
            'responsivePriority' => 2
        ];

        $columnsConfig[] = [
            'data' => 'warna_peta',
            'name' => 'warna_peta',
            'className' => 'text-center',
            'orderable' => false,
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
        tableId="kategoriTable"
        ajaxUrl="{{ route('master-data.kategori_mitra.getData') }}"
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
        id="modalHapusKategori"
        title="Hapus Kategori Mitra"
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
                $('#modalHapusKategoriItemName').text(nama);

                // Update form action - sesuaikan dengan route destroy
                const deleteUrl = '{{ route("master-data.kategori_mitra.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusKategoriForm').attr('action', deleteUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusKategori'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips setelah DataTables draw
            $('#kategoriTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>
</x-app-layout>
