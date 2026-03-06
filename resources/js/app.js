import 'bootstrap';
import '../css/app.css';

// ── Theme system ─────────────────────────────────────────────────────────────
// Uses the SAME key and approach as the flat PHP pages (includes/header.php +
// public/assets/js/app.js) so theme is shared across ALL pages of the site.
//
// Key : 'nexora-theme'   (not 'theme')
// Target: <html data-theme="dark|light">

(function () {
    var html = document.documentElement;

    function applyTheme(t) {
        html.setAttribute('data-theme', t);
        localStorage.setItem('nexora-theme', t);
        // Update any toggle button icons
        document.querySelectorAll('.theme-toggle-icon-moon').forEach(function (el) {
            el.style.display = t === 'dark' ? 'none'  : '';
        });
        document.querySelectorAll('.theme-toggle-icon-sun').forEach(function (el) {
            el.style.display = t === 'dark' ? ''      : 'none';
        });
    }

    // Apply on load (theme already set by inline script in <head>, this keeps icons in sync)
    document.addEventListener('DOMContentLoaded', function () {
        var current = html.getAttribute('data-theme') || localStorage.getItem('nexora-theme') || 'light';
        applyTheme(current);

        // Wire up ALL theme toggle buttons on the page
        document.querySelectorAll('[data-nexora-theme-toggle]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
            });
        });
    });
})();
