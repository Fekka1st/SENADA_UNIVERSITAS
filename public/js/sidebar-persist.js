(function() {
  // Simpan dan pulihkan posisi scroll sidebar lintas navigasi halaman
  function buildStorageKey() {
    const wrapper = document.querySelector('.wrapper');
    const uid = (wrapper && wrapper.getAttribute('data-user-id')) || 'guest';
    return `sidebarScrollTop_v1::${uid}`;
  }
  let storageKey = 'sidebarScrollTop_v1::guest';

  function getSidebarScrollable() {
    // Elemen scroll utama pada sidebar
    const el = document.querySelector('.sidebar .scrollbar-inner');
    // Jika plugin jQuery Scrollbar membungkus konten, kadang scroll ada di .scroll-content
    const inner = el && el.querySelector('.scroll-content');
    return inner || el;
  }

  function restoreScroll() {
    const scrollable = getSidebarScrollable();
    if (!scrollable) return;
    const saved = localStorage.getItem(storageKey);
    if (saved !== null) {
      const pos = parseInt(saved, 10);
      if (!isNaN(pos)) {
        scrollable.scrollTop = pos;
      }
    } else {
      // Fallback: kalau belum ada posisi tersimpan, pastikan item aktif terlihat
      const activeLink = document.querySelector('.sidebar .nav .active');
      if (activeLink) {
        try {
          const parent = scrollable;
          const parentRect = parent.getBoundingClientRect();
          const linkRect = activeLink.getBoundingClientRect();
          const offset = (linkRect.top - parentRect.top) + parent.scrollTop;
          const target = Math.max(0, offset - (parent.clientHeight / 2) + (activeLink.clientHeight / 2));
          parent.scrollTop = target;
        } catch (e) {
          // Cadangan: pusatkan item aktif
          activeLink.scrollIntoView({ block: 'center', behavior: 'auto' });
        }
      }
    }
  }

  function watchScroll() {
    const scrollable = getSidebarScrollable();
    if (!scrollable) return;
    let ticking = false;
    scrollable.addEventListener('scroll', function() {
      if (ticking) return;
      ticking = true;
      setTimeout(() => {
        localStorage.setItem(storageKey, String(scrollable.scrollTop));
        ticking = false;
      }, 120);
    }, { passive: true });

    // Simpan posisi saat user klik link di sidebar (agar tersimpan meski tidak ada scroll event terakhir)
    document.querySelectorAll('.sidebar a').forEach(a => {
      a.addEventListener('click', () => {
        localStorage.setItem(storageKey, String(scrollable.scrollTop));
      }, { passive: true });
    });
  }

  // Jalankan setelah halaman siap (dan setelah inisialisasi template selesai)
  document.addEventListener('DOMContentLoaded', function() {
    storageKey = buildStorageKey();
    // Tunda sedikit untuk memastikan plugin template menerapkan scrollbar custom
    setTimeout(() => {
      restoreScroll();
      watchScroll();
    }, 50);
  });
})();
