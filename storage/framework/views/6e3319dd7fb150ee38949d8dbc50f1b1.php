<?php if($paginator->hasPages()): ?>
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination mb-0">
                
                <?php if($paginator->onFirstPage()): ?>
                    <li class="page-item disabled me-2" aria-disabled="true">
                        <span class="page-link">
                            <i class="ti ti-chevrons-left align-middle"></i> Sebelumnya
                        </span>
                    </li>
                <?php else: ?>
                    <li class="page-item me-2">
                        <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">
                            <i class="ti ti-chevrons-left align-middle"></i> Sebelumnya
                        </a>
                    </li>
                <?php endif; ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">
                            Berikutnya <i class="ti ti-chevrons-right align-middle"></i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">
                            Berikutnya <i class="ti ti-chevrons-right align-middle"></i>
                        </span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div>
                <p class="small text-muted mb-0">
                    <?php echo __('Menampilkan'); ?>

                    <span class="fw-semibold"><?php echo e($paginator->firstItem()); ?></span>
                    <?php echo __('sampai'); ?>

                    <span class="fw-semibold"><?php echo e($paginator->lastItem()); ?></span>
                    <?php echo __('dari'); ?>

                    <span class="fw-semibold"><?php echo e($paginator->total()); ?></span>
                    <?php echo __('data'); ?>

                </p>
            </div>

            <div>
                <ul class="pagination mb-0">
                    
                    <?php if($paginator->onFirstPage()): ?>
                        <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">
                            <span class="page-link" aria-hidden="true">Sebelumnya</span>
                        </li>
                    <?php else: ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" aria-label="<?php echo app('translator')->get('pagination.previous'); ?>">Sebelumnya</a>
                        </li>
                    <?php endif; ?>

                    
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link"><?php echo e($element); ?></span></li>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <li class="page-item active" aria-current="page"><span class="page-link"><?php echo e($page); ?></span></li>
                                <?php else: ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <?php if($paginator->hasMorePages()): ?>
                        <li class="page-item">
                            <a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">Berikutnya</a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled" aria-disabled="true" aria-label="<?php echo app('translator')->get('pagination.next'); ?>">
                            <span class="page-link" aria-hidden="true">Berikutnya</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
<?php endif; ?><?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>