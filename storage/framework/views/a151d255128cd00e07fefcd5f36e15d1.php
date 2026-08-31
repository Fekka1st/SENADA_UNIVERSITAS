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
     <?php $__env->slot('title', null, []); ?> Master Data - Sasaran Kerja <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Master Data / Sasaran Kerja <?php $__env->endSlot(); ?>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
            
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

            
            <?php if (isset($component)) { $__componentOriginalf62c325e4af28667db0b3dbb4d765e5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf62c325e4af28667db0b3dbb4d765e5d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.filter-bar','data' => ['searchId' => 'customSearch','searchPlaceholder' => 'Pencarian sasaran kerja...','hasDateFilter' => false,'hasExport' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.filter-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchId' => 'customSearch','searchPlaceholder' => 'Pencarian sasaran kerja...','hasDateFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'hasExport' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>

                
                 <?php $__env->slot('additionalButtons', null, []); ?> 
                    

                    <a href="<?php echo e(route('master-data.sasaran_kerja.create')); ?>" class="btn btn-primary d-flex align-items-center gap-2 flex-shrink-0 shadow-sm rounded-pill px-3">
                        <i class="ti ti-plus"></i> Tambah Sasaran Kerja
                    </a>
                 
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf62c325e4af28667db0b3dbb4d765e5d)): ?>
<?php $attributes = $__attributesOriginalf62c325e4af28667db0b3dbb4d765e5d; ?>
<?php unset($__attributesOriginalf62c325e4af28667db0b3dbb4d765e5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf62c325e4af28667db0b3dbb4d765e5d)): ?>
<?php $component = $__componentOriginalf62c325e4af28667db0b3dbb4d765e5d; ?>
<?php unset($__componentOriginalf62c325e4af28667db0b3dbb4d765e5d); ?>
<?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                
                <?php if (isset($component)) { $__componentOriginal6560fc3ad76cf5949812372c29413a89 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6560fc3ad76cf5949812372c29413a89 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.per-page','data' => ['selectId' => 'perPage','options' => [5, 10, 25, 50, 100],'default' => 10]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.per-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['selectId' => 'perPage','options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([5, 10, 25, 50, 100]),'default' => 10]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6560fc3ad76cf5949812372c29413a89)): ?>
<?php $attributes = $__attributesOriginal6560fc3ad76cf5949812372c29413a89; ?>
<?php unset($__attributesOriginal6560fc3ad76cf5949812372c29413a89); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6560fc3ad76cf5949812372c29413a89)): ?>
<?php $component = $__componentOriginal6560fc3ad76cf5949812372c29413a89; ?>
<?php unset($__componentOriginal6560fc3ad76cf5949812372c29413a89); ?>
<?php endif; ?>
                <div class="text-muted small d-none d-md-block">
                    <i class="ti ti-info-circle me-1"></i> Daftar master data target/sasaran dari kegiatan kerjasama
                </div>
            </div>

            
            <?php if (isset($component)) { $__componentOriginale9454b11ce6ec38d56f723fe8a017055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9454b11ce6ec38d56f723fe8a017055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.wrapper','data' => ['tableId' => 'sasaranKerjaTable','columns' => [
                    'No',
                    'Nama Sasaran Kerja',
                    'Jumlah Indikator',
                    'Keterangan',
                    'Aksi'
                ],'hasCheckbox' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'sasaranKerjaTable','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'No',
                    'Nama Sasaran Kerja',
                    'Jumlah Indikator',
                    'Keterangan',
                    'Aksi'
                ]),'hasCheckbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale9454b11ce6ec38d56f723fe8a017055)): ?>
