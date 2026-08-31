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
     <?php $__env->slot('title', null, []); ?> Edit Mitra: <?php echo e($mitra->nama_mitra); ?> <?php $__env->endSlot(); ?>
     <?php $__env->slot('breadcrumb', null, []); ?> Edit Mitra <?php $__env->endSlot(); ?>
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

    <form action="<?php echo e(route('Manajemen-Mitra.update', $mitra->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-warning"><i class="ti ti-edit me-2"></i>Informasi Instansi Mitra</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nama Mitra <span class="text-danger">*</span></label>
                                <input type="text" name="nama_mitra" class="form-control <?php $__errorArgs = ['nama_mitra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_mitra', $mitra->nama_mitra)); ?>" required>
                                <?php $__errorArgs = ['nama_mitra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Kategori Mitra <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select select2" required>
                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kat->id); ?>" <?php echo e((old('kategori_id', $mitra->kategori_id) == $kat->id) ? 'selected' : ''); ?>>
                                            <?php echo e($kat->nama_kategori); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Negara <span class="text-danger">*</span></label>
                                <input type="text" name="negara" class="form-control" value="<?php echo e(old('negara', $mitra->negara)); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="ti ti-world"></i></span>
                                    <input type="url" name="url_website" class="form-control" placeholder="https://..." value="<?php echo e(old('url_website', $mitra->url_website)); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3"><?php echo e(old('alamat_lengkap', $mitra->alamat_lengkap)); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="ti ti-map-pin me-2"></i>Sesuaikan Lokasi</h5>
                        <span class="badge bg-light-warning text-warning border border-warning border-opacity-10">Geser marker atau klik peta</span>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Latitude</label>
                                <input type="text" name="latitude" id="lat" class="form-control bg-light" value="<?php echo e(old('latitude', $mitra->latitude)); ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Longitude</label>
                                <input type="text" name="longtitude" id="lng" class="form-control bg-light" value="<?php echo e(old('longtitude', $mitra->longtitude)); ?>" readonly>
                            </div>
                        </div>
                        <div id="map" style="height: 400px; border-radius: 12px;" class="border shadow-sm"></div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-4">
                <?php
                    // Ambil PIC Utama dari relasi hasMany (status_pic = 1)
                    $picUtama = $mitra->pics->where('status_pic', 1)->first();
                ?>
                <div class="card shadow-sm border-0 border-top border-4 border-warning">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-dark"><i class="ti ti-user-edit me-2 text-warning"></i>Edit PIC Utama</h5>
                    </div>
                    <div class="card-body">
                        
                        <input type="hidden" name="pic_id" value="<?php echo e($picUtama->id ?? ''); ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap PIC <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pic" class="form-control shadow-sm" value="<?php echo e(old('nama_pic', $picUtama->nama_pic ?? '')); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control shadow-sm" value="<?php echo e(old('jabatan', $picUtama->jabatan ?? '')); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">No. Telp / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group shadow-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="ti ti-brand-whatsapp text-success"></i></span>
                                <input type="text" name="no_telp" class="form-control border-start-0" value="<?php echo e(old('no_telp', $picUtama->no_telp ?? '')); ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email_pic" class="form-control shadow-sm" value="<?php echo e(old('email_pic', $picUtama->email ?? '')); ?>">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-3">
                        <button type="submit" class="btn btn-warning text-white w-100 fw-bold py-2 mb-2 shadow-sm">
                            <i class="ti ti-refresh me-1"></i>Perbarui Data Mitra
                        </button>
                        <a href="<?php echo e(route('Manajemen-Mitra.index')); ?>" class="btn btn-light w-100 fw-bold py-2">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil titik koordinat dari database
            var savedLat = <?php echo e($mitra->latitude ?? -6.123456); ?>;
            var savedLng = <?php echo e($mitra->longtitude ?? 106.123456); ?>;

            // 1. Init Map fokus ke lokasi tersimpan
            var map = L.map('map').setView([savedLat, savedLng], 15);

            // 2. Tile Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // 3. Tambahkan Marker di lokasi tersimpan (Bisa digeser)
            var marker = L.marker([savedLat, savedLng], {draggable: true}).addTo(map);

            function updateCoords(lat, lng) {
                document.getElementById('lat').value = lat.toFixed(7);
                document.getElementById('lng').value = lng.toFixed(7);
            }

            // Update saat marker digeser
            marker.on('dragend', function (e) {
                var position = marker.getLatLng();
                updateCoords(position.lat, position.lng);
            });

            // Update saat peta diklik
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/Manajemen-Mitra/edit.blade.php ENDPATH**/ ?>