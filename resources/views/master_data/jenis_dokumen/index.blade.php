<x-app-layout>
    <x-slot:title>Daftar Jenis Dokumen</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchJenisDokumen"
                searchPlaceholder="Cari Jenis Dokumen..."
                :hasDateFilter="false"
                :hasExport="false">

                <x-slot name="additionalButtons">
                    @permission('jenis_dokumen.create')
                    <a href="{{ route('master-data.jenis_dokumen.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                        <i class="ti ti-plus"></i>Tambah Jenis Dokumen
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page Selector --}}
            <x-datatable.per-page selectId="perPage" :default="10" />

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="jenisDokumenTable"
                :columns="['No','Kode Dokumen','Jenis Dokumen', 'Keterangan', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            [
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'orderable' => false,
                'searchable' => false,
                'width' => '50px',
                'className' => 'text-center all'
            ],
            [
                'data' => 'kode_inisial',
                'name' => 'kode_inisial',
                'className' => 'all'
            ],
            [
                'data' => 'nama_jenis',
                'name' => 'nama_jenis',
                'className' => 'all'
            ],
            [
                'data' => 'keterangan',
                'name' => 'keterangan',
                'className' => 'text-muted'
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'orderable' => false,
                'searchable' => false,
                'width' => '100px',
                'className' => 'text-center'
            ]
        ];
    @endphp

    <x-datatable.scripts
        tableId="jenisDokumenTable"
        ajaxUrl="{{ route('master-data.jenis_dokumen.getData') }}"
        :columns="$columnsConfig"
        :order="[[1, 'asc']]"
        searchId="searchJenisDokumen"
        perPageId="perPage"
    />

    <x-modal.hapus id="modalHapusJenisDokumen" title="Hapus Jenis Dokumen" :isDynamic="true" />

    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                $('#modalHapusJenisDokumenItemName').text(nama);
                const deleteUrl = '{{ route("master-data.jenis_dokumen.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusJenisDokumenForm').attr('action', deleteUrl);
                const modal = new bootstrap.Modal(document.getElementById('modalHapusJenisDokumen'));
                modal.show();
            });
            $('#jenisDokumenTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>
</x-app-layout>
