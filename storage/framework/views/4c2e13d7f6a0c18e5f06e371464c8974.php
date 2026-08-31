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
     <?php $__env->slot('breadcrumb', null, []); ?> Tambah <?php $__env->endSlot(); ?>

    <div class="card">
        <div class="card-body">

            
            <form action="<?php echo e(route('role.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div>
                        <div class="mb-3">
                            <label class="form-label">Nama Role <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama')); ?>" autocomplete="off">

                            
                            <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="ti ti-shield-check me-2"></i>Permissions 
                                <small class="text-muted">(Pilih akses yang diizinkan untuk role ini)</small>
                            </label>
                            
                            
                            <div class="alert alert-info py-2 mb-3">
                                <small>
                                    <i class="ti ti-info-circle me-1"></i>
                                    <strong>Tips:</strong> Gunakan tombol "Pilih Semua" untuk memilih semua permissions, atau pilih per modul sesuai kebutuhan.
                                    Permission dasar (Lihat) harus dipilih terlebih dahulu sebelum permission lainnya.
                                </small>
                            </div>
                            
                            <div class="card border overflow-hidden">
                                <div class="card-header bg-light py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 text-primary">
                                            <i class="ti ti-settings me-2"></i>Pengaturan Akses Sistem
                                        </h6>
                                        <div>
                                            <button type="button" class="btn btn-sm btn-primary me-1" onclick="selectAll()">
                                                <i class="ti ti-check me-1"></i>Pilih Semua
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                                <i class="ti ti-x me-1"></i>Hapus Semua
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module => $modulePermissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-6 col-xl-4">
                                            <div class="permission-module-card h-100">
                                                
                                                <div class="module-header">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="module-title">
                                                            <?php
                                                                $moduleIcons = [
                                                                    'dashboard' => 'ti ti-layout-dashboard',
                                                                    'role' => 'ti ti-user',
                                                                    'user' => 'ti ti-user-plus',
                                                                    'pengaturan' => 'ti ti-home-cog',
                                                                    'profile' => 'ti ti-user-circle',
                                                                    'backup_database' => 'ti ti-database-export'
                                                                ];
                                                                $moduleNames = [
                                                                    'dashboard' => 'Dashboard',
                                                                    'role' => 'Manajemen Role',
                                                                    'user' => 'Manajemen User',
                                                                    'pengaturan' => 'Profil Pengaturan',
                                                                    'profile' => 'Profile',
                                                                    'backup_database' => 'Backup Database'
                                                                ];
                                                                $icon = $moduleIcons[$module] ?? 'ti ti-folder';
                                                                $displayName = $moduleNames[$module] ?? ucfirst(str_replace('_', ' ', $module));
                                                            ?>
                                                            <i class="<?php echo e($icon); ?> me-2"></i>
                                                            <strong><?php echo e($displayName); ?></strong>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input module-check-all" type="checkbox" 
                                                                   data-module="<?php echo e($module); ?>" id="checkAll_<?php echo e($module); ?>">
                                                            <label class="form-check-label small text-muted" for="checkAll_<?php echo e($module); ?>">
                                                                Semua
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="module-permissions">
                                                    <?php $__currentLoopData = $modulePermissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $isBasePermission = str_ends_with($permission->name, '.view') || $permission->name === 'dashboard.view';
                                                    ?>
                                                    
                                                    <div class="form-check permission-item <?php echo e($isBasePermission ? 'base-permission' : ''); ?>">
                                                        <input 
                                                            class="form-check-input permission-check" 
                                                            type="checkbox" 
                                                            name="permissions[]" 
                                                            value="<?php echo e($permission->id); ?>"
                                                            id="permission_<?php echo e($permission->id); ?>"
                                                            data-module="<?php echo e($module); ?>"
                                                            data-permission-name="<?php echo e($permission->name); ?>"
                                                            <?php echo e(in_array($permission->id, old('permissions', [])) ? 'checked' : ''); ?>>
                                                        <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                                            <?php if($isBasePermission): ?>
                                                                <i class="ti ti-eye me-1 text-primary"></i>
                                                            <?php elseif(str_contains($permission->name, 'password.change')): ?>
                                                                <i class="ti ti-lock me-1"></i>
                                                            <?php elseif(str_contains($permission->name, 'create')): ?>
                                                                <i class="ti ti-plus me-1 text-primary"></i>
                                                            <?php elseif(str_contains($permission->name, 'edit')): ?>
                                                                <i class="ti ti-edit me-1 text-warning"></i>
                                                            <?php elseif(str_contains($permission->name, 'delete')): ?>
                                                                <i class="ti ti-trash me-1 text-danger"></i>
                                                            <?php elseif(str_contains($permission->name, 'download')): ?>
                                                                <i class="ti ti-download me-1 text-success"></i>
                                                            <?php else: ?>
                                                                <i class="ti ti-check me-1 text-muted"></i>
                                                            <?php endif; ?>
                                                            <?php echo e($permission->display_name); ?>

                                                        </label>
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
                    </div>
                </div>

                
                <?php if (isset($component)) { $__componentOriginal2720027075619929b6f895eb46dac441 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2720027075619929b6f895eb46dac441 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-action-buttons','data' => ['route' => 'role']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-action-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'role']); ?>
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
            </form>
        </div>
    </div>

    <style>
    /* Permission Module Cards */
    .permission-module-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        background: #ffffff;
        transition: all 0.2s ease;
    }
    
    .permission-module-card:hover {
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0,123,255,0.15);
    }
    
    .module-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 12px 15px;
        border-radius: 8px 8px 0 0;
        border-bottom: 1px solid #dee2e6;
    }
    
    .module-title {
        font-size: 0.9rem;
        color: #495057;
    }
    
    .module-permissions {
        padding: 12px 15px;
        max-height: 280px;
        overflow-y: auto;
    }
    
    .permission-item {
        margin-bottom: 8px;
        padding: 4px 0;
        transition: background-color 0.15s ease;
    }
    
    .permission-item:hover {
        background-color: #f8f9fa;
        border-radius: 4px;
        padding-left: 4px;
    }
    
    .permission-item.base-permission {
        background: linear-gradient(90deg, #e3f2fd 0%, transparent 100%);
        border-left: 3px solid #2196f3;
        padding-left: 8px;
        font-weight: 500;
    }
    
    .permission-level-1 {
        margin-left: 15px;
        padding-left: 10px;
        border-left: 2px solid #dee2e6;
    }
    
    .permission-level-2 {
        margin-left: 30px;
        padding-left: 10px;
        border-left: 2px solid #f1f3f4;
        background: #fafafa;
    }
    
    .module-note {
        padding: 8px 15px;
        background: #fff3cd;
        border-top: 1px solid #ffeaa7;
        border-radius: 0 0 8px 8px;
        margin-top: auto;
    }
    
    /* Form Controls */
    .form-check input[disabled] + .form-check-label {
        color: #6c757d !important;
        cursor: not-allowed;
    }
    
    .form-check input[disabled] {
        cursor: not-allowed;
    }
    
    .form-check.disabled-dependency {
        opacity: 0.5;
        pointer-events: none;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .module-permissions {
            max-height: none;
        }
        
        .permission-level-1 {
            margin-left: 10px;
        }
        
        .permission-level-2 {
            margin-left: 20px;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Helper function to get checkbox by permission name
        function getCheckboxByPermissionName(permissionName) {
            return document.querySelector(`input[name="permissions[]"][data-permission-name="${permissionName}"]`);
        }
        
        // Define permission dependencies
    const permissionDependencies = {
            // User dependencies
            'user.create': 'user.view',
            'user.edit': 'user.view',
            'user.delete': 'user.view',
            
            // Role dependencies
            'role.create': 'role.view',
            'role.edit': 'role.view',
            'role.delete': 'role.view',
            
            // Pengaturan dependencies
            'pengaturan.edit': 'pengaturan.view',
            
            // Backup Database dependencies
            'backup_database.create': 'backup_database.view',
            'backup_database.download': 'backup_database.view',
            'backup_database.delete': 'backup_database.view',
        };

        // Mutual exclusion - currently empty for core modules
        const mutuallyExclusive = {};
        
        // Function to check dependencies and enable/disable checkboxes
        function checkDependencies() {
            const permissionCheckboxes = document.querySelectorAll('input[name="permissions[]"]');
            
            permissionCheckboxes.forEach(checkbox => {
                const permissionName = checkbox.dataset.permissionName;
                const dependsOn = permissionDependencies[permissionName];
                
                if (dependsOn) {
                    const dependencyCheckbox = getCheckboxByPermissionName(dependsOn);
                    
                    if (dependencyCheckbox) {
                        if (!dependencyCheckbox.checked) {
                            // Dependency not met - disable and uncheck
                            checkbox.checked = false;
                            checkbox.disabled = true;
                            checkbox.closest('.form-check').classList.add('disabled-dependency');
                        } else {
                            // Dependency met - enable
                            checkbox.disabled = false;
                            checkbox.closest('.form-check').classList.remove('disabled-dependency');
                        }
                    }
                } else {
                    // No dependency - always enabled
                    checkbox.disabled = false;
                    checkbox.closest('.form-check').classList.remove('disabled-dependency');
                }
            });

            // Update module check-all states after dependency check
            updateModuleCheckAllStates();
        }
        
        // Function to update module check-all states
        function updateModuleCheckAllStates() {
            document.querySelectorAll('.module-check-all').forEach(checkboxAll => {
                const module = checkboxAll.dataset.module;
                
                // Define expected permissions untuk setiap module
                const expectedPermissions = {
                    'dashboard': ['dashboard.view'],
                    'role': ['role.view', 'role.create', 'role.edit', 'role.delete'],
                    'user': ['user.view', 'user.create', 'user.edit', 'user.delete'],
                    'pengaturan': ['pengaturan.view', 'pengaturan.edit'],
                    'profile': ['profile.edit', 'password.change'],
                    'backup_database': ['backup_database.view', 'backup_database.create', 'backup_database.download', 'backup_database.delete']
                };
                
                const moduleExpectedPerms = expectedPermissions[module] || [];
                const allModuleCheckboxes = document.querySelectorAll(`.permission-check[data-module="${module}"]`);
                
                // Check berapa banyak expected permissions yang checked
                let expectedCheckedCount = 0;
                let totalModuleChecked = 0;
                
                moduleExpectedPerms.forEach(permName => {
                    const checkbox = getCheckboxByPermissionName(permName);
                    if (checkbox && checkbox.checked) {
                        expectedCheckedCount++;
                    }
                });
                
                // Count total checked in module
                allModuleCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        totalModuleChecked++;
                    }
                });
                
                if (expectedCheckedCount === moduleExpectedPerms.length && totalModuleChecked === expectedCheckedCount) {
                    // All expected permissions checked and no extra permissions
                    checkboxAll.checked = true;
                    checkboxAll.indeterminate = false;
                } else if (totalModuleChecked > 0) {
                    // Some permissions checked but not complete expected set
                    checkboxAll.checked = false;
                    checkboxAll.indeterminate = true;
                } else {
                    // No permissions checked
                    checkboxAll.checked = false;
                    checkboxAll.indeterminate = false;
                }
            });
        }

        // Handle module check all
    document.querySelectorAll('.module-check-all').forEach(checkboxAll => {
            checkboxAll.addEventListener('change', function() {
                const module = this.dataset.module;
                const isChecked = this.checked;
                
                // Define specific permissions untuk setiap module ketika module check all
                const moduleSelectRules = {
                    'dashboard': isChecked ? ['dashboard.view'] : [],
                    'role': isChecked ? ['role.view', 'role.create', 'role.edit', 'role.delete'] : [],
                    'user': isChecked ? ['user.view', 'user.create', 'user.edit', 'user.delete'] : [],
                    'pengaturan': isChecked ? ['pengaturan.view', 'pengaturan.edit'] : [],
                    'profile': isChecked ? ['profile.edit', 'password.change'] : [],
                    'backup_database': isChecked ? ['backup_database.view', 'backup_database.create', 'backup_database.download', 'backup_database.delete'] : []
                };
                
                // First uncheck all permissions in this module
                document.querySelectorAll(`.permission-check[data-module="${module}"]`).forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                // Then check specific permissions if isChecked
                if (isChecked && moduleSelectRules[module]) {
                    moduleSelectRules[module].forEach(permissionName => {
                        const checkbox = getCheckboxByPermissionName(permissionName);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }
                
                // Check dependencies after module selection
                setTimeout(checkDependencies, 10);
            });
        });
        
        // Handle individual permission checkboxes
        document.querySelectorAll('.permission-check').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Check dependencies after individual selection
                setTimeout(checkDependencies, 10);
            });
        });
        
        // Initialize state
        updateModuleCheckAllStates();
        
        // Initial dependency check
        checkDependencies();
        
        // Global functions untuk button onclick
    window.selectAll = function() {
            // Define specific permissions untuk setiap module ketika select all
            const selectAllRules = {
                'dashboard': ['dashboard.view'],
                'role': ['role.view', 'role.create', 'role.edit', 'role.delete'],
                'user': ['user.view', 'user.create', 'user.edit', 'user.delete'],
                'pengaturan': ['pengaturan.view', 'pengaturan.edit'],
                'profile': ['profile.edit', 'password.change'],
                'backup_database': ['backup_database.view', 'backup_database.create', 'backup_database.download', 'backup_database.delete']
            };
            
            // First, uncheck all permissions
            document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Then, check permissions sesuai rules
            Object.keys(selectAllRules).forEach(module => {
                const permissionsToCheck = selectAllRules[module];
                permissionsToCheck.forEach(permissionName => {
                    const checkbox = getCheckboxByPermissionName(permissionName);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            });
            
            // Check dependencies and update UI
            setTimeout(() => {
                checkDependencies();
                updateModuleCheckAllStates();
            }, 50);
        };

        window.deselectAll = function() {
            document.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.querySelectorAll('.module-check-all').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.indeterminate = false;
            });
            
            // Re-check dependencies after deselecting all
            setTimeout(() => {
                checkDependencies();
                updateModuleCheckAllStates();
            }, 10);
        };
    });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/role/create.blade.php ENDPATH**/ ?>