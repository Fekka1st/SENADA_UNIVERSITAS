<x-app-layout>
    <x-slot:title>Repository Kerja Sama {{ Auth::user()->fakultas->nama_fakultas ?? 'Universitas' }}</x-slot:title>

    <div class="card border-0 shadow-sm rounded-0 rounded-top-4 overflow-hidden">
        <div class="card-body p-4">
            <x-alert></x-alert>

            {{-- Action Bar --}}
            <div class="mb-4">
                <x-datatable.filter-bar
                    searchId="searchRepository"
                    searchPlaceholder="Cari Judul atau Nomor Dokumen..."
                    :hasDateFilter="false"
                    :hasExport="false">
                    <x-slot name="additionalButtons">
                        @permission('repository.create')
                        <a href="{{ route('Repository_kerjasama.create') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-3">
                            <i class="ti ti-plus fs-5"></i>
                            <span class="d-none d-md-inline fw-bold">Tambah Repository</span>
                        </a>
                        @endpermission
                    </x-slot>
                </x-datatable.filter-bar>
            </div>

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <x-datatable.per-page selectId="perPage" :default="10" />
                </div>
                <div class="alert alert-primary py-2 px-3 mb-0 border-0 rounded-3 d-flex align-items-center shadow-none" style="background-color: rgba(93, 135, 255, 0.08);">
                    <i class="ti ti-database me-2 text-primary fs-5"></i>
                    <span class="small text-dark">Menampilkan seluruh arsip dokumen kerjasama dan rincian kegiatannya.</span>
                </div>
            </div>

            <div class="table-responsive">
                <x-datatable.wrapper
                    tableId="repositoryTable"
                    :columns="['No', 'Dokumen', 'Penanggung Jawab (Mitra)', 'Masa Berlaku', 'Nilai Kontrak', 'Status', 'Aksi']"
                    :hasCheckbox="false"
                />
            </div>
        </div>
    </div>

    @php
        $columnsConfig = [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center align-middle'],
            ['data' => 'dokumen_info', 'name' => 'judul_kerjasama', 'className' => 'align-middle'],
            ['data' => 'pj_info', 'name' => 'pihakTerlibat.nama_penandatangan', 'className' => 'align-middle'],
            ['data' => 'masa_berlaku', 'name' => 'tanggal_berakhir', 'className' => 'text-center align-middle'],
            ['data' => 'nilai_kontrak', 'name' => 'bentukKegiatan.nilai_kontrak', 'className' => 'text-end align-middle'],
            ['data' => 'status_label', 'name' => 'status', 'className' => 'text-center align-middle'],
            ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '120px', 'className' => 'text-center align-middle']
        ];
    @endphp

    <x-datatable.scripts
        tableId="repositoryTable"
        ajaxUrl="{{ route('Repository_kerjasama.getData') }}"
        :columns="$columnsConfig"
        searchId="searchRepository"
        perPageId="perPage"
    />

    <x-modal.hapus id="modalHapusRepo" title="Hapus Data Repository" :isDynamic="true" />

    <script>
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const judul = $(this).data('judul');
            $('#modalHapusRepoItemName').html(`Arsip: <strong>${judul}</strong>`);
            $('#modalHapusRepoForm').attr('action', '{{ route("Repository_kerjasama.destroy", ":id") }}'.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusRepo')).show();
        });
    </script>
</x-app-layout>