<?php $attributes = $__attributesOriginale9454b11ce6ec38d56f723fe8a017055; ?>
<?php unset($__attributesOriginale9454b11ce6ec38d56f723fe8a017055); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale9454b11ce6ec38d56f723fe8a017055)): ?>
<?php $component = $__componentOriginale9454b11ce6ec38d56f723fe8a017055; ?>
<?php unset($__componentOriginale9454b11ce6ec38d56f723fe8a017055); ?>
<?php endif; ?>
        </div>
    </div>

    <?php
        // Build columns configuration
        $columnsConfig = [];

        $columnsConfig[] = [
            'data' => 'DT_RowIndex',
            'name' => 'DT_RowIndex',
            'orderable' => false,
            'searchable' => false,
            'width' => '50px',
            'className' => 'text-center all',
            'responsivePriority' => 1
        ];


        $columnsConfig[] = [
            'data' => 'nama_sasaran',
            'name' => 'nama_sasaran',
            'className' => 'fw-bold text-dark all',
            'responsivePriority' => 2
        ];
        $columnsConfig[] = [
            'data' => 'jumlah_indikator',
            'name' => 'indikator_kerja_count',
            'className' => 'text-center',
            'searchable' => false
        ];
        $columnsConfig[] = [
            'data' => 'keterangan',
            'name' => 'keterangan',
            'className' => 'text-muted'
        ];

        $columnsConfig[] = [
            'data' => 'action',
            'name' => 'action',
            'orderable' => false,
            'searchable' => false,
            'width' => '100px',
            'className' => 'text-center'
        ];
    ?>


    <?php if (isset($component)) { $__componentOriginal1c2b979406087a497c6fe4479f01e65c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2b979406087a497c6fe4479f01e65c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.scripts','data' => ['tableId' => 'sasaranKerjaTable','ajaxUrl' => ''.e(route('master-data.sasaran_kerja.getData')).'','columns' => $columnsConfig,'order' => [[1, 'asc']],'pageLength' => 10,'searchId' => 'customSearch','perPageId' => 'perPage','hasDateFilter' => false,'hasExport' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'sasaranKerjaTable','ajaxUrl' => ''.e(route('master-data.sasaran_kerja.getData')).'','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsConfig),'order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([[1, 'asc']]),'pageLength' => 10,'searchId' => 'customSearch','perPageId' => 'perPage','hasDateFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'hasExport' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1c2b979406087a497c6fe4479f01e65c)): ?>
<?php $attributes = $__attributesOriginal1c2b979406087a497c6fe4479f01e65c; ?>
<?php unset($__attributesOriginal1c2b979406087a497c6fe4479f01e65c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1c2b979406087a497c6fe4479f01e65c)): ?>
<?php $component = $__componentOriginal1c2b979406087a497c6fe4479f01e65c; ?>
<?php unset($__componentOriginal1c2b979406087a497c6fe4479f01e65c); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal9bb3a892d945664f458b28dbbf2a402e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.hapus','data' => ['id' => 'modalHapusSasaranKerja','title' => 'Hapus Sasaran Kerja','isDynamic' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.hapus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modalHapusSasaranKerja','title' => 'Hapus Sasaran Kerja','isDynamic' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $attributes = $__attributesOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__attributesOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e)): ?>
<?php $component = $__componentOriginal9bb3a892d945664f458b28dbbf2a402e; ?>
<?php unset($__componentOriginal9bb3a892d945664f458b28dbbf2a402e); ?>
<?php endif; ?>

    
    <script>
        $(document).ready(function() {
            // Handle click pada tombol delete
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const nama = $(this).data('nama');

                // Update modal content
                $('#modalHapusSasaranKerjaItemName').text(nama);

                // Update form action - sesuaikan dengan route destroy
                const deleteUrl = '<?php echo e(route("master-data.sasaran_kerja.destroy", ":id")); ?>'.replace(':id', id);
                $('#modalHapusSasaranKerjaForm').attr('action', deleteUrl);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusSasaranKerja'));
                modal.show();
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips setelah DataTables draw
            $('#sasaranKerjaTable').on('draw.dt', function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/sasaran_kerja/index.blade.php ENDPATH**/ ?>