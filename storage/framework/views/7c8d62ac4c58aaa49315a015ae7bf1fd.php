<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e($pengaturan->kepanjangan_aplikasi); ?>">
    <meta name="author" content="<?php echo e($pengaturan->nama_copyright); ?>">

    
    <title>Login - <?php echo e($pengaturan->nama_aplikasi); ?></title>

    
    <?php
        $faviconPath = safe_image_url($pengaturan->favicon ?? null, 'favicon', 'images/favicon.ico');
    ?>
    <link rel="shortcut icon" href="<?php echo e($faviconPath); ?>" type="image/x-icon">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">

    
    <style>
        :root {
            --primary-color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
            --primary-dark: <?php echo e(darken_color($pengaturan->tema_warna_utama ?? '#14438B', 15)); ?>;
            --auth-primary-color: <?php echo e($pengaturan->tema_warna_utama ?? '#082A99'); ?>;
        }

        .bg-pattern {
            background-image: url('<?php echo e(safe_image_url($pengaturan->background_login ?? null, 'background_login', 'images/background.jpg')); ?>');
        }
    </style>

    <?php echo htmlScriptTagJsApi([
        'action' => 'login',
        'custom_validation_token_field_id' => 'recaptcha_token'
    ]); ?>


</head>

<body>
    <div class="login-container">
        <div class="left-section">
            <div class="bg-pattern"></div>
            <div class="left-content">
                <div class="logo-section">
                    <div class="logo-header">
                        <div class="logo">
                            <img src="<?php echo e(safe_image_url($pengaturan->logo_instnasi ?? null, 'logo', 'images/logo.png')); ?>"
                                alt="Logo <?php echo e($pengaturan->nama_aplikasi); ?>">
                        </div>
                    </div>
                    <h1 class="main-title">
                        Selamat Datang di <?php echo e($pengaturan->nama_aplikasi); ?>

                    </h1>
                    <p class="subtitle"><?php echo e($pengaturan->kepanjangan_aplikasi); ?></p>
                    <?php
                        $hasSocialMedia =
                            $pengaturan->sosmed_facebook ||
                            $pengaturan->sosmed_twitter ||
                            $pengaturan->sosmed_instagram ||
                            $pengaturan->sosmed_youtube ||
                            $pengaturan->sosmed_tiktok;
                    ?>

                    <?php if($hasSocialMedia): ?>
                        <div class="social-links">
                            <?php if($pengaturan->sosmed_facebook): ?>
                                <a href="<?php echo e($pengaturan->sosmed_facebook); ?>" target="_blank" class="social-icon facebook"
                                    title="Facebook">
                                    <i class="ti ti-brand-facebook"></i>
                                </a>
                            <?php endif; ?>

                            <?php if($pengaturan->sosmed_twitter): ?>
                                <a href="<?php echo e($pengaturan->sosmed_twitter); ?>" target="_blank" class="social-icon twitter"
                                    title="Twitter/X">
                                    <i class="ti ti-brand-x"></i>
                                </a>
                            <?php endif; ?>

                            <?php if($pengaturan->sosmed_instagram): ?>
                                <a href="<?php echo e($pengaturan->sosmed_instagram); ?>" target="_blank"
                                    class="social-icon instagram" title="Instagram">
                                    <i class="ti ti-brand-instagram"></i>
                                </a>
                            <?php endif; ?>

                            <?php if($pengaturan->sosmed_youtube): ?>
                                <a href="<?php echo e($pengaturan->sosmed_youtube); ?>" target="_blank" class="social-icon youtube"
                                    title="YouTube">
                                    <i class="ti ti-brand-youtube"></i>
                                </a>
                            <?php endif; ?>

                            <?php if($pengaturan->sosmed_tiktok): ?>
                                <a href="<?php echo e($pengaturan->sosmed_tiktok); ?>" target="_blank" class="social-icon tiktok"
                                    title="TikTok">
                                    <i class="ti ti-brand-tiktok"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="login-form">
                <div class="login-header">
                    <img src="<?php echo e(safe_image_url($pengaturan->logo_instnasi ?? null, 'logo', 'images/logo.png')); ?>"
                        alt="Logo <?php echo e($pengaturan->nama_aplikasi); ?>" class="mb-4" style="width: 200px; height: auto;">
                    <h2 class="login-title"><?php echo e($pengaturan->nama_aplikasi); ?></h2>
                    <p class="login-subtitle">Silahkan Login untuk masuk ke Dashboard</p>
                </div>

                <!-- Alert -->
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

                <!-- Form -->
                <form action="<?php echo e(route('login.authenticate')); ?>" method="POST" id="loginForm">
                    <?php echo csrf_field(); ?>

                    <!-- Username -->
                    <div class="form-group">
                        <label class="form-label"><i class="ti ti-user"></i> Username</label>
                        <input type="text" name="username" class="form-input <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Masukkan username Anda" value="<?php echo e(old('username')); ?>">
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
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label"><i class="ti ti-lock"></i> Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password"
                                class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="loginPassword"
                                placeholder="Masukkan password Anda">
                            <button type="button" class="password-toggle" id="togglePasswordBtn"
                                style="display: none;">
                                <i class="ti ti-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
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

                    <input type="hidden" name="g-recaptcha-response" id="recaptcha_token">

                    <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <!-- Checkbox Ingat Saya -->
                    <div class="checkbox-group">
                        <input type="checkbox" class="checkbox" id="remember" name="remember">
                        <label for="remember" class="checkbox-label">Ingat Saya</label>
                    </div>

                    <?php if (isset($component)) { $__componentOriginal9d87c63e255afa82c19f5ff3bf8d9ef8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9d87c63e255afa82c19f5ff3bf8d9ef8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-buttons','data' => ['text' => 'LOGIN','loadingText' => 'Memproses...','icon' => 'ti-login-2','class' => 'login-btn']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['text' => 'LOGIN','loadingText' => 'Memproses...','icon' => 'ti-login-2','class' => 'login-btn']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9d87c63e255afa82c19f5ff3bf8d9ef8)): ?>
<?php $attributes = $__attributesOriginal9d87c63e255afa82c19f5ff3bf8d9ef8; ?>
<?php unset($__attributesOriginal9d87c63e255afa82c19f5ff3bf8d9ef8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9d87c63e255afa82c19f5ff3bf8d9ef8)): ?>
<?php $component = $__componentOriginal9d87c63e255afa82c19f5ff3bf8d9ef8; ?>
<?php unset($__componentOriginal9d87c63e255afa82c19f5ff3bf8d9ef8); ?>
<?php endif; ?>

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('loginPassword');
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const usernameInput = document.querySelector('input[name="username"]');
            const rememberCheckbox = document.getElementById('remember');
            const loginForm = document.getElementById('loginForm');

            // === REMEMBER USERNAME FUNCTIONALITY ===

            // Load saved username saat halaman dimuat
            function loadSavedUsername() {
                const savedUsername = localStorage.getItem('remembered_username');
                const wasRemembered = localStorage.getItem('remember_username') === 'true';

                if (savedUsername && wasRemembered) {
                    usernameInput.value = savedUsername;
                    rememberCheckbox.checked = true;

                    // Auto focus ke password field jika username sudah terisi
                    setTimeout(() => {
                        passwordInput.focus();
                    }, 100);
                }
            }

            // Save/Clear username berdasarkan checkbox
            function handleRememberUsername() {
                if (rememberCheckbox.checked && usernameInput.value.trim()) {
                    // Save username to localStorage only if not empty
                    localStorage.setItem('remembered_username', usernameInput.value.trim());
                    localStorage.setItem('remember_username', 'true');
                } else {
                    // Clear saved username
                    localStorage.removeItem('remembered_username');
                    localStorage.removeItem('remember_username');
                }
            }

            // Handle form submission
            loginForm.addEventListener('submit', function() {
                handleRememberUsername();
            });

            // Handle checkbox change (untuk clear data jika diun-check)
            rememberCheckbox.addEventListener('change', function() {
                if (!this.checked) {
                    localStorage.removeItem('remembered_username');
                    localStorage.removeItem('remember_username');
                }
            });

            // Load saved data saat halaman dimuat
            loadSavedUsername();

            // === PASSWORD TOGGLE FUNCTIONALITY ===

            // Fungsi untuk toggle visibilitas icon
            function toggleIconVisibility() {
                if (passwordInput.value.trim() !== '') {
                    toggleBtn.style.display = 'block';
                } else {
                    toggleBtn.style.display = 'none';
                }
            }

            // Inisialisasi awal
            toggleIconVisibility();

            // Perbarui setiap kali input berubah
            passwordInput.addEventListener('input', toggleIconVisibility);

            // Toggle visibility password
            toggleBtn.addEventListener('click', function() {
                const icon = toggleBtn.querySelector('i');
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('ti-eye');
                icon.classList.toggle('ti-eye-off');
            });

            // Add interactive animations for form inputs
            document.querySelectorAll('.form-input').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });
    </script>

</body>

</html>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/auth/login.blade.php ENDPATH**/ ?>