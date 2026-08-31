<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> Manajemen Role <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Detail <?php $__env->endSlot(); ?>

    <div class="card">
        <div class="card-body">

            
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
                            <td><?php echo e($role->nama); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah User</td>
                            <td>:</td>
                            <td><?php echo e($role->user->count()); ?> User</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Jumlah Permission</td>
                            <td>:</td>
                            <td><?php echo e($role->permissions->count()); ?> Permission</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dibuat Pada</td>
                            <td>:</td>
                            <td><?php echo e($role->created_at ? $role->created_at->format('d/m/Y H:i:s') : '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Diperbarui Pada</td>
                            <td>:</td>
                            <td><?php echo e($role->updated_at ? $role->updated_at->format('d/m/Y H:i:s') : '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>



            
            <?php if($allPermissions->count() > 0): ?>
                <div class="mb-4">
                    <div class="card border overflow-hidden">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-bold text-primary">
                                    <i class="ti ti-shield-check me-2"></i>Akses Sistem untuk Role: <?php echo e($role->nama); ?>

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
                                <?php
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
                                ?>
                                <?php $__currentLoopData = $sortedAllPermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        // Hitung permission yang dimiliki di module ini
                                        $ownedCount = $modulePermissions->whereIn('id', $rolePermissionIds)->count();
                                        $totalCount = $modulePermissions->count();
                                    ?>
                                    <div class="col-lg-6 col-xl-4">
                                        <div class="permission-module-card-show h-100">
                                            
                                            <div class="module-header-show">
                                                <div class="module-title-show">
                                                    <?php
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
                                                    ?>
                                                    <div class="d-flex align-items-center">
                                                        <i class="<?php echo e($icon); ?> me-2 text-primary"></i>
                                                        <strong><?php echo e($displayName); ?></strong>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-1">
                                                        <span
                                                            class="badge <?php echo e($badgeClass); ?>"><?php echo e($ownedCount); ?>/<?php echo e($totalCount); ?></span>
                                                        <?php if($ownedCount == $totalCount): ?>
                                                            <i class="ti ti-check-circle text-success"
                                                                title="Semua permission aktif"></i>
                                                        <?php elseif($ownedCount > 0): ?>
                                                            <i class="ti ti-clock text-warning"
                                                                title="Sebagian permission aktif"></i>
                                                        <?php else: ?>
                                                            <i class="ti ti-x-circle text-danger"
                                                                title="Tidak ada permission aktif"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                            <div class="module-permissions-show">
                                                <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $isBasePermission =
                                                            str_ends_with($permission->name, '.view') ||
                                                            $permission->name === 'dashboard.view';
                                                        $hasPermission = in_array($permission->id, $rolePermissionIds);
                                                    ?>

                                                    <div
                                                        class="permission-item-show <?php echo e($isBasePermission ? 'base-permission-show' : ''); ?> <?php echo e($hasPermission ? 'permission-active' : 'permission-inactive'); ?>">
                                                        <div class="permission-status-icon">
                                                            <?php if($hasPermission): ?>
                                                                <i class="ti ti-check-circle text-success me-2"></i>
                                                            <?php else: ?>
                                                                <i class="ti ti-x-circle text-danger me-2"></i>
                                                            <?php endif; ?>
                                                        </div>

                                                        <div class="permission-action-icon">
                                                            <?php if($isBasePermission): ?>
                                                                <i class="ti ti-eye me-2 text-primary"></i>
                                                            <?php elseif(str_contains($permission->name, 'import')): ?>
                                                                <i class="ti ti-upload me-2 text-secondary"></i>
                                                            <?php elseif(str_contains($permission->name, 'export')): ?>
                                                                <i class="ti ti-file-spreadsheet me-2 text-success"></i>
                                                            <?php elseif(str_contains($permission->name, 'password.change')): ?>
                                                                <i class="ti ti-lock me-2"></i>
                                                            <?php elseif(str_contains($permission->name, 'create')): ?>
                                                                <i class="ti ti-plus me-2 text-primary"></i>
                                                            <?php elseif(str_contains($permission->name, 'edit') || str_contains($permission->name, 'change')): ?>
                                                                <i class="ti ti-edit me-2 text-warning"></i>
                                                            <?php elseif(str_contains($permission->name, 'delete')): ?>
                                                                <i class="ti ti-trash me-2 text-danger"></i>
                                                            <?php else: ?>
                                                                <i class="ti ti-check me-2 text-muted"></i>
                                                            <?php endif; ?>
                                                        </div>

                                                        <span
                                                            class="permission-text"><?php echo e($permission->display_name); ?></span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($role->user->count() > 0): ?>
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
                                <?php $__currentLoopData = $role->user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td width="50"><?php echo e($loop->iteration); ?></td>
                                        <td width="50">
                                            <img src="<?php echo e(safe_image_url($user->foto, 'foto_user', 'images/avatar.png')); ?>"
                                                alt="Foto <?php echo e($user->nama_user); ?>" class="rounded-circle me-2"
                                                width="32" height="32" style="object-fit: cover;">
                                        </td>
                                        <td><?php echo e($user->nama_user); ?></td>
                                        <td><?php echo e($user->username); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal2720027075619929b6f895eb46dac441 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2720027075619929b6f895eb46dac441 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-action-buttons','data' => ['route' => 'role','showEditButton' => true,'showDeleteButton' => true,'editRoute' => route('role.edit', $role->id),'editPermission' => 'role.edit','deletePermission' => 'role.delete','deleteModalTarget' => '#modalHapus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-action-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'role','showEditButton' => true,'showDeleteButton' => true,'editRoute' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('role.edit', $role->id)),'editPermission' => 'role.edit','deletePermission' => 'role.delete','deleteModalTarget' => '#modalHapus']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2720027075619929b6f895eb46dac441)): ?>
<?php $attributes = $__attributesOriginal2720027075619929b6f895eb46dac441; ?>
<?php unset($__attributesOriginal2720027075619929b6f895eb46dac441); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2720027075619929b6f895eb46dac441)): ?>
<?php $component = $__componentOriginal2720027075619929b6f895eb46dac441; ?>
<?php unset($__componentOriginal2720027075619929b6f895eb46dac441); ?>
<?php endif; ?>
        </div>
    </div>

    
    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'role.delete')): ?>
        <?php if (isset($component)) { $__componentOriginal9bb3a892d945664f458b28dbbf2a402e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.hapus','data' => ['id' => 'modalHapus','title' => 'Hapus Role','itemName' => ''.e($role->nama).'','deleteRoute' => ''.e(route('role.destroy', $role->id)).'','relatedCount' => $role->user->count(),'relatedType' => 'user']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.hapus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modalHapus','title' => 'Hapus Role','itemName' => ''.e($role->nama).'','deleteRoute' => ''.e(route('role.destroy', $role->id)).'','relatedCount' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($role->user->count()),'relatedType' => 'user']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $attributes = $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $component = $__componentOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>
    <?php endif; ?>

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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/role/show.blade.php ENDPATH**/ ?>