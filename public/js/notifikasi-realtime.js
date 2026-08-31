/**
 * Real-time Notification Handler
 * Mengelola notifikasi real-time menggunakan Laravel Echo dan Reverb
 */

// Simple notification sound (reused single Audio instance)
const __APP_BASE__ = (typeof window !== 'undefined' && window.APP_BASE_URL) ? window.APP_BASE_URL.replace(/\/$/, '') : '';
const __DING_URL__ = `${__APP_BASE__}/sound/ding.mp3`;
const __notifAudio__ = (typeof Audio !== 'undefined') ? new Audio(__DING_URL__) : null;
if (__notifAudio__) {
    __notifAudio__.preload = 'auto';
    __notifAudio__.volume = 1.0;
}

// Preference helpers
function isNotifSoundEnabled() {
    try {
        const v = localStorage.getItem('notif_sound');
        if (v === null) return true; // default ON
        return v !== 'off';
    } catch (_) { return true; }
}

function setNotifSoundEnabled(enabled) {
    try { localStorage.setItem('notif_sound', enabled ? 'on' : 'off'); } catch (_) {}
}

// Expose to window for UI buttons
if (typeof window !== 'undefined') {
    window.isNotifSoundEnabled = isNotifSoundEnabled;
    window.setNotifSoundEnabled = setNotifSoundEnabled;
}

function playNotifSound() {
    if (!isNotifSoundEnabled()) return;
    if (!__notifAudio__) return;
    try {
        __notifAudio__.currentTime = 0;
        // Ignore autoplay restrictions silently; user interaction will unlock later
        __notifAudio__.play().catch(() => {});
    } catch (_) {}
}

document.addEventListener('DOMContentLoaded', function() {
    const userId = document.querySelector('.wrapper')?.dataset.userId;
    
    if (!userId || userId === 'guest') {
        return;
    }

    // Listen untuk notifikasi real-time
    if (window.Echo) {
        if (window.__NOTIF_LISTENER_BOUND__) {
            return; // prevent double-binding
        }

        // Delay untuk memastikan Echo sudah fully initialized
        setTimeout(() => {
            try {
                const channel = window.Echo.private(`notifikasi-user.${userId}`)
                    .listen('.notifikasi.baru', () => {
                        updateNotificationBadge();
                        if (isNotificationDropdownOpen()) {
                            loadNotifications();
                        }
                        playNotifSound();
                    })
                    .error((error) => {
                        console.warn('Echo channel error:', error);
                    });
                window.__NOTIF_LISTENER_BOUND__ = true;
            } catch (error) {
                console.warn('Failed to setup Echo listener:', error);
                // Fallback ke polling jika gagal setup Echo
                ensurePollingStarted();
            }
        }, 500);

        // Aktifkan fallback polling hanya jika koneksi WS tidak tersambung
        setTimeout(() => {
            try {
                const pusher = window.Echo.connector && window.Echo.connector.pusher;
                if (pusher && pusher.connection) {
                    const handleState = (state) => {
                        const isConnected = state === 'connected';
                        if (!isConnected) {
                            ensurePollingStarted();
                        } else {
                            stopPollingIfRunning();
                        }
                    };
                    // Initial state check after delay
                    setTimeout(() => {
                        handleState(pusher.connection.state);
                    }, 1000);
                    // Subscribe to state changes
                    pusher.connection.bind('state_change', (states) => {
                        handleState(states.current);
                    });
                } else {
                    // Jika struktur echo tidak lengkap, mulai polling
                    ensurePollingStarted();
                }
            } catch (_) {
                ensurePollingStarted();
            }
        }, 1000);
    } else {
        // Fallback ke polling jika Echo tidak tersedia sama sekali
        ensurePollingStarted();
    }
});

/**
 * Update notification badge dengan jumlah terbaru
 */
function updateNotificationBadge() {
    const base = (window.NOTIF_URLS && window.NOTIF_URLS.base) || (window.NOTIF_BASE || '/notifikasi');
    const urlJumlah = (window.NOTIF_URLS && window.NOTIF_URLS.jumlah) || `${base}/jumlah-belum-dibaca`;
    fetch(urlJumlah)
        .then(response => {
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            return response.json();
        })
        .then(data => {
            const badge = document.getElementById('notification-count');
            if (badge) {
                if (data.jumlah > 0) {
                    badge.textContent = data.jumlah > 99 ? '99+' : data.jumlah;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(() => {});
}

/**
 * Cek apakah dropdown notifikasi sedang terbuka
 */
function isNotificationDropdownOpen() {
    const dropdown = document.getElementById('notificationDropdown');
    return dropdown && dropdown.getAttribute('aria-expanded') === 'true';
}

/**
 * Fallback polling untuk browser yang tidak support WebSocket
 */
let __pollingIntervalId = null;
let __lastNotificationCount = 0;
let __pollingFirstRun = true;

function ensurePollingStarted() {
    if (__pollingIntervalId !== null) return; // already running
    const pollNotifications = () => {
        const base = (window.NOTIF_URLS && window.NOTIF_URLS.base) || (window.NOTIF_BASE || '/notifikasi');
        const urlJumlah = (window.NOTIF_URLS && window.NOTIF_URLS.jumlah) || `${base}/jumlah-belum-dibaca`;
        fetch(urlJumlah)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(data => {
                const currentCount = data.jumlah;
                // Skip sound on first poll to avoid false-positive ding
                if (__pollingFirstRun) {
                    __pollingFirstRun = false;
                    __lastNotificationCount = currentCount;
                    return;
                }
                if (currentCount > __lastNotificationCount) {
                    updateNotificationBadge();
                    if (isNotificationDropdownOpen()) {
                        loadNotifications();
                    }
                    playNotifSound();
                }
                __lastNotificationCount = currentCount;
            })
            .catch(() => {});
    };
    __pollingIntervalId = setInterval(pollNotifications, 30000);
    pollNotifications();
}

function stopPollingIfRunning() {
    if (__pollingIntervalId !== null) {
        clearInterval(__pollingIntervalId);
        __pollingIntervalId = null;
        __pollingFirstRun = true; // reset for next time
    }
}
