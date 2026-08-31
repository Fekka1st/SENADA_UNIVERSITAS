<x-app-layout>
    <x-slot:title>Manajemen Mitra Strategis</x-slot:title>
    <x-alert></x-alert>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <x-datatable.filter-bar
                searchId="searchMitra"
                searchPlaceholder="Cari Nama Mitra atau Negara..."
                :hasDateFilter="false"
                :hasExport="false">
                <x-slot name="additionalButtons">
                    @permission('mitra.create')
                    <a href="{{ route('Manajemen-Mitra.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                        <i class="ti ti-plus fs-4"></i>
                        <span class="d-none d-md-inline">Tambah Mitra Baru</span>
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <x-datatable.per-page selectId="perPage" :default="10" />
                <div class="text-muted small">
                    <i class="ti ti-info-circle me-1"></i> Menampilkan daftar mitra aktif universitas
                </div>
            </div>

            <x-datatable.wrapper
                tableId="mitraTable"
                :columns="['No', 'Nama Mitra', 'Kategori', 'Negara', 'PIC', 'Website', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
            ['data' => 'nama_mitra', 'name' => 'nama_mitra', 'className' => 'fw-bold text-dark'],
            ['data' => 'kategori_nama', 'name' => 'kategori.nama_kategori', 'className' => 'text-center'],
            ['data' => 'negara', 'name' => 'negara', 'className' => 'text-center'],
            ['data' => 'pic_info', 'name' => 'pic.nama_pic'],
           ['data' => 'url_website', 'name' => 'url_website', 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '100px', 'className' => 'text-center']
        ];
    @endphp

    <x-datatable.scripts
        tableId="mitraTable"
        ajaxUrl="{{ route('Manajemen-Mitra.getData') }}"
        :columns="$columnsConfig"
        searchId="searchMitra"
        perPageId="perPage"
    />

    <x-modal.hapus id="modalHapusMitra" title="Hapus Data Mitra" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $('#modalHapusMitraItemName').text(nama);
            $('#modalHapusMitraForm').attr('action', '{{ route("Manajemen-Mitra.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusMitra')).show();
        });
    </script>
</x-app-layout>
