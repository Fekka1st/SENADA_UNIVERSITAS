<x-app-layout>
    <x-slot:title>Profil</x-slot:title>
    <x-slot:breadcrumb>Edit Profil</x-slot:breadcrumb>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            {{-- form edit profil --}}
            <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">

                    {{-- Kolom Kiri: Preview Foto --}}
                    <div class="col-lg-4">
                        <div class="card border bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-subtitle mb-3 text-primary">
                                    <i class="ti ti-camera me-1"></i> Preview Foto
                                </h6>

                                <div class="position-relative d-inline-block mb-3">
                                    @php
                                        $previewPath = safe_image_url($user->foto, 'foto_user', 'images/avatar.png');
                                    @endphp
                                    <img id="previewFoto" src="{{ $previewPath }}"
                                        class="img-thumbnail rounded-circle shadow" width="180" height="180"
                                        style="object-fit: cover; border: 4px solid #fff;" alt="Foto Profil">
                                </div>

                                {{-- Info User --}}
                                <h5 class="mb-2">{{ $user->nama_user }}</h5>

                                <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                    <i class="ti ti-shield-check me-1"></i>
                                    {{ $user->roleModel->nama ?? 'User' }}
                                </span>

                                {{-- Tombol hapus foto jika ada foto --}}
                                @if ($user->foto)
                                    <div class="mt-3">
                                        <div
                                            class="form-check form-switch d-flex justify-content-center align-items-center gap-2">
                                            <input class="form-check-input m-0" type="checkbox" name="hapus_foto"
                                                id="hapusFoto" value="1" style="cursor: pointer;">
                                            <label class="form-check-label text-danger fw-semibold m-0" for="hapusFoto"
                                                style="cursor: pointer; line-height: 1.5;">
                                                <i class="ti ti-trash fs-6 me-1"></i> Hapus Foto
                                            </label>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Input --}}
                    <div class="col-lg-8">
                        <div class="card border">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-4 text-primary">
                                    <i class="ti ti-forms me-1"></i> Data Pengguna
                                </h6>

                                {{-- Nama User --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="ti ti-user me-1"></i> Nama Lengkap
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_user"
                                        value="{{ old('nama_user', $user->nama_user) }}"
                                        class="form-control @error('nama_user') is-invalid @enderror"
                                        placeholder="Masukkan nama lengkap">
                                    @error('nama_user')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Username --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="ti ti-at me-1"></i> Username
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="Masukkan username">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Info Role --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        <i class="ti ti-shield-check me-1"></i> Role
                                    </label>
                                    <div class="input-group">
                                        <input type="text" value="{{ $user->roleModel->nama ?? 'Tidak ada role' }}"
                                            class="form-control bg-light" disabled>
                                        <span class="input-group-text bg-light">
                                            <i class="ti ti-lock text-muted"></i>
                                        </span>
                                    </div>
                                    <small class="text-muted">Role tidak dapat diubah</small>
                                </div>

                                {{-- Foto Upload --}}
                                <div class="mb-0">
                                    <label class="form-label fw-semibold">
                                        <i class="ti ti-photo me-1"></i> Foto Profil
                                    </label>
                                    <input type="file" name="foto"
                                        class="form-control @error('foto') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png" onchange="previewImage(event, 'previewFoto')"
                                        id="fotoInput">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="ti ti-info-circle me-1"></i>
                                        Format: JPG, JPEG, PNG. Maksimal 2MB
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Action Buttons --}}
                <x-page-action-buttons route="dashboard" />
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus Foto --}}
    @if ($user->foto)
        <div class="modal fade" id="modalHapusFoto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalHapusFotoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="modalHapusFotoLabel">
                            <i class="ti ti-trash me-1"></i> Hapus Foto Profil
                        </h1>
                    </div>
                    <div class="modal-body">
                        {{-- informasi foto yang akan dihapus --}}
                        <p class="mb-2">
                            Yakin ingin menghapus foto profil? Foto akan diganti dengan gambar default.
                        </p>
                        <div class="text-center mb-3">
                            <img src="{{ safe_image_url($user->foto, 'foto_user', 'images/avatar.png') }}"
                                alt="Foto Profil" class="img-thumbnail rounded-circle" width="100" height="100"
                                style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" id="btnKonfirmasiHapusFoto">Ya, Hapus
                            Foto!</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Script untuk preview gambar --}}
    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const preview = document.getElementById(previewId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Handle checkbox hapus foto
        document.addEventListener('DOMContentLoaded', function() {
            const hapusFotoCheckbox = document.getElementById('hapusFoto');
            const fotoInput = document.querySelector('input[name="foto"]');
            const previewImg = document.getElementById('previewFoto');

            // Modal konfirmasi hapus foto
            const modalHapusFoto = document.getElementById('modalHapusFoto');
            const btnKonfirmasiHapusFoto = document.getElementById('btnKonfirmasiHapusFoto');
            let bootstrapModalHapusFoto;

            if (modalHapusFoto) {
                bootstrapModalHapusFoto = new bootstrap.Modal(modalHapusFoto);
            }

            if (hapusFotoCheckbox) {
                hapusFotoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Reset file input dan preview ke default
                        fotoInput.value = '';
                        previewImg.src = '{{ asset('images/avatar.png') }}';

                        // Tampilkan modal konfirmasi
                        if (bootstrapModalHapusFoto) {
                            bootstrapModalHapusFoto.show();
                        }
                    }
                });
            }

            // Handler untuk tombol konfirmasi hapus foto
            if (btnKonfirmasiHapusFoto) {
                btnKonfirmasiHapusFoto.addEventListener('click', function() {
                    // Tutup modal
                    bootstrapModalHapusFoto.hide();
                    // Checkbox tetap checked karena user sudah konfirmasi
                });
            }

            // Handler untuk modal dibatalkan
            if (modalHapusFoto) {
                modalHapusFoto.addEventListener('hidden.bs.modal', function() {
                    // Jika modal ditutup tanpa konfirmasi, uncheck checkbox dan restore preview
                    if (hapusFotoCheckbox && hapusFotoCheckbox.checked && !this.wasConfirmed) {
                        hapusFotoCheckbox.checked = false;
                        // Restore preview image ke foto asli
                        previewImg.src =
                            '{{ safe_image_url($user->foto, 'foto_user', 'images/avatar.png') }}';
                    }
                    this.wasConfirmed = false;
                });

                // Tandai bahwa modal dikonfirmasi
                if (btnKonfirmasiHapusFoto) {
                    btnKonfirmasiHapusFoto.addEventListener('click', function() {
                        modalHapusFoto.wasConfirmed = true;
                    });
                }
            }

            // Jika user upload foto baru, uncheck hapus foto
            if (fotoInput) {
                fotoInput.addEventListener('change', function() {
                    if (this.files.length > 0 && hapusFotoCheckbox) {
                        hapusFotoCheckbox.checked = false;
                    }
                });
            }
        });

        // Force refresh avatar setelah form submit berhasil
        @if (session('success'))
            setTimeout(function() {
                // Refresh semua avatar images dengan timestamp baru
                document.querySelectorAll('img.avatar-img').forEach(function(img) {
                    const originalSrc = img.src.split('?')[0]; // Remove existing timestamp
                    img.src = originalSrc + '?t=' + Date.now();
                });

                // Force browser untuk refresh halaman jika perlu
                window.location.reload();
            }, 1000);
        @endif
    </script>
</x-app-layout>
