/**
 * Laravel Echo Configuration
 * 
 * Konfigurasi otomatis untuk WebSocket menggunakan Laravel Reverb
 * Mendukung environment local dan production
 * 
 * KONFIGURASI ENVIRONMENT:
 * 
 * === LOCAL DEVELOPMENT (.env) ===
 * BROADCAST_CONNECTION=reverb
 * REVERB_APP_ID=your-app-id
 * REVERB_APP_KEY=your-app-key
 * REVERB_APP_SECRET=your-app-secret
 * REVERB_HOST=localhost
 * REVERB_PORT=8080
 * REVERB_SCHEME=http
 * 
 * === PRODUCTION SERVER (.env) ===
 * APP_ENV=production
 * APP_URL=https://your-domain.com
 * BROADCAST_CONNECTION=reverb
 * REVERB_APP_ID=your-production-app-id
 * REVERB_APP_KEY=your-production-app-key
 * REVERB_APP_SECRET=your-production-app-secret
 * REVERB_HOST=your-domain.com
 * REVERB_PORT=443
 * REVERB_SCHEME=https
 * 
 * CARA MENJALANKAN:
 * - Local: npm run laravel (atau jalankan terpisah: php artisan reverb:start)
 * - Production: Setup supervisor/systemd untuk php artisan reverb:start --host=0.0.0.0 --port=8080
 * - Nginx/Apache: Proxy WebSocket dari port 443 ke 8080
 * 
 * FALLBACK:
 * - Jika koneksi WebSocket gagal, sistem otomatis fallback ke HTTP polling setiap 30 detik
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

// Deteksi environment berdasarkan hostname
const hostname = window.location.hostname;
const isProduction = !hostname.includes('localhost') && !hostname.includes('127.0.0.1') && !hostname.includes('.test');
const isLocal = hostname === 'localhost' || hostname === '127.0.0.1' || hostname.includes('.test');

// Konfigurasi dinamis berdasarkan environment
let echoConfig = {
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
            'Authorization': 'Bearer ' + (document.querySelector('meta[name="auth-token"]')?.getAttribute('content') || '')
        },
    },
};

if (isProduction) {
    // Konfigurasi untuk production
    echoConfig.wsHost = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
    echoConfig.wsPort = import.meta.env.VITE_REVERB_PORT || 443;
    echoConfig.wssPort = import.meta.env.VITE_REVERB_PORT || 443;
    echoConfig.forceTLS = true;
    echoConfig.encrypted = true;
} else if (isLocal) {
    // Konfigurasi untuk local development
    echoConfig.wsHost = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
    echoConfig.wsPort = import.meta.env.VITE_REVERB_PORT || 8080;
    echoConfig.wssPort = import.meta.env.VITE_REVERB_PORT || 8080;
    echoConfig.forceTLS = (import.meta.env.VITE_REVERB_SCHEME ?? 'http') === 'https';
    echoConfig.encrypted = false;
} else {
    // Fallback untuk environment lainnya
    echoConfig.wsHost = import.meta.env.VITE_REVERB_HOST || window.location.hostname;
    echoConfig.wsPort = import.meta.env.VITE_REVERB_PORT || 8080;
    echoConfig.wssPort = import.meta.env.VITE_REVERB_PORT || 443;
    echoConfig.forceTLS = window.location.protocol === 'https:';
    echoConfig.encrypted = window.location.protocol === 'https:';
}

window.Echo = new Echo(echoConfig);
