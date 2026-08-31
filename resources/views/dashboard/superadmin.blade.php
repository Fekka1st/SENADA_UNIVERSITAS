<x-app-layout>
    <x-slot:title>Dashboard Sistem</x-slot:title>
    <x-alert></x-alert>

    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-uppercase text-muted fw-bold mb-3 fs-6">
                <i class="ti ti-activity-heartbeat me-2"></i> Kesehatan Server & Aplikasi
            </h5>
        </div>


        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold">Disk Usage</span>
                        <div class="icon-shape bg-light-primary text-primary rounded-2 p-2">
                            <i class="ti ti-server fs-4"></i>
                        </div>
                    </div>

                    <h3 class="mb-2 fw-bold">{{ $disk_percentage ?? 0 }}%</h3>
                    <div class="progress mb-2" style="height: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar"
                             style="width: {{ $disk_percentage ?? 0 }}%"
                             aria-valuenow="{{ $disk_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <small class="text-muted">{{ $disk_used ?? '0 GB' }} terpakai dari {{ $disk_total ?? '0 GB' }}</small>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold">Database Size</span>
                        <div class="icon-shape bg-light-warning text-warning rounded-2 p-2">
                            <i class="ti ti-database fs-4"></i>
                        </div>
                    </div>

                    <h3 class="mb-2 fw-bold">{{ $db_size ?? '0 MB' }}</h3>
                    <small class="text-muted">Total ukuran database saat ini</small>

                </div>
            </div>
        </div>

        @php
            $lastBackup = $last_backup_date ?? '-';
            $statusBackup = 'danger';
            $labelBackup = 'Belum ada backup';
            $iconBackup = 'ti-alert-circle';
            $btnLabel = 'Buat Backup Sekarang';

            if ($lastBackup !== '-') {
                $lastBackupTimestamp = \Carbon\Carbon::createFromFormat('d M Y, H:i', $lastBackup);
                $hoursDiff = $lastBackupTimestamp->diffInHours(now());

                if ($hoursDiff < 24) {
                    $statusBackup = 'success';
                    $labelBackup = 'Backup Terkini';
                    $iconBackup = 'ti-circle-check';
                    $btnLabel = 'Kelola Backup';
                } elseif ($hoursDiff < 72) {
                    $statusBackup = 'warning';
                    $labelBackup = 'Backup Usang';
                    $iconBackup = 'ti-history';
                    $btnLabel = 'Perbarui Backup';
                } else {
                    $statusBackup = 'danger';
                    $labelBackup = 'Sangat Usang';
                    $iconBackup = 'ti-alert-triangle';
                    $btnLabel = 'Backup Darurat';
                }
            }
        @endphp

        <style>
            .hover-lift {
                transition: all 0.2s ease;
            }
            .hover-lift:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .btn-light-success { background: #e6fffa; border: 1px solid #b2f5ea; }
            .btn-light-warning { background: #fffaf0; border: 1px solid #feebc8; }
            .btn-light-danger { background: #fff5f5; border: 1px solid #feb2b2; }
        </style>
        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold">Last Backup</span>
                        <div class="icon-shape bg-light-success text-success rounded-2 p-2">
                            <i class="ti ti-cloud-upload fs-4"></i>
                        </div>
                    </div>

                    <h4 class="mb-1 fw-bold text-dark">{{ $lastBackup ?? "-"}}</h4>
                    <small class="text-{{ $statusBackup }} d-flex align-items-center fw-bold">
                        <i class="ti {{ $iconBackup }} me-1"></i> {{ $labelBackup }}
                    </small>
                    <div class="mt-4">
                        <a href="{{ route('backup-database.index') }}"
                        class="btn btn-light-{{ $statusBackup }} w-100 d-flex align-items-center justify-content-between rounded-2 py-2 px-3 hover-lift shadow-none border-1">
                            <span class="fw-bold fs-2 text-{{ $statusBackup }}">{{ $btnLabel }}</span>
                            <i class="ti ti-chevron-right fs-4 text-{{ $statusBackup }}"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted fw-semibold">Refresh System</span>
                        <div class="icon-shape bg-light-info text-info rounded-2 p-2">
                            <i class="ti ti-bolt fs-4"></i>
                        </div>
                    </div>

                    <div class="d-grid">

                        <form action="{{ route('pengaturan.optimize') }}" method="POST">
                            @csrf
                            <button type="button"
                    class="btn btn-info text-white w-100 fw-bold btn-confirm-dashboard"
                    data-title="Optimasi Sistem"
                    data-message="Ini akan membersihkan cache aplikasi untuk memuat konfigurasi terbaru."
                    data-action="{{ route('pengaturan.optimize') }}"
                    data-button="Proses Sekarang">
                    <i class="ti ti-rocket me-2"></i> Optimize App
                </button>
                        </form>
                    </div>
                    <small class="text-muted d-block mt-2 text-center" style="font-size: 11px;">
                        Gunakan setelah update file .env atau config
                    </small>
                </div>
            </div>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-uppercase text-muted fw-bold mb-3 fs-6">
                <i class="ti ti-users me-2"></i> Statistik Pengguna
            </h5>
        </div>

        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-user-shield fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Admin Universitas</h6>

                            <h3 class="mb-0">{{ $total_admin ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-keyboard fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Operator Fakultas</h6>

                            <h3 class="mb-0">{{ $total_operator ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="ti ti-eye fs-1"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Pimpinan / Viewer</h6>
                            <h3 class="mb-0">{{ $total_viewer ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="ti ti-history me-2"></i> Aktivitas Sistem Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">User</th>
                                    <th>Aktivitas</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($recent_activities ?? [] as $log)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xs me-2">
                                                    <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                        {{ substr($log->causer->name ?? 'S', 0, 1) }}
                                                    </span>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fs-3">{{ $log->causer->name ?? 'System' }}</h6>
                                                    <small class="text-muted">{{ $log->causer->roleModel->nama ?? '-' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $log->description }}</span>
                                            <small class="text-muted d-block mt-1">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</small>
                                        </td>
                                        <td class="text-muted">{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada aktivitas tercatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">

            <div class="card h-100 border-0 shadow-sm">

                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-danger">
                    <i class="ti ti-alert-triangle me-2"></i>
                    Error Log / Failed Jobs
                </h5>

                @if(!empty($error_logs) && count($error_logs) > 0)

                    <span class="badge bg-danger rounded-pill fs-6">

                        {{ count($error_logs) }}

                    </span>

                @endif

            </div>

            <div class="card-body">
                @if(count($error_logs ?? []) > 0)
                <div class="list-group list-group-flush">
                    @foreach(collect($error_logs)->take(5) as $error)
                    <div class="list-group-item px-0">
                        <div class="d-flex align-items-start">
                            <i class="ti ti-bug text-danger fs-3 me-2 mt-1"></i>
                            <div class="flex-grow-1">
                                <div class="fw-bold text-truncate"
                                    style="max-width: 220px;">
                                    {{ $error->message }}
                                </div>
                                <small class="text-muted">
                                    {{ $error->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


                <div class="mt-3 text-center">
                    <button
                        class="btn btn-outline-secondary fw-bold w-100"
                        data-bs-toggle="modal"
                        data-bs-target="#errorLogModal">
                        <i class="ti ti-eye me-1"></i>
                        Lihat Semua Error
                    </button>

                    <button type="button"
                            class="mt-2 btn btn-outline-danger fw-bold  w-100 btn-confirm-dashboard"
                            data-title="Bersihkan Log Error"
                            data-message="Tindakan ini akan menghapus semua error secara permanen."
                            data-action="{{ route('dashboard.clear-log') }}"
                            data-button="Ya, Bersihkan">
                            <i class="ti ti-trash me-2"></i>
                            Bersihkan Log
                    </button>
                </div>

                @else

                <div class="text-center py-5">

                    <i class="ti ti-circle-check text-success fs-1 mb-2"></i>

                    <h6 class="text-muted">
                        Sistem Berjalan Normal
                    </h6>

                    <small class="text-muted">
                        Tidak ada error kritis.
                    </small>

                </div>

                @endif

            </div>

        </div>
    </div>

    <div class="modal fade"
        id="errorLogModal"
        tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">
                        <i class="ti ti-bug me-2 text-danger"></i>
                        Detail Error Log Sistem

                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body p-0">
                    @if(count($error_logs ?? []) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($error_logs as $error)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between mb-2">
                                <strong class="text-danger">
                                    {{ $error->created_at->format('d M Y H:i') }}
                                </strong>
                                <small class="text-muted">
                                    {{ $error->created_at->diffForHumans() }}
                                </small>
                            </div>
                        <pre class="bg-light p-3 rounded small mb-0"
                            style="white-space: pre-wrap; word-break: break-word;">
                            {{ $error->message }}
                        </pre>
                    </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        Tidak ada error ditemukan.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<x-modal.hapus
    id="modalConfirmAction"
    title="Konfirmasi Tindakan"
    :isDynamic="true"/>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchError');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                let keyword = this.value.toLowerCase();
                document.querySelectorAll('.error-item').forEach(function (item) {
                    let text = item.innerText.toLowerCase();
                    item.style.display = text.includes(keyword)
                        ? 'block'
                        : 'none';
                });
            });
        }
        document.querySelectorAll('.copy-error').forEach(btn => {
            btn.addEventListener('click', function () {
                let text = this.dataset.text;
                navigator.clipboard.writeText(text);
                this.innerHTML = '<i class="ti ti-check me-1"></i> Copied';
                setTimeout(() => {
                    this.innerHTML = '<i class="ti ti-copy me-1"></i> Copy';
                }, 1500);
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.btn-copy-error').forEach(btn => {

            btn.addEventListener('click', function () {

                const errorBox = this.closest('.list-group-item')
                                    .querySelector('.error-text');

                const fullText = errorBox.dataset.full;

                navigator.clipboard.writeText(fullText).then(() => {

                    this.innerHTML = '<i class="ti ti-check text-success"></i>';

                    setTimeout(() => {
                        this.innerHTML = '<i class="ti ti-copy"></i>';
                    }, 1500);

                });

            });

        });

    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-confirm-dashboard', function(e) {
            e.preventDefault();

            const title = $(this).data('title');
            const message = $(this).data('message');
            const actionUrl = $(this).data('action');
            const btnText = $(this).data('button');

            const form = $('#modalConfirmActionForm');

            $('#modalConfirmActionLabel').text(title);
            $('#modalConfirmActionItemName').text(message);
            form.attr('action', actionUrl);

            const methodInput = form.find('input[name="_method"]');
            if (methodInput.length) {
                methodInput.val('POST');
            }

            $('#modalConfirmActionWarningDelete').addClass('d-none');

            const submitBtn = $('#modalConfirmActionBtnSubmit');
            submitBtn.text(btnText).prop('disabled', false).removeClass('d-none');

            if (title.includes('Log')) {
                submitBtn.removeClass('btn-primary').addClass('btn-danger');
            } else {
                submitBtn.removeClass('btn-danger').addClass('btn-primary');
            }

            const modalElement = document.getElementById('modalConfirmAction');
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
        });
    });
</script>

</x-app-layout>
