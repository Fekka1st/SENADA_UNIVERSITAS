<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'tableId' => 'dataTable',
    'ajaxUrl' => '',
    'columns' => [],
    'order' => [[0, 'desc']],
    'pageLength' => 5,
    'searchId' => 'customSearch',
    'perPageId' => 'perPage',
    'dateFilterId' => 'filterTanggal',
    'filterButtonId' => 'btnTerapkanFilter',
    'exportButtonId' => 'btnExport',
    'exportRoute' => '',
    'hasDateFilter' => true,
    'hasExport' => false,
    'customExportHandler' => false, // Jika true, skip default export handler
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'tableId' => 'dataTable',
    'ajaxUrl' => '',
    'columns' => [],
    'order' => [[0, 'desc']],
    'pageLength' => 5,
    'searchId' => 'customSearch',
    'perPageId' => 'perPage',
    'dateFilterId' => 'filterTanggal',
    'filterButtonId' => 'btnTerapkanFilter',
    'exportButtonId' => 'btnExport',
    'exportRoute' => '',
    'hasDateFilter' => true,
    'hasExport' => false,
    'customExportHandler' => false, // Jika true, skip default export handler
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<?php if (isset($component)) { $__componentOriginal45b2b36f3ae088a5bb2e68f2f51e725a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal45b2b36f3ae088a5bb2e68f2f51e725a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.datatable.assets','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('datatable.assets'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal45b2b36f3ae088a5bb2e68f2f51e725a)): ?>
<?php $attributes = $__attributesOriginal45b2b36f3ae088a5bb2e68f2f51e725a; ?>
<?php unset($__attributesOriginal45b2b36f3ae088a5bb2e68f2f51e725a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal45b2b36f3ae088a5bb2e68f2f51e725a)): ?>
<?php $component = $__componentOriginal45b2b36f3ae088a5bb2e68f2f51e725a; ?>
<?php unset($__componentOriginal45b2b36f3ae088a5bb2e68f2f51e725a); ?>
<?php endif; ?>

<script>
    let table;
    let selectedRange = '';

    $(document).ready(function() {
        <?php if($hasDateFilter): ?>
        // Initialize Flatpickr
        flatpickr("#<?php echo e($dateFilterId); ?>", {
            mode: "range",
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "d M Y",
            allowInput: true
        });
        <?php endif; ?>

        // Initialize DataTables
        table = $('#<?php echo e($tableId); ?>').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo e($ajaxUrl); ?>",
                data: function(d) {
                    d.range = selectedRange;
                }
            },
            columns: <?php echo json_encode($columns); ?>,
            responsive: true,
            order: <?php echo json_encode($order); ?>,
            pageLength: <?php echo e($pageLength); ?>,
            lengthMenu: [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            language: {
                processing: '<div class="text-center py-2 mb-2">Memuat data...</div>',
                search: "",
                searchPlaceholder: "Pencarian...",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                emptyTable: '<div class="d-flex justify-content-center align-items-center py-3"><i class="ti ti-info-circle fs-5 me-2"></i><div>Tidak ada data tersedia.</div></div>',
                zeroRecords: '<div class="d-flex justify-content-center align-items-center py-3"><i class="ti ti-info-circle fs-5 me-2"></i><div>Tidak ada data yang cocok.</div></div>'
            },
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row mt-3"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            drawCallback: function() {
                // Adjust columns immediately after draw
                table.columns.adjust().responsive.recalc();

                // Reinitialize tooltips after table draw
                const tooltipTriggerList = [].slice.call(document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });

                // Update checkbox listeners if exists
                if (typeof updateCheckboxListeners === 'function') {
                    updateCheckboxListeners();
                }
            },
            initComplete: function() {
                // Adjust columns after initial load
                this.api().columns.adjust().responsive.recalc();
            }
        });

        // Hide default DataTables search and length menu
        $('.dataTables_filter, .dataTables_length').hide();

        // Custom search
        $('#<?php echo e($searchId); ?>').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Custom length menu
        $('#<?php echo e($perPageId); ?>').on('change', function() {
            table.page.len(this.value).draw();
        });

        <?php if($hasDateFilter): ?>
        // Filter tanggal
        $('#<?php echo e($filterButtonId); ?>').on('click', function() {
            selectedRange = $('#<?php echo e($dateFilterId); ?>').val();
            table.ajax.reload();
        });
        <?php endif; ?>

        <?php if($hasExport && !$customExportHandler): ?>
        // Export Excel with filters (default handler)
        $('#<?php echo e($exportButtonId); ?>').on('click', function(e) {
            e.preventDefault();
            let exportUrl = "<?php echo e($exportRoute); ?>";
            const params = new URLSearchParams();

            if ($('#<?php echo e($searchId); ?>').val()) {
                params.append('search', $('#<?php echo e($searchId); ?>').val());
            }

            if (selectedRange) {
                params.append('range', selectedRange);
            }

            if (params.toString()) {
                exportUrl += '?' + params.toString();
            }

            window.location.href = exportUrl;
        });
        <?php endif; ?>

        // Helper function untuk adjust table columns
        function adjustTableColumns() {
            if (table) {
                table.columns.adjust().responsive.recalc();
            }
        }

        // Auto-adjust columns on window resize dengan debounce
        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(adjustTableColumns, 250);
        });

        // Auto-adjust untuk berbagai events
        const adjustEvents = [
            { target: document, event: 'visibilitychange', condition: () => !document.hidden, delay: 100 },
            { target: window, event: 'orientationchange', delay: 200 },
            { target: window, event: 'load', delay: 0 },
            { target: window, event: 'pageshow', condition: (e) => e.persisted, delay: 100 }
        ];

        adjustEvents.forEach(({ target, event, condition, delay }) => {
            target.addEventListener(event, function(e) {
                if (!condition || condition(e)) {
                    if (delay > 0) {
                        setTimeout(adjustTableColumns, delay);
                    } else {
                        adjustTableColumns();
                    }
                }
            });
        });
    });

    <?php echo e($customScripts ?? ''); ?>

</script>
<?php /**PATH C:\Users\ferry\Documents\SENADA\resources\views/components/datatable/scripts.blade.php ENDPATH**/ ?>