/**
 * Sidebar JavaScript
 * Auto expand active submenu on page load
 */

document.addEventListener('DOMContentLoaded', function() {
    const activeLink = document.querySelector('.sidebar .nav-collapse li a.active');
    
    if (activeLink) {
        const collapse = activeLink.closest('.collapse');
        
        if (collapse) {
            // Show the collapse
            collapse.classList.add('show');
            
            // Set aria-expanded to true on the toggle link
            const toggleLink = document.querySelector('[href="#' + collapse.id + '"]');
            
            if (toggleLink) {
                toggleLink.classList.remove('collapsed');
                toggleLink.setAttribute('aria-expanded', 'true');
            }
        }
    }
});
