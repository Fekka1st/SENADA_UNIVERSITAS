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
     <?php $__env->slot('title', null, []); ?> Detail Sasaran Kerja <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Master Data / Sasaran Kerja / Detail <?php $__env->endSlot(); ?>

    <div class="row">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                            style="width: 40px; height: 40px;">
                            <i class="ti ti-info-circle fs-5"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0">Informasi Dasar</h6>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted d-block mb-1">Nama Sasaran Kerja</label>
                        <p class="fw-bold text-dark mb-0"><?php echo e($sasaranKerja->nama_sasaran); ?></p>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted d-block mb-1">Keterangan</label>
                        <p class="text-muted small mb-0"><?php echo e($sasaranKerja->keterangan ?? 'Tidak ada deskripsi.'); ?></p>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('master-data.sasaran_kerja.edit', $sasaranKerja->id)); ?>"
                            class="btn btn-warning fw-bold text-dark rounded-pill">
                            <i class="ti ti-edit me-1"></i> Edit Sasaran
                        </a>
                        <a href="<?php echo e(route('master-data.sasaran_kerja.index')); ?>"
                            class="btn btn-light fw-bold rounded-pill">
                            <i class="ti ti-arrow-left me-1"></i> Kembali ke List
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div
                    class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-chart-dots me-2 text-primary fs-5"></i>
                        <h6 class="fw-bold text-dark mb-0">Daftar Indikator Kerja</h6>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm fw-bold rounded-pill px-3"
                        data-bs-toggle="modal" data-bs-target="#modalTambahIndikator">
                        <i class="ti ti-plus me-1"></i> Tambah Indikator
                    </button>
                </div>
                <div class="card-body p-0">
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

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-4 text-muted fw-bold" style="width: 50px;">No</th>
                                    <th class="py-3 px-4 text-muted fw-bold">Nama Indikator (IKU/IKP)</th>
                                    <th class="py-3 px-4 text-muted fw-bold">Keterangan</th>
                                    <th class="py-3 px-4 text-center text-muted fw-bold" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $sasaranKerja->indikatorKerja; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="px-4 text-center text-muted fw-bold"><?php echo e($index + 1); ?></td>
                                        <td class="px-4 fw-bold text-dark"><?php echo e($item->nama_indikator); ?></td>
                                        <td class="px-4 text-muted small"><?php echo e($item->keterangan ?? '-'); ?></td>
                                        <td class="px-4 text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-warning border rounded-circle btn-edit-indikator"
                                                    style="width: 32px; height: 32px;" data-id="<?php echo e($item->id); ?>"
                                                    data-nama="<?php echo e($item->nama_indikator); ?>"
                                                    data-ket="<?php echo e($item->keterangan); ?>">
                                                    <i class="ti ti-edit"></i>
                                                </button>
                                                <form
                                                    action="<?php echo e(route('master-data.sasaran_kerja.destroy_indikator', $item->id)); ?>"
                                                    method="POST" onsubmit="return confirm('Hapus indikator ini?')">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-danger border rounded-circle"
                                                        style="width: 32px; height: 32px;">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="ti ti-ghost fs-1 d-block mb-2 opacity-50"></i>
                                            Belum ada indikator untuk sasaran kerja ini.
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

    
    <div class="modal fade" id="modalTambahIndikator" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form action="<?php echo e(route('master-data.sasaran_kerja.store_indikator', $sasaranKerja->id)); ?>"
                    method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header border-bottom py-3">
                        <h6 class="modal-title fw-bold text-dark">Tambah Indikator Baru</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Indikator <span class="text-danger">*</span></label>
                            <input type="text" name="nama_indikator" class="form-control bg-light"
                                placeholder="Masukkan nama IKU/IKP..." required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control bg-light" rows="3" placeholder="Tambahkan penjelasan jika ada..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-3">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold rounded-pill px-4">Simpan
                            Indikator</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="modalEditIndikator" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form id="formEditIndikator" action="" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                    <div class="modal-header border-bottom py-3">
                        <h6 class="modal-title fw-bold text-dark">Edit Indikator</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Indikator <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_indikator" id="edit_nama_indikator"
                                class="form-control bg-light" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label fw-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="edit_keterangan_indikator" class="form-control bg-light" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-3">
                        <button type="button" class="btn btn-light fw-bold rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 text-dark">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.btn-edit-indikator').click(function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const ket = $(this).data('ket');

                // Set data ke dalam input modal
                $('#edit_nama_indikator').val(nama);
                $('#edit_keterangan_indikator').val(ket);

                // Update form action URL secara dinamis
                let updateUrl = '<?php echo e(route('master-data.sasaran_kerja.update_indikator', ':id')); ?>';
                updateUrl = updateUrl.replace(':id', id);
                $('#formEditIndikator').attr('action', updateUrl);

                // Tampilkan modal
                const editModal = new bootstrap.Modal(document.getElementById('modalEditIndikator'));
                editModal.show();
            });
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/sasaran_kerja/detail.blade.php ENDPATH**/ ?>