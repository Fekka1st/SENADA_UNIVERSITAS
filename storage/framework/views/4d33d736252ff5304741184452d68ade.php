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

 <?php $__env->slot('title', null, []); ?> Edit Kategori Mitra <?php $__env->endSlot(); ?>
 <?php $__env->slot('breadcrumb', null, []); ?> Edit <?php $__env->endSlot(); ?>

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


        
        <form action="<?php echo e(route('master-data.kategori_mitra.update', $kategori->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>


            <div class="row">

                
                <div class="col-md-8">

                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="ti ti-tag"></i>
                            </span>

                            <input type="text"
                                name="nama_kategori"
                                class="form-control <?php $__errorArgs = ['nama_kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('nama_kategori', $kategori->nama_kategori)); ?>"
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
                        <label class="form-label fw-bold">Keterangan</label>

                        <textarea name="keterangan"
                            rows="4"
                            class="form-control  <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Jelaskan secara singkat cakupan kategori ini..."
                        ><?php echo e(old('keterangan', $kategori->keterangan)); ?></textarea>

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
                                <i class="ti ti-palette me-1"></i>
                                Identitas Warna <span class="text-danger">*</span>
                            </label>

                            <p class="small text-muted mb-3">
                                Klik untuk memilih warna marker.
                            </p>


                            <div class="d-flex flex-column gap-2 mb-3">

                                
                                <div
                                    id="customColorDisplay"
                                    class="custom-color-display d-flex align-items-center justify-content-center shadow-sm"
                                    style="
                                        background-color: <?php echo e(old('warna_peta', $kategori->warna_peta)); ?>;
                                        height:45px;
                                        border-radius:8px;
                                        cursor:pointer;
                                    "
                                >
                                    <span class="fw-bold text-white">
                                        Klik Pilih Warna
                                    </span>
                                </div>


                                <div class="d-flex gap-2">

                                    
                                    <input type="color"
                                        name="warna_peta"
                                        id="colorPicker"
                                        class="visually-hidden"
                                        value="<?php echo e(old('warna_peta', $kategori->warna_peta)); ?>">


                                    
                                    <div class="input-group">

                                        <span class="input-group-text">
                                            HEX
                                        </span>

                                        <input type="text"
                                            id="colorText"
                                            class="form-control text-center fw-bold"
                                            readonly
                                            value="<?php echo e(old('warna_peta', $kategori->warna_peta)); ?>">
                                    </div>

                                </div>
                            </div>


                            
                            <div class="p-3 bg-white rounded border text-center">

                                <div id="previewMarker"
                                    class="mx-auto"
                                    style="
                                        width:40px;
                                        height:40px;
                                        border-radius:50% 50% 50% 0;
                                        background-color: <?php echo e(old('warna_peta', $kategori->warna_peta)); ?>;
                                        transform:rotate(-45deg);
                                        border:3px solid #fff;
                                    ">
                                </div>

                                <small class="text-muted d-block mt-2">
                                    Preview Marker
                                </small>

                            </div>


                            <?php $__errorArgs = ['warna_peta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2">
                                    <?php echo e($message); ?>

                                </div>
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

                    <hr>

                    <a href="<?php echo e(route('master-data.kategori_mitra.index')); ?>"
                       class="btn btn-light me-2">

                        <i class="ti ti-arrow-left"></i> Batal
                    </a>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="ti ti-device-floppy"></i>
                        Update Kategori
                    </button>

                </div>
            </div>

        </form>

    </div>
</div>



<style>
.border-dashed {
    border: 2px dashed #dee2e6;
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

    function syncColor(color) {

        if (!color) return;

        const hex = color.toUpperCase();

        colorText.value = hex;
        previewMarker.style.backgroundColor = hex;
        customColorDisplay.style.backgroundColor = hex;
        colorPicker.value = hex;
    }

    syncColor(colorPicker.value);


    [customColorDisplay, colorText, previewMarker].forEach(function (el) {

        el.addEventListener('click', function (e) {

            e.preventDefault();
            colorPicker.click();

        });

    });


    colorPicker.addEventListener('input', function () {
        syncColor(this.value);
    });

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
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/master_data/kategori_mitra/edit.blade.php ENDPATH**/ ?>