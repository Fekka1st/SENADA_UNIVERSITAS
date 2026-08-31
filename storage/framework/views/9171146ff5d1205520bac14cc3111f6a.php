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
     <?php $__env->slot('title', null, []); ?> Tambah Sasaran Kerja & Indikator <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Master Data / Sasaran Kerja / Tambah <?php $__env->endSlot(); ?>

    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10"> 

            
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

            <form action="<?php echo e(route('master-data.sasaran_kerja.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 p-md-5"> 
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary text-white rounded-4 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 48px; height: 48px;">
                                <i class="ti ti-target fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bolder text-dark mb-1">Informasi Sasaran Kerja</h5>
                                <p class="small text-muted mb-0">Tentukan target utama dari kegiatan kerjasama ini.</p>
                            </div>
                        </div>

                        <div class="row g-4">
                            
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Nama Sasaran Kerja <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg shadow-none rounded-3 overflow-hidden border">
                                    <span class="input-group-text bg-light border-0 text-muted px-4"><i class="ti ti-writing"></i></span>
                                    <input type="text" name="nama_sasaran"
                                        class="form-control bg-light border-0 fs-6 <?php $__errorArgs = ['nama_sasaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        value="<?php echo e(old('nama_sasaran')); ?>"
                                        placeholder="Contoh: Meningkatnya kualitas lulusan..."
                                        autocomplete="off" required>
                                </div>
                                <?php $__errorArgs = ['nama_sasaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small mt-2 fw-medium"><i class="ti ti-alert-circle me-1"></i><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Keterangan / Deskripsi <span class="text-muted fw-normal small">(Opsional)</span></label>
                                <textarea name="keterangan" rows="3"
                                    class="form-control bg-light border shadow-none rounded-3 p-3"
                                    placeholder="Berikan penjelasan tambahan jika diperlukan..."><?php echo e(old('keterangan')); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-4 px-4 px-md-5 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="ti ti-chart-bar fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bolder text-dark mb-0 d-flex align-items-center gap-2">
                                    Rincian Indikator (IKU/IKP)
                                    <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 10px; letter-spacing: 0.5px;">OPSIONAL</span>
                                </h6>
                            </div>
                        </div>
                        <button type="button" id="btnAddIndikator" class="btn btn-primary fw-bold rounded-pill px-4 shadow-sm hover-lift d-flex align-items-center">
                            <i class="ti ti-plus me-2"></i> Tambah Baris
                        </button>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="indikatorTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 px-4 text-center text-muted fw-bold" style="width: 5%;">No</th>
                                        <th class="py-3 px-2 text-muted fw-bold" style="width: 45%;">NAMA INDIKATOR <span class="text-danger">*</span></th>
                                        <th class="py-3 px-2 text-muted fw-bold" style="width: 40%;">KETERANGAN</th>
                                        <th class="py-3 px-4 text-center text-muted fw-bold" style="width: 10%;">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody id="indikatorTableBody" class="border-top-0">
                                    
                                    <tr id="emptyStateRow">
                                        <td colspan="4" class="p-4 p-md-5">
                                            <div class="text-center p-5 border border-2 border-dashed rounded-4 bg-light bg-opacity-50">
                                                <div class="bg-white rounded-circle d-inline-flex p-3 mb-3 shadow-sm border">
                                                    <i class="ti ti-table-plus text-primary fs-2"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark mb-2">Belum Ada Indikator Target</h6>
                                                <p class="small text-muted mb-0 max-w-sm mx-auto">Klik tombol <strong>"Tambah Baris"</strong> di atas untuk mulai mendata indikator kinerja. Anda juga dapat melewatinya dan mengisi nanti.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                
                <div class="d-flex justify-content-end gap-3 mb-5 mt-4">
                    <a href="<?php echo e(route('master-data.sasaran_kerja.index')); ?>" class="btn btn-light fw-bold px-4 py-2 rounded-pill hover-dark border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-dark fw-bold px-5 py-2 rounded-pill shadow-sm hover-lift">
                        <i class="ti ti-device-floppy me-2"></i>Simpan Master Data
                    </button>
                </div>

            </form>
        </div>
    </div>

    <style>
        /* Modern Utilities */
        .border-dashed { border-style: dashed !important; border-color: #cbd5e1 !important; }
        .hover-dark:hover { background-color: #e2e8f0; color: #0f172a !important; transition: all 0.2s ease; }
        .hover-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important; }

        /* Table Input Styling */
        .input-seamless {
            background-color: #f8fafc;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .input-seamless:focus {
            background-color: #ffffff !important;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        }
        .table > :not(caption) > * > * {
            border-bottom-color: #f1f5f9; /* Soft border untuk tabel */
        }
    </style>

    <?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            let indikatorIndex = 0;
            const $tbody = $('#indikatorTableBody');
            const $emptyState = $('#emptyStateRow');

            function refreshTable() {
                const $rows = $tbody.find('.indikator-row');

                if ($rows.length === 0) {
                    $emptyState.show();
                } else {
                    $emptyState.hide();
                    $rows.each(function(index) {
                        $(this).find('.row-number').text(index + 1);
                        $(this).find('.input-nama').attr('name', `indikator[${index}][nama_indikator]`);
                        $(this).find('.input-ket').attr('name', `indikator[${index}][keterangan]`);
                    });
                }
                indikatorIndex = $rows.length;
            }

            $('#btnAddIndikator').click(function() {
                $emptyState.hide();

                // Menggunakan input type="text" menggantikan textarea agar baris tabel konsisten tingginya
                const trHtml = `
                    <tr class="indikator-row animate__animated animate__fadeIn">
                        <td class="text-center align-middle fw-bolder text-secondary row-number px-4"></td>
                        <td class="align-middle px-2 py-3">
                            <input type="text" name="indikator[${indikatorIndex}][nama_indikator]"
                                class="form-control form-control-sm py-2 rounded-3 input-seamless input-nama fw-medium"
                                placeholder="Ketik nama IKU/IKP..." required>
                        </td>
                        <td class="align-middle px-2 py-3">
                            <input type="text" name="indikator[${indikatorIndex}][keterangan]"
                                class="form-control form-control-sm py-2 rounded-3 input-seamless input-ket"
                                placeholder="Catatan opsional...">
                        </td>
                        <td class="text-center align-middle px-4">
                            <button type="button" class="btn btn-sm btn-light text-danger rounded-circle border-0 btn-remove-indikator shadow-sm"
                                style="width: 35px; height: 35px;" title="Hapus Baris">
                                <i class="ti ti-trash fs-6"></i>
                            </button>
                        </td>
                    </tr>
                `;

                $tbody.append(trHtml);
                refreshTable();
                $tbody.find('.indikator-row').last().find('.input-nama').focus();
            });

            $(document).on('click', '.btn-remove-indikator', function() {
                const $row = $(this).closest('.indikator-row');
                $row.fadeOut(200, function() {
                    $(this).remove();
                    refreshTable();
                });
            });

            refreshTable();
        });
    </script>
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/sasaran_kerja/create.blade.php ENDPATH**/ ?>