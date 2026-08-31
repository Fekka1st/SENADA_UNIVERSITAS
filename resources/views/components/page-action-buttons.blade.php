@props([
    'route',
    'showEditButton' => false,
    'showDeleteButton' => false,
    'editRoute' => null,
    'editPermission' => null,
    'deletePermission' => null,
    'deleteModalTarget' => '#modalHapus',
    'showDefaultSubmit' => true
])

<div class="pt-3 pb-1 mt-4 border-top">
    @if (request()->routeIs($route . '.show'))
        {{-- Layout untuk halaman show --}}
        <div class="d-flex justify-content-between align-items-center gap-2">
            {{-- Button kembali ke halaman index --}}
            <a href="{{ route($route . '.index') }}" class="btn btn-secondary px-4">
                <i class="ti ti-arrow-left me-2"></i> Kembali
            </a>
            
            <div class="d-flex gap-2 align-items-center">
                {{-- Tombol Edit otomatis jika parameter diberikan --}}
                @if ($showEditButton && $editRoute && $editPermission)
                    @permission($editPermission)
                        <a href="{{ $editRoute }}" class="btn btn-warning">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                    @endpermission
                @endif

                {{-- Tombol Delete otomatis jika parameter diberikan --}}
                @if ($showDeleteButton && $deletePermission)
                    @permission($deletePermission)
                        <button type="button" class="btn btn-danger" 
                                data-bs-toggle="modal"
                                data-bs-target="{{ $deleteModalTarget }}">
                            <i class="ti ti-trash me-1"></i> Hapus
                        </button>
                    @endpermission
                @endif
                
                {{-- Slot untuk tombol tambahan di halaman show --}}
                {{ $actions ?? '' }}
            </div>
        </div>
    @else
        {{-- Layout untuk halaman create dan edit --}}
        <div class="d-flex justify-content-between align-items-center gap-2">
            {{-- Button kembali ke halaman index untuk create dan edit --}}
            @if (request()->routeIs('profil.edit'))
                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary px-4">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
            @else
                <a href="{{ route($route . '.index') }}" class="btn btn-secondary px-4">
                    <i class="ti ti-arrow-left me-2"></i> Kembali
                </a>
            @endif

            <div class="d-flex gap-2 align-items-center">
                {{-- Button simpan data untuk create dan edit (optional) --}}
                @if ($showDefaultSubmit)
                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                        <i class="ti ti-device-floppy me-2"></i>Simpan
                    </button>
                @endif
                
                {{-- Slot untuk tombol tambahan di halaman create dan edit --}}
                {{ $actions ?? '' }}
            </div>
        </div>
    @endif
</div>

@if ($showDefaultSubmit)
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('submitBtn');
            const forms = document.querySelectorAll('form');
            
            if (submitBtn && forms.length > 0) {
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        // Disable button untuk mencegah double submit
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Menyimpan...';
                        
                        // Enable kembali setelah 5 detik untuk mencegah stuck
                        setTimeout(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="ti ti-device-floppy me-2"></i>Simpan';
                        }, 5000);
                    });
                });
            }
        });
    </script>
    @endpush
@endif