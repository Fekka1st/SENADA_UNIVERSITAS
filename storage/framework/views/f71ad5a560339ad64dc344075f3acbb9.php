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
     <?php $__env->slot('title', null, []); ?> Backup Database <?php $__env->endSlot(); ?>

    <div class="card">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.filter-bar','data' => ['searchId' => 'customSearch','searchPlaceholder' => 'Pencarian...','hasDateFilter' => false,'hasExport' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.filter-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchId' => 'customSearch','searchPlaceholder' => 'Pencarian...','hasDateFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'hasExport' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
                
                
                 <?php $__env->slot('additionalButtons', null, []); ?> 
                    <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'backup_database.create')): ?>
                    <button type="button" id="btnProsesBackup" class="btn btn-primary d-flex align-items-center gap-1 flex-shrink-0">
                        <i class="ti ti-database-export" id="backupIcon"></i>
                        <span id="backupText">Proses Backup</span>
                    </button>
                    <?php endif; ?>
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

            
            <?php if (isset($component)) { $__componentOriginale9454b11ce6ec38d56f723fe8a017055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9454b11ce6ec38d56f723fe8a017055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.wrapper','data' => ['tableId' => 'backupTable','columns' => [
                    'No',
                    'File',
                    'Waktu Backup',
                    'Ukuran',
                    'Aksi'
                ],'hasCheckbox' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'backupTable','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                    'No',
                    'File',
                    'Waktu Backup',
                    'Ukuran',
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
            'data' => 'file',
            'name' => 'file',
            'className' => 'all',
            'responsivePriority' => 2
        ];
        
        $columnsConfig[] = [
            'data' => 'waktu_backup',
            'name' => 'waktu_backup'
        ];
        
        $columnsConfig[] = [
            'data' => 'ukuran',
            'name' => 'ukuran'
        ];
        
        $columnsConfig[] = [
            'data' => 'aksi',
            'name' => 'aksi',
            'orderable' => false,
            'searchable' => false,
            'width' => '100px'
        ];
    ?>

    
    <?php if (isset($component)) { $__componentOriginal1c2b979406087a497c6fe4479f01e65c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2b979406087a497c6fe4479f01e65c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.scripts','data' => ['tableId' => 'backupTable','ajaxUrl' => ''.e(route('backup-database.datatables')).'','columns' => $columnsConfig,'order' => [[2, 'desc']],'pageLength' => 10,'searchId' => 'customSearch','perPageId' => 'perPage','hasDateFilter' => false,'hasExport' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'backupTable','ajaxUrl' => ''.e(route('backup-database.datatables')).'','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($columnsConfig),'order' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([[2, 'desc']]),'pageLength' => 10,'searchId' => 'customSearch','perPageId' => 'perPage','hasDateFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'hasExport' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.hapus','data' => ['id' => 'modalHapusBackup','title' => 'Hapus Backup Database','isDynamic' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.hapus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modalHapusBackup','title' => 'Hapus Backup Database','isDynamic' => true]); ?>
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
            // ========================================
            // PROSES BACKUP DATABASE
            // ========================================
            $('#btnProsesBackup').on('click', function(e) {
                e.preventDefault();
                
                const btn = $(this);
                const icon = $('#backupIcon');
                const text = $('#backupText');
                
                // Simpan state awal
                const originalIcon = icon.attr('class');
                const originalText = text.text();
                
                // Disable button dan tampilkan loading
                btn.prop('disabled', true);
                icon.removeClass().addClass('ti ti-loader-2 ti-spin');
                text.text('Memproses...');
                
                // Kirim request AJAX
                $.ajax({
                    url: '<?php echo e(route("backup-database.backup")); ?>',
                    type: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Tampilkan notifikasi sukses
                            showNotification('success', response.message);
                            
                            // Reload tabel
                            $('#backupTable').DataTable().ajax.reload(null, false);
                        } else {
                            showNotification('error', response.message);
                        }
                    },
                    error: function(xhr) {
                        let message = 'Terjadi kesalahan saat memproses backup database.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        
                        showNotification('error', message);
                    },
                    complete: function() {
                        // Kembalikan button ke state semula
                        btn.prop('disabled', false);
                        icon.removeClass().addClass(originalIcon);
                        text.text(originalText);
                    }
                });
            });

            // ========================================
            // HAPUS BACKUP
            // ========================================
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                const file = $(this).data('file');
                
                // Update modal content
                $('#modalHapusBackupItemName').text(file);
                
                // Update form action
                const deleteUrl = '<?php echo e(route("backup-database.destroy", ":file")); ?>'.replace(':file', encodeURIComponent(file));
                $('#modalHapusBackupForm').attr('action', deleteUrl);
                
                // Tidak ada warning relasi, langsung bisa hapus
                $('#modalHapusBackupWarningRelated').addClass('d-none');
                $('#modalHapusBackupWarningDelete').removeClass('d-none');
                $('#modalHapusBackupBtnSubmit').prop('disabled', false).removeClass('d-none');
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('modalHapusBackup'));
                modal.show();
            });

            // ========================================
            // HELPER: SHOW NOTIFICATION
            // ========================================
            function showNotification(type, message) {
                // Buat alert element
                const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                const iconClass = type === 'success' ? 'ti-check' : 'ti-alert-circle';
                
                const alertHtml = `
                    <div class="alert ${alertClass} alert-dismissible fade show d-flex align-items-center" role="alert">
                        <i class="ti ${iconClass} fs-5 me-2"></i>
                        <div>${message}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                // Hapus alert lama jika ada di dalam card-body
                $('.card .card-body > .alert').remove();
                
                // Tambahkan alert baru setelah x-alert component di dalam card-body
                $('.card .card-body').find('x-alert, .alert').first().remove();
                $('.card .card-body').prepend(alertHtml);
                
                // Auto dismiss setelah 5 detik
                setTimeout(function() {
                    $('.card .card-body > .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            // ========================================
            // INITIALIZE TOOLTIPS
            // ========================================
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Re-initialize tooltips after DataTables draw
            $('#backupTable').on('draw.dt', function() {
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/backup-database/index.blade.php ENDPATH**/ ?>