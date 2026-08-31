<x-app-layout>
    <x-slot:title>Notifikasi</x-slot:title>

    <div class="card">
        <div class="card-body">
            {{-- Alert Messages --}}
            <x-alert></x-alert>

            {{-- Filter Bar --}}
            <x-datatable.filter-bar
                searchId="customSearch"
                searchPlaceholder="Pencarian..."
                :hasDateFilter="false"
                :hasExport="false"
            >
                <x-slot:additionalButtons>
                    <button type="button" class="btn btn-secondary d-flex align-items-center gap-1" 
                        id="notif-sound-toggle-index" 
                        title="Toggle suara notifikasi">
                        <i class="ti ti-volume"></i>
                        <span>Suara</span>
                    </button>

                    <button type="button" class="btn btn-success d-flex align-items-center gap-1" 
                        onclick="tandaiSemuaSudahDibaca()">
                        <i class="ti ti-checks"></i>
                        <span>Tandai Semua Dibaca</span>
                    </button>
                    
                    <button type="button" class="btn btn-danger d-flex align-items-center gap-1" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalHapusSudahDibaca">
                        <i class="ti ti-trash"></i>
                        <span>Hapus Sudah Dibaca</span>
                    </button>
                </x-slot:additionalButtons>
            </x-datatable.filter-bar>

            {{-- Per Page & Filter Status (Sejajar) --}}
            <div class="row mb-3">
                {{-- Per Page Selector --}}
                <div class="col-12 col-md-6 mb-2 mb-md-0">
                    <div class="d-flex align-items-center gap-2">
                        <label for="perPage" class="form-label mb-0">Tampilkan</label>
                        <select id="perPage" class="form-select form-select-sm" style="width: 70px;">
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span class="mb-0">data per halaman</span>
                    </div>
                </div>

                {{-- Filter Status --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center gap-2 justify-content-md-end">
                        <label for="filterStatus" class="form-label mb-0 text-nowrap">Filter Status:</label>
                        <select id="filterStatus" class="form-select form-select-sm" style="width: 130px;">
                            <option value="">Semua Status</option>
                            <option value="belum_dibaca">Belum Dibaca</option>
                            <option value="sudah_dibaca">Sudah Dibaca</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- DataTable Wrapper --}}
            <x-datatable.wrapper
                tableId="notifikasiTable"
                :columns="[
                    'No',
                    'Ikon',
                    'Judul',
                    'Pesan',
                    'Waktu',
                    'Status',
                    'Aksi'
                ]"
                :hasCheckbox="false"
            />
        </div>
    </div>

    {{-- Modal Hapus Notifikasi Individual --}}
    <x-modal.hapus 
        id="modalHapusNotifikasi" 
        title="Hapus Notifikasi" 
        :isDynamic="true"
    />

    {{-- Modal Hapus Semua Sudah Dibaca --}}
    <x-modal.hapus 
        id="modalHapusSudahDibaca" 
        title="Hapus Semua Notifikasi yang Sudah Dibaca" 
        itemName="semua notifikasi yang sudah dibaca"
        :isDynamic="true"
    />

    @php
        // Build columns configuration
        $columnsConfig = [
            [
                'data' => 'DT_RowIndex',
                'name' => 'DT_RowIndex',
                'orderable' => false,
                'searchable' => false,
                'width' => '10px',
                'className' => 'text-center all',
                'responsivePriority' => 1
            ],
            [
                'data' => 'icon_display',
                'name' => 'icon_display',
                'orderable' => false,
                'searchable' => false,
                'width' => '48px',
                'className' => 'text-center'
            ],
            [
                'data' => 'judul_display',
                'name' => 'judul_display',
                'className' => 'all',
                'responsivePriority' => 2
            ],
            [
                'data' => 'pesan_display',
                'name' => 'pesan_display',
                'orderable' => false
            ],
            [
                'data' => 'waktu_display',
                'name' => 'waktu_display',
                'width' => '160px'
            ],
            [
                'data' => 'status_badge',
                'name' => 'status_badge',
                'orderable' => false,
                'searchable' => false,
                'width' => '120px',
                'className' => 'text-center'
            ],
            [
                'data' => 'action',
                'name' => 'action',
                'orderable' => false,
                'searchable' => false,
                'width' => '150px'
            ]
        ];
    @endphp

    {{-- DataTable Scripts Component --}}
    <x-datatable.scripts
        tableId="notifikasiTable"
        ajaxUrl="{{ route('notifikasi.datatables') }}"
        :columns="$columnsConfig"
        :order="[[4, 'desc']]"
        :pageLength="10"
        searchId="customSearch"
        perPageId="perPage"
        :hasDateFilter="false"
        :hasExport="false"
    >
        {{-- Custom Scripts for Filter Status & Row Styling --}}
        <x-slot:customScripts>
            // Handle filter status
            let selectedStatus = '';
            
            // Pastikan element ada sebelum attach event handler
            const filterStatusElement = document.getElementById('filterStatus');
            if (filterStatusElement) {
                $(filterStatusElement).on('change', function() {
                    selectedStatus = $(this).val();
                    
                    // Update ajax data
                    if (table && table.settings) {
                        table.settings()[0].ajax.data = function(d) {
                            d.status = selectedStatus;
                        };
                        
                        table.ajax.reload();
                    }
                });
            }

            // Add custom row classes based on read status and add data attributes
            if (table) {
                table.on('draw.dt', function() {
                    $('#notifikasiTable tbody tr').each(function() {
                        const rowData = table.row(this).data();
                        if (rowData) {
                            // Add table-light class for unread notifications
                            if (rowData.is_read === '0') {
                                $(this).addClass('table-light');
                            } else {
                                $(this).removeClass('table-light');
                            }
                            
                            // Add data attributes for easier manipulation
                            $(this).attr('data-notif-id', rowData.id || '');
                            $(this).attr('data-read', rowData.is_read || '0');
                        }
                    });
                });
            }
        </x-slot:customScripts>
    </x-datatable.scripts>

    {{-- Custom JavaScript for Notification Actions --}}
    <script>
        const NOTIF_BASE = (window.NOTIF_URLS && window.NOTIF_URLS.base) || window.NOTIF_BASE || '{{ url('/notifikasi') }}';
        
        // Mute/unmute control sinkron dengan navbar
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('notif-sound-toggle-index');
            if (!btn) return;
            
            const setIcon = () => {
                const enabled = (window.isNotifSoundEnabled ? window.isNotifSoundEnabled() : true);
                btn.querySelector('i').className = `ti ${enabled ? 'ti-volume' : 'ti-volume-off'}`;
                btn.classList.toggle('btn-secondary', enabled);
                btn.classList.toggle('btn-danger', !enabled);
            };
            
            setIcon();
            
            btn.addEventListener('click', function() {
                const enabled = (window.isNotifSoundEnabled ? window.isNotifSoundEnabled() : true);
                if (window.setNotifSoundEnabled) window.setNotifSoundEnabled(!enabled);
                setIcon();
            });
        });

        function tandaiSudahDibaca(id) {
            fetch(`${NOTIF_BASE}/${id}/tandai-dibaca`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Reload table to reflect changes (keep current page)
                if (typeof table !== 'undefined' && table && table.ajax) {
                    table.ajax.reload(null, false);
                }
                
                // Update notification count
                if (typeof updateNotificationCount === 'function') {
                    try { 
                        updateNotificationCount(); 
                    } catch (e) {
                        console.error('Error updating notification count:', e);
                    }
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
                // Tetap reload table karena sebenarnya sudah berhasil di server
                if (typeof table !== 'undefined' && table && table.ajax) {
                    table.ajax.reload(null, false);
                }
                
                // Update notification count
                if (typeof updateNotificationCount === 'function') {
                    try { 
                        updateNotificationCount(); 
                    } catch (e) {
                        console.error('Error updating notification count:', e);
                    }
                }
            });
        }

        function tandaiSemuaSudahDibaca() {
            // Langsung aksi tanpa konfirmasi
            fetch(`${NOTIF_BASE}/tandai-semua-dibaca`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => { 
                if (data.success) {
                    // Reload table to reflect changes
                    if (typeof table !== 'undefined' && table && table.ajax) {
                        table.ajax.reload();
                    }
                    
                    // Update notification count
                    if (typeof updateNotificationCount === 'function') {
                        try { 
                            updateNotificationCount(); 
                        } catch (e) {
                            console.error('Error updating notification count:', e);
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
                alert('Gagal menandai semua notifikasi sebagai dibaca.');
            });
        }

        // Setup modal hapus notifikasi individual
        function setupModalHapusNotifikasi(id, itemName) {
            const form = document.getElementById('modalHapusNotifikasiForm');
            const itemNameSpan = document.getElementById('modalHapusNotifikasiItemName');
            
            if (form && itemNameSpan) {
                form.action = `${NOTIF_BASE}/${id}`;
                itemNameSpan.textContent = itemName;
            }
        }

        // Handle submit modal hapus notifikasi individual
        document.addEventListener('DOMContentLoaded', function() {
            // Handle modal hapus individual
            const modalForm = document.getElementById('modalHapusNotifikasiForm');
            if (modalForm) {
                modalForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formAction = this.action;
                    
                    fetch(formAction, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Tutup modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalHapusNotifikasi'));
                        if (modal) {
                            modal.hide();
                        }
                        
                        // Reload table
                        if (typeof table !== 'undefined' && table && table.ajax) {
                            table.ajax.reload(null, false);
                        }
                        
                        // Update notification count
                        if (typeof updateNotificationCount === 'function') {
                            try { 
                                updateNotificationCount(); 
                            } catch (e) {
                                console.error('Error updating notification count:', e);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting notification:', error);
                        alert('Gagal menghapus notifikasi.');
                    });
                });
            }

            // Handle modal hapus semua sudah dibaca
            const modalFormSudahDibaca = document.getElementById('modalHapusSudahDibacaForm');
            if (modalFormSudahDibaca) {
                modalFormSudahDibaca.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const URL_HAPUS_SUDAH = (window.NOTIF_URLS && window.NOTIF_URLS.hapusSudahDibaca) || `${NOTIF_BASE}/hapus-sudah-dibaca`;
                    
                    fetch(URL_HAPUS_SUDAH, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Tutup modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalHapusSudahDibaca'));
                            if (modal) {
                                modal.hide();
                            }
                            
                            // Reload table
                            if (typeof table !== 'undefined' && table && table.ajax) {
                                table.ajax.reload();
                            }
                            
                            // Update notification count
                            if (typeof updateNotificationCount === 'function') {
                                try { 
                                    updateNotificationCount(); 
                                } catch (e) {
                                    console.error('Error updating notification count:', e);
                                }
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting read notifications:', error);
                        alert('Gagal menghapus notifikasi yang sudah dibaca.');
                    });
                });
            }
        });
    </script>
</x-app-layout>
