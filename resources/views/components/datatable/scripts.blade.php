@props([
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
])

{{-- Load DataTables Assets (CSS & JS) --}}
<x-datatable.assets />

<script>
    let table;
    let selectedRange = '';

    $(document).ready(function() {
        @if($hasDateFilter)
        // Initialize Flatpickr
        flatpickr("#{{ $dateFilterId }}", {
            mode: "range",
            dateFormat: "d-m-Y",
            altInput: true,
            altFormat: "d M Y",
            allowInput: true
        });
        @endif

        // Initialize DataTables
        table = $('#{{ $tableId }}').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ $ajaxUrl }}",
                data: function(d) {
                    d.range = selectedRange;
                }
            },
            columns: {!! json_encode($columns) !!},
            responsive: true,
            order: {!! json_encode($order) !!},
            pageLength: {{ $pageLength }},
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
        $('#{{ $searchId }}').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Custom length menu
        $('#{{ $perPageId }}').on('change', function() {
            table.page.len(this.value).draw();
        });

        @if($hasDateFilter)
        // Filter tanggal
        $('#{{ $filterButtonId }}').on('click', function() {
            selectedRange = $('#{{ $dateFilterId }}').val();
            table.ajax.reload();
        });
        @endif

        @if($hasExport && !$customExportHandler)
        // Export Excel with filters (default handler)
        $('#{{ $exportButtonId }}').on('click', function(e) {
            e.preventDefault();
            let exportUrl = "{{ $exportRoute }}";
            const params = new URLSearchParams();

            if ($('#{{ $searchId }}').val()) {
                params.append('search', $('#{{ $searchId }}').val());
            }

            if (selectedRange) {
                params.append('range', selectedRange);
            }

            if (params.toString()) {
                exportUrl += '?' + params.toString();
            }

            window.location.href = exportUrl;
        });
        @endif

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

    {{ $customScripts ?? '' }}
</script>
