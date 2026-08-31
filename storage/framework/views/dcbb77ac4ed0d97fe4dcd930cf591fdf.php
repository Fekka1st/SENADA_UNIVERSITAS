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
     <?php $__env->slot('title', null, []); ?> Detail Dokumen MoU <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Kerjasama / MoU / Detail / <?php echo e($mou->nomor_mou); ?> <?php $__env->endSlot(); ?>

    <div class="container-fluid">
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

        <div class="row g-4">
            <div class="col-lg-8 d-flex flex-column">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div
                        class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="ti ti-file-text me-2 text-primary"></i>Informasi Dokumen MoU
                        </h5>
                        <?php
                            // Logika auto-expired jika status aktif (1) tapi tanggalnya sudah lewat
                            $isExpired = $mou->tanggal_berakhir ? now()->gt($mou->tanggal_berakhir) : false;
                            $effectiveStatus = $mou->status_mou;

                            if ($effectiveStatus == 1 && $isExpired) {
                                $effectiveStatus = 2;
                            }

                            $statusMap = [
                                '0' => ['class' => 'bg-warning text-dark', 'label' => 'MENUNGGU APPROVE'],
                                '1' => ['class' => 'bg-success', 'label' => 'AKTIF'],
                                '2' => ['class' => 'bg-danger', 'label' => 'EXPIRED'],
                                '3' => ['class' => 'bg-warning', 'label' => 'REVISI'],
                            ];
                            $currStatus = $statusMap[$effectiveStatus] ?? ['class' => 'bg-dark', 'label' => 'UNKNOWN'];
                        ?>
                        <span class="badge <?php echo e($currStatus['class']); ?> px-3 py-2 rounded-pill shadow-sm">
                            <?php echo e($currStatus['label']); ?>

                        </span>
                    </div>

                    <div class="card-body p-4">
                        <h3 class="fw-bold text-dark mb-3"><?php echo e($mou->judul_mou); ?></h3>

                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <div class="small text-muted">
                                <i class="ti ti-barcode me-1"></i> No. MoU:
                                <strong><?php echo e($mou->nomor_berkas_mou ?? 'Belum Diregistrasi'); ?></strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-user me-1"></i> Diregistrasi oleh:
                                <strong><?php echo e($mou->user->nama_user ?? 'Admin'); ?></strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-clock me-1"></i> Usulan Durasi:
                                <strong><?php echo e($mou->usulan_durasi_tahun ?? '-'); ?> Tahun</strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-calendar me-1"></i> Masa Berlaku:
                                <strong>
                                    <?php if($mou->tanggal_mulai && $mou->tanggal_berakhir): ?>
                                        <?php echo e($mou->tanggal_mulai->format('d M Y')); ?> s/d
                                        <?php echo e($mou->tanggal_berakhir->format('d M Y')); ?>

                                    <?php else: ?>
                                        Menunggu Finalisasi
                                    <?php endif; ?>
                                </strong>
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary mb-2">Ringkasan Poin Kerjasama:</h6>

                        <div
                            class="bg-light rounded-4 p-4 border border-secondary-subtle border-start border-primary border-4 position-relative overflow-hidden">
                            <div class="position-relative z-1">
                                <p class="small text-muted fw-bold mb-3 text-uppercase d-flex align-items-center gap-2"
                                    style="letter-spacing: 0.5px; font-size: 10px;">
                                    <i class="ti ti-align-justified fs-6 text-primary"></i> Ringkasan Poin Kerjasama
                                </p>
                                <div class="text-dark fw-medium" style="line-height: 1.8; font-size: 0.95rem;">
                                    <?php echo nl2br(e($mou->deskripsi_singkat ?? 'Tidak ada ringkasan deskripsi yang ditambahkan untuk dokumen ini.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-4">
                    <div
                        class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark">
                        <i class="ti ti-paperclip "></i>
                        Lampiran Dokumen PDF
                        </h6>
                        <span class="badge bg-secondary rounded-pill"><?php echo e($mou->files->count()); ?> File</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <?php $__empty_1 = true; $__currentLoopData = $mou->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-6">
                                    <div
                                        class="d-flex align-items-center p-3 border border-secondary-subtle rounded-4 hover-bg-light transition-all bg-white shadow-sm position-relative group">
                                        <div class="bg-danger bg-opacity-10 p-2 rounded-3 me-3 text-danger flex-shrink-0 d-flex align-items-center justify-content-center"
                                            style="width: 48px; height: 48px;">
                                            <i class="ti ti-file-type-pdf fs-2 text-white"></i>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden pe-2">
                                            <p class="mb-0 text-truncate fw-bold small text-dark"
                                                title="<?php echo e($file->nama_file); ?>"><?php echo e($file->nama_file); ?></p>
                                            <div class="d-flex align-items-center text-muted gap-2 mt-1"
                                                style="font-size: 0.75rem;">
                                                <span><?php echo e(formatBytes($file->size)); ?></span>
                                                <span>•</span>
                                                <span><?php echo e($file->created_at->format('d M Y')); ?></span>
                                            </div>
                                        </div>
                                        <a href="<?php echo e(asset('storage/' . $file->file_path)); ?>" target="_blank"
                                            class="btn btn-sm btn-outline-danger rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center stretched-link bg-white"
                                            style="width: 36px; height: 36px; z-index: 2;" title="Unduh/Lihat Dokumen">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div
                                    class="col-12 text-center py-5 bg-light rounded-4 border border-dashed border-secondary-subtle">
                                    <div class="bg-white rounded-circle d-inline-flex p-3 shadow-sm mb-3">
                                        <i class="ti ti-file-x text-muted opacity-50" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <p class="text-muted mb-0 fw-medium">Tidak ada lampiran dokumen digital yang
                                        ditemukan.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if(in_array($mou->status_mou, [1, 2])): ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4 border-top border-success border-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="ti ti-certificate me-2 text-success"></i>Pengesahan & Dokumen Final
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">

                                
                                <div class="col-12">
                                    <p class="text-muted small text-uppercase fw-bold mb-1"
                                        style="letter-spacing: 0.5px;">Pejabat Penandatangan</p>
                                    <h6 class="fw-bold text-dark fs-6 mb-0"><?php echo e($mou->pejabat_penandatangan ?? '-'); ?>

                                    </h6>
                                </div>

                                
                                <?php if($mou->catatan_admin): ?>
                                    <div class="col-12">
                                        <div class="p-3 bg-light rounded-4 border-3 shadow-sm">
                                            <p class="text-muted small fw-bold mb-1"><i
                                                    class="ti ti-message-dots me-1"></i>Catatan Pengesahan Rektorat:</p>
                                            <div class="text-dark" style="font-size: 0.9rem; line-height: 1.6;">
                                                <?php echo nl2br(e($mou->catatan_admin)); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                
                                <div class="col-12 pt-2">
                                    <?php if($mou->file_mou_final): ?>
                                        <div class="row align-items-center py-3 border-top border-bottom">
                                            
                                            <div class="col-md-7 d-flex align-items-center">
                                                <div class="text-success me-3">
                                                    <i class="ti ti-file-type-pdf fs-2"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">Dokumen Resmi MoU (Final)</h6>
                                                    <p class="text-muted small mb-0">Sudah ditandatangani dan dicap
                                                        basah.</p>
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-5 d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                                                <div class="d-flex align-items-center gap-2">

                                                    <a href="<?php echo e(route('berkas-MoU.view-file-final', $mou->id)); ?>"
                                                        target="_blank"
                                                        class="btn btn-sm btn-light text-secondary d-flex align-items-center px-3"
                                                        title="Lihat Dokumen">
                                                        <i class="ti ti-eye me-1"></i> Lihat
                                                    </a>


                                                    <a href="<?php echo e(asset('storage/' . $mou->file_mou_final)); ?>"
                                                        download="MoU_<?php echo e($mou->nomor_berkas_mou ?? $mou->id); ?>.pdf"
                                                        class="btn btn-sm btn-primary d-flex align-items-center px-3 shadow-sm">
                                                        <i class="ti ti-download me-1"></i> Unduh
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div
                                            class="alert alert-danger border-danger border-opacity-25 bg-danger bg-opacity-10 d-flex align-items-center mb-0 rounded-4 shadow-sm">
                                            <i class="ti ti-alert-circle fs-4 me-3 text-danger"></i>
                                            <span class="small text-danger fw-bold">File dokumen final tidak
                                                ditemukan.</span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>



            
            <div class="col-lg-4 d-flex flex-column">
                
                <?php
                    $isPending = $mou->status_mou == 0;
                    $isRevisi = $mou->status_mou == 3;

                    // Parsing tanggal yang aman (Cek null terlebih dahulu)
                    $tglMulai = $mou->tanggal_mulai ? \Carbon\Carbon::parse($mou->tanggal_mulai) : null;
                    $tglAkhir = $mou->tanggal_berakhir ? \Carbon\Carbon::parse($mou->tanggal_berakhir) : null;

                    // Pastikan tglAkhir ada sebelum mengecek kedaluwarsa
                    $isExpired = $tglAkhir ? now()->gt($tglAkhir) : false;
                    $isActive = $mou->status_mou == 1 && !$isExpired;

                    if ($isPending) {
                        $theme = 'warning';
                        $icon = 'ti-clock-hour-4';
                        $statusText = 'MENUNGGU FINALISASI';
                        $progress = 0;
                    } elseif ($isRevisi) {
                        $theme = 'danger';
                        $icon = 'ti-edit-circle';
                        $statusText = 'PERLU REVISI';
                        $progress = 0;
                    } elseif ($isExpired || $mou->status_mou == 2) {
                        $theme = 'danger';
                        $icon = 'ti-calendar-cancel';
                        $statusText = 'EXPIRED';
                        $progress = 100;
                    } else {
                        $theme = 'success';
                        $icon = 'ti-circle-check';
                        $statusText = 'AKTIF BERLAKU';

                        // Kalkulasi hari HANYA dijalankan jika tglMulai dan tglAkhir tidak null
                        if ($tglMulai && $tglAkhir) {
                            $totalDurasi = $tglMulai->diffInDays($tglAkhir) ?: 1;
                            $berjalan = $tglMulai->diffInDays(now());
                            $progress = min(100, max(0, round(($berjalan / $totalDurasi) * 100)));

                            // LOGIKA BARU: Format Tahun, Bulan, Hari
                            $diff = now()->diff($tglAkhir);
                            $parts = [];

                            if ($diff->y > 0) {
                                $parts[] = $diff->y . ' tahun';
                            }
                            if ($diff->m > 0) {
                                $parts[] = $diff->m . ' bulan';
                            }
                            if ($diff->d > 0) {
                                $parts[] = $diff->d . ' hari';
                            }

                            // Gabungkan array menjadi string, atau tampilkan teks jika sisa < 1 hari
                            $teksSisaWaktu = count($parts) > 0 ? implode(' ', $parts) : 'Kurang dari 1 hari';
                        } else {
                            $progress = 0;
                            $teksSisaWaktu = '-';
                        }
                    }
                ?>

                
                <div class="card border-0 shadow-sm rounded-4 border-top border-<?php echo e($theme); ?>">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center">

                        <div class="d-inline-flex align-items-center justify-content-center bg-<?php echo e($theme); ?> text-white rounded-circle mb-3 shadow-sm mx-auto <?php if($isPending): ?> animate__animated animate__pulse animate__infinite <?php endif; ?>"
                            style="width: 72px; height: 72px; animation-duration: 2s;">
                            <i class="ti <?php echo e($icon); ?>" style="font-size: 2.3rem;"></i>
                        </div>

                        <h6 class="fw-bold text-muted small text-uppercase mb-2"
                            style="letter-spacing: 0.5px; font-size: 11px;">
                            Status Tracker
                        </h6>

                        <div>
                            <span
                                class="badge bg-<?php echo e($theme); ?>-subtle text-<?php echo e($theme); ?> border border-<?php echo e($theme); ?>-subtle px-4 py-2 rounded-pill fw-bolder mb-4 shadow-sm"
                                style="font-size: 12px;">
                                <?php echo e($statusText); ?>

                            </span>
                        </div>

                        <div class="bg-light rounded-4 p-3 border border-secondary-subtle mt-auto">
                            <?php if($isPending): ?>
                                <div class="text-center py-2">
                                    <p class="small text-dark fw-bold mb-1">
                                        <i class="ti ti-info-circle text-warning me-1 fs-5 align-middle"></i> Tahap
                                        Review Rektorat
                                    </p>
                                    <small class="text-muted d-block" style="font-size: 11px; line-height: 1.4;">
                                        Menunggu penetapan tanggal resmi dan persetujuan berkas fisik.
                                    </small>
                                </div>

                                
                            <?php elseif($isRevisi): ?>
                                <div class="text-start py-1">
                                    <p class="small text-danger fw-bold mb-2 d-flex align-items-center">
                                        <i class="ti ti-alert-triangle fs-5 me-1"></i> Catatan Revisi Rektorat:
                                    </p>
                                    <div class="p-2 bg-white rounded-3 border border-danger-subtle text-dark mb-3 shadow-sm"
                                        style="font-size: 11px; line-height: 1.6;">
                                        <?php echo nl2br(e($mou->catatan_admin ?? 'Silakan perbaiki dokumen pengajuan MoU Anda.')); ?>

                                    </div>

                                    
                                    <?php if(auth()->user()->role == 4): ?>
                                        <a href="<?php echo e(route('berkas-MoU.edit', $mou->id)); ?>"
                                            class="btn btn-danger w-100 btn-sm fw-bold rounded-pill shadow-sm d-flex align-items-center justify-content-center gap-1 hover-lift transition-all">
                                            <i class="ti ti-edit fs-6"></i> Perbaiki Dokumen
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <div class="d-flex justify-content-between text-dark small fw-bold mb-2"
                                    style="font-size: 11px;">
                                    <span><i
                                            class="ti ti-calendar-event text-secondary me-1"></i><?php echo e($mou->tanggal_mulai ? \Carbon\Carbon::parse($mou->tanggal_mulai)->format('d/m/Y') : 'Belum Ditetapkan'); ?></span>
                                    <span><i
                                            class="ti ti-calendar-x text-secondary me-1"></i><?php echo e($mou->tanggal_berakhir ? \Carbon\Carbon::parse($mou->tanggal_berakhir)->format('d/m/Y') : '-'); ?></span>
                                </div>

                                <div class="progress mb-3 shadow-none rounded-pill"
                                    style="height: 8px; background-color: #e2e8f0;">
                                    <div class="progress-bar bg-<?php echo e($theme); ?> <?php echo e($isActive ? 'progress-bar-striped progress-bar-animated' : ''); ?> rounded-pill"
                                        role="progressbar" style="width: <?php echo e($progress); ?>%"
                                        aria-valuenow="<?php echo e($progress); ?>" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>

                                <div class="small fw-bold <?php echo e($isExpired ? 'text-danger' : 'text-dark'); ?>"
                                    style="font-size: 12px;">
                                    <?php if($isActive): ?>
                                        Masa berlaku tersisa
                                        <span class="badge bg-success text-white px-2 py-0.5 rounded fs-7 fw-bold">
                                            <?php echo e($teksSisaWaktu); ?>

                                        </span> Lagi
                                    <?php else: ?>
                                        <span class="text-danger">
                                            <i class="ti ti-alert-triangle me-1"></i>Masa kontrak payung hukum telah
                                            habis.
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                

                
                <?php if(in_array(auth()->user()->role, [1, 2])): ?>
                    <?php if(in_array($mou->status_mou, [0, 3])): ?>
                        <div
                            class="card border border-secondary-subtle shadow-sm rounded-4 bg-white overflow-hidden position-relative">
                            <div class="card-body p-4 position-relative z-1">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0 shadow-sm"
                                        style="width: 45px; height: 45px;">
                                        <i class="ti ti-shield-check fs-4"></i>
                                    </div>
                                    <div>
                                        <p class="text-muted mb-0 text-uppercase fw-bold"
                                            style="letter-spacing: 1px; font-size: 10px;">Tindakan Verifikasi</p>
                                        
                                    </div>
                                </div>
                                <?php if($mou->status_mou == 0): ?>
                                    <p class="small text-muted mb-4" style="line-height: 1.5;">
                                        Tinjau dokumen ini untuk diregistrasi secara resmi, atau kembalikan ke Prodi
                                        jika
                                        perlu perbaikan.
                                    </p>
                                    <div class="d-flex flex-column gap-2">
                                        <button type="button" data-bs-toggle="modal"
                                            data-bs-target="#modalFinalisasi"
                                            class="btn btn-success text-white fw-bold shadow-sm w-100 rounded-pill transition-all hover-lift d-flex align-items-center justify-content-center gap-2">
                                            <i class="ti ti-circle-check fs-5"></i> Setujui & Finalisasi
                                        </button>

                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalAction"
                                            class="btn btn-warning text-dark fw-bold shadow-sm w-100 rounded-pill transition-all hover-lift d-flex align-items-center justify-content-center gap-2 mt-1">
                                            <i class="ti ti-arrow-back-up fs-5"></i> Minta Revisi
                                        </button>
                                    </div>
                                <?php elseif($mou->status_mou == 3): ?>
                                    <div
                                        class="alert alert-warning border-warning border-start border-3 shadow-sm rounded-3 mb-0">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="ti ti-clock-pause text-warning fs-4 me-2"></i>
                                            <h6 class="mb-0 fw-bold text-dark">Menunggu Revisi Prodi</h6>
                                        </div>
                                        <p class="small text-dark-emphasis mb-0" style="line-height: 1.5;">
                                            Aksi ditangguhkan. Dokumen sedang dalam tahap perbaikan oleh pihak pengusul
                                            berdasarkan catatan revisi sebelumnya.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>


                        
                        <div class="modal fade" id="modalFinalisasi" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-success d-flex align-items-center"
                                            id="modalFinalisasiTitle">
                                            <i class="ti ti-circle-check me-2 fs-4"></i> Finalisasi Dokumen MoU
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    
                                    <form action="<?php echo e(route('berkas-MoU.update-feedback', $mou->id)); ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="status_mou" value="1">
                                        

                                        <div class="modal-body px-4 py-4">
                                            <div
                                                class="alert bg-success-subtle text-success border-0 small mb-4 rounded-3">
                                                <i class="ti ti-info-circle me-1"></i> Lengkapi data di bawah ini untuk
                                                menerbitkan MoU secara resmi ke sistem.
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark">Nomor MoU (Rektorat)
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="nomor_berkas_mou"
                                                        class="form-control bg-light border-0 px-3 py-2"
                                                        placeholder="Contoh: 123/UN.X/MoU/2024" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-bold text-dark">Pejabat Penandatangan
                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" name="pejabat_penandatangan"
                                                        class="form-control bg-light border-0 px-3 py-2"
                                                        placeholder="Contoh: Rektor / Wakil Rektor Bidang Kerja Sama"
                                                        required>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-bold text-dark">File MoU Final (Telah
                                                        Di-Tanda Tangani) <span class="text-danger">*</span></label>
                                                    <input type="file" name="file_mou_final"
                                                        class="form-control bg-light border-0 px-3 py-2"
                                                        accept=".pdf" required>
                                                    <small class="text-muted mt-1 d-block"
                                                        style="font-size: 11px;">Unggah
                                                        dokumen utuh berformat PDF hasil *scan* yang sudah
                                                        ditandatangani
                                                        dan dicap (Maks. 10MB).</small>
                                                </div>

                                                <div class="col-12">
                                                    <label class="form-label fw-bold text-dark">Catatan Finalisasi
                                                        <span class="text-danger">*</span></label>
                                                    <textarea name="catatan_admin" class="form-control bg-light border-0 p-3" rows="3" required>Dokumen MoU telah disetujui dan diregistrasi secara resmi oleh Admin Universitas. Dokumen sudah bisa digunakan sebagai rujukan payung hukum.</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit"
                                                class="btn btn-success text-white rounded-pill px-4 fw-bold shadow-sm">Simpan
                                                & Terbitkan MoU</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modalAction" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                                        <h5 class="modal-title fw-bold text-dark" id="modalActionTitle">Kembalikan
                                            untuk
                                            Revisi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo e(route('berkas-MoU.update-feedback', $mou->id)); ?>"
                                        method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="status_mou" value="3">

                                        <div class="modal-body px-4 py-4">
                                            <div class="alert bg-light border-0 small text-muted mb-4 rounded-3">
                                                <i class="ti ti-info-circle me-1"></i> Catatan ini akan dikirimkan ke
                                                pihak
                                                Prodi agar mereka dapat memperbaiki dokumen MoU.
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold text-dark">Catatan Revisi <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="catatan_admin" class="form-control bg-light border-0 p-3" rows="4"
                                                    placeholder="Tuliskan bagian mana saja yang perlu direvisi..." required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit"
                                                class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm">Kirim
                                                Revisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="mb-0 text-dark fw-bold">
                            <i class="ti ti-building-community me-2 text-primary"></i>Instansi Mitra
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary-subtle">
                            <div class="bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3 me-3 flex-shrink-0 shadow-sm"
                                style="width: 56px; height: 56px;">
                                <?php echo e(strtoupper(substr($mou->mitra->nama_mitra, 0, 1))); ?>

                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="fw-bold text-dark mb-1 text-truncate"
                                    title="<?php echo e($mou->mitra->nama_mitra); ?>">
                                    <?php echo e($mou->mitra->nama_mitra); ?>

                                </h6>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="ti ti-map-pin me-1 text-danger"></i>
                                    <span class="text-truncate"><?php echo e($mou->mitra->negara); ?></span>
                                </div>
                            </div>
                        </div>
                        <a href="<?php echo e(route('Manajemen-Mitra.show', $mou->mitra_id)); ?>"
                            class="btn btn-outline-primary fw-bold w-100 rounded-pill hover-primary transition-all shadow-sm">
                            Lihat Profil Mitra
                        </a>
                    </div>
                </div>

            </div>

            <?php if($mou->moas && $mou->moas->count() > 0): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div
                        class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="ti ti-link me-2 text-primary"></i>MoA Terkoneksi
                        </h6>
                        <span class="badge bg-primary rounded-pill"><?php echo e($mou->moas->count()); ?> Dokumen</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $mou->moas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $moa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item p-3 d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-2 me-3">
                                        <i class="ti ti-file-certificate fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate"><?php echo e($moa->judul_moa); ?></h6>
                                        <small class="text-muted">Nomor: <?php echo e($moa->nomor_moa ?? '-'); ?></small>
                                    </div>
                                    <a href="<?php echo e(route('moa.show', $moa->id)); ?>"
                                        class="btn btn-sm btn-light rounded-circle shadow-sm" title="Lihat MoA">
                                        <i class="ti ti-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <style>
        .hover-bg-light:hover {
            background-color: #f8f9fa !important;
            border-color: #cbd5e1 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
        }

        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* Trick to make the whole file card clickable while keeping the button functional */
        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }

        .btn-outline-danger {
            position: relative;
            z-index: 2;
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/kerjasama/berkas_mou/detail.blade.php ENDPATH**/ ?>