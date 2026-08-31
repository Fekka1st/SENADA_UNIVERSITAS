<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            {{-- Notifikasi Dropdown --}}
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ti ti-bell fs-4"></i>
                    <span class="notification-badge badge bg-danger" id="notification-count" style="display: none;"></span>
                </a>
                <ul class="dropdown-menu notifications-dropdown animated fadeIn" aria-labelledby="notificationDropdown">
                    <div class="dropdown-user-scroll scrollbar-outer d-flex flex-column">
                        <li class="notification-header">
                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <h6 class="mb-0">Notifikasi</h6>
                                <div>
                                    <button type="button" class="btn btn-sm me-2" id="notif-sound-toggle" title="Toggle suara notifikasi">
                                        <i class="ti ti-volume"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" id="btn-tandai-semua" onclick="tandaiSemuaDibaca()" title="Tandai semua dibaca">
                                        <i class="ti ti-checks fs-6"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                        <li class="notification-list flex-grow-1" id="notification-list">
                            <div class="text-center p-3">
                                <i class="ti ti-loader-2 fs-4 spinning"></i>
                                <p class="mb-0 text-muted mt-2">Memuat notifikasi...</p>
                            </div>
                        </li>
                        <li class="notification-footer border-top bg-white sticky-bottom">
                            <div class="p-2 text-center">
                                <a href="{{ route('notifikasi.index') }}" class="btn btn-primary w-100" style="font-weight:600"> Lihat semua notifikasi
                                </a>
                            </div>
                        </li>
                    </div>
                </ul>
            </li>

            <li class="nav-item topbar-user dropdown hidden-caret">
                @php
                    // Get fresh user data untuk memastikan tidak cache
                    $currentUser = \App\Models\User::with('roleModel')->find(auth()->id());
                    
                    // Prioritas: fresh user foto > auth user foto > default
                    $userFoto = null;
                    if ($currentUser && $currentUser->foto) {
                        $userFoto = $currentUser->foto;
                    } elseif (auth()->user() && auth()->user()->foto) {
                        $userFoto = auth()->user()->foto;
                    }
                    
                    $userName = $currentUser->nama_user ?? auth()->user()->nama_user;
                @endphp
                {{-- User Profile --}}
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false" title="{{ $userName }}">
                    <div class="avatar-sm">
                        <img src="{{ safe_image_url($userFoto, 'foto_user', 'images/avatar.png') }}" alt="image profile" class="avatar-img rounded-circle">
                    </div>
                    <span class="profile-username">
                        <span class="fw-bold">{{ $userName }}</span>
                    </span>
                </a>
                {{-- User Menu --}}
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ safe_image_url($userFoto, 'foto_user', 'images/avatar.png') }}" alt="image profile" class="avatar-img rounded-circle">
                                </div>
                                <div class="u-text">
                                    <h4>{{ $userName }}</h4>
                                    <p class="text-muted">{{ $currentUser->roleModel->nama ?? auth()->user()->roleModel->nama }}</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>

                            @permission('profile.edit')
                            <a href="{{ route('profil.edit') }}" class="dropdown-item py-2">
                                <i class="ti ti-user fs-5 me-2"></i> Edit Profil
                            </a>
                            @endpermission

                            @permission('password.change')
                            <a href="{{ route('password.edit') }}" class="dropdown-item py-2">
                                <i class="ti ti-lock fs-5 me-2"></i> Ubah Password
                            </a>
                            @endpermission

                            <div class="dropdown-divider mb-1"></div>
                            
                            <div class="dropdown-item py-3">
                                {{-- button logout --}}
                                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalLogout"> 
                                    Logout
                                </button>
                            </div>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>

{{-- JavaScript untuk Notifikasi Real-time --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load notifikasi awal
    loadNotifications();
    
    // Update badge count awal (tanpa polling berkala)
    updateNotificationCount();
    
    // Reload notifikasi ketika dropdown dibuka
    document.getElementById('notificationDropdown').addEventListener('click', function() {
        loadNotifications();
    });

    // Init mute/unmute button
    const toggleBtn = document.getElementById('notif-sound-toggle');
    const btnTandai = document.getElementById('btn-tandai-semua');
    const refreshIcon = () => {
        const enabled = (window.isNotifSoundEnabled ? window.isNotifSoundEnabled() : true);
        toggleBtn.innerHTML = `<i class="ti ${enabled ? 'ti-volume' : 'ti-volume-off'}"></i>`;
        toggleBtn.classList.toggle('btn-secondary', enabled);
        toggleBtn.classList.toggle('btn-danger', !enabled);
    };
    refreshIcon();
    toggleBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const enabled = (window.isNotifSoundEnabled ? window.isNotifSoundEnabled() : true);
        if (window.setNotifSoundEnabled) window.setNotifSoundEnabled(!enabled);
        refreshIcon();
    });
    // Keep dropdown open when clicking mark all read
    btnTandai.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        // onclick will still run tandaiSemuaDibaca()
    });
});

function loadNotifications() {
    const NOTIF_BASE = (window.NOTIF_BASE || (window.NOTIF_URLS && window.NOTIF_URLS.base) || '{{ url('/notifikasi') }}');
    const URL_TERBARU = (window.NOTIF_URLS && window.NOTIF_URLS.terbaru) || `${NOTIF_BASE}/terbaru`;
    fetch(URL_TERBARU)
        .then(response => response.json())
        .then(data => {
            const notificationList = document.getElementById('notification-list');
            
            if (data.notifikasi.length === 0) {
                notificationList.innerHTML = `
                    <div class="text-center p-3">
                        <i class="ti ti-bell-off fs-4 text-muted"></i>
                        <p class="mb-0 text-muted mt-2">Tidak ada notifikasi</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            data.notifikasi.forEach(notif => {
            html += `
                <li class="notification-item ${!notif.sudah_dibaca ? 'unread' : ''}" onclick="bukaNotifikasi(${notif.id})">
                    <div class="d-flex align-items-start">
                        <div class="avatar avatar-xs bg-${notif.warna} text-white rounded-2 d-inline-flex align-items-center justify-content-center me-3">
                            <i class="${notif.icon}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-title">${notif.judul}</div>
                            <div class="notification-message">${notif.pesan}</div>
                            <div class="notification-time">
                                <i class="ti ti-clock"></i>${notif.waktu_relatif}
                            </div>
                        </div>
                        <button type="button" class="btn btn-link p-0 text-muted" onclick="event.stopPropagation(); hapusSingle(${notif.id})" title="Hapus" aria-label="Hapus">
                            &times;
                        </button>
                    </div>
                </li>
            `;
            });
            
            notificationList.innerHTML = html;
        })
        .catch(() => {
            document.getElementById('notification-list').innerHTML = `
                <div class="text-center p-3">
                    <i class="ti ti-exclamation-circle fs-4 text-danger"></i>
                    <p class="mb-0 text-muted mt-2">Error memuat notifikasi</p>
                </div>
            `;
        });
}

function updateNotificationCount() {
    const URL_JUMLAH = (window.NOTIF_URLS && window.NOTIF_URLS.jumlah) || `${NOTIF_BASE}/jumlah-belum-dibaca`;
    fetch(URL_JUMLAH)
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notification-count');
            if (data.jumlah > 0) {
                badge.textContent = data.jumlah > 99 ? '99+' : data.jumlah;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        })
    .catch(() => {});
}

function bukaNotifikasi(id) {
    const BASE = (window.NOTIF_BASE || (window.NOTIF_URLS && window.NOTIF_URLS.base) || '{{ url('/notifikasi') }}');
    window.location.href = `${BASE}/${id}/buka`;
}

function tandaiDibacaSingle(id) {
    const BASE = (window.NOTIF_BASE || (window.NOTIF_URLS && window.NOTIF_URLS.base) || '{{ url('/notifikasi') }}');
    fetch(`${BASE}/${id}/tandai-dibaca`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
            updateNotificationCount();
        }
    })
    .catch(() => {});
}

function hapusSingle(id) {
    const BASE = (window.NOTIF_BASE || (window.NOTIF_URLS && window.NOTIF_URLS.base) || '{{ url('/notifikasi') }}');
    fetch(`${BASE}/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
            updateNotificationCount();
        }
    })
    .catch(() => {});
}

function tandaiSemuaDibaca() {
    const URL_TANDAI_SEMUA = (window.NOTIF_URLS && window.NOTIF_URLS.tandaiSemua) || ((window.NOTIF_BASE || '{{ url('/notifikasi') }}') + '/tandai-semua-dibaca');
    fetch(URL_TANDAI_SEMUA, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
            updateNotificationCount();
        }
    })
    .catch(() => {});
}
</script>
@endpush