<x-app-layout>
    <x-slot:title>Manajemen Role</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian..."
                :hasDateFilter="false"
                :hasExport="false">

                {{-- Tombol Tambah --}}
                <x-slot name="additionalButtons">
                    @permission('role.create')
                    <a href="{{ route('role.create') }}" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-plus"></i>Tambah Role
                    </a>
                    @endpermission
                </x-slot>
            </x-datatable.filter-bar>

            {{-- Per Page Selector --}}
            <x-datatable.per-page
                selectId="perPage"
                :options="[5, 10, 25, 50, 100]"
                :default="10"
            />

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="roleTable"
                :columns="[
                    'No',
                    'Nama Role',
                    'Aksi'
                ]"
                :hasCheckbox="false"
            />
        </div>
    </div>

    @php
        // Build columns configuration
        $columnsConfig = [];

        $columnsConfig[] = [
            'data' => 'DT_RowIndex',
            'name' => 'DT_RowIndex',
            'orderable' => false,
            'searchable' => false,
            'width' => '50px',
            'className' => 'text-center all',
            'responsivePriority' => 1
        ];

        $columnsConfig[] = [
            'data' => 'nama',
            'name' => 'nama',
            'className' => 'all',
            'responsivePriority' => 2
        ];

        $columnsConfig[] = [
            'data' => 'aksi',
            'name' => 'aksi',
            'orderable' => false,
            'searchable' => false,
            'width' => '100px'
        ];
    @endphp

    {{-- DataTable Scripts Component --}}
    <x-datatable.scripts
        tableId="roleTable"
        ajaxUrl="{{ route('role.datatables') }}"
        :columns="$columnsConfig"
        :order="[[1, 'asc']]"
        :pageLength="10"
        searchId="customSearch"
        perPageId="perPage"
        :hasDateFilter="false"
        :hasExport="false"
    />

    {{-- Modal Hapus menggunakan komponen dengan mode dynamic --}}
    <x-modal.hapus
        id="modalHapusRole"
        title="Hapus Role"
        relatedType="user"
        :isDynamic="true"
    />

    {{-- Script untuk Hapus --}}
    <script>
        $(document).ready(function() {
            // Handle click pada tombol delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const count = parseInt($(this).data('count'));

                // Update modal content
                $('#modalHapusRoleItemName').text(nama);

                // Update form action
                const deleteUrl = '{{ route("role.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusRoleForm').attr('action', deleteUrl);

                // Show/hide warning and button based on related count
                if (count > 0) {
                    $('#modalHapusRoleRelatedCount').text(count);
                    $('#modalHapusRoleWarningRelated').removeClass('d-none');
                    $('#modalHapusRoleWarningDelete').addClass('d-none');
                    $('#modalHapusRoleBtnSubmit').prop('disabled', true).addClass('d-none');
                } else {
                    $('#modalHapusRoleWarningRelated').addClass('d-none');
                    $('#modalHapusRoleWarningDelete').removeClass('d-none');
                    $('#modalHapusRoleBtnSubmit').prop('disabled', false).removeClass('d-none');
                }

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusRole'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips after DataTables draw
            $('#roleTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>

</x-app-layout>
