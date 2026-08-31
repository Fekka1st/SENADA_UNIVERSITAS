<x-app-layout>
    <x-slot:title>Detail Rencana Kerjasama</x-slot:title>
    <x-slot:breadcrumb>Rencana / Detail / {{ $rencana->judul_rencana }}</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div
                        class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="ti ti-notes me-2 text-primary"></i>Informasi Rencana
                        </h5>
                        @php
                            $statusMap = [
                                '0' => ['class' => 'bg-secondary', 'label' => 'DRAFT'],
                                '1' => ['class' => 'bg-info', 'label' => 'PROSES REVIEW'],
                                '2' => ['class' => 'bg-success', 'label' => 'DISETUJUI'],
                                '3' => ['class' => 'bg-danger', 'label' => 'DITOLAK'],
                                '4' => ['class' => 'bg-warning text-dark', 'label' => 'PERLU REVISI'], // Tambahan status revisi
                            ];
                            $currStatus = $statusMap[$rencana->status] ?? ['class' => 'bg-dark', 'label' => 'UNKNOWN'];
                        @endphp
                        <span class="badge {{ $currStatus['class'] }} px-3 py-2 rounded-pill shadow-sm">
                            {{ $currStatus['label'] }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <h3 class="fw-bold text-dark mb-3">{{ $rencana->judul_rencana }}</h3>

                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <div class="small text-muted">
                                <i class="ti ti-user me-1"></i> Diajukan oleh:
                                <strong>{{ $rencana->user->nama_user }}</strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-building me-1"></i> Fakultas:
                                <strong>{{ $rencana->fakultas->nama_fakultas ?? '-' }}</strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-school me-1"></i> Prodi:
                                <strong>{{ $rencana->user->prodi->nama_prodi ?? '-' }}</strong>
                            </div>
                            <div class="small text-muted">
                                <i class="ti ti-calendar me-1"></i> Tgl:
                                <strong>{{ $rencana->created_at->format('d M Y') }}</strong>
                            </div>
                        </div>

                        <h6 class="fw-bold text-primary mb-2">Deskripsi & Tujuan:</h6>
                        {{-- <div class="p-3 bg-light rounded-4 text-dark shadow-sm border-start border-primary border-4"
                            style="line-height: 1.8;">
                            {!! nl2br(e($rencana->deskripsi)) !!}
                        </div> --}}
                        <div class="bg-light rounded-4 p-4 border border-secondary-subtle border-start border-primary border-4 position-relative overflow-hidden">
                            <div class="position-relative z-1">
                                <p class="small text-muted fw-bold mb-3 text-uppercase d-flex align-items-center gap-2"
                                    style="letter-spacing: 0.5px; font-size: 10px;">
                                    <i class="ti ti-align-justified fs-6 text-primary"></i> Deskripsi Rencana Kerjasama
                                </p>
                                <div class="text-dark fw-medium" style="line-height: 1.8; font-size: 0.95rem;">
                                    {!! nl2br(e($rencana->deskripsi ?? 'Tidak ada ringkasan deskripsi yang ditambahkan untuk dokumen ini.')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BERKAS PENDUKUNG --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="ti ti-files me-2 text-primary"></i>Berkas Pendukung
                            ({{ $rencana->files->count() }})</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @forelse($rencana->files as $file)
                                <div class="col-md-6">
                                    <div
                                        class="d-flex align-items-center p-3 border rounded-4 hover-shadow transition-all bg-white">
                                        <div class="bg-light p-2 rounded-3 me-3">
                                            @if (Str::contains($file->type_file, 'pdf'))
                                                <i class="ti ti-file-type-pdf text-danger fs-3"></i>
                                            @else
                                                <i class="ti ti-photo text-success fs-3"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="mb-0 text-truncate fw-bold small text-dark">{{ $file->nama_file }}
                                            </p>
                                            <small class="text-muted">{{ formatBytes($file->size) }}</small>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <a href="{{ route('rencana-kerjasama.view-file', $file->id) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-primary rounded-circle shadow-sm"
                                                title="Lihat Dokumen">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary rounded-circle shadow-sm"
                                                title="Unduh Dokumen">
                                                <i class="ti ti-download"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-4">
                                    <img src="https://illustrations.popsy.co/gray/empty-folder.svg" alt="empty"
                                        style="width: 120px;">
                                    <p class="text-muted mt-2">Tidak ada berkas pendukung diunggah.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: MITRA & ACTION PANEL --}}
            <div class="col-lg-4">
                {{-- ACTION PANEL (HANYA MUNCUL JIKA OPERATOR/PRODI & STATUS REVISI) --}}
                @if (auth()->user()->role == 4 && $rencana->status == '4')
                    <div
                        class="card border-0 shadow-lg rounded-4 mb-4 border-top border-warning border-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                            <div class="icon-shape bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 p-3 shadow-sm"
                                style="width: 60px; height: 60px;">
                                <i class="ti ti-file-pencil fs-2 text-white"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Tindakan Diperlukan</h5>
                            <p class="text-muted small">Pengajuan ini dikembalikan. Silakan perbaiki sesuai catatan
                                verifikator.</p>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <a href="{{ route('rencana-kerjasama.edit', $rencana->id) }}"
                                class="btn btn-warning text-dark w-100 py-2 fw-bold shadow-sm rounded-pill d-flex align-items-center justify-content-center"
                                style="transition: transform 0.2s ease, box-shadow 0.2s ease;"
                                onmouseover="this.style.transform='translateY(-2px)';"
                                onmouseout="this.style.transform='translateY(0)';">
                                <i class="ti ti-edit me-2 fs-5"></i> Perbaiki Pengajuan
                            </a>
                        </div>
                    </div>
                @endif

                {{-- ACTION PANEL (HANYA MUNCUL JIKA ADMIN & STATUS PROSES REVIEW) --}}
                @if (auth()->user()->role != 4 && $rencana->status == '1')
                    <div
                        class="card border-0 shadow-lg rounded-4 mb-4 border-top border-primary border-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 pb-0 text-center">
                            <div class="icon-shape bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 p-3 shadow-sm"
                                style="width: 60px; height: 60px;">
                                <i class="ti ti-shield-check fs-2"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">Tindakan Verifikasi</h5>
                            <p class="text-muted small">Tentukan keputusan untuk pengajuan ini.</p>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="d-grid gap-2">
                                {{-- Form Langsung Setuju (Tanpa Popup) --}}
                                <form action="{{ route('rencana-kerjasama.update-feedback', $rencana->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Anda yakin ingin menyetujui rencana ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="2"> {{-- 2 = Disetujui --}}
                                    <input type="hidden" name="feedback_internal"
                                        value="Telah disetujui oleh Admin Universitas.">
                                    <button type="button"
                                        class="btn btn-success w-100 py-2 fw-bold shadow-sm rounded-pill d-flex align-items-center justify-content-center btn-action-modal"
                                        data-action="2" data-title="Setujui Pengajuan" data-color="success"
                                        data-default-text="Telah disetujui oleh Admin Universitas. Silakan lanjutkan ke proses pembuatan MoU. Jika sudah kirimkan Hard file aslinya ke Rektorat Terimakasih">
                                        <i class="ti ti-check me-2 fs-5"></i> Setujui Pengajuan
                                    </button>
                                </form>

                                <hr class="my-2 opacity-25">

                                {{-- Tombol Pemicu Modal Revisi --}}
                                <button type="button"
                                    class="btn btn-outline-warning text-dark fw-bold rounded-pill d-flex align-items-center justify-content-center btn-action-modal"
                                    data-action="4" data-title="Minta Revisi Dokumen" data-color="warning">
                                    <i class="ti ti-edit me-2 fs-5"></i> Kembalikan untuk Revisi
                                </button>

                                {{-- Tombol Pemicu Modal Tolak --}}
                                <button type="button"
                                    class="btn btn-outline-danger fw-bold rounded-pill d-flex align-items-center justify-content-center btn-action-modal"
                                    data-action="3" data-title="Tolak Pengajuan" data-color="danger">
                                    <i class="ti ti-x me-2 fs-5"></i> Tolak Pengajuan
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- FEEDBACK DISPLAY (Muncul kalau sudah diproses) --}}
                @if (in_array($rencana->status, ['2', '3', '4']))
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-{{ $currStatus['class'] }} bg-opacity-10 border-0 py-3">
                            <h6 class="mb-0 fw-bold {{ Str::replace('bg-', 'text-', $currStatus['class']) }}">
                                <i class="ti ti-message-dots me-2"></i>Catatan Verifikator
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <div
                                class="p-3 bg-light rounded-4 border-start border-{{ Str::replace('bg-', '', $currStatus['class']) }} border-4">
                                <p class="small text-dark mb-0 fw-medium">
                                    "{{ $rencana->feedback_internal ?? 'Tidak ada catatan tambahan.' }}"</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- INFO MITRA --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="mb-0 text-dark fw-bold">
                            <i class="ti ti-building-community me-2 text-primary"></i>Profil Mitra Strategis
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        {{-- Header Profil Mitra dengan Avatar Inisial --}}
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-circle d-flex align-items-center justify-content-center fw-bold fs-3 me-3 flex-shrink-0 shadow-sm"
                                style="width: 55px; height: 55px;">
                                {{ strtoupper(substr($rencana->mitra->nama_mitra, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $rencana->mitra->nama_mitra }}</h5>
                                <span class="badge bg-light text-muted border border-secondary-subtle fw-medium">
                                    <i class="ti ti-map-pin me-1 text-danger"></i>{{ $rencana->mitra->negara }}
                                </span>
                            </div>
                        </div>

                        {{-- Info Box Ruang Lingkup yang lebih elegan --}}
                        <div class="p-3 bg-light rounded-4 mb-4 border border-secondary-subtle">
                            <p class="small text-muted fw-bold mb-1 text-uppercase"
                                style="letter-spacing: 0.5px; font-size: 10px;">
                                Fokus Ruang Lingkup
                            </p>
                            <div class="d-flex align-items-start">
                                <i class="ti ti-target text-primary m-1"></i>
                                <span class="text-dark fw-bold small">
                                    {{ $rencana->ruangLingkup->nama_ruanglingkup ?? 'Belum ada ruang lingkup spesifik' }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <a href="{{ route('Manajemen-Mitra.show', $rencana->mitra_id) }}"
                            class="btn btn-outline-primary border-2 fw-bold w-100 rounded-pill shadow-sm btn-anim-mitra">
                            <i class="ti ti-external-link me-1 icon-slide"></i> Detail Profil Mitra
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DINAMIS UNTUK REVISI / TOLAK --}}
    <div class="modal fade" id="modalAction" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-dark" id="modalActionTitle">Tindakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('rencana-kerjasama.update-feedback', $rencana->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    {{-- Hidden input yang nilainya akan diisi oleh JS (3 = Tolak, 4 = Revisi) --}}
                    <input type="hidden" name="status" id="modalActionStatus">

                    <div class="modal-body px-4 py-4">
                        <div class="alert bg-light border-0 small text-muted mb-4 rounded-3">
                            <i class="ti ti-info-circle me-1"></i> Keterangan ini akan dikirimkan ke pihak Unit/Prodi
                            pengaju.
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Alasan / Catatan <span
                                    class="text-danger">*</span></label>
                            <textarea name="feedback_internal" class="form-control bg-light border-0 p-3" rows="4"
                                placeholder="Tuliskan alasan penolakan atau bagian mana yang perlu direvisi..." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-pill px-4 fw-bold shadow-sm"
                            id="modalActionSubmitBtn">Kirim Keputusan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
    <style>
        /* ... CSS kamu sebelumnya ... */

        /* Efek Lift & Glow pada tombol */
        .btn-anim-mitra {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
            background-color: transparent;
        }

        .btn-anim-mitra:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2) !important;
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        /* Efek geser kecil pada Icon saat di-hover */
        .btn-anim-mitra .icon-slide {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .btn-anim-mitra:hover .icon-slide {
            transform: translateX(3px) translateY(-1px);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil semua tombol yang memicu modal
                const actionButtons = document.querySelectorAll('.btn-action-modal');
                const modalAction = new bootstrap.Modal(document.getElementById('modalAction'));

                // Elemen di dalam modal yang akan diubah secara dinamis
                const modalTitle = document.getElementById('modalActionTitle');
                const modalStatusInput = document.getElementById('modalActionStatus');
                const modalSubmitBtn = document.getElementById('modalActionSubmitBtn');
                const feedbackTextarea = document.querySelector('textarea[name="feedback_internal"]');

                actionButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Ambil data dari atribut tombol yang diklik
                        const actionValue = this.getAttribute('data-action');
                        const actionTitle = this.getAttribute('data-title');
                        const colorTheme = this.getAttribute(
                            'data-color'); // 'success', 'warning', atau 'danger'
                        const defaultText = this.getAttribute('data-default-text') ||
                            ''; // Cek jika ada teks default

                        // Ubah UI Modal sesuai tombol yang diklik
                        modalTitle.textContent = actionTitle;
                        modalStatusInput.value = actionValue;

                        // Isi textarea secara otomatis jika ada default text (untuk ACC),
                        // atau kosongkan jika tidak ada (untuk Revisi/Tolak)
                        feedbackTextarea.value = defaultText;

                        // Reset class warna tombol submit
                        modalSubmitBtn.className = 'btn rounded-pill px-4 fw-bold shadow-sm';
                        modalSubmitBtn.classList.add(`btn-${colorTheme}`);

                        // Jika warning (Revisi), teks tombol submit text-dark agar kontras
                        if (colorTheme === 'warning') {
                            modalSubmitBtn.classList.add('text-dark');
                        } else {
                            modalSubmitBtn.classList.add('text-white');
                        }

                        // Ubah label tombol submit
                        modalSubmitBtn.textContent = actionValue === '2' ? 'Ya, Setujui' :
                            'Kirim Keputusan';

                        // Tampilkan Modal
                        modalAction.show();
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
