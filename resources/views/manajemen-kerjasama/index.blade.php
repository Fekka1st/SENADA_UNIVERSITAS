<x-app-layout>
    <x-slot:title>Manajemen Kerja Sama</x-slot:title>

    {{-- Card Utama dengan Rounded Top sesuai request sebelumnya --}}
    <div class="card border-0 shadow-sm rounded-0 rounded-top-4 overflow-hidden">
        <div class="card-body p-4">
            <x-alert></x-alert>

            {{-- Action Bar: Penataan layout yang lebih bersih --}}
            <div class="mb-4">
                <x-datatable.filter-bar
                    searchId="searchKerjasama"
                    searchPlaceholder="Cari Kode Dokumen atau Judul..."
                    :hasDateFilter="true"
                    :hasExport="false">
                    <x-slot name="additionalButtons">
                        @permission('kerjasama.create')
                        <a href="{{ route('Manajemen-Kerjasama.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-3">
                            <i class="ti ti-plus fs-5"></i>
                            <span class="d-none d-md-inline fw-bold">Tambah Kerja Sama</span>
                        </a>
                        @endpermission
                    </x-slot>
                </x-datatable.filter-bar>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <x-datatable.per-page selectId="perPage" :default="10" />
                    
                </div>
                <div class="alert alert-info py-2 px-3 mb-0 border-0 rounded-3 d-flex align-items-center shadow-none" style="background-color: rgba(59, 130, 246, 0.08);">
                    <i class="ti ti-info-circle me-2 text-primary fs-5"></i>
                    <span class="small text-dark">Data yang tampil meliputi MoU, MoA, dan IA yang telah diinput operator.</span>
                </div>
            </div>

            {{-- Wrapper Tabel dengan Kolom yang lebih deskriptif --}}
            <div class="table-responsive">
                <x-datatable.wrapper
                    tableId="kerjasamaTable"
                    :columns="['No', 'Detail Dokumen', 'Mitra', 'Masa Berlaku', 'Tgl Upload', 'Status', 'Aksi']"
                    :hasCheckbox="false"
                />
            </div>
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center align-middle'],
            ['data' => 'dokumen_info', 'name' => 'kode_dokumen', 'className' => 'align-middle'],
            ['data' => 'mitra_nama', 'name' => 'mitra.nama_mitra', 'className' => 'align-middle'],
            ['data' => 'masa_berlaku', 'name' => 'tanggal_selesai', 'className' => 'text-center align-middle'],
            ['data' => 'tgl_upload', 'name' => 'created_at', 'className' => 'text-center align-middle'],
            ['data' => 'status_label', 'name' => 'status_kerjasama', 'className' => 'text-center align-middle'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '120px', 'className' => 'text-center align-middle']
        ];
    @endphp

    <x-datatable.scripts
        tableId="kerjasamaTable"
        ajaxUrl="{{ route('Manajemen-Kerjasama.getData') }}"
        :columns="$columnsConfig"
        searchId="searchKerjasama"
        perPageId="perPage"
    />

    {{-- Modal Hapus --}}
    <x-modal.hapus id="modalHapusKerjasama" title="Hapus Data Kerja Sama" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const nomor = $(this).data('nomor');
            $('#modalHapusKerjasamaItemName').html(`Dokumen: <strong>${nomor}</strong>`);
            $('#modalHapusKerjasamaForm').attr('action', '{{ route("Manajemen-Kerjasama.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusKerjasama')).show();
        });
    </script>
</x-app-layout>
