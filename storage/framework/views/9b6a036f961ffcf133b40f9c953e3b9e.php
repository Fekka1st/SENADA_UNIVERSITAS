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
     <?php $__env->slot('title', null, []); ?> Detail Mitra Strategis <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Manajemen / Mitra / Detail / <?php echo e($mitra->nama_mitra); ?> <?php $__env->endSlot(); ?>
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

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="container-fluid">
        
        <div class="row g-4 mb-4">
            
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-layout-grid me-2 text-primary"></i>Informasi Instansi</h5>
                        <div class="d-flex gap-2">
                            <a href="<?php echo e(route('Manajemen-Mitra.edit', $mitra->id)); ?>" class="btn btn-sm btn-light border fw-bold text-dark px-3">
                                <i class="ti ti-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12 mb-2">
                                <h3 class="fw-bold text-dark mb-1"><?php echo e($mitra->nama_mitra); ?></h3>
                                <div class="d-flex align-items-center gap-2">
                                    <?php $warna = $mitra->kategori->warna_peta ?? '#6c757d'; ?>
                                    <span class="badge border" style="background-color: <?php echo e($warna); ?>15; color: <?php echo e($warna); ?>; border-color: <?php echo e($warna); ?>30;">
                                        <?php echo e($mitra->kategori->nama_kategori ?? 'Umum'); ?>

                                    </span>
                                    <span class="text-muted small">|</span>
                                    <span class="text-muted small"><i class="ti ti-calendar me-1"></i>Terdaftar <?php echo e($mitra->created_at->format('d/m/Y')); ?></span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Negara Asal</label>
                                <p class="text-dark mb-0 fw-semibold"><?php echo e($mitra->negara); ?></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Official Website</label>
                                <?php if($mitra->url_website): ?>
                                    <a href="<?php echo e($mitra->url_website); ?>" target="_blank" class="text-primary fw-bold text-decoration-none d-flex align-items-center">
                                        <?php echo e(str_replace(['https://', 'http://'], '', $mitra->url_website)); ?> <i class="ti ti-external-link ms-1 small"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small italic">Tidak tersedia</span>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <hr class="my-1 opacity-25">
                                <label class="text-muted small fw-bold text-uppercase d-block mb-1">Alamat Lengkap</label>
                                <p class="text-dark mb-0 fs-6 lh-base"><?php echo e($mitra->alamat_lengkap ?: 'Detail alamat belum dikonfigurasi.'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-map-2 text-success me-2"></i>Lokasi Geospasial</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="map" style="height: 100%; min-height: 300px; z-index: 1;"></div>
                    </div>
                    <div class="card-footer bg-white py-2 border-top-0">
                        <div class="d-flex justify-content-between small text-muted font-monospace">
                            <span>Lat: <?php echo e($mitra->latitude); ?></span>
                            <span>Lng: <?php echo e($mitra->longtitude); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-users text-primary me-2"></i>Daftar Personil (PIC)</h5>
                        </div>
                        

                    </div>
                    <div class="card-body">
                        
                        <?php if (isset($component)) { $__componentOriginalf62c325e4af28667db0b3dbb4d765e5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf62c325e4af28667db0b3dbb4d765e5d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.filter-bar','data' => ['searchId' => 'searchPic','searchPlaceholder' => 'Cari Nama atau Jabatan...','hasDateFilter' => false,'hasExport' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.filter-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchId' => 'searchPic','searchPlaceholder' => 'Cari Nama atau Jabatan...','hasDateFilter' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'hasExport' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>

                             <?php $__env->slot('additionalButtons', null, []); ?> 
                                <?php if (\Illuminate\Support\Facades\Blade::check('permission', 'mitra.create')): ?>
                               <a href="<?php echo e(route('Pic-Mitra.create', $mitra->id)); ?>" class="btn btn-primary d-flex align-items-center gap-1">
                                    <i class="ti ti-plus"></i> Tambah PIC
                                </a>
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

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <?php if (isset($component)) { $__componentOriginal6560fc3ad76cf5949812372c29413a89 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6560fc3ad76cf5949812372c29413a89 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.per-page','data' => ['selectId' => 'perPagePic','default' => 5]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.per-page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['selectId' => 'perPagePic','default' => 5]); ?>
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
                        </div>

                        <?php if (isset($component)) { $__componentOriginale9454b11ce6ec38d56f723fe8a017055 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale9454b11ce6ec38d56f723fe8a017055 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.wrapper','data' => ['tableId' => 'picTable','columns' => ['No', 'Nama & Jabatan', 'WhatsApp', 'Email', 'Status', 'Aksi'],'hasCheckbox' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.wrapper'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'picTable','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['No', 'Nama & Jabatan', 'WhatsApp', 'Email', 'Status', 'Aksi']),'hasCheckbox' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
            </div>
        </div>

        <?php
            $picColumnsConfig = [
                ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'width' => '50px', 'className' => 'text-center'],
                ['data' => 'pic_info', 'name' => 'nama_pic', 'className' => 'fw-bold text-dark'],
                ['data' => 'kontak', 'name' => 'no_telp', 'className' => 'text-center'],
                ['data' => 'email', 'name' => 'email'],
                ['data' => 'status', 'name' => 'status_pic', 'className' => 'text-center'],
                ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false, 'width' => '100px', 'className' => 'text-center']
            ];
        ?>

        <?php if (isset($component)) { $__componentOriginal1c2b979406087a497c6fe4479f01e65c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1c2b979406087a497c6fe4479f01e65c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.scripts','data' => ['tableId' => 'picTable','ajaxUrl' => ''.e(route('Pic-Mitra.getData', $mitra->id)).'','columns' => $picColumnsConfig,'searchId' => 'searchPic','perPageId' => 'perPagePic']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.scripts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tableId' => 'picTable','ajaxUrl' => ''.e(route('Pic-Mitra.getData', $mitra->id)).'','columns' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($picColumnsConfig),'searchId' => 'searchPic','perPageId' => 'perPagePic']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.hapus','data' => ['id' => 'modalHapusPic','title' => 'Hapus Personil PIC','isDynamic' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.hapus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modalHapusPic','title' => 'Hapus Personil PIC','isDynamic' => true]); ?>
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

        <div class="mt-4 text-center">
            <a href="<?php echo e(route('Manajemen-Mitra.index')); ?>" class="btn btn-primary text-mute small">
                <i class="ti ti-arrow-left me-1"></i> Kembali ke Daftar Utama
            </a>
        </div>
    </div>

    <script>
        $(document).on('click', '.btn-delete-pic', function() {
            const id = $(this).data('id');
            const nama = $(this).data('nama');
            $('#modalHapusPicItemName').text(nama);
            let url = '<?php echo e(route("Pic-Mitra.destroy", ":id")); ?>';
            $('#modalHapusPicForm').attr('action', url.replace(':id', id));
            new bootstrap.Modal(document.getElementById('modalHapusPic')).show();
        });
    </script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = <?php echo e($mitra->latitude ?? -2.5489); ?>;
            var lng = <?php echo e($mitra->longtitude ?? 118.0149); ?>;

            var map = L.map('map', {
                scrollWheelZoom: false,
                zoomControl: false
            }).setView([lat, lng], 15);

            L.control.zoom({ position: 'topright' }).addTo(map);

            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <div style="font-family: sans-serif;">
                    <b style="font-size: 14px; color: #2c3e50;"><?php echo e($mitra->nama_mitra); ?></b><br>
                    <span style="font-size: 12px; color: #7f8c8d;">
                        <i class="ti ti-map-pin me-1"></i> <?php echo e($mitra->alamat_lengkap); ?>

                    </span>
                </div>
            `).openPopup();
        });
    </script>

    <style>
        .avatar-simple { width: 34px; height: 34px; background: #f0f2f5; border: 1px solid #e1e4e8; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #5a6a85; font-size: 12px; }
        .bg-light-subtle { background-color: #fbfbfb; }
        .btn-white { background: #fff; }
        .btn-white:hover { background: #f8f9fa; }
        .table thead th { font-weight: 700; }
        .card-header { letter-spacing: 0.2px; }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/Manajemen-Mitra/detail.blade.php ENDPATH**/ ?>