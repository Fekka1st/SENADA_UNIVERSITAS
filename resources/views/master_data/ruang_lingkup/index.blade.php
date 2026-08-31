<x-app-layout>
    <x-slot:title>Daftar Ruang Lingkup Kerja Sama</x-slot:title>

    <div class="card">
        <div class="card-body">
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchRuangLingkup"
                searchPlaceholder="Cari Ruang Lingkup..."
                :hasDateFilter="false"
                :hasExport="false">
                <x-slot name="additionalButtons">
                    @permission('ruang_lingkup.create')
                    <a href="{{ route('master-data.ruang_lingkup.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                        <i class="ti ti-plus"></i>Tambah Ruang Lingkup
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page Selector --}}
            <x-datatable.per-page selectId="perPage" :default="10" />

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="ruangLingkupTable"
                :columns="['No', 'Nama Ruang Lingkup', 'Keterangan', 'Aksi']"
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
                'className' => 'text-center'
            ],
            [
                'data' => 'nama_ruanglingkup',
                'name' => 'nama_ruanglingkup'
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

    {{-- DataTable Scripts --}}
    <x-datatable.scripts
        tableId="ruangLingkupTable"
        ajaxUrl="{{ route('master-data.ruang_lingkup.getData') }}"
        :columns="$columnsConfig"
        searchId="searchRuangLingkup"
        perPageId="perPage"
    />

    {{-- Modal Hapus --}}
    <x-modal.hapus id="modalHapusRuangLingkup" title="Hapus Ruang Lingkup" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');

            $('#modalHapusRuangLingkupItemName').text(nama);
            $('#modalHapusRuangLingkupForm').attr('action', '{{ route("master-data.ruang_lingkup.destroy", ":id") }}'.replace(':id', id));

            new bootstrap.Modal(document.getElementById('modalHapusRuangLingkup')).show();
        });
    </script>
</x-app-layout>
