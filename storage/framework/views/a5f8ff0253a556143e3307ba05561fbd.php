<!DOCTYPE html>
<html lang="id">

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

    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('css/error-page.css')); ?>" />

    
    <style>
        :root {
            --primary-color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
            --primary-dark: <?php echo e(darken_color($pengaturan->tema_warna_utama ?? '#14438B', 15)); ?>;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            opacity: 0.85;
            z-index: 1;
        }

        .error-container {
            background-image: url('<?php echo e(safe_image_url($pengaturan->background_login ?? null, 'background_login', 'images/background.jpg')); ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="bg-pattern"></div>
        <div class="error-content">
            <div class="error-box">
                
                <div class="logo-section">
                    <div class="logo">
                        <img src="<?php echo e(safe_image_url($pengaturan->logo_instnasi ?? null, 'logo', 'images/logo.png')); ?>" alt="Logo <?php echo e($pengaturan->nama_aplikasi); ?>">
                    </div>
                </div>

                
                <div class="error-code">
                    <h1><?php echo e($errorcode); ?></h1>
                </div>

                
                <div class="error-message">
                    <h2><?php echo e($errortitle); ?></h2>
                    <p><?php echo e($slot); ?></p>
                </div>

                
                <div class="error-action">
                    <a href="<?php echo e(route('dashboard.index')); ?>" class="btn-dashboard">
                        <i class="fas fa-home"></i>
                        Kembali ke Dashboard
                    </a>
                </div>

                
                <?php
                    $hasSocialMedia = $pengaturan->sosmed_facebook || $pengaturan->sosmed_twitter || $pengaturan->sosmed_instagram || $pengaturan->sosmed_youtube || $pengaturan->sosmed_tiktok;
                ?>

                <?php if($hasSocialMedia): ?>
                    <div class="social-links">
                        <?php if($pengaturan->sosmed_facebook): ?>
                            <a href="<?php echo e($pengaturan->sosmed_facebook); ?>" target="_blank" class="social-icon facebook" title="Facebook">
                                <i class="ti ti-brand-facebook"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($pengaturan->sosmed_twitter): ?>
                            <a href="<?php echo e($pengaturan->sosmed_twitter); ?>" target="_blank" class="social-icon twitter" title="Twitter/X">
                                <i class="ti ti-brand-x"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($pengaturan->sosmed_instagram): ?>
                            <a href="<?php echo e($pengaturan->sosmed_instagram); ?>" target="_blank" class="social-icon instagram" title="Instagram">
                                <i class="ti ti-brand-instagram"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($pengaturan->sosmed_youtube): ?>
                            <a href="<?php echo e($pengaturan->sosmed_youtube); ?>" target="_blank" class="social-icon youtube" title="YouTube">
                                <i class="ti ti-brand-youtube"></i>
                            </a>
                        <?php endif; ?>

                        <?php if($pengaturan->sosmed_tiktok): ?>
                            <a href="<?php echo e($pengaturan->sosmed_tiktok); ?>" target="_blank" class="social-icon tiktok" title="TikTok">
                                <i class="ti ti-brand-tiktok"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                
                <div class="error-footer">
                    <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($pengaturan->nama_copyright); ?>. Hak cipta dilindungi.</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/error-layout.blade.php ENDPATH**/ ?>