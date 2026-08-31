<?php
    $pengaturan = \App\Models\Pengaturan::first();
?>

<div class="logo-header" data-background-color="white">
    
    <a href="<?php echo e(route('dashboard.index')); ?>" class="logo d-flex align-items-center">
        <img src="<?php echo e(safe_image_url($pengaturan->logo_instnasi ?? null, 'logo', 'images/logo.png')); ?>" 
             alt="Logo Pengaturan" 
             class="navbar-brand me-2" 
             style="height: 50px; width: auto; max-width: 120px; object-fit: contain;">
    </a>
    
    <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
            <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
            <i class="gg-menu-left"></i>
        </button>
    </div>
    <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
    </button>
</div><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/logo-header.blade.php ENDPATH**/ ?>