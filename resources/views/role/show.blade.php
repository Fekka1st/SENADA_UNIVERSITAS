<x-app-layout>
    <x-slot:title>Manajemen Role</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">

            {{-- tampilkan detail data --}}
            <div class="border rounded mb-4 overflow-hidden">
                <div class="bg-light p-3 border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="ti ti-info-circle me-2"></i>Informasi Role
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle text-nowrap mb-0">
                        <tr>
                            <td width="200" class="fw-bold">Nama Role</td>
                            <td width="10">:</td>
                            <td>{{ $role->nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah User</td>
                            <td>:</td>
                            <td>{{ $role->user->count() }} User</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Permission</td>
                            <td>:</td>
                            <td>{{ $role->permissions->count() }} Permission</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dibuat Pada</td>
                            <td>:</td>
                            <td>{{ $role->created_at ? $role->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diperbarui Pada</td>
                            <td>:</td>
                            <td>{{ $role->updated_at ? $role->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>



            {{-- Tampilkan permissions yang dimiliki role --}}
            @if ($allPermissions->count() > 0)
                <div class="mb-4">
                    <div class="card border overflow-hidden">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="ti ti-shield-check me-2"></i>Akses Sistem untuk Role: {{ $role->nama }}
                                </h6>
                                <div class="d-flex align-items-center gap-3">
                                    <small class="text-muted">
                                        <i class="ti ti-circle text-success me-1"></i>Memiliki Akses
                                    </small>
                                    <small class="text-muted">
                                        <i class="ti ti-circle text-danger me-1"></i>Tidak Memiliki Akses
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row g-3">
                                @php
                                    // Urutan modul agar konsisten dengan halaman create/edit
                                    $moduleOrder = [
                                        'dashboard',
                                        'role',
                                        'user',
                                        'pengaturan',
                                        'profile',
                                        'backup_database',
                                    ];
                                    $sortedAllPermissions = collect($allPermissions)->sortBy(function (
                                        $value,
                                        $key,
                                    ) use ($moduleOrder) {
                                        $idx = array_search($key, $moduleOrder, true);
                                        return $idx === false ? PHP_INT_MAX : $idx;
                                    });
                                @endphp
                                @foreach ($sortedAllPermissions as $module => $modulePermissions)
                                    @php
                                        // Hitung permission yang dimiliki di module ini
                                        $ownedCount = $modulePermissions->whereIn('id', $rolePermissionIds)->count();
                                        $totalCount = $modulePermissions->count();
                                    @endphp
                                    <div class="col-lg-6 col-xl-4">
                                        <div class="permission-module-card-show h-100">
                                            {{-- Module Header --}}
                                            <div class="module-header-show">
                                                <div class="module-title-show">
                                                    @php
                                                        $moduleIcons = [
                                                            'dashboard' => 'ti ti-layout-dashboard',
                                                            'role' => 'ti ti-shield',
                                                            'user' => 'ti ti-user-plus',
                                                            'pengaturan' => 'ti ti-home-cog',
                                                            'profile' => 'ti ti-user-circle',
                                                            'backup_database' => 'ti ti-database-export',
                                                        ];
                                                        $moduleNames = [
                                                            'dashboard' => 'Dashboard',
                                                            'role' => 'Role',
                                                            'user' => 'User',
                                                            'pengaturan' => 'Pengaturan',
                                                            'profile' => 'Profile',
                                                            'backup_database' => 'Backup Database',
                                                        ];
                                                        $icon = $moduleIcons[$module] ?? 'ti ti-folder';
                                                        $displayName =
                                                            $moduleNames[$module] ??
                                                            ucfirst(str_replace('_', ' ', $module));

                                                        // Tentukan warna badge berdasarkan permission yang dimiliki
                                                        if ($ownedCount == 0) {
                                                            $badgeClass = 'bg-danger';
                                                        } elseif ($ownedCount == $totalCount) {
                                                            $badgeClass = 'bg-success';
                                                        } else {
                                                            $badgeClass = 'bg-warning';
                                                        }
                                                    @endphp
                                                    <div class="d-flex align-items-center">
                                                        <i class="{{ $icon }} me-2 text-primary"></i>
                                                        <strong>{{ $displayName }}</strong>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span
                                                            class="badge {{ $badgeClass }}">{{ $ownedCount }}/{{ $totalCount }}</span>
                                                        @if ($ownedCount == $totalCount)
                                                            <i class="ti ti-check-circle text-success"
                                                                title="Semua permission aktif"></i>
                                                        @elseif($ownedCount > 0)
                                                            <i class="ti ti-clock text-warning"
                                                                title="Sebagian permission aktif"></i>
                                                        @else
                                                            <i class="ti ti-x-circle text-danger"
                                                                title="Tidak ada permission aktif"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Module Permissions --}}
                                            <div class="module-permissions-show">
                                                @foreach ($modulePermissions as $permission)
                                                    @php
                                                        $isBasePermission =
                                                            str_ends_with($permission->name, '.view') ||
                                                            $permission->name === 'dashboard.view';
                                                        $hasPermission = in_array($permission->id, $rolePermissionIds);
                                                    @endphp

                                                    <div
                                                        class="permission-item-show {{ $isBasePermission ? 'base-permission-show' : '' }} {{ $hasPermission ? 'permission-active' : 'permission-inactive' }}">
                                                        <div class="permission-status-icon">
                                                            @if ($hasPermission)
                                                                <i class="ti ti-check-circle text-success me-2"></i>
                                                            @else
                                                                <i class="ti ti-x-circle text-danger me-2"></i>
                                                            @endif
                                                        </div>

                                                        <div class="permission-action-icon">
                                                            @if ($isBasePermission)
                                                                <i class="ti ti-eye me-2 text-primary"></i>
                                                            @elseif(str_contains($permission->name, 'import'))
                                                                <i class="ti ti-upload me-2 text-secondary"></i>
                                                            @elseif(str_contains($permission->name, 'export'))
                                                                <i class="ti ti-file-spreadsheet me-2 text-success"></i>
                                                            @elseif(str_contains($permission->name, 'password.change'))
                                                                <i class="ti ti-lock me-2"></i>
                                                            @elseif(str_contains($permission->name, 'create'))
                                                                <i class="ti ti-plus me-2 text-primary"></i>
                                                            @elseif(str_contains($permission->name, 'edit') || str_contains($permission->name, 'change'))
                                                                <i class="ti ti-edit me-2 text-warning"></i>
                                                            @elseif(str_contains($permission->name, 'delete'))
                                                                <i class="ti ti-trash me-2 text-danger"></i>
                                                            @else
                                                                <i class="ti ti-check me-2 text-muted"></i>
                                                            @endif
                                                        </div>

                                                        <span
                                                            class="permission-text">{{ $permission->display_name }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Tampilkan users yang menggunakan role ini --}}
            @if ($role->user->count() > 0)
                <div class="border rounded mb-4 overflow-hidden">
                    <div class="bg-light p-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="ti ti-users me-2"></i>Users dengan Role Ini
                        </h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama User</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($role->user as $user)
                                    <tr>
                                        <td width="50">{{ $loop->iteration }}</td>
                                        <td width="50">
                                            <img src="{{ safe_image_url($user->foto, 'foto_user', 'images/avatar.png') }}"
                                                alt="Foto {{ $user->nama_user }}" class="rounded-circle me-2"
                                                width="32" height="32" style="object-fit: cover;">
                                        </td>
                                        <td>{{ $user->nama_user }}</td>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Gunakan komponen page-action-buttons yang sudah dioptimalkan --}}
            <x-page-action-buttons route="role" :showEditButton="true" :showDeleteButton="true" :editRoute="route('role.edit', $role->id)"
                editPermission="role.edit" deletePermission="role.delete" deleteModalTarget="#modalHapus" />
        </div>
    </div>

    {{-- Modal Hapus --}}
    @permission('role.delete')
        <x-modal.hapus id="modalHapus" title="Hapus Role" itemName="{{ $role->nama }}"
            deleteRoute="{{ route('role.destroy', $role->id) }}" :relatedCount="$role->user->count()" relatedType="user" />
    @endpermission

    <style>
        /* Permission Module Cards for Show */
        .permission-module-card-show {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            background: #ffffff;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .permission-module-card-show:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
        }

        .module-header-show {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .module-title-show {
            font-size: 0.9rem;
            color: #495057;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .module-permissions-show {
            padding: 12px 15px;
            max-height: 280px;
            overflow-y: auto;
        }

        .permission-item-show {
            margin-bottom: 8px;
            padding: 6px 8px;
            border-radius: 4px;
            transition: background-color 0.15s ease;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
        }

        .permission-item-show:hover {
            background-color: #f8f9fa;
        }

        .permission-item-show.base-permission-show {
            border-left: 3px solid #28a745;
            font-weight: 500;
        }

        /* Permission Status Styling */
        .permission-item-show.permission-active {
            background: linear-gradient(90deg, #e8f5e8 0%, #f8f9fa 100%);
            border-left: 3px solid #28a745;
        }

        .permission-item-show.permission-inactive {
            background: linear-gradient(90deg, #ffeaea 0%, #f8f9fa 100%);
            border-left: 3px solid #dc3545;
            opacity: 0.7;
        }

        .permission-status-icon {
            min-width: 20px;
        }

        .permission-action-icon {
            min-width: 20px;
        }

        .permission-text {
            flex: 1;
        }

        /* Module badge styling */
        .badge.bg-success {
            background-color: #28a745 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #212529 !important;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .module-permissions-show {
                max-height: none;
            }
        }
    </style>

</x-app-layout>
