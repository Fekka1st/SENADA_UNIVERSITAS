<div class="modal fade" id="modalLogout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">
                    <i class="ti ti-logout me-1"></i> Logout
                </h2>
            </div>
            <div class="modal-body">
                <p class="mb-2">
                    Apakah Anda yakin ingin logout?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="ps-2">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-danger"> Ya, Logout! </button>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/modal/logout.blade.php ENDPATH**/ ?>