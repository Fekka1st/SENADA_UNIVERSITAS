<x-app-layout>
    <x-slot:title>Manajemen User</x-slot:title>
    <x-slot:breadcrumb>Detail</x-slot:breadcrumb>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            {{-- menampilkan pesan berhasil --}}
            <x-alert></x-alert>

            <div class="row g-4">
                {{-- Kolom Kiri: Preview Foto --}}
                <div class="col-lg-4">
                    <div class="card border bg-light">
                        <div class="card-body text-center">
                            <h6 class="card-subtitle mb-3 text-primary">
                                <i class="ti ti-camera me-1"></i> Foto User
                            </h6>

                            <div class="position-relative d-inline-block mb-3">
                                @php
                                    $previewPath = safe_image_url($user->foto, 'foto_user', 'images/avatar.png');
                                @endphp
                                <img src="{{ $previewPath }}" class="img-thumbnail rounded-circle shadow" width="180"
                                    height="180" style="object-fit: cover; border: 4px solid #fff;"
                                    alt="Foto {{ $user->nama_user }}">
                            </div>

                            {{-- Info User --}}
                            <h5 class="mb-2">{{ $user->nama_user }}</h5>

                            <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                <i class="ti ti-shield-check me-1"></i>
                                {{ $user->roleModel->nama ?? 'User' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail Data --}}
                <div class="col-lg-8">
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="card-subtitle mb-4 text-primary">
                                <i class="ti ti-info-circle me-1"></i> Informasi Detail
                            </h6>

                            {{-- Nama User --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="ti ti-user me-1"></i> Nama Lengkap
                                </label>
                                <div class="form-control bg-light" style="cursor: default;">
                                    {{ $user->nama_user }}
                                </div>
                            </div>

                            {{-- Username --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="ti ti-at me-1"></i> Username
                                </label>
                                <div class="form-control bg-light" style="cursor: default;">
                                    {{ $user->username }}
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="ti ti-shield-check me-1"></i> Role
                                </label>
                                <div class="form-control bg-light" style="cursor: default;">
                                    {{ $user->roleModel->nama }}
                                </div>
                            </div>

                            {{-- Dibuat Pada --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="ti ti-calendar-plus me-1"></i> Dibuat Pada
                                </label>
                                <div class="form-control bg-light" style="cursor: default;">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : '-' }}
                                </div>
                            </div>

                            {{-- Diperbarui Pada --}}
                            <div class="mb-0">
                                <label class="form-label fw-semibold text-muted small">
                                    <i class="ti ti-calendar-time me-1"></i> Diperbarui Pada
                                </label>
                                <div class="form-control bg-light" style="cursor: default;">
                                    {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <x-page-action-buttons route="user" :showEditButton="true" :showDeleteButton="true" :editRoute="route('user.edit', $user->id)"
                editPermission="user.edit" deletePermission="user.delete" deleteModalTarget="#modalHapus" />
        </div>
    </div>

    {{-- Modal Hapus --}}
    @permission('user.delete')
        <x-modal.hapus id="modalHapus" title="Hapus User" itemName="{{ $user->username }}"
            deleteRoute="{{ route('user.destroy', $user->id) }}" />
    @endpermission

</x-app-layout>
