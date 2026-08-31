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
     <?php $__env->slot('title', null, []); ?> Manajemen User <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Tambah <?php $__env->endSlot(); ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>

            
            <form action="<?php echo e(route('user.store.data')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-4">

                    
                    <div class="col-lg-4">
                        <div class="card border bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-subtitle mb-3 text-primary">
                                    <i class="ti ti-camera me-1"></i> Preview Foto
                                </h6>

                                <div class="position-relative d-inline-block mb-3">
                                    <img id="previewFoto" src="<?php echo e(asset('images/avatar.png')); ?>"
                                        class="img-thumbnail rounded-circle shadow" width="180" height="180"
                                        style="object-fit: cover; border: 4px solid #fff;" alt="Foto User">
                                </div>

                                
                                <h5 class="mb-2 text-muted">User Baru</h5>

                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                    <i class="ti ti-user-plus me-1"></i>
                                    Belum Ada Foto
                                </span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-lg-8">
                        <div class="card border">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-4 text-primary">
                                    <i class="ti ti-forms me-1"></i> Data Pengguna
                                </h6>

                                <div class="row">
                                    
                                    <div class="col-lg-6">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-user me-1"></i> Nama Lengkap
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="nama_user" value="<?php echo e(old('nama_user')); ?>"
                                                class="form-control <?php $__errorArgs = ['nama_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Masukkan nama lengkap" autocomplete="off">
                                            <?php $__errorArgs = ['nama_user'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-at me-1"></i> Username
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="username" value="<?php echo e(old('username')); ?>"
                                                class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Masukkan username" autocomplete="off">
                                            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="form-text">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Username untuk login ke sistem
                                            </div>
                                        </div>

                                        
                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-shield-check me-1"></i> Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="role"
                                                class="form-select select2-single <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                autocomplete="off" required>
                                                <option selected disabled value="">- Pilih Role -</option>
                                                <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($r->id); ?>"
                                                        <?php echo e(old('role') == $r->id ? 'selected' : ''); ?>>
                                                        <?php echo e($r->nama); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="form-text">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Jika role belum ada, daftarkan di menu Manajemen Role
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-lg-6">
                                        
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-lock me-1"></i> Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control toggle-password <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Masukkan password" autocomplete="new-password">
                                                <span class="input-group-text bg-white toggle-password-btn"
                                                    style="cursor: pointer;">
                                                    <i class="ti ti-eye"></i>
                                                </span>
                                            </div>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                            <!-- Indikator kekuatan password -->
                                            <div id="password-strength" class="mt-2" style="display: none;">
                                                <div class="progress" style="height: 8px;">
                                                    <div id="password-strength-bar" class="progress-bar"
                                                        role="progressbar" style="width: 0%"></div>
                                                </div>
                                                <small id="password-strength-text" class="text-muted"></small>
                                            </div>

                                            <!-- Checklist validasi password -->
                                            <div id="password-checklist" class="mt-2" style="display: none;">
                                                <small>
                                                    <div id="length-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Minimal 8 karakter
                                                    </div>
                                                    <div id="uppercase-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Huruf besar (A-Z)
                                                    </div>
                                                    <div id="lowercase-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Huruf kecil (a-z)
                                                    </div>
                                                    <div id="number-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Angka (0-9)
                                                    </div>
                                                    <div id="symbol-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Simbol (!@#$%^&*)
                                                    </div>
                                                </small>
                                            </div>
                                        </div>

                                        
                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-photo me-1"></i> Foto User
                                            </label>
                                            <input type="file" name="foto"
                                                class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                accept=".jpg,.jpeg,.png" onchange="previewImage(event, 'previewFoto')"
                                                id="fotoInput">
                                            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            <div class="form-text">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Format: JPG, JPEG, PNG. Maksimal 2MB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                
                <?php if (isset($component)) { $__componentOriginal2720027075619929b6f895eb46dac441 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2720027075619929b6f895eb46dac441 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-action-buttons','data' => ['route' => 'user']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-action-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'user']); ?>
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

    
    <script>
        // Preview image function
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk validasi password real-time
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');
            const passwordStrengthBar = document.getElementById('password-strength-bar');
            const passwordStrengthText = document.getElementById('password-strength-text');
            const passwordChecklist = document.getElementById('password-checklist');

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (password.length > 0) {
                        passwordStrength.style.display = 'block';
                        passwordChecklist.style.display = 'block';
                        validatePassword(password);
                    } else {
                        passwordStrength.style.display = 'none';
                        passwordChecklist.style.display = 'none';
                    }
                });
            }

            function validatePassword(password) {
                let score = 0;
                const checks = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    symbol: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(password)
                };

                // Update checklist visual
                updateCheck('length-check', checks.length);
                updateCheck('uppercase-check', checks.uppercase);
                updateCheck('lowercase-check', checks.lowercase);
                updateCheck('number-check', checks.number);
                updateCheck('symbol-check', checks.symbol);

                // Calculate strength score
                Object.values(checks).forEach(check => {
                    if (check) score++;
                });

                // Update strength bar
                const percentage = (score / 5) * 100;
                passwordStrengthBar.style.width = percentage + '%';

                // Update strength text and color
                if (score === 5) {
                    passwordStrengthBar.className = 'progress-bar bg-success';
                    passwordStrengthText.textContent = 'Password sangat kuat';
                    passwordStrengthText.className = 'text-success';
                } else if (score >= 4) {
                    passwordStrengthBar.className = 'progress-bar bg-info';
                    passwordStrengthText.textContent = 'Password kuat';
                    passwordStrengthText.className = 'text-info';
                } else if (score >= 3) {
                    passwordStrengthBar.className = 'progress-bar bg-warning';
                    passwordStrengthText.textContent = 'Password sedang';
                    passwordStrengthText.className = 'text-warning';
                } else if (score >= 1) {
                    passwordStrengthBar.className = 'progress-bar bg-warning';
                    passwordStrengthText.textContent = 'Password lemah';
                    passwordStrengthText.className = 'text-warning';
                } else {
                    passwordStrengthBar.className = 'progress-bar bg-danger';
                    passwordStrengthText.textContent = 'Password sangat lemah';
                    passwordStrengthText.className = 'text-danger';
                }
            }

            function updateCheck(elementId, isValid) {
                const element = document.getElementById(elementId);
                if (element) {
                    const icon = element.querySelector('i');
                    if (isValid) {
                        icon.className = 'ti ti-check text-success';
                        element.className = 'text-success';
                    } else {
                        icon.className = 'ti ti-x text-danger';
                        element.className = 'text-muted';
                    }
                }
            }
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
<?php endif; ?>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/user/create.blade.php ENDPATH**/ ?>