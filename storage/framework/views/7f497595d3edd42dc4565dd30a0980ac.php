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
     <?php $__env->slot('title', null, []); ?> Pengaturan Aplikasi <?php $__env->endSlot(); ?>

    
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

    
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="ms-3">
                        <h4 class="mb-1 fw-bold">Pengaturan Aplikasi</h4>
                        <p class="text-muted mb-0">Informasi dan konfigurasi aplikasi</p>
                    </div>
                </div>
                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'pengaturan.edit')): ?>
                <div class="flex-shrink-0">
                    <a href="<?php echo e(route('pengaturan.edit')); ?>" class="btn btn-primary w-100 w-md-auto">
                        <i class="ti ti-edit me-2"></i>Ubah Pengaturan
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-info-circle me-2 text-primary"></i>Informasi Aplikasi
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Nama Aplikasi</label>
                                <p class="fw-semibold mb-0 fs-5"><?php echo e($pengaturan->nama_aplikasi); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Kepanjangan Nama Aplikasi</label>
                                <p class="fw-semibold mb-0"><?php echo e($pengaturan->kepanjangan_aplikasi); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-1 d-block">Copyright</label>
                                <p class="fw-semibold mb-0"><?php echo e($pengaturan->nama_copyright); ?></p>
                            </div>
                        </div>

                        
                        <div class="col-12">
                            <div class="info-item">
                                <label class="text-muted small mb-2 d-block">Warna Tema Utama</label>
                                <div class="d-flex align-items-center">
                                    <div class="color-preview me-3"
                                        style="width: 50px; height: 50px; background-color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>; border-radius: 10px; border: 2px solid #e0e6eb; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    </div>
                                    <div>
                                        <p class="fw-bold mb-0"><?php echo e(strtoupper($pengaturan->tema_warna_utama ?? '#14438B')); ?></p>
                                        <small class="text-muted">Kode Warna Hex</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-share-3 me-2 text-primary"></i>Sosial Media
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                        $socialMedias = [
                            [
                                'field' => 'sosmed_facebook',
                                'icon' => 'ti ti-brand-facebook',
                                'color' => '#1877F2',
                                'name' => 'Facebook',
                            ],
                            [
                                'field' => 'sosmed_twitter',
                                'icon' => 'ti ti-brand-x',
                                'color' => '#000000',
                                'name' => 'Twitter/X',
                            ],
                            [
                                'field' => 'sosmed_instagram',
                                'icon' => 'ti ti-brand-instagram',
                                'color' => '#E4405F',
                                'name' => 'Instagram',
                            ],
                            [
                                'field' => 'sosmed_youtube',
                                'icon' => 'ti ti-brand-youtube',
                                'color' => '#FF0000',
                                'name' => 'YouTube',
                            ],
                            [
                                'field' => 'sosmed_tiktok',
                                'icon' => 'ti ti-brand-tiktok',
                                'color' => '#000000',
                                'name' => 'TikTok',
                            ],
                        ];
                        $hasSocialMedia = false;
                        foreach ($socialMedias as $social) {
                            if (!empty($pengaturan->{$social['field']})) {
                                $hasSocialMedia = true;
                                break;
                            }
                        }
                    ?>

                    <?php if($hasSocialMedia): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php $__currentLoopData = $socialMedias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(!empty($pengaturan->{$social['field']})): ?>
                                    <a href="<?php echo e($pengaturan->{$social['field']}); ?>" target="_blank"
                                        class="social-media-item p-3 border rounded-3 text-decoration-none d-flex align-items-center">
                                        <div class="social-icon me-3" style="background-color: <?php echo e($social['color']); ?>15;">
                                            <i class="<?php echo e($social['icon']); ?> fs-3" style="color: <?php echo e($social['color']); ?>;"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-0 fw-semibold text-dark"><?php echo e($social['name']); ?></p>
                                            <small class="text-muted text-truncate d-block">
                                                <?php echo e($pengaturan->{$social['field']}); ?>

                                            </small>
                                        </div>
                                        <i class="ti ti-external-link text-muted ms-2"></i>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="ti ti-share-off fs-1 text-muted mb-3"></i>
                            <p class="text-muted mb-0">Belum ada sosial media terdaftar</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-bottom">
                    <h5 class="mb-0 fw-semibold">
                        <i class="ti ti-photo me-2 text-primary"></i>Aset Visual
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-building fs-2 text-primary"></i>
                                </div>
                                <?php
                                    $logoInstansiPath = safe_image_url($pengaturan->logo_instansi, 'logo', 'images/logo.png');
                                ?>
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px;">
                                    <img src="<?php echo e($logoInstansiPath); ?>" class="img-fluid"
                                        style="max-height: 100px; max-width: 100%; object-fit: contain;"
                                        alt="Logo Instansi">
                                </div>
                                <h6 class="fw-semibold mb-1">Logo Instansi</h6>
                                <small class="text-muted">Ditampilkan di header aplikasi</small>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-favicon fs-2 text-success"></i>
                                </div>
                                <?php
                                    $faviconPath = safe_image_url($pengaturan->favicon, 'favicon', 'images/favicon.ico');
                                ?>
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px;">
                                    <img src="<?php echo e($faviconPath); ?>" class="img-fluid"
                                        style="max-height: 100px; max-width: 100%; object-fit: contain;"
                                        alt="Favicon">
                                </div>
                                <h6 class="fw-semibold mb-1">Favicon</h6>
                                <small class="text-muted">Icon browser tab</small>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div class="asset-card text-center p-4 border rounded-3 h-100">
                                <div class="asset-icon mb-3">
                                    <i class="ti ti-photo-filled fs-2 text-info"></i>
                                </div>
                                <?php
                                    $backgroundLoginPath = safe_image_url($pengaturan->background_login, 'background_login', 'images/background.jpg');
                                ?>
                                <div class="asset-preview mb-3"
                                    style="height: 120px; display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; border-radius: 10px; overflow: hidden;">
                                    <img src="<?php echo e($backgroundLoginPath); ?>" class="img-fluid"
                                        style="width: 100%; height: 100%; object-fit: cover;"
                                        alt="Background Login">
                                </div>
                                <h6 class="fw-semibold mb-1">Background Login</h6>
                                <small class="text-muted">Background halaman login</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .avatar-md {
            width: 60px;
            height: 60px;
        }

        .w-md-auto {
            width: 100% !important;
        }

        @media (min-width: 768px) {
            .w-md-auto {
                width: auto !important;
            }
        }

        .info-item {
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .social-media-item {
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .social-media-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            background-color: #f8f9fa;
        }

        .asset-card {
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .asset-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .asset-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 12px;
        }

        .color-preview {
            transition: transform 0.3s ease;
            flex-shrink: 0;
        }

        .color-preview:hover {
            transform: scale(1.1);
        }

        /* Mobile responsive adjustments */
        @media (max-width: 767.98px) {
            .card-header h5 {
                font-size: 1rem;
            }

            .avatar-md {
                width: 50px;
                height: 50px;
            }

            .avatar-md i {
                font-size: 1.5rem !important;
            }

            h4.fw-bold {
                font-size: 1.25rem;
            }

            .asset-card {
                margin-bottom: 1rem;
            }
        }
    </style>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/pengaturan/index.blade.php ENDPATH**/ ?>