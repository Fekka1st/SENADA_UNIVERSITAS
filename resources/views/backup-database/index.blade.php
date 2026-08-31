<x-app-layout>
    <x-slot:title>Backup Database</x-slot:title>

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
                
                {{-- Tombol Proses Backup --}}
                <x-slot name="additionalButtons">
                    @permission('backup_database.create')
                    <button type="button" id="btnProsesBackup" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-database-export" id="backupIcon"></i>
                        <span id="backupText">Proses Backup</span>
                    </button>
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
                tableId="backupTable"
                :columns="[
                    'No',
                    'File',
                    'Waktu Backup',
                    'Ukuran',
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
            'data' => 'file',
            'name' => 'file',
            'className' => 'all',
            'responsivePriority' => 2
        ];
        
        $columnsConfig[] = [
            'data' => 'waktu_backup',
            'name' => 'waktu_backup'
        ];
        
        $columnsConfig[] = [
            'data' => 'ukuran',
            'name' => 'ukuran'
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
        tableId="backupTable"
        ajaxUrl="{{ route('backup-database.datatables') }}"
        :columns="$columnsConfig"
        :order="[[2, 'desc']]"
        :pageLength="10"
        searchId="customSearch"
        perPageId="perPage"
        :hasDateFilter="false"
        :hasExport="false"
    />

    {{-- Modal Hapus menggunakan komponen dengan mode dynamic --}}
    <x-modal.hapus 
        id="modalHapusBackup"
        title="Hapus Backup Database"
        :isDynamic="true"
    />

    {{-- Script untuk Backup dan Hapus --}}
    <script>
        $(document).ready(function() {
            // ========================================
            // PROSES BACKUP DATABASE
            // ========================================
            $('#btnProsesBackup').on('click', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const icon = $('#backupIcon');
                const text = $('#backupText');
                
                // Simpan state awal
                const originalIcon = icon.attr('class');
                const originalText = text.text();
                
                // Disable button dan tampilkan loading
                btn.prop('disabled', true);
                icon.removeClass().addClass('ti ti-loader-2 ti-spin');
                text.text('Memproses...');
                
                // Kirim request AJAX
                $.ajax({
                    url: '{{ route("backup-database.backup") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tampilkan notifikasi sukses
                            showNotification('success', response.message);
                            
                            // Reload tabel
                            $('#backupTable').DataTable().ajax.reload(null, false);
                        } else {
                            showNotification('error', response.message);
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat memproses backup database.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        showNotification('error', message);
                    },
                    complete: function() {
                        // Kembalikan button ke state semula
                        btn.prop('disabled', false);
                        icon.removeClass().addClass(originalIcon);
                        text.text(originalText);
                    }
                });
            });

            // ========================================
            // HAPUS BACKUP
            // ========================================
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const file = $(this).data('file');
                
                // Update modal content
                $('#modalHapusBackupItemName').text(file);
                
                // Update form action
                const deleteUrl = '{{ route("backup-database.destroy", ":file") }}'.replace(':file', encodeURIComponent(file));
                $('#modalHapusBackupForm').attr('action', deleteUrl);
                
                // Tidak ada warning relasi, langsung bisa hapus
                $('#modalHapusBackupWarningRelated').addClass('d-none');
                $('#modalHapusBackupWarningDelete').removeClass('d-none');
                $('#modalHapusBackupBtnSubmit').prop('disabled', false).removeClass('d-none');
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusBackup'));
                modal.show();
            });

            // ========================================
            // HELPER: SHOW NOTIFICATION
            // ========================================
            function showNotification(type, message) {
                // Buat alert element
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'ti-check' : 'ti-alert-circle';
                
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="ti ${iconClass} fs-5 me-2"></i>
                        <div>${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                // Hapus alert lama jika ada di dalam card-body
                $('.card .card-body > .alert').remove();
                
                // Tambahkan alert baru setelah x-alert component di dalam card-body
                $('.card .card-body').find('x-alert, .alert').first().remove();
                $('.card .card-body').prepend(alertHtml);
                
                // Auto dismiss setelah 5 detik
                setTimeout(function() {
                    $('.card .card-body > .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // ========================================
            // INITIALIZE TOOLTIPS
            // ========================================
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips after DataTables draw
            $('#backupTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            });
        });
    </script>

</x-app-layout>
