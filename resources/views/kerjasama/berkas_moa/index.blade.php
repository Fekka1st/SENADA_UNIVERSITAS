<x-app-layout>
    <x-slot:title>Berkas MoA (Memorandum of Agreement)</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoA</x-slot:breadcrumb>

    <x-alert></x-alert>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="searchMoa"
                searchPlaceholder="Cari Judul MoA, Nomor, atau Mitra..."
                :hasDateFilter="false"
                :hasExport="true">

                <x-slot name="additionalButtons">
                    @if(auth()->user()->role_id != 5)
                        {{-- Sesuaikan nama permissionnya dengan yang ada di sistemmu --}}
                        {{-- @permission('pengajuan_moa.create') --}}
                        <a href="{{ route('berkas-MoA.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm">
                            <i class="ti ti-file-plus fs-4"></i>
                            <span class="d-none d-md-inline">Registrasi MoA Baru</span>
                        </a>
                        {{-- @endpermission --}}
                    @endif
                </x-slot>
            </x-datatable.filter-bar>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <x-datatable.per-page selectId="perPage" :default="10" />
                <div class="text-muted small d-none d-md-block">
                    <i class="ti ti-info-circle me-1"></i> Daftar Perjanjian Kerja Sama Teknis (Turunan MoU)
                </div>
            </div>

            {{-- Table Wrapper --}}
            <x-datatable.wrapper
                tableId="moaTable"
                :columns="['No', 'Judul & Nomor MoA', 'Mitra & Payung MoU', 'Masa Berlaku', 'Status', 'Aksi']"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
            ['data' => 'judul_lengkap', 'name' => 'judul_moa', 'className' => 'small'],
            ['data' => 'mou_mitra', 'name' => 'mou.mitra.nama_mitra', 'className' => 'small'], // Bisa di-search lewat nama mitra
            ['data' => 'masa_berlaku', 'name' => 'tanggal_berakhir', 'className' => 'text-center align-middle'],
            ['data' => 'status_moa', 'name' => 'tanggal_berakhir', 'searchable' => false, 'className' => 'text-center align-middle'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '120px', 'className' => 'text-center align-middle']
        ];
    @endphp

    {{-- Datatable Scripts --}}
    <x-datatable.scripts
        tableId="moaTable"
        ajaxUrl="{{ route('berkas-MoA.getData') }}"
        :columns="$columnsConfig"
        searchId="searchMoa"
        perPageId="perPage"
    />

    {{-- Modal Hapus --}}
    <x-modal.hapus id="modalHapusMoa" title="Hapus Registrasi MoA" :isDynamic="true" />

    <style>
        .hover-bg-primary:hover { background-color: #0d6efd !important; color: white !important; }
        .hover-bg-warning:hover { background-color: #ffc107 !important; color: black !important; }
        .hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; }
        .transition-all { transition: all 0.2s ease-in-out; }
    </style>

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            $('#modalHapusMoaItemName').text(judul);
            // Pastikan route destroy-nya sudah terdaftar di web.php
            $('#modalHapusMoaForm').attr('action', '{{ route("berkas-MoA.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusMoa')).show();
        });
    </script>
</x-app-layout>
