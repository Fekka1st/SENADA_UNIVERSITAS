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
     <?php $__env->slot('title', null, []); ?> Dashboard Verifikasi <?php $__env->endSlot(); ?>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-warning text-white h-100 border-0 shadow-sm overflow-hidden position-relative">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-uppercase fw-bold mb-1 opacity-75">Perlu Tindakan</h6>
                            <h2 class="display-4 fw-bold mb-0"><?php echo e($antrean_verifikasi ?? 0); ?></h2>
                            <span class="fs-6">Pengajuan Menunggu Verifikasi</span>
                        </div>
                        <div class="icon-shape bg-white text-warning rounded-circle p-3 shadow-sm">
                            <i class="ti ti-clock-exclamation fs-2"></i>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="" class="btn btn-sm btn-light text-warning fw-bold w-100 shadow-sm">
                            <i class="ti ti-checklist me-1"></i> Mulai Review Sekarang
                        </a>
                    </div>
                </div>
                <i class="ti ti-clock position-absolute opacity-10" style="font-size: 8rem; right: -20px; bottom: -20px;"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="text-muted fw-bold mb-1">Total Mitra Terdaftar</h6>
                            <h2 class="fw-bold mb-0 text-primary"><?php echo e($total_mitra ?? 0); ?></h2>
                        </div>
                        <div class="icon-shape bg-light-primary text-primary rounded-2 p-3">
                            <i class="ti ti-building-skyscraper fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted fs-7">
                        <span class="text-success fw-bold me-1"><i class="ti ti-trending-up"></i> +5</span>
                        bulan ini
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h6 class="text-muted fw-bold mb-1">Dokumen Disetujui</h6>
                            <h2 class="fw-bold mb-0 text-success"><?php echo e($total_disetujui ?? 0); ?></h2>
                        </div>
                        <div class="icon-shape bg-light-success text-success rounded-2 p-3">
                            <i class="ti ti-file-check fs-3"></i>
                        </div>
                    </div>
                    <div class="d-flex align-items-center text-muted fs-7">
                        <span>Total akumulasi MoU/MoA/IA</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0 fw-bold"><i class="ti ti-inbox me-2"></i> Pengajuan Terbaru</h5>
                        <small class="text-muted">Daftar dokumen yang baru masuk dan belum diproses.</small>
                    </div>
                    <a href="" class="btn btn-sm btn-outline-primary">
                        Lihat Semua Antrean
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Tanggal Masuk</th>
                                    <th>Unit Pengaju</th>
                                    <th>Mitra & Judul</th>
                                    <th>Jenis</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $latest_pengajuan ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4 text-muted">
                                            <div class="fw-bold text-dark"><?php echo e($item->created_at->format('d M Y')); ?></div>
                                            <small><?php echo e($item->created_at->format('H:i')); ?> WIB</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-light-info text-info border border-info">
                                                <?php echo e($item->unit->name ?? '-'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark"><?php echo e($item->partner->name ?? 'Mitra Tidak Dikenal'); ?></span>
                                                <small class="text-muted text-truncate" style="max-width: 250px;">
                                                    <?php echo e($item->title); ?>

                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                                $badgeColor = match($item->document_type_id) {
                                                    1 => 'primary', // MoU
                                                    2 => 'success', // MoA
                                                    3 => 'warning', // IA
                                                    default => 'secondary'
                                                };

                                                $docName = $item->documentType->name ?? 'Dokumen';
                                            ?>
                                            <span class="badge bg-<?php echo e($badgeColor); ?>"><?php echo e($docName); ?></span>
                                        </td>
                                        <td class="text-end pe-4">

                                            <a href="" class="btn btn-sm btn-primary">
                                                <i class="ti ti-eye me-1"></i> Review
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="mb-3">
                                                <i class="ti ti-circle-check text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                                            </div>
                                            <h6 class="text-muted fw-bold">Kerja Bagus!</h6>
                                            <p class="text-muted mb-0">Tidak ada pengajuan baru yang perlu diverifikasi saat ini.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-12">
            <h6 class="text-muted fw-bold mb-3 text-uppercase fs-7">Jalan Pintas</h6>
        </div>
        <div class="col-md-3 mb-3">
            <a href="" class="card text-decoration-none h-100 border-0 shadow-sm hover-elevate">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-shape bg-light-primary text-primary rounded-circle me-3">
                        <i class="ti ti-database fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Data Master Mitra</h6>
                        <small class="text-muted">Kelola data mitra global</small>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="" class="card text-decoration-none h-100 border-0 shadow-sm hover-elevate">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-shape bg-light-info text-info rounded-circle me-3">
                        <i class="ti ti-file-analytics fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold text-dark">Laporan & Rekap</h6>
                        <small class="text-muted">Export data ke Excel</small>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <style>
        .hover-elevate {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s;
        }
        .hover-elevate:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/dashboard/adminuniv.blade.php ENDPATH**/ ?>