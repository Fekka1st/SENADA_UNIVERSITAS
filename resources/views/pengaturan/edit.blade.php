<x-app-layout>
    <x-slot:title>Pengaturan Aplikasi</x-slot:title>
    <x-slot:breadcrumb>Ubah</x-slot:breadcrumb>

    {{-- Form ubah data --}}
    <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- Informasi Aplikasi --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="ti ti-info-circle me-2 text-primary"></i>Informasi Aplikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Nama Aplikasi --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Nama Aplikasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_aplikasi" 
                                   class="form-control @error('nama_aplikasi') is-invalid @enderror" 
                                   value="{{ old('nama_aplikasi', $pengaturan->nama_aplikasi) }}" 
                                   placeholder="Contoh: SIAD NamaPT"
                                   autocomplete="off">
                            @error('nama_aplikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kepanjangan Nama Aplikasi --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Kepanjangan Nama Aplikasi <span class="text-danger">*</span>
                            </label>
                            <textarea name="kepanjangan_aplikasi" rows="3" 
                                      class="form-control @error('kepanjangan_aplikasi') is-invalid @enderror" 
                                      placeholder="Contoh: Sistem Informasi Akademik Digital - Nama Perguruan Tinggi"
                                      autocomplete="off">{{ old('kepanjangan_aplikasi', $pengaturan->kepanjangan_aplikasi) }}</textarea>
                            @error('kepanjangan_aplikasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Copyright --}}
                        <div class="mb-0">
                            <label class="form-label fw-semibold">
                                Copyright <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_copyright" 
                                   class="form-control @error('nama_copyright') is-invalid @enderror" 
                                   value="{{ old('nama_copyright', $pengaturan->nama_copyright) }}" 
                                   placeholder="Contoh: Â© 2025 Nama Perguruan Tinggi"
                                   autocomplete="off">
                            @error('nama_copyright')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Akan ditampilkan di footer aplikasi</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tema & Warna --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="ti ti-palette me-2 text-primary"></i>Tema & Warna
                        </h5>
                    </div>
                    <div class="card-body">
                        <label class="form-label fw-semibold">
                            Warna Tema Utama <span class="text-danger">*</span>
                        </label>
                        
                        {{-- Color Display --}}
                        <div class="mb-3">
                            <div class="custom-color-picker-wrapper">
                                <div class="custom-color-display" id="customColorDisplay" 
                                     style="background-color: {{ old('tema_warna_utama', $pengaturan->tema_warna_utama ?? '#14438B') }};">
                                    <span class="color-text">Klik untuk memilih warna</span>
                                </div>
                                <input type="color" id="hiddenColorPicker" name="tema_warna_utama" 
                                       class="custom-color-input @error('tema_warna_utama') is-invalid @enderror" 
                                       value="{{ old('tema_warna_utama', $pengaturan->tema_warna_utama ?? '#14438B') }}">
                            </div>
                            @error('tema_warna_utama')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Hex Value --}}
                        <div class="mb-3">
                            <input type="text" id="colorValueText" 
                                   class="form-control text-uppercase fw-bold text-center" 
                                   value="{{ old('tema_warna_utama', $pengaturan->tema_warna_utama ?? '#14438B') }}" 
                                   readonly>
                        </div>
                        
                        {{-- Preset Colors --}}
                        <div>
                            <label class="form-label small text-muted mb-2">Warna Rekomendasi</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn p-0 border color-preset" data-color="#14438B" 
                                        style="width: 45px; height: 45px; background-color: #14438B; border-radius: 10px;" 
                                        title="Biru Tua"></button>
                                <button type="button" class="btn p-0 border color-preset" data-color="#2E7D32" 
                                        style="width: 45px; height: 45px; background-color: #2E7D32; border-radius: 10px;" 
                                        title="Hijau"></button>
                                <button type="button" class="btn p-0 border color-preset" data-color="#C62828" 
                                        style="width: 45px; height: 45px; background-color: #C62828; border-radius: 10px;" 
                                        title="Merah"></button>
                                <button type="button" class="btn p-0 border color-preset" data-color="#F57F17" 
                                        style="width: 45px; height: 45px; background-color: #F57F17; border-radius: 10px;" 
                                        title="Kuning"></button>
                                <button type="button" class="btn p-0 border color-preset" data-color="#1976D2" 
                                        style="width: 45px; height: 45px; background-color: #1976D2; border-radius: 10px;" 
                                        title="Biru Muda"></button>
                                <button type="button" class="btn p-0 border color-preset" data-color="#8D6E63" 
                                        style="width: 45px; height: 45px; background-color: #8D6E63; border-radius: 10px;" 
                                        title="Cokelat"></button>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3 mb-0" role="alert">
                            <small>
                                <i class="ti ti-info-circle me-1"></i>
                                Warna akan diterapkan pada sidebar, tombol, dan elemen utama lainnya.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aset Visual --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h5 class="mb-0 fw-semibold">
                            <i class="ti ti-photo me-2 text-primary"></i>Aset Visual
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            {{-- Logo Instansi --}}
                            <div class="col-md-4">
                                <div class="text-center">
                                    <label class="form-label fw-semibold d-block mb-3">
                                        Logo Instansi <span class="text-danger">*</span>
                                    </label>
                                    
                                    @php
                                        $previewInstansiPath = safe_image_url($pengaturan->logo_instansi, 'logo', 'images/logo.png');
                                    @endphp
                                    
                                    <div class="image-preview-box mx-auto mb-3" 
                                         style="width: 200px; height: 150px; border: 2px dashed #dee2e6; border-radius: 15px; 
                                                display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; 
                                                padding: 15px; transition: all 0.3s;">
                                        <img id="previewLogoInstansi" src="{{ $previewInstansiPath }}" 
                                             class="img-fluid" 
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                             alt="Logo Instansi">
                                    </div>

                                    <input type="file" accept=".jpg,.jpeg,.png" name="logo_instansi" 
                                           class="form-control @error('logo_instansi') is-invalid @enderror" 
                                           onchange="previewImage(event, 'previewLogoInstansi')">
                                    @error('logo_instansi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($pengaturan->logo_instansi)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="hapusLogoInstansi" 
                                               name="hapus_logo_instansi" value="1">
                                        <label class="form-check-label small" for="hapusLogoInstansi">
                                            Gunakan logo default
                                        </label>
                                    </div>
                                    @endif
                                    
                                    <small class="text-muted d-block mt-2">
                                        JPG, JPEG, PNG Max 1 MB
                                    </small>
                                </div>
                            </div>

                            {{-- Favicon --}}
                            <div class="col-md-4">
                                <div class="text-center">
                                    <label class="form-label fw-semibold d-block mb-3">
                                        Favicon <span class="text-danger">*</span>
                                    </label>
                                    
                                    @php
                                        $previewFaviconPath = safe_image_url($pengaturan->favicon, 'favicon', 'images/favicon.ico');
                                    @endphp
                                    
                                    <div class="image-preview-box mx-auto mb-3" 
                                         style="width: 200px; height: 150px; border: 2px dashed #dee2e6; border-radius: 15px; 
                                                display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; 
                                                padding: 15px; transition: all 0.3s;">
                                        <img id="previewFavicon" src="{{ $previewFaviconPath }}" 
                                             class="img-fluid" 
                                             style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                             alt="Favicon">
                                    </div>

                                    <input type="file" accept=".jpg,.jpeg,.png,.ico" name="favicon" 
                                           class="form-control @error('favicon') is-invalid @enderror" 
                                           onchange="previewImage(event, 'previewFavicon')">
                                    @error('favicon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($pengaturan->favicon)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="hapusFavicon" 
                                               name="hapus_favicon" value="1">
                                        <label class="form-check-label small" for="hapusFavicon">
                                            Gunakan favicon default
                                        </label>
                                    </div>
                                    @endif

                                    <small class="text-muted d-block mt-2">
                                        JPG, JPEG, PNG, ICO Max 512 KB<br>
                                        Rekomendasi: 32x32 px
                                    </small>
                                </div>
                            </div>

                            {{-- Background Login --}}
                            <div class="col-md-4">
                                <div class="text-center">
                                    <label class="form-label fw-semibold d-block mb-3">
                                        Background Login <span class="text-danger">*</span>
                                    </label>
                                    
                                    @php
                                        $previewBackgroundPath = safe_image_url($pengaturan->background_login, 'background_login', 'images/background.jpg');
                                    @endphp
                                    
                                    <div class="image-preview-box mx-auto mb-3" 
                                         style="width: 200px; height: 150px; border: 2px dashed #dee2e6; border-radius: 15px; 
                                                display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; 
                                                padding: 4px; overflow: hidden; transition: all 0.3s;">
                                        <img id="previewBackgroundLogin" src="{{ $previewBackgroundPath }}" 
                                             class="img-fluid" 
                                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;" 
                                             alt="Background Login">
                                    </div>

                                    <input type="file" accept=".jpg,.jpeg,.png" name="background_login" 
                                           class="form-control @error('background_login') is-invalid @enderror" 
                                           onchange="previewImage(event, 'previewBackgroundLogin')">
                                    @error('background_login')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    @if($pengaturan->background_login)
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="hapusBackgroundLogin" 
                                               name="hapus_background_login" value="1">
                                        <label class="form-check-label small" for="hapusBackgroundLogin">
                                            Gunakan background default
                                        </label>
                                    </div>
                                    @endif

                                    <small class="text-muted d-block mt-2">
                                        JPG, JPEG, PNG Max 2 MB<br>
                                        Rekomendasi: 1920x1080 px
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sosial Media --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0 fw-semibold">
                                <i class="ti ti-brand-facebook me-2 text-primary"></i>Sosial Media
                            </h5>
                            <span class="badge bg-light text-muted">Opsional</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            <i class="ti ti-info-circle me-1"></i>
                            Link sosial media akan ditampilkan di halaman login. Kosongkan jika tidak ingin menampilkan.
                        </p>

                        <div class="row g-4">
                            {{-- Facebook --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ti ti-brand-facebook text-primary me-2"></i>Facebook
                                </label>
                                <input type="url" name="sosmed_facebook" 
                                       class="form-control @error('sosmed_facebook') is-invalid @enderror" 
                                       placeholder="https://facebook.com/username" 
                                       value="{{ old('sosmed_facebook', $pengaturan->sosmed_facebook) }}">
                                @error('sosmed_facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Twitter/X --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ti ti-brand-x text-dark me-2"></i>Twitter/X
                                </label>
                                <input type="url" name="sosmed_twitter" 
                                       class="form-control @error('sosmed_twitter') is-invalid @enderror" 
                                       placeholder="https://twitter.com/username" 
                                       value="{{ old('sosmed_twitter', $pengaturan->sosmed_twitter) }}">
                                @error('sosmed_twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Instagram --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ti ti-brand-instagram text-danger me-2"></i>Instagram
                                </label>
                                <input type="url" name="sosmed_instagram" 
                                       class="form-control @error('sosmed_instagram') is-invalid @enderror" 
                                       placeholder="https://instagram.com/username" 
                                       value="{{ old('sosmed_instagram', $pengaturan->sosmed_instagram) }}">
                                @error('sosmed_instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- YouTube --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ti ti-brand-youtube text-danger me-2"></i>YouTube
                                </label>
                                <input type="url" name="sosmed_youtube" 
                                       class="form-control @error('sosmed_youtube') is-invalid @enderror" 
                                       placeholder="https://youtube.com/@username" 
                                       value="{{ old('sosmed_youtube', $pengaturan->sosmed_youtube) }}">
                                @error('sosmed_youtube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TikTok --}}
                            <div class="col-md-6">
                                <label class="form-label">
                                    <i class="ti ti-brand-tiktok text-dark me-2"></i>TikTok
                                </label>
                                <input type="url" name="sosmed_tiktok" 
                                       class="form-control @error('sosmed_tiktok') is-invalid @enderror" 
                                       placeholder="https://tiktok.com/@username" 
                                       value="{{ old('sosmed_tiktok', $pengaturan->sosmed_tiktok) }}">
                                @error('sosmed_tiktok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <x-page-action-buttons route="pengaturan" />
            </div>
        </div>
    </form>

    <script>
        function previewImage(event, idPreview) {
            const input = event.target;
            const preview = document.getElementById(idPreview);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // JavaScript untuk handle hapus logo instansi
        document.addEventListener('DOMContentLoaded', function() {
            const hapusLogoCheckbox = document.getElementById('hapusLogoInstansi');
            const logoInput = document.querySelector('input[name="logo_instansi"]');
            const previewLogo = document.getElementById('previewLogoInstansi');
            
            // Handle hapus logo instansi
            if (hapusLogoCheckbox) {
                hapusLogoCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Reset file input dan preview ke default
                        logoInput.value = '';
                        previewLogo.src = '{{ asset('images/logo.png') }}';
                        
                        // Konfirmasi
                        if (!confirm('Yakin ingin menghapus logo instansi? Logo akan diganti dengan logo default.')) {
                            this.checked = false;
                            // Restore preview
                            previewLogo.src = '{{ safe_image_url($pengaturan->logo_instansi, 'logo', 'images/logo.png') }}';
                        }
                    }
                });
            }
            
            // Jika admin upload logo baru, uncheck hapus logo
            if (logoInput) {
                logoInput.addEventListener('change', function() {
                    if (this.files.length > 0 && hapusLogoCheckbox) {
                        hapusLogoCheckbox.checked = false;
                    }
                });
            }

            // Handle hapus background login
            const hapusBackgroundCheckbox = document.getElementById('hapusBackgroundLogin');
            const backgroundInput = document.querySelector('input[name="background_login"]');
            const previewBackground = document.getElementById('previewBackgroundLogin');
            
            if (hapusBackgroundCheckbox) {
                hapusBackgroundCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Reset file input dan preview ke default
                        backgroundInput.value = '';
                        previewBackground.src = '{{ asset('images/background.jpg') }}';
                        
                        // Konfirmasi
                        if (!confirm('Yakin ingin menghapus background login? Background akan diganti dengan background default.')) {
                            this.checked = false;
                            // Restore preview
                            previewBackground.src = '{{ safe_image_url($pengaturan->background_login, 'background_login', 'images/background.jpg') }}';
                        }
                    }
                });
            }
            
            // Jika admin upload background baru, uncheck hapus background
            if (backgroundInput) {
                backgroundInput.addEventListener('change', function() {
                    if (this.files.length > 0 && hapusBackgroundCheckbox) {
                        hapusBackgroundCheckbox.checked = false;
                    }
                });
            }

            // Handle hapus favicon
            const hapusFaviconCheckbox = document.getElementById('hapusFavicon');
            const faviconInput = document.querySelector('input[name="favicon"]');
            const previewFavicon = document.getElementById('previewFavicon');
            
            if (hapusFaviconCheckbox) {
                hapusFaviconCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Reset file input dan preview ke default
                        faviconInput.value = '';
                        previewFavicon.src = '{{ asset('images/favicon.ico') }}';
                        
                        // Konfirmasi
                        if (!confirm('Yakin ingin menghapus favicon? Favicon akan diganti dengan favicon default.')) {
                            this.checked = false;
                            // Restore preview
                            previewFavicon.src = '{{ safe_image_url($pengaturan->favicon, 'favicon', 'images/favicon.ico') }}';
                        }
                    }
                });
            }
            
            // Jika admin upload favicon baru, uncheck hapus favicon
            if (faviconInput) {
                faviconInput.addEventListener('change', function() {
                    if (this.files.length > 0 && hapusFaviconCheckbox) {
                        hapusFaviconCheckbox.checked = false;
                    }
                });
            }

            // Color picker functionality
            const hiddenColorPicker = document.getElementById('hiddenColorPicker');
            const customColorDisplay = document.getElementById('customColorDisplay');
            const colorValueText = document.getElementById('colorValueText');
            const colorPresets = document.querySelectorAll('.color-preset');

            // Update display when color picker changes
            if (hiddenColorPicker && customColorDisplay && colorValueText) {
                hiddenColorPicker.addEventListener('change', function() {
                    const color = this.value;
                    customColorDisplay.style.backgroundColor = color;
                    colorValueText.value = color.toUpperCase();
                    updatePreview(color);
                    updateSelectedPreset(color);
                });

                // Also handle input event for real-time changes
                hiddenColorPicker.addEventListener('input', function() {
                    const color = this.value;
                    customColorDisplay.style.backgroundColor = color;
                    colorValueText.value = color.toUpperCase();
                    updatePreview(color);
                });
            }

            // Handle preset color clicks
            colorPresets.forEach(function(preset) {
                preset.addEventListener('click', function(e) {
                    e.preventDefault();
                    const color = this.getAttribute('data-color');
                    
                    // Update all elements
                    hiddenColorPicker.value = color;
                    customColorDisplay.style.backgroundColor = color;
                    colorValueText.value = color.toUpperCase();
                    updatePreview(color);
                    
                    // Update selected state
                    updateSelectedPreset(color);
                });
            });

            // Update selected preset visual state
            function updateSelectedPreset(selectedColor) {
                colorPresets.forEach(function(preset) {
                    const presetColor = preset.getAttribute('data-color');
                    if (presetColor.toLowerCase() === selectedColor.toLowerCase()) {
                        preset.classList.add('selected');
                    } else {
                        preset.classList.remove('selected');
                    }
                });
            }

            // Update preview colors
            function updatePreview(color) {
                // Update some preview elements if they exist
                const sampleElements = document.querySelectorAll('.btn-primary, .text-primary');
                // Note: This is just for preview, actual changes apply after save
                sampleElements.forEach(function(element) {
                    if (element.classList.contains('btn-primary')) {
                        element.style.backgroundColor = color;
                        element.style.borderColor = color;
                    } else if (element.classList.contains('text-primary')) {
                        element.style.color = color;
                    }
                });
            }

            // Set initial selected preset if matches
            const currentColor = hiddenColorPicker.value;
            updateSelectedPreset(currentColor);
        });
    </script>
</x-app-layout>
