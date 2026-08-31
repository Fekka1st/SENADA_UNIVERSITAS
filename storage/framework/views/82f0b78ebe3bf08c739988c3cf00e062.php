<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e($pengaturan->kepanjangan_aplikasi); ?>">
    <meta name="author" content="<?php echo e($pengaturan->nama_copyright); ?>">

    
    <title><?php echo e($title); ?> - <?php echo e($pengaturan->nama_aplikasi); ?></title>

    
    <?php
        $faviconPath = safe_image_url($pengaturan->favicon ?? null, 'favicon', 'images/favicon.ico');
    ?>
    <link rel="shortcut icon" href="<?php echo e($faviconPath); ?>" type="image/x-icon">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/jquery.scrollbar@0.2.11/jquery.scrollbar.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    
    <link rel="stylesheet" href="<?php echo e(asset('css/template/kaiadmin.min.css')); ?>">
    
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    
    <style>
        :root {
            --primary-color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
            --primary-dark: <?php echo e(darken_color($pengaturan->tema_warna_utama ?? '#14438B', 15)); ?>;
            --primary-light: <?php echo e(lighten_color($pengaturan->tema_warna_utama ?? '#14438B', 90)); ?>;
            --primary-subtle: <?php echo e(lighten_color($pengaturan->tema_warna_utama ?? '#14438B', 93)); ?>;
            --primary-shadow: rgba(<?php echo e(hexToRgb($pengaturan->tema_warna_utama ?? '#14438B')); ?>, 0.3);
        }

        /* Sidebar Section Collapse */
        .nav-section-toggle {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            color: #575962;
        }

        .nav-section-toggle:hover {
            background-color: #f8f9fa;
        }

        .nav-section-toggle .sidebar-mini-icon {
            margin-right: 10px;
            display: flex;
            align-items: center;
        }

        .nav-section-toggle .text-section {
            flex: 1;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin: 0;
            color: #6c757d;
        }

        .nav-section-toggle .caret {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-section-toggle .caret:before {
            content: "\f078";
            font-family: "tabler-icons";
            font-size: 12px;
        }

        .nav-section-toggle:not(.collapsed) .caret {
            transform: rotate(180deg);
        }

        .nav-section-toggle.collapsed .text-section {
            color: #6c757d;
        }

        /* Sidebar minimized state */
        .sidebar_minimize .nav-section-toggle .text-section,
        .sidebar_minimize .nav-section-toggle .caret {
            display: none;
        }

        /* Adjust section items when collapsed */
        .sidebar .collapse {
            transition: all 0.3s ease;
        }

        .sidebar .collapse .nav-item {
            margin-left: 0;
        }
    </style>

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    
    <?php echo $__env->yieldPushContent('styles'); ?>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="wrapper" data-user-id="<?php echo e(auth()->id() ?? 'guest'); ?>">
        
        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div class="main-panel">
            
            <div class="main-header">
                
                <div class="main-header-logo">
                    
                    <?php if (isset($component)) { $__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8)): ?>
<?php $attributes = $__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8; ?>
<?php unset($__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8)): ?>
<?php $component = $__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8; ?>
<?php unset($__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8); ?>
<?php endif; ?>
                </div>

                
                <?php echo $__env->make('layouts.navbar-header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <div class="container">
                <div class="page-inner">
                    
                    <div class="card card-body" style="background-color: var(--primary-color, #14438B)">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <div class="d-sm-flex align-items-center justify-space-between">
                                    
                                    <h4 class="d-flex align-items-center mb-2 mb-sm-0 card-title" style="color: #ffffff">
                                        <?php echo e($title); ?>

                                    </h4>
                                    
                                    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb" class="ms-auto">
                                        <ol class="breadcrumb mb-0">
                                            <li class="breadcrumb-item d-flex align-items-center">
                                                <a href="<?php echo e(route('dashboard.index')); ?>" class="text-muted text-decoration-none d-flex">
                                                    <i class="ti ti-home fs-5" style="color: #ffffff"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item ps-1">
                                                <i class="ti ti-chevron-right align-middle op-7" style="color: #ffffff"></i>
                                            </li>
                                            <li class="breadcrumb-item ps-0" aria-current="page">
                                                <span class="badge fw-medium bg-light text-primary">
                                                    <?php echo e($title); ?>

                                                </span>
                                            </li>
                                            <?php if(isset($breadcrumb)): ?>
                                            <li class="breadcrumb-item ps-0">
                                                <i class="ti ti-chevron-right align-middle op-7" style="color: #ffffff"></i>
                                            </li>
                                            <li class="breadcrumb-item ps-0" aria-current="page">
                                                <span class="badge fw-medium bg-light text-primary">
                                                    <?php echo e($breadcrumb); ?>

                                                </span>
                                            </li>
                                            <?php endif; ?>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php echo e($slot); ?>

                </div>
            </div>

            
            <footer class="footer">
                <div class="container-fluid">
                    

                    
                    <div class="copyright ms-auto">
                        &copy; <?php echo e(date('Y')); ?> <?php echo e($pengaturan->nama_copyright); ?>. Hak cipta dilindungi.
                    </div>
                </div>
            </footer>
        </div>

        
        <?php if (isset($component)) { $__componentOriginalb53c8542c6dfd9debeda3fa49e1dae13 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb53c8542c6dfd9debeda3fa49e1dae13 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.logout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.logout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb53c8542c6dfd9debeda3fa49e1dae13)): ?>
<?php $attributes = $__attributesOriginalb53c8542c6dfd9debeda3fa49e1dae13; ?>
<?php unset($__attributesOriginalb53c8542c6dfd9debeda3fa49e1dae13); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb53c8542c6dfd9debeda3fa49e1dae13)): ?>
<?php $component = $__componentOriginalb53c8542c6dfd9debeda3fa49e1dae13; ?>
<?php unset($__componentOriginalb53c8542c6dfd9debeda3fa49e1dae13); ?>
<?php endif; ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.closest('.input-group').querySelector('.toggle-password');
                    const icon = this.querySelector('i');

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';

                    icon.classList.toggle('ti-eye');
                    icon.classList.toggle('ti-eye-off');
                });
            });
        });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/jquery.scrollbar@0.2.11/jquery.scrollbar.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/id.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    
    <script src="<?php echo e(asset('js/template/kaiadmin.min.js')); ?>"></script>

    
    <script src="<?php echo e(asset('js/plugins.js')); ?>"></script>
    <script src="<?php echo e(asset('js/image-preview.js')); ?>"></script>
    
    <script>
        window.APP_BASE_URL = "<?php echo e(url('/')); ?>";
        window.NOTIF_BASE = "<?php echo e(url('/notifikasi')); ?>";
        window.CSRF_TOKEN = document.querySelector('meta[name=csrf-token]')?.getAttribute('content');
    </script>
    <script src="<?php echo e(asset('js/notifikasi-realtime.js')); ?>"></script>

    
    <script src="<?php echo e(asset('js/sidebar-persist.js')); ?>"></script>

    
    <script>
        window.NOTIF_URLS = {
            base: "<?php echo e(route('notifikasi.index')); ?>",
            terbaru: "<?php echo e(route('notifikasi.terbaru')); ?>",
            jumlah: "<?php echo e(route('notifikasi.jumlah-belum-dibaca')); ?>",
            tandaiSemua: "<?php echo e(route('notifikasi.tandai-semua-dibaca')); ?>",
            hapusSudahDibaca: "<?php echo e(route('notifikasi.hapus-sudah-dibaca')); ?>"
        };
    </script>

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
</body>

</html><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/layouts/app.blade.php ENDPATH**/ ?>