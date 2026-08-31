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
     <?php $__env->slot('title', null, []); ?> GeoMitra Explorer <?php $__env->endSlot(); ?>

    
    <?php $__env->startPush('styles'); ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            #map {
                height: 500px;
                border-radius: 15px;
                z-index: 1;
            }

            .custom-popup .leaflet-popup-content-wrapper {
                border-radius: 8px;
                padding: 5px;
            }

            .stat-card {
                transition: transform 0.2s;
                border: none;
            }

            .stat-card:hover {
                transform: translateY(-5px);
            }
        </style>
    <?php $__env->stopPush(); ?>

    <div class="row g-4">
        
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-0"><i class="ti ti-map-2 me-2 text-primary"></i>Sebaran Geografis
                            Mitra</h5>
                        <small class="text-muted">Visualisasi titik lokasi mitra di seluruh dunia</small>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-white px-3 py-2 rounded-pill">
                        Total: <?php echo e($mitras->count()); ?> Lokasi Terdeteksi
                    </span>
                </div>
                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold text-dark mb-0">Direktori Mitra Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 text-muted small fw-bold">NAMA MITRA</th>
                                    <th class="px-4 py-3 text-muted small fw-bold">NEGARA</th>
                                    <th class="px-4 py-3 text-muted small fw-bold">KATEGORI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $listMitra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-3">
                                            <div class="fw-bold text-dark"><?php echo e($m->nama_mitra); ?></div>
                                            <small
                                                class="text-muted"><?php echo e($m->alamat_pusat ?? 'Alamat belum diatur'); ?></small>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="text-dark"><i
                                                    class="ti ti-world me-1"></i><?php echo e($m->negara); ?></span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <?php
                                                $warna = $m->kategori->warna_peta ?? '#6c757d';
                                            ?>

                                            <span class="badge fw-bold px-3 py-2"
                                                style="background-color: <?php echo e($warna); ?>15 !important;
                                                color: <?php echo e($warna); ?> !important;
                                                border: 1px solid <?php echo e($warna); ?>40 !important;
                                                letter-spacing: 0.5px;">
                                                <i class="ti ti-circle-filled me-1" style="font-size: 8px;"></i>
                                                <?php echo e($m->kategori->nama_kegiatan ?? ($m->kategori->nama_kategori ?? '-')); ?>

                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3">
                        <?php echo e($listMitra->links()); ?>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold text-dark mb-0">Top 10 Negara Mitra</h6>
                </div>
                <div class="card-body">
                    <?php
                        // Hitung total semua mitra dari koleksi topNegara untuk persentase murni
                        $grandTotal = $topNegara->sum('total');
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $topNegara; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $tn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            // Menghitung persentase terhadap total keseluruhan
                            $percent = $grandTotal > 0 ? ($tn->total / $grandTotal) * 100 : 0;
                        ?>
                        <div class="d-flex align-items-center mb-4">
                            
                            <div class="flex-shrink-0 bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                                style="width: 38px; height: 38px; font-size: 14px;">
                                <?php echo e($index + 1); ?>

                            </div>

                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div>
                                        <span class="fw-bold text-dark d-block"
                                            style="line-height: 1.2;"><?php echo e($tn->negara); ?></span>
                                        <small class="text-muted"><?php echo e($tn->total); ?> Mitra</small>
                                    </div>
                                    
                                    <span class="badge bg-soft-primary text-primary fw-bold"
                                        style="background-color: rgba(59, 130, 246, 0.1);">
                                        <?php echo e(number_format($percent, 1)); ?>%
                                    </span>
                                </div>

                                
                                <div class="progress rounded-pill" style="height: 7px; background-color: #f0f2f5;">
                                    <div class="progress-bar rounded-pill shadow-none" role="progressbar"
                                        style="width: <?php echo e($percent); ?>%; transition: width 1s ease-in-out;"
                                        aria-valuenow="<?php echo e($percent); ?>" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-5">
                            <i class="ti ti-database-off fs-1 opacity-25 text-muted"></i>
                            <p class="text-muted mt-2 small">Belum ada data distribusi negara.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__env->startPush('scripts'); ?>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Map (Default Center: Indonesia atau tengah dunia)
                const map = L.map('map').setView([-2.5489, 118.0149], 5);

                // Layer Peta (Menggunakan OpenStreetMap / CartoDB Voyager untuk tampilan profesional)
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Parsing Data Mitra dari Laravel ke JS
                const mitras = <?php echo json_encode($mitras, 15, 512) ?>;

                // Loop untuk menambahkan marker
                mitras.forEach(mitra => {
                    if (mitra.latitude && mitra.longtitude) {
                        // Gunakan warna dari kategori_mitra jika ada
                        const markerColor = mitra.kategori ? mitra.kategori.warna_peta : '#3b82f6';

                        const marker = L.circleMarker([mitra.latitude, mitra.longtitude], {
                            radius: 8,
                            fillColor: markerColor,
                            color: "#fff",
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        // Hover tooltip: Tampilkan nama mitra
                        marker.bindTooltip(`
                        <div class="p-1">
                            <strong style="color: ${markerColor}">${mitra.nama_mitra}</strong><br>
                            <small class="text-muted"><i class="ti ti-map-pin me-1"></i>${mitra.negara}</small>
                        </div>
                    `, {
                            permanent: false,
                            direction: 'top',
                            className: 'shadow-sm border-0'
                        });

                        // Klik popup untuk detail singkat
                        marker.bindPopup(`
                        <div class="custom-popup">
                            <h6 class="fw-bold mb-1">${mitra.nama_mitra}</h6>
                            <p class="small text-muted mb-0">${mitra.alamat_pusat || ''}</p>
                            <hr class="my-2">
                            <a href="/master-data/mitra/${mitra.id}" class="btn btn-xs btn-primary text-white py-1 px-2 rounded-pill fw-bold" style="font-size: 10px;">Lihat Profil</a>
                        </div>
                    `);
                    }
                });

                if (mitras.length > 0) {
                    const group = new L.featureGroup(mitras.map(m => L.marker([m.latitude, m.longtitude])));
                    map.fitBounds(group.getBounds().pad(0.1));
                }
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/Analitik/geo-mitra/index.blade.php ENDPATH**/ ?>