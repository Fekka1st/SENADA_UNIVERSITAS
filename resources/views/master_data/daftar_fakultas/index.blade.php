<x-app-layout>
    <x-slot:title>Daftar Fakultas</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian Fakultas..."
                :hasDateFilter="false"
                :hasExport="false">

                {{-- Tombol Tambah --}}
                <x-slot name="additionalButtons">
                    @permission('daftar_fakultas.create')
                    <a href="{{ route('master-data.daftar_fakultas.create') }}" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-plus"></i>Tambah Fakultas
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
                tableId="fakultasTable"
                :columns="[
                    'No',
                    'Nama Fakultas',
                    'Akreditasi',
                    'Total Prodi',
                    'Aksi'
                ]"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
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
            'data' => 'nama_fakultas',
            'name' => 'nama_fakultas',
            'className' => 'all',
            'responsivePriority' => 2
        ];

        $columnsConfig[] = [
            'data' => 'akreditasi_fakultas',
            'name' => 'akreditasi',
            'className' => 'text-center',
        ];

        $columnsConfig[] = [
            'data' => 'jumlah_prodi',
            'name' => 'prodis_count', // Sesuai dengan withCount('prodis') di Controller
            'className' => 'text-center',
            'searchable' => false,
        ];

        $columnsConfig[] = [
            'data' => 'action',
            'name' => 'action',
            'orderable' => false,
            'searchable' => false,
            'width' => '150px', // Sedikit lebih lebar karena ada tambahan tombol Prodi
            'className' => 'text-center'
        ];
    @endphp

    {{-- DataTable Scripts Component --}}
    <x-datatable.scripts
        tableId="fakultasTable"
        ajaxUrl="{{ route('master-data.daftar_fakultas.getData') }}"
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
        id="modalHapusFakultas"
        title="Hapus Data Fakultas"
        :isDynamic="true"
    />

    <script>
        $(document).ready(function() {
            // Handle click pada tombol delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                // Update modal content
                $('#modalHapusFakultasItemName').text(nama);

                // Update form action
                const deleteUrl = '{{ route("master-data.daftar_fakultas.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusFakultasForm').attr('action', deleteUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusFakultas'));
                modal.show();
            });

            // Re-initialize tooltips setelah DataTables draw (untuk button prodi & edit)
            $('#fakultasTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>
</x-app-layout>
