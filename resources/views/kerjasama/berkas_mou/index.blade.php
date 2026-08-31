<x-app-layout>
    <x-slot:title>Berkas MoU (Memorandum of Understanding)</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoU</x-slot:breadcrumb>

    <x-alert></x-alert>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchMou"
                searchPlaceholder="Cari Nomor MoU, Judul, atau Mitra..."
                :hasDateFilter="false"
                :hasExport="true"> {{-- MoU biasanya butuh export Excel untuk laporan rektorat --}}

                <x-slot name="additionalButtons">
                    {{-- Hanya Admin (Bukan Role 5) yang bisa registrasi MoU baru --}}
                    @if(auth()->user()->role_id != 5)
                        @permission('pengajuan_mou.create')
                        <a href="{{ route('berkas-MoU.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                            <i class="ti ti-file-plus fs-4"></i>
                            <span class="d-none d-md-inline">Registrasi MoU Baru</span>
                        </a>
                        @endpermission
                    @endif
                </x-slot>
            </x-datatable.filter-bar>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <x-datatable.per-page selectId="perPage" :default="10" />
                <div class="text-muted small d-none d-md-block">
                    <i class="ti ti-info-circle me-1"></i> Daftar seluruh dokumen payung hukum tingkat universitas
                </div>
            </div>

            {{-- Table Wrapper --}}
            <x-datatable.wrapper
                tableId="mouTable"
                :columns="['No', 'Nomor MoU', 'Instansi Mitra', 'Judul MoU', 'Masa Berlaku', 'Status', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
            ['data' => 'nomor_berkas_mou', 'name' => 'nomor_mou', 'className' => 'fw-bold text-dark'],
            ['data' => 'mitra_nama', 'name' => 'mitra.nama_mitra'],
            ['data' => 'judul_mou', 'name' => 'judul_mou', 'className' => 'small'],
            ['data' => 'masa_berlaku', 'name' => 'tanggal_berakhir', 'className' => 'text-center'],
            ['data' => 'status_mou', 'name' => 'status_mou', 'className' => 'text-center'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '120px', 'className' => 'text-center']
        ];
    @endphp

    {{-- Datatable Scripts --}}
    <x-datatable.scripts
        tableId="mouTable"
        ajaxUrl="{{ route('berkas-MoU.getData') }}"
        :columns="$columnsConfig"
        searchId="searchMou"
        perPageId="perPage"
    />

    {{-- Modal Hapus (Khusus Admin) --}}
    <x-modal.hapus id="modalHapusMou" title="Hapus Registrasi MoU" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            $('#modalHapusMouItemName').text(judul);
            $('#modalHapusMouForm').attr('action', '{{ route("berkas-MoU.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusMou')).show();
        });
    </script>
</x-app-layout>
