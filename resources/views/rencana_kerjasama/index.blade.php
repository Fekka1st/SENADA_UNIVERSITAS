<x-app-layout>
    <x-slot:title>Pengajuan Rencana Kerja Sama</x-slot:title>

    <x-alert></x-alert>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchRencana"
                searchPlaceholder="Cari Judul Rencana atau Mitra..."
                :hasDateFilter="false"
                :hasExport="false">
                <x-slot name="additionalButtons">
                    @permission('rencana_kerjasama.create')
                    <a href="{{ route('rencana-kerjasama.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                        <i class="ti ti-plus fs-4"></i>
                        <span class="d-none d-md-inline">Ajukan Rencana Baru</span>
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page & Info --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <x-datatable.per-page selectId="perPage" :default="10" />
                <div class="text-muted small">
                    <i class="ti ti-info-circle me-1"></i> Memantau progress diskusi rencana kerja sama prodi
                </div>
            </div>

            {{-- Table Wrapper --}}
            <x-datatable.wrapper
                tableId="rencanaTable"
                :columns="['No', 'Mitra', 'Judul Rencana', 'Unit / Prodi', 'Status', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
            ['data' => 'mitra_nama', 'name' => 'mitra.nama_mitra', 'className' => 'fw-bold text-dark'],
            ['data' => 'judul_rencana', 'name' => 'judul_rencana'],
            ['data' => 'user.prodi.nama_prodi', 'name' => 'user.prodi.nama_prodi', 'className' => 'text-muted'],
            ['data' => 'status', 'name' => 'status', 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '120px', 'className' => 'text-center']
        ];
    @endphp

    {{-- Datatable Scripts --}}
    <x-datatable.scripts
        tableId="rencanaTable"
        ajaxUrl="{{ route('rencana-kerjasama.getData') }}"
        :columns="$columnsConfig"
        searchId="searchRencana"
        perPageId="perPage"
    />

    {{-- Modal Hapus --}}
    <x-modal.hapus id="modalHapusRencana" title="Hapus Pengajuan Rencana" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul'); // Ambil judul dari data-judul di controller
            $('#modalHapusRencanaItemName').text(judul);
            $('#modalHapusRencanaForm').attr('action', '{{ route("rencana-kerjasama.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusRencana')).show();
        });
    </script>
</x-app-layout>
