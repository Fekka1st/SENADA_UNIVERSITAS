<x-app-layout>
    <x-slot:title>Daftar Program Studi </x-slot:title>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            <x-datatable.filter-bar
                searchId="searchProdi"
                searchPlaceholder="Cari Prodi..."
                :hasDateFilter="false"
                :hasExport="false">
                <x-slot name="additionalButtons">
                    @permission('daftar_prodi.create')
                    <a href="{{ route('master-data.daftar_prodi.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                        <i class="ti ti-plus"></i>Tambah Prodi
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            <x-datatable.per-page selectId="perPage" :default="10" />

            <x-datatable.wrapper
                tableId="prodiTable"
                :columns="['No','Fakultas' ,'Program Studi' , 'Akreditasi', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
            ['data' => 'nama_fakultas_tabel', 'name' => 'fakultas.nama_fakultas'],
            ['data' => 'nama_prodi', 'name' => 'nama_prodi'],
            ['data' => 'akreditasi_prodi', 'name' => 'akreditasi', 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '100px', 'className' => 'text-center']
        ];
    @endphp

    <x-datatable.scripts
        tableId="prodiTable"
        ajaxUrl="{{ route('master-data.daftar_prodi.getData') }}"
        :columns="$columnsConfig"
        searchId="searchProdi"
        perPageId="perPage"
    />

    <x-modal.hapus id="modalHapusProdi" title="Hapus Prodi" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $('#modalHapusProdiItemName').text(nama);
            $('#modalHapusProdiForm').attr('action', '{{ route("master-data.daftar_prodi.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusProdi')).show();
        });
    </script>
</x-app-layout>
