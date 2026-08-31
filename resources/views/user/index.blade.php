<x-app-layout>
    <x-slot:title>Manajemen User</x-slot:title>

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
                    @permission('user.create')
                    <a href="{{ route('user.create') }}" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-plus"></i>Tambah User
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
                tableId="userTable"
                :columns="[
                    'No',
                    'Foto',
                    'Nama User',
                    'Username',
                    'Role',
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
            'data' => 'foto',
            'name' => 'foto',
            'orderable' => false,
            'searchable' => false,
            'width' => '60px',
            'className' => 'text-center'
        ];
        
        $columnsConfig[] = [
            'data' => 'nama_user',
            'name' => 'nama_user',
            'className' => 'all',
            'responsivePriority' => 2
        ];
        
        $columnsConfig[] = [
            'data' => 'username',
            'name' => 'username'
        ];
        
        $columnsConfig[] = [
            'data' => 'role_nama',
            'name' => 'roleModel.nama'
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
        tableId="userTable"
        ajaxUrl="{{ route('user.datatables') }}"
        :columns="$columnsConfig"
        :order="[[2, 'asc']]"
        :pageLength="10"
        searchId="customSearch"
        perPageId="perPage"
        :hasDateFilter="false"
        :hasExport="false"
    />

    {{-- Modal Hapus menggunakan komponen dengan mode dynamic --}}
    <x-modal.hapus 
        id="modalHapusUser"
        title="Hapus User"
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
                const isSelf = $(this).data('self') === true || $(this).data('self') === 'true';
                
                // Update modal content
                $('#modalHapusUserItemName').text(nama);
                
                // Update form action
                const deleteUrl = '{{ route("user.destroy", ":id") }}'.replace(':id', id);
                $('#modalHapusUserForm').attr('action', deleteUrl);
                
                // Show/hide warning based on conditions
                if (isSelf) {
                    // User mencoba menghapus akunnya sendiri
                    $('#modalHapusUserWarningDelete').addClass('d-none');
                    
                    // Tampilkan warning khusus untuk self-delete
                    let selfWarning = $('#modalHapusUserWarningSelf');
                    if (selfWarning.length === 0) {
                        // Buat elemen warning jika belum ada
                        selfWarning = $('<div id="modalHapusUserWarningSelf" class="alert alert-danger d-flex align-items-center mb-0" role="alert">' +
                            '<i class="ti ti-alert-triangle fs-5 me-2"></i>' +
                            '<div>Anda tidak dapat menghapus akun Anda sendiri.</div>' +
                            '</div>');
                        $('#modalHapusUserWarningDelete').parent().append(selfWarning);
                    } else {
                        selfWarning.removeClass('d-none');
                    }
                    
                    $('#modalHapusUserBtnSubmit').prop('disabled', true).addClass('d-none');
                } else {
                    // Aman untuk dihapus
                    $('#modalHapusUserWarningDelete').removeClass('d-none');
                    if ($('#modalHapusUserWarningSelf').length) {
                        $('#modalHapusUserWarningSelf').addClass('d-none');
                    }
                    $('#modalHapusUserBtnSubmit').prop('disabled', false).removeClass('d-none');
                }
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusUser'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips after DataTables draw
            $('#userTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>

</x-app-layout>
