<x-app-layout>
    <x-slot:title>Daftar Prodi: {{ $fakultas->nama_fakultas }}</x-slot:title>
    <x-slot:breadcrumb>Detail Prodi</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- Header Info --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold mb-0">Fakultas {{ $fakultas->nama_fakultas }}</h4>
                    <p class="text-muted mb-0">Manajemen daftar program studi di bawah naungan fakultas ini.</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                        Akreditasi Fakultas: <strong>{{ $fakultas->akreditasi_fakultas }}</strong>
                    </span>
                </div>
            </div>

            <hr class="opacity-10 mb-4">

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchProdi"
                searchPlaceholder="Cari nama prodi..."
                :hasDateFilter="false"
                :hasExport="false">

                <x-slot name="additionalButtons">
                    {{-- Tombol Kembali --}}
                    <a href="{{ route('master-data.daftar_fakultas.index') }}" class="btn btn-light d-flex align-items-center gap-1">
                        <i class="ti ti-arrow-left"></i>Kembali
                    </a>
                    {{-- Tombol Tambah Prodi (Langsung terikat ke fakultas ini) --}}
                    @permission('prodi.create')
                    <a href="{{ route('master-data.daftar_fakultas.create', ['fakultas_id' => $fakultas->id]) }}" class="btn btn-primary d-flex align-items-center gap-1">
                        <i class="ti ti-plus"></i>Tambah Prodi
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page --}}
            <x-datatable.per-page selectId="perPageProdi" :default="10" />

            {{-- Table --}}
            <x-datatable.wrapper
                tableId="prodiDetailTable"
                :columns="[
                    'No',
                    'Nama Program Studi',
                    'Akreditasi Prodi',

                ]"
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
                'data' => 'nama_prodi',
                'name' => 'nama_prodi',
                'className' => 'all'
            ],
            [
                'data' => 'akreditasi_prodi',
                'name' => 'akreditasi',
                'className' => 'text-center'
            ],

        ];
    @endphp

    {{-- DataTable Scripts --}}
    <x-datatable.scripts
        tableId="prodiDetailTable"
        ajaxUrl="{{ route('master-data.daftar_prodi.getData') }}"
        :columns="$columnsConfig"
        :order="[[1, 'asc']]"
        searchId="searchProdi"
        perPageId="perPageProdi"
        :hasDateFilter="false"
        :hasExport="false"
    >
        {{-- Inject parameter fakultas_id ke Ajax Request --}}
        <x-slot name="customAjaxData">
            d.fakultas_id = "{{ $fakultas->id }}";
        </x-slot>
    </x-datatable.scripts>

    {{-- Modal Hapus --}}
    <x-modal.hapus
        id="modalHapusProdi"
        title="Hapus Program Studi"
        :isDynamic="true"
    />

    <script>
        $(document).ready(function() {
            // Delete Action
            $(document).on('click', '.btn-delete-prodi', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                $('#modalHapusProdiItemName').text(nama);
                const url = '{{ route("master-data.daftar_prodi.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusProdiForm').attr('action', url);

                new bootstrap.Modal(document.getElementById('modalHapusProdi')).show();
            });
        });
    </script>
</x-app-layout>
