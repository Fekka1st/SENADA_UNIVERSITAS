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
 <?php $__env->slot('title', null, []); ?> Tambah Kategori Mitra <?php $__env->endSlot(); ?>
 <?php $__env->slot('breadcrumb', null, []); ?> Tambah <?php $__env->endSlot(); ?>
<div class="card ">
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

        
        <form action="<?php echo e(route('master-data.kategori_mitra.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-8">
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Nama Kategori <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="ti ti-tag"></i></span>
                            <input type="text" name="nama_kategori"
                                class="form-control <?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama_kategori')); ?>"
                                placeholder="Contoh: Perusahaan Multinasional, Instansi Pemerintah..."
                                autocomplete="off">
                            <?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan / Deskripsi</label>
                        <textarea name="keterangan" rows="4"
                            class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Jelaskan secara singkat cakupan kategori ini..."><?php echo e(old('keterangan')); ?></textarea>
                        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="col-md-4">
                    
                    <div class="card border-dashed bg-light bg-opacity-50 h-100">
                        <div class="card-body">
                            <label class="form-label fw-bold">
                                <i class="ti ti-palette me-1"></i> Identitas Warna Peta <span class="text-danger">*</span>
                            </label>
                            <p class="small text-muted mb-3">Klik tombol warna atau kode HEX untuk memilih warna penanda peta.</p>

                            <div class="d-flex flex-column gap-2 mb-3">
                                
                                <div class="custom-color-display d-flex align-items-center justify-content-center shadow-sm" id="customColorDisplay"
                                    style="background-color: <?php echo e(old('warna_peta', '#3b82f6')); ?>; height: 45px; border-radius: 8px; cursor: pointer; transition: all 0.2s ease;">
                                    <span class="color-text fw-bold text-white shadow-text" style="text-shadow: 0px 1px 3px rgba(0,0,0,0.3);">Klik untuk memilih warna</span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    
                                    <input type="color" name="warna_peta"
                                        id="colorPicker"
                                        class="visually-hidden"
                                        value="<?php echo e(old('warna_peta', '#3b82f6')); ?>">

                                    
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0 text-muted">HEX</span>
                                        <input type="text" id="colorText" class="form-control fw-bold text-center bg-white cursor-pointer"
                                            value="<?php echo e(old('warna_peta', '#3b82f6')); ?>"
                                            placeholder="#000000"
                                            readonly
                                            style="letter-spacing: 1px;">
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 bg-white rounded-3 border text-center shadow-sm">
                                <div id="previewMarker" class="mx-auto"
                                    style="width: 40px; height: 40px; border-radius: 50% 50% 50% 0; background-color: <?php echo e(old('warna_peta', '#3b82f6')); ?>; transform: rotate(-45deg); border: 3px solid #fff; cursor: pointer; transition: background-color 0.2s ease;">
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted fw-bold d-block">Preview Marker Peta</small>
                                    <span class="fs-7 text-muted">Warna identitas kategori di peta</span>
                                </div>
                            </div>

                            <?php $__errorArgs = ['warna_peta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-end">
                    <hr class="opacity-10 mb-4">
                    <a href="<?php echo e(route('master-data.kategori_mitra.index')); ?>" class="btn btn-light fw-bold px-4 me-2">
                        <i class="ti ti-arrow-left me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="ti ti-device-floppy me-1"></i>Simpan Kategori
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .border-dashed {
        border: 2px dashed #dee2e6 !important;
    }
    .form-control-color {
        width: 60px;
        height: 45px;
        padding: .2rem;
        cursor: pointer;
    }
    #colorText {
        letter-spacing: 1px;
        text-transform: uppercase;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const colorPicker = document.getElementById('colorPicker');
    const colorText = document.getElementById('colorText');
    const previewMarker = document.getElementById('previewMarker');
    const customColorDisplay = document.getElementById('customColorDisplay');

    // Sinkronisasi warna
    function syncColor(color) {
        if (!color) return;

        const hex = color.toUpperCase();

        colorText.value = hex;
        previewMarker.style.backgroundColor = hex;
        customColorDisplay.style.backgroundColor = hex;
        colorPicker.value = hex;
    }

    // Init default / old value
    syncColor(colorPicker.value);

    // Trigger color picker saat diklik
    [customColorDisplay, colorText, previewMarker].forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            colorPicker.click();
        });
    });

    // Realtime update
    colorPicker.addEventListener('input', function () {
        syncColor(this.value);
    });

    // Final update
    colorPicker.addEventListener('change', function () {
        syncColor(this.value);
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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/kategori_mitra/create.blade.php ENDPATH**/ ?>