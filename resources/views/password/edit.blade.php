<x-app-layout>
    <x-slot:title>Password</x-slot:title>
    <x-slot:breadcrumb>Ubah</x-slot:breadcrumb>

    <div class="card">
        <div class="card-body">
            {{-- judul form --}}
            <x-form-title>
                <i class="ti ti-edit fs-5 me-2"></i> Ubah Password
            </x-form-title>

            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>
            
            {{-- form ubah data --}}
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                            <input type="password" name="password_lama" class="form-control @error('password_lama') is-invalid @enderror" autocomplete="off">
                            
                            {{-- pesan error untuk password lama --}}
                            @error('password_lama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="password_baru" id="password_baru" class="form-control @error('password_baru') is-invalid @enderror" autocomplete="off">
                            
                            {{-- pesan error untuk password baru --}}
                            @error('password_baru')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <div class="form-text text-muted mt-2">
                                <small>
                                    <strong>Aturan Password Aman:</strong>
                                    <ul class="mb-0 mt-1">
                                        <li>Minimal 8 karakter</li>
                                        <li>Mengandung huruf besar (A-Z)</li>
                                        <li>Mengandung huruf kecil (a-z)</li>
                                        <li>Mengandung angka (0-9)</li>
                                        <li>Mengandung simbol (!@#$%^&*)</li>
                                    </ul>
                                </small>
                            </div>
                            
                            <!-- Indikator kekuatan password -->
                            <div id="password-strength" class="mt-2" style="display: none;">
                                <div class="progress" style="height: 8px;">
                                    <div id="password-strength-bar" class="progress-bar" role="progressbar" style="width: 0%"></div>
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

                        <div>
                            <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <input type="password" name="konfirmasi_password" class="form-control @error('konfirmasi_password') is-invalid @enderror" autocomplete="off">
                            
                            {{-- pesan error untuk konfirmasi password --}}
                            @error('konfirmasi_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
        
                {{-- action buttons --}}
                <x-page-action-buttons route="dashboard" />
            </form>
        </div>
    </div>

    {{-- Script untuk validasi password real-time --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk validasi password real-time
            const passwordInput = document.getElementById('password_baru');
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