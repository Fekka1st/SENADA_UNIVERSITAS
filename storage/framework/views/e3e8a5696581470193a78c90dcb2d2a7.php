<?php
    $sidebarMenu = config('sidebar');
?>


<link rel="stylesheet" href="<?php echo e(asset('css/sidebar.css')); ?>?v=<?php echo e(filemtime(public_path('css/sidebar.css'))); ?>">

<style>
    /* Dynamic Theme Color Styles */
    .sidebar.sidebar-style-2 .nav .nav-item.submenu > a[data-bs-toggle="collapse"][aria-expanded="true"]::after {
        color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
    }

    .sidebar.sidebar-style-2 .nav .nav-item a:hover p,
    .sidebar.sidebar-style-2 .nav .nav-item a:hover i,
    .sidebar.sidebar-style-2 .nav .nav-item a:focus p,
    .sidebar.sidebar-style-2 .nav .nav-item a:focus i,
    .sidebar.sidebar-style-2 .nav .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] p,
    .sidebar.sidebar-style-2 .nav .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i {
        color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?> !important;
    }

    /* Parent submenu button background when child is active */
    .sidebar.sidebar-style-2 .nav .nav-item.submenu:has(.nav-collapse li a.active) > a {
        background: #f0f0f0;
    }

    .sidebar .nav.nav-primary > .nav-item a:focus i,
    .sidebar .nav.nav-primary > .nav-item a:hover i,
    .sidebar .nav.nav-primary > .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:focus i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a:hover i,
    .sidebar[data-background-color="white"] .nav.nav-primary > .nav-item a[data-bs-toggle="collapse"][aria-expanded="true"] i {
        color: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?> !important;
    }

    /* Active state for main menu items (without submenu) */
    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active {
        background: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?> !important;
        box-shadow: 0 10px 15px -5px rgba(<?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 1, 2))); ?>, <?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 3, 2))); ?>, <?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 5, 2))); ?>, 0.3);
    }

    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active p,
    .sidebar.sidebar-style-2 .nav.nav-primary > .nav-item:not(.submenu) a.active i {
        color: #ffffff !important;
        font-weight: 500;
    }

    /* Submenu items hover and active states */
    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover {
        background: #f0f0f0;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a:hover i {
        color: #575962;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active {
        background: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
        box-shadow: 0 10px 15px -5px rgba(<?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 1, 2))); ?>, <?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 3, 2))); ?>, <?php echo e(hexdec(substr($pengaturan->tema_warna_utama ?? '#14438B', 5, 2))); ?>, 0.3);
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active i {
        color: #ffffff !important;
        font-weight: 500;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover {
        background: <?php echo e($pengaturan->tema_warna_utama ?? '#14438B'); ?>;
    }

    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover p,
    .sidebar.sidebar-style-2 .nav .nav-collapse li a.active:hover i {
        color: #ffffff !important;
    }

</style>

<div class="sidebar sidebar-style-2" data-background-color="white">
    
    <div class="sidebar-logo">
        
        <?php if (isset($component)) { $__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.logo-header','data' => ['logo' => ''.e($attributes['logo']).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('logo-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['logo' => ''.e($attributes['logo']).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8)): ?>
<?php $attributes = $__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8; ?>
<?php unset($__attributesOriginal03c6c65b958fcc76e9069678ce5ff9a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8)): ?>
<?php $component = $__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8; ?>
<?php unset($__componentOriginal03c6c65b958fcc76e9069678ce5ff9a8); ?>
<?php endif; ?>
    </div>

    
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">
                <?php $__currentLoopData = $sidebarMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(isset($menu['type']) && $menu['type'] === 'header'): ?>
                    <?php
                        $showHeader = true;
                        if (isset($menu['permission'])) {
                            if (strtolower($menu['permission']) === 'all') {
                                $showHeader = true;
                            } else {
                                $showHeader = auth()->user()->hasPermission($menu['permission']);
                            }
                        }
                        if ($showHeader && isset($menu['roles'])) {
                            $showHeader = in_array(auth()->user()->roleid, $menu['roles']);
                        }
                    ?>

                    <?php if($showHeader): ?>
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="ti ti-minus text-muted opacity-50"></i>
                            </span>
                            <h2 class="text-section fw-bold text-muted" style="font-size: 14px; letter-spacing: 1.2px;">
                                <?php echo e(strtoupper($menu['title'])); ?>

                            </h2>
                        </li>
                    <?php endif; ?>

                    <?php elseif(isset($menu['type']) && $menu['type'] === 'nosection'): ?>
                        
                        <?php
                            $show = true;
                            if (isset($menu['roles'])) {
                                $show = in_array(auth()->user()->roleid, $menu['roles']);
                            }
                            if (isset($menu['permission'])) {
                                $show = $show && auth()->user()->hasPermission($menu['permission']);
                            }
                        ?>
                        <?php if($show): ?>
                            <li class="nav-item">
                                <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route($menu['route'])).'','active' => request()->routeIs($menu['route'].'*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route($menu['route'])).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs($menu['route'].'*'))]); ?>
                                    <i class="<?php echo e($menu['icon']); ?>"></i>
                                    <p><?php echo e($menu['title']); ?></p>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php elseif(isset($menu['section'])): ?>
                        <?php
                            $showSection = true;
                            if (isset($menu['permission'])) {
                                if (is_array($menu['permission'])) {
                                    $showSection = false;
                                    foreach ($menu['permission'] as $perm) {
                                        if (auth()->user()->hasPermission($perm)) {
                                            $showSection = true;
                                            break;
                                        }
                                    }
                                } else {
                                    $showSection = auth()->user()->hasPermission($menu['permission']);
                                }
                            }

                            if (isset($menu['roles'])) {
                                $showSection = $showSection && in_array(auth()->user()->roleid, $menu['roles']);
                            }

                            // Collect child menus
                            $childMenus = [];
                            if ($showSection) {
                                for ($i = $index + 1; $i < count($sidebarMenu); $i++) {
                                    // Stop at next section or nosection item
                                    if (isset($sidebarMenu[$i]['section']) || (isset($sidebarMenu[$i]['type']) && $sidebarMenu[$i]['type'] === 'nosection')) {
                                        break;
                                    }

                                    $childMenu = $sidebarMenu[$i];

                                    // Only include items with type 'section' or without type attribute
                                    if (isset($childMenu['type']) && $childMenu['type'] !== 'section') {
                                        continue;
                                    }

                                    $showChild = true;

                                    if (isset($childMenu['roles'])) {
                                        $showChild = in_array(auth()->user()->roleid, $childMenu['roles']);
                                    }
                                    if (isset($childMenu['permission'])) {
                                        $showChild = $showChild && auth()->user()->hasPermission($childMenu['permission']);
                                    }

                                    if ($showChild && isset($childMenu['route']) && isset($childMenu['title'])) {
                                        $childMenus[] = $childMenu;
                                    }
                                }
                            }

                            $hasChildren = count($childMenus) > 0;
                            $sectionId = 'section-' . \Str::slug($menu['section']);
                        ?>

                        <?php if($showSection && $hasChildren): ?>
                            <li class="nav-item submenu">
                                <a data-bs-toggle="collapse" href="#<?php echo e($sectionId); ?>" class="collapsed" aria-expanded="false">
                                    <i class="<?php echo e($menu['icon'] ?? 'ti ti-dots'); ?>"></i>
                                    <p><?php echo e($menu['section']); ?></p>
                                </a>
                                <div class="collapse" id="<?php echo e($sectionId); ?>">
                                    <ul class="nav nav-collapse">
                                        <?php $__currentLoopData = $childMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route($childMenu['route'])).'','active' => request()->routeIs($childMenu['route'].'*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route($childMenu['route'])).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs($childMenu['route'].'*'))]); ?>
                                                    <i class="ti ti-point-filled"></i>
                                                    <p><?php echo e($childMenu['title']); ?></p>
                                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </li>
                        <?php elseif($showSection && !$hasChildren): ?>
                            
                            <li class="nav-section">
                                <span class="sidebar-mini-icon">
                                    <i class="<?php echo e($menu['icon'] ?? 'ti ti-dots'); ?>"></i>
                                </span>
                                <h4 class="text-section"><?php echo e($menu['section']); ?></h4>
                            </li>
                        <?php endif; ?>
                    <?php elseif(isset($menu['route']) && isset($menu['title'])): ?>
                        <?php
                            // Skip if menu has type 'section' (already rendered as child)
                            if (isset($menu['type']) && $menu['type'] === 'section') {
                                continue;
                            }

                            // Check if this menu is already rendered as child
                            $isChild = false;
                            for ($j = $index - 1; $j >= 0; $j--) {
                                if (isset($sidebarMenu[$j]['section'])) {
                                    // This menu belongs to a section
                                    $isChild = true;
                                    break;
                                }
                                // Stop if we hit a nosection item
                                if (isset($sidebarMenu[$j]['type']) && $sidebarMenu[$j]['type'] === 'nosection') {
                                    break;
                                }
                            }

                            // Skip if it's a child menu (already rendered in collapse)
                            if ($isChild) {
                                continue;
                            }

                            $show = true;
                            if (isset($menu['roles'])) {
                                $show = in_array(auth()->user()->roleid, $menu['roles']);
                            }
                            if (isset($menu['permission'])) {
                                $show = $show && auth()->user()->hasPermission($menu['permission']);
                            }
                        ?>
                        <?php if($show): ?>
                            <li class="nav-item">
                                <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route($menu['route'])).'','active' => request()->routeIs($menu['route'].'*')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route($menu['route'])).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs($menu['route'].'*'))]); ?>
                                    <i class="<?php echo e($menu['icon']); ?>"></i>
                                    <p><?php echo e($menu['title']); ?></p>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>


<script src="<?php echo e(asset('js/sidebar.js')); ?>?v=<?php echo e(filemtime(public_path('js/sidebar.js'))); ?>"></script>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>