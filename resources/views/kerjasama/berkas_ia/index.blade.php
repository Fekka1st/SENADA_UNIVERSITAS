<x-app-layout>
    <x-slot:title>Daftar Perjanjian Kerja Sama (MoA)</x-slot:title>
    <x-slot:breadcrumb>Kerjasama / MoA / Daftar</x-slot:breadcrumb>

    <div class="container-fluid">
        <x-alert></x-alert>

        {{-- WIDGET STATISTIK (EXECUTIVE SUMMARY) --}}
        <div class="row g-4 mb-4">
            {{-- Widget 1: Total Dokumen --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 bg-dark text-white overflow-hidden position-relative h-100">
                    <i class="ti ti-file-text position-absolute opacity-10" style="right: -20px; bottom: -20px; font-size: 8rem;"></i>
                    <div class="card-body p-4 position-relative z-1 d-flex flex-column justify-content-center">
                        <h6 class="fw-bold mb-1 opacity-75 text-uppercase" style="letter-spacing: 1px; font-size: 11px;">Total Dokumen MoA</h6>
                        <h2 class="display-5 fw-bolder mb-0">{{ $total_moa ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            {{-- Widget 2: Status Aktif --}}
            <div class="col-md-4">
                <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-white h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px;">
                            <i class="ti ti-shield-check fs-2"></i>
                        </div>
                        <div>
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">MoA Aktif Berlaku</h6>
                            <h3 class="fw-bolder text-dark mb-0">{{ $moa_aktif ?? 0 }} <span class="fs-6 text-muted fw-medium">Dokumen</span></h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Widget 3: Total Nilai Finansial --}}
            <div class="col-md-4">
                <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-white h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width: 60px; height: 60px;">
                            <i class="ti ti-report-money fs-2"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="text-muted fw-bold mb-1 text-uppercase" style="letter-spacing: 0.5px; font-size: 10px;">Total Nilai Kerjasama</h6>
                            <h3 class="fw-bolder text-dark mb-0 text-truncate" title="Rp {{ number_format($total_finansial ?? 0, 0, ',', '.') }}">
                                Rp {{ number_format($total_finansial ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL DIREKTORI MoA --}}
        <div class="card border border-secondary-subtle shadow-sm rounded-4">
            {{-- Header Card & Action Bar --}}
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <span class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-list fs-5"></i>
                    </span>
                    Direktori Dokumen MoA
                </h6>

                <div class="d-flex flex-column flex-sm-row gap-2">
                    {{-- Search Bar (Opsional: Siapkan untuk fitur search) --}}
                    <form action="{{ route('data-moa.index') }}" method="GET" class="input-group input-group-sm shadow-sm rounded-pill overflow-hidden border border-secondary-subtle">
                        <span class="input-group-text bg-light border-0 px-3"><i class="ti ti-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Cari Judul / Mitra..." value="{{ request('search') }}">
                        <button class="btn btn-light border-start text-muted fw-bold" type="submit">Cari</button>
                    </form>

                    <a href="{{ route('data-moa.create') }}" class="btn btn-primary btn-sm rounded-pill fw-bold shadow-sm px-3 d-flex align-items-center justify-content-center">
                        <i class="ti ti-plus me-1"></i> Registrasi Baru
                    </a>
                </div>
            </div>

            {{-- Isi Tabel --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border-bottom mb-0" style="min-width: 1000px;">
                        <thead class="bg-light">
                            <tr>
                                <th class="py-3 px-4 text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px; width: 35%;">No. Dokumen & Judul</th>
                                <th class="py-3 px-3 text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px; width: 25%;">Payung MoU & Mitra</th>
                                <th class="py-3 px-3 text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px; width: 15%;">Nilai Finansial</th>
                                <th class="py-3 px-3 text-uppercase text-muted fw-bold" style="font-size: 10px; letter-spacing: 0.5px; width: 15%;">Masa Berlaku</th>
                                <th class="py-3 px-4 text-uppercase text-muted fw-bold text-end" style="font-size: 10px; letter-spacing: 0.5px; width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($moas ?? [] as $moa)
                                @php
                                    // Logika Status Masa Berlaku
                                    $akhir = \Carbon\Carbon::parse($moa->tanggal_berakhir)->endOfDay();
                                    $isExpired = now()->gt($akhir);
                                @endphp
                                <tr class="transition-all hover-bg-light">
                                    <td class="px-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3 flex-shrink-0">
                                                <i class="ti ti-file-text fs-4"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h6 class="fw-bold text-dark mb-1 text-truncate" title="{{ $moa->judul_moa }}">{{ $moa->judul_moa }}</h6>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-light text-dark border border-secondary-subtle font-monospace px-2 py-1">{{ $moa->nomor_moa }}</span>
                                                    @if($moa->files_count > 0)
                                                        <span class="text-muted small"><i class="ti ti-paperclip"></i> {{ $moa->files_count }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-dark fs-7 text-truncate" title="{{ $moa->mou->mitra->nama_mitra ?? '-' }}">
                                                {{ $moa->mou->mitra->nama_mitra ?? 'Mitra Tidak Ditemukan' }}
                                            </span>
                                            <small class="text-muted d-flex align-items-center mt-1 text-truncate" title="Induk: {{ $moa->mou->nomor_mou ?? '-' }}">
                                                <i class="ti ti-link me-1 text-primary"></i>
                                                {{ $moa->mou->nomor_mou ?? 'MoU Terhapus' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">
                                        @if($moa->nominal_finansial)
                                            <span class="fw-bolder text-success">Rp {{ number_format($moa->nominal_finansial, 0, ',', '.') }}</span><br>
                                            <span class="badge bg-light text-muted border border-secondary-subtle mt-1" style="font-size: 9px;">
                                                <i class="ti ti-wallet me-1"></i>{{ \Illuminate\Support\Str::limit($moa->sumber_dana, 15) }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border border-secondary-subtle px-2 py-1">Non-Finansial</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3">
                                        <div class="d-flex flex-column align-items-start gap-1">
                                            <span class="text-dark small fw-medium">
                                                {{ \Carbon\Carbon::parse($moa->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($moa->tanggal_berakhir)->format('d M Y') }}
                                            </span>
                                            @if($isExpired)
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1" style="font-size: 9px;">KEDALUWARSA</span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-2 py-1" style="font-size: 9px;">AKTIF</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('data-moa.show', $moa->id) }}" class="btn btn-sm btn-light text-primary border border-secondary-subtle hover-bg-primary transition-all rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Lihat Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @if(auth()->user()->role != 5) {{-- Misal Role 5 adalah View Only --}}
                                                <a href="{{ route('data-moa.edit', $moa->id) }}" class="btn btn-sm btn-light text-warning border border-secondary-subtle hover-bg-warning transition-all rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Edit Data">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                                {{-- Tombol Hapus --}}
                                                <form action="{{ route('data-moa.destroy', $moa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen MoA ini? Semua lampiran PDF juga akan terhapus permanen.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger border border-secondary-subtle hover-bg-danger transition-all rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" title="Hapus Data">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3 shadow-sm border border-secondary-subtle">
                                            <i class="ti ti-folder-off text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Belum Ada Data MoA</h6>
                                        <p class="small text-muted mb-3">Tidak ada dokumen Perjanjian Kerja Sama yang diregistrasi.</p>
                                        <a href="{{ route('data-moa.create') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">
                                            Mulai Registrasi Baru
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginasi (Jika menggunakan paginate() di Controller) --}}
            @if(isset($moas) && $moas instanceof \Illuminate\Pagination\LengthAwarePaginator && $moas->hasPages())
                <div class="card-footer bg-white border-top p-3 d-flex justify-content-center">
                    {{ $moas->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
        .fs-7 { font-size: 0.85rem; }
        .hover-bg-light:hover { background-color: #f8faff !important; }
        .hover-bg-primary:hover { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd !important; }
        .hover-bg-warning:hover { background-color: #ffc107 !important; color: black !important; border-color: #ffc107 !important; }
        .hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
        .transition-all { transition: all 0.2s ease-in-out; }
    </style>
</x-app-layout>
