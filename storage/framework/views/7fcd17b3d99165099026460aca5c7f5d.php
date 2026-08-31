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
     <?php $__env->slot('title', null, []); ?> Detail Kerjasama <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Repository / Detail / <?php echo e($repository->nomor_dokumen); ?> <?php $__env->endSlot(); ?>

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="<?php echo e(route('Repository_kerjasama.index')); ?>" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('Repository_kerjasama.edit', $repository->id)); ?>" class="btn btn-warning rounded-pill px-4">
                    <i class="ti ti-edit me-1"></i> Edit Data
                </a>
                <button class="btn btn-danger rounded-pill px-4" onclick="confirmDelete()">
                    <i class="ti ti-trash me-1"></i> Hapus
                </button>
            </div>
        </div>

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between mb-4">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-white mb-2 px-3 py-2 rounded-pill">
                                    <?php echo e($repository->jenisDokumen->nama_jenis); ?>

                                </span>
                                <h3 class="fw-bold text-dark mb-1"><?php echo e($repository->judul_kerjasama); ?></h3>
                                <p class="text-muted mb-0"><i class="ti ti-hash me-1"></i>Nomor: <?php echo e($repository->nomor_dokumen); ?></p>
                            </div>
                            <div class="text-end">
                                <?php if($repository->status == 1): ?>
                                    <span class="badge bg-success px-4 py-2 rounded-pill shadow-sm">AKTIF</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-4 py-2 rounded-pill shadow-sm">KADALUARSA</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row g-4 pt-3 border-top">
                            <div class="col-md-4">
                                <label class="text-muted small d-block mb-1">Tanggal Mulai</label>
                                <h6 class="fw-bold"><i class="ti ti-calendar-event me-2 text-primary"></i><?php echo e(\Carbon\Carbon::parse($repository->tanggal_mulai)->translatedFormat('d F Y')); ?></h6>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block mb-1">Tanggal Berakhir</label>
                                <h6 class="fw-bold"><i class="ti ti-calendar-time me-2 text-danger"></i><?php echo e(\Carbon\Carbon::parse($repository->tanggal_berakhir)->translatedFormat('d F Y')); ?></h6>
                            </div>
                            <div class="col-md-4">
                                <label class="text-muted small d-block mb-1">Fakultas / Unit</label>
                                <h6 class="fw-bold"><i class="ti ti-school me-2 text-info"></i><?php echo e($repository->fakultas->nama_fakultas ?? 'Universitas'); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0"><i class="ti ti-users me-2 text-primary"></i>Pihak Terlibat</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Pihak</th>
                                        <th>Instansi / Mitra</th>
                                        <th>Penandatangan</th>
                                        <th class="pe-4">PIC Teknis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $repository->pihakTerlibat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pihak): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-outline-primary border border-primary text-primary rounded-pill">Ke-<?php echo e($pihak->urutan_pihak); ?></span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?php echo e($pihak->mitra->nama_mitra); ?></div>
                                            <small class="text-muted text-truncate d-block" style="max-width: 200px;"><?php echo e($pihak->alamat_instansi); ?></small>
                                        </td>
                                        <td>
                                            <div class="small fw-bold"><?php echo e($pihak->nama_penandatangan); ?></div>
                                            <div class="text-muted small"><?php echo e($pihak->jabatan_penandatangan); ?></div>
                                        </td>
                                        <td class="pe-4">
                                            <div class="small"><?php echo e($pihak->nama_penanggungjawab ?? '-'); ?></div>
                                            <div class="text-muted" style="font-size: 11px;"><?php echo e($pihak->jabatan_penanggungjawab ?? ''); ?></div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h5 class="fw-bold mb-0"><i class="ti ti-list-check me-2 text-success"></i>Rincian Kegiatan</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Nama Kegiatan</th>
                                        <th>Nilai Kontrak</th>
                                        <th>Sasaran & Luaran</th>
                                        <th class="pe-4">Indikator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $repository->bentukKegiatan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kegiatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark"><?php echo e($kegiatan->nama_bentuk_kegiatan); ?></td>
                                        <td><span class="text-success fw-bold">Rp <?php echo e(number_format($kegiatan->nilai_kontrak, 0, ',', '.')); ?></span></td>
                                        <td>
                                            <div class="small"><span class="badge bg-light text-dark me-1">Sasaran:</span> <?php echo e($kegiatan->sasaran); ?></div>
                                            <div class="small mt-1 text-muted"><?php echo e($kegiatan->luaran); ?></div>
                                        </td>
                                        <td class="pe-4 small text-muted"><?php echo e($kegiatan->indikator_kerja); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">Ringkasan Deskripsi</h6>
                        <p class="text-muted small mb-0" style="line-height: 1.6;">
                            <?php echo e($repository->deskripsi ?? 'Tidak ada deskripsi tambahan untuk kerjasama ini.'); ?>

                        </p>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-dark border-0 p-3">
                        <h6 class="text-white mb-0 small fw-bold"><i class="ti ti-files me-2"></i>Berkas Lampiran</h6>
                    </div>
                    <div class="card-body p-3">
                        <?php if($repository->files->count() > 0): ?>
                            <div class="list-group list-group-flush">
                                <?php $__currentLoopData = $repository->files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="list-group-item bg-transparent px-0 border-dashed-bottom">
                                        <div class="d-flex align-items-center">
                                            
                                            <div class="p-2 bg-light rounded-3 text-danger me-3">
                                                <i class="ti ti-file-type-pdf fs-4"></i>
                                            </div>

                                            
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h6 class="mb-0 text-truncate small fw-bold"><?php echo e($file->nama_file); ?></h6>
                                                <small class="text-muted" style="font-size: 10px;"><?php echo e(number_format($file->size / 1024, 2)); ?> KB</small>
                                            </div>

                                            
                                            
                                            <a href="<?php echo e($file->signed_url); ?>"
                                            target="_blank"
                                            class="btn btn-sm btn-light border shadow-sm"
                                            title="Pratinjau Aman">
                                                <i class="ti ti-eye text-primary"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="ti ti-file-off fs-1 text-muted d-block mb-2"></i>
                                <span class="text-muted small">Tidak ada lampiran berkas.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-dashed-bottom { border-bottom: 1px dashed #dee2e6; }
        .border-dashed-bottom:last-child { border-bottom: none; }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/Repository/detail.blade.php ENDPATH**/ ?>