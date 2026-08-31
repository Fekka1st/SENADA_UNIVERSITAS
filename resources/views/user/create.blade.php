<x-app-layout>
    <x-slot:title>Manajemen User</x-slot:title>
    <x-slot:breadcrumb>Tambah</x-slot:breadcrumb>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            {{-- form tambah data --}}
            <form action="{{ route('user.store.data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">

                    {{-- Kolom Kiri: Preview Foto --}}
                    <div class="col-lg-4">
                        <div class="card border bg-light">
                            <div class="card-body text-center">
                                <h6 class="card-subtitle mb-3 text-primary">
                                    <i class="ti ti-camera me-1"></i> Preview Foto
                                </h6>

                                <div class="position-relative d-inline-block mb-3">
                                    <img id="previewFoto" src="{{ asset('images/avatar.png') }}"
                                        class="img-thumbnail rounded-circle shadow" width="180" height="180"
                                        style="object-fit: cover; border: 4px solid #fff;" alt="Foto User">
                                </div>

                                {{-- Info --}}
                                <h5 class="mb-2 text-muted">User Baru</h5>

                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2">
                                    <i class="ti ti-user-plus me-1"></i>
                                    Belum Ada Foto
                                </span>
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

                                <div class="row">
                                    {{-- Kolom Kiri Form --}}
                                    <div class="col-lg-6">
                                        {{-- Nama User --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-user me-1"></i> Nama Lengkap
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="nama_user" value="{{ old('nama_user') }}"
                                                class="form-control @error('nama_user') is-invalid @enderror"
                                                placeholder="Masukkan nama lengkap" autocomplete="off">
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
                                            <input type="text" name="username" value="{{ old('username') }}"
                                                class="form-control @error('username') is-invalid @enderror"
                                                placeholder="Masukkan username" autocomplete="off">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Username untuk login ke sistem
                                            </div>
                                        </div>

                                        {{-- Role --}}
                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-shield-check me-1"></i> Role
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select name="role"
                                                class="form-select select2-single @error('role') is-invalid @enderror"
                                                autocomplete="off" required>
                                                <option selected disabled value="">- Pilih Role -</option>
                                                @foreach ($role as $r)
                                                    <option value="{{ $r->id }}"
                                                        {{ old('role') == $r->id ? 'selected' : '' }}>
                                                        {{ $r->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">
                                                <i class="ti ti-info-circle me-1"></i>
                                                Jika role belum ada, daftarkan di menu Manajemen Role
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan Form --}}
                                    <div class="col-lg-6">
                                        {{-- Password --}}
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-lock me-1"></i> Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control toggle-password @error('password') is-invalid @enderror"
                                                    placeholder="Masukkan password" autocomplete="new-password">
                                                <span class="input-group-text bg-white toggle-password-btn"
                                                    style="cursor: pointer;">
                                                    <i class="ti ti-eye"></i>
                                                </span>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror

                                            <!-- Indikator kekuatan password -->
                                            <div id="password-strength" class="mt-2" style="display: none;">
                                                <div class="progress" style="height: 8px;">
                                                    <div id="password-strength-bar" class="progress-bar"
                                                        role="progressbar" style="width: 0%"></div>
                                                </div>
                                                <small id="password-strength-text" class="text-muted"></small>
                                            </div>

                                            <!-- Checklist validasi password -->
                                            <div id="password-checklist" class="mt-2" style="display: none;">
                                                <small>
                                                    <div id="length-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Minimal 8 karakter
                                                    </div>
                                                    <div id="uppercase-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Huruf besar (A-Z)
                                                    </div>
                                                    <div id="lowercase-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Huruf kecil (a-z)
                                                    </div>
                                                    <div id="number-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Angka (0-9)
                                                    </div>
                                                    <div id="symbol-check" class="text-muted">
                                                        <i class="ti ti-x text-danger"></i> Simbol (!@#$%^&*)
                                                    </div>
                                                </small>
                                            </div>
                                        </div>

                                        {{-- Foto Upload --}}
                                        <div class="mb-0">
                                            <label class="form-label fw-semibold">
                                                <i class="ti ti-photo me-1"></i> Foto User
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
                    </div>

                </div>

                {{-- Action Buttons --}}
                <x-page-action-buttons route="user" />
            </form>
        </div>
    </div>

    {{-- Script untuk preview gambar dan validasi password --}}
    <script>
        // Preview image function
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

        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk validasi password real-time
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('password-strength');
            const passwordStrengthBar = document.getElementById('password-strength-bar');
            const passwordStrengthText = document.getElementById('password-strength-text');
            const passwordChecklist = document.getElementById('password-checklist');

            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (password.length > 0) {
                        passwordStrength.style.display = 'block';
                        passwordChecklist.style.display = 'block';
                        validatePassword(password);
                    } else {
                        passwordStrength.style.display = 'none';
                        passwordChecklist.style.display = 'none';
                    }
                });
            }

            function validatePassword(password) {
                let score = 0;
                const checks = {
                    length: password.length >= 8,
                    uppercase: /[A-Z]/.test(password),
                    lowercase: /[a-z]/.test(password),
                    number: /[0-9]/.test(password),
                    symbol: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~`]/.test(password)
                };

                // Update checklist visual
                updateCheck('length-check', checks.length);
                updateCheck('uppercase-check', checks.uppercase);
                updateCheck('lowercase-check', checks.lowercase);
                updateCheck('number-check', checks.number);
                updateCheck('symbol-check', checks.symbol);

                // Calculate strength score
                Object.values(checks).forEach(check => {
                    if (check) score++;
                });

                // Update strength bar
                const percentage = (score / 5) * 100;
                passwordStrengthBar.style.width = percentage + '%';

                // Update strength text and color
                if (score === 5) {
                    passwordStrengthBar.className = 'progress-bar bg-success';
                    passwordStrengthText.textContent = 'Password sangat kuat';
                    passwordStrengthText.className = 'text-success';
                } else if (score >= 4) {
                    passwordStrengthBar.className = 'progress-bar bg-info';
                    passwordStrengthText.textContent = 'Password kuat';
                    passwordStrengthText.className = 'text-info';
                } else if (score >= 3) {
                    passwordStrengthBar.className = 'progress-bar bg-warning';
                    passwordStrengthText.textContent = 'Password sedang';
                    passwordStrengthText.className = 'text-warning';
                } else if (score >= 1) {
                    passwordStrengthBar.className = 'progress-bar bg-warning';
                    passwordStrengthText.textContent = 'Password lemah';
                    passwordStrengthText.className = 'text-warning';
                } else {
                    passwordStrengthBar.className = 'progress-bar bg-danger';
                    passwordStrengthText.textContent = 'Password sangat lemah';
                    passwordStrengthText.className = 'text-danger';
                }
            }

            function updateCheck(elementId, isValid) {
                const element = document.getElementById(elementId);
                if (element) {
                    const icon = element.querySelector('i');
                    if (isValid) {
                        icon.className = 'ti ti-check text-success';
                        element.className = 'text-success';
                    } else {
                        icon.className = 'ti ti-x text-danger';
                        element.className = 'text-muted';
                    }
                }
            }
        });
    </script>
</x-app-layout>
