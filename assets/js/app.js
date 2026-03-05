/**
 * Nexora Tools — Main JavaScript
 * Features: Dark/Light mode toggle, Mobile nav, Search overlay, Category filter
 */

(function () {
    'use strict';

    const BASE_URL   = window.BASE_URL   || '/';
    const ALL_TOOLS  = window.NEXORA_TOOLS || [];

    // ─── Theme Toggle ────────────────────────────────────────────────────────
    const html         = document.documentElement;
    const themeToggle  = document.getElementById('themeToggle');
    const THEME_KEY    = 'nexora-theme';

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        localStorage.setItem(THEME_KEY, theme);
    }

    // Init: use saved preference, then system preference
    const savedTheme = localStorage.getItem(THEME_KEY);
    if (savedTheme) {
        applyTheme(savedTheme);
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        applyTheme('dark');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const current = html.getAttribute('data-theme') || 'light';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    }

    // ─── Navbar Scroll Shadow ────────────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    if (navbar) {
        const onScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 10);
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // ─── Mobile Hamburger ────────────────────────────────────────────────────
    const hamburger = document.getElementById('hamburger');
    const navLinks  = document.getElementById('navLinks');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            const open = navLinks.classList.toggle('open');
            hamburger.classList.toggle('open', open);
            hamburger.setAttribute('aria-expanded', open);
        });
        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!navbar.contains(e.target)) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('open');
            }
        });
    }

    // ─── Search Overlay ──────────────────────────────────────────────────────
    const searchToggle   = document.getElementById('searchToggle');
    const searchOverlay  = document.getElementById('searchOverlay');
    const searchBackdrop = document.getElementById('searchBackdrop');
    const searchInput    = document.getElementById('searchInput');
    const searchResults  = document.getElementById('searchResults');
    const searchClose    = document.getElementById('searchClose');

    function openSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.add('open');
        searchBackdrop.classList.add('open');
        setTimeout(() => searchInput && searchInput.focus(), 80);
    }

    function closeSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.remove('open');
        searchBackdrop.classList.remove('open');
        if (searchInput)  searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    if (searchToggle)   searchToggle.addEventListener('click', openSearch);
    if (searchClose)    searchClose.addEventListener('click', closeSearch);
    if (searchBackdrop) searchBackdrop.addEventListener('click', closeSearch);

    // Keyboard: Ctrl+K / Cmd+K to open, Esc to close
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault(); openSearch();
        }
        if (e.key === 'Escape') closeSearch();
    });

    // Live search results
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.trim().toLowerCase();
            if (!searchResults) return;
            if (!q) { searchResults.innerHTML = ''; return; }

            const matches = ALL_TOOLS.filter(t =>
                t.name.toLowerCase().includes(q) ||
                t.desc.toLowerCase().includes(q) ||
                t.cat.toLowerCase().includes(q)
            ).slice(0, 12);

            if (!matches.length) {
                searchResults.innerHTML = '<span style="color:var(--text-3);font-size:0.85rem;padding:4px">No tools found for "' + q + '"</span>';
                return;
            }

            searchResults.innerHTML = matches.map(t => `
                <a href="${BASE_URL}${t.slug}" class="search-result-item" onclick="closeSearch()">
                    <span class="search-result-icon">${t.icon}</span>
                    <span>${t.name}</span>
                </a>
            `).join('');
        });
    }

    // ─── Category Filter (homepage / tools page) ─────────────────────────────
    const catTabs   = document.querySelectorAll('.cat-tab[data-cat]');
    const toolCards = document.querySelectorAll('.tool-card[data-cat]');

    if (catTabs.length) {
        catTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const selected = tab.dataset.cat;

                catTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                toolCards.forEach(card => {
                    const match = selected === 'all' || card.dataset.cat === selected;
                    card.classList.toggle('hidden', !match);
                });
            });
        });
    }

    // ─── Hero Search (redirects to tools page) ───────────────────────────────
    const heroSearchForm = document.getElementById('heroSearchForm');
    if (heroSearchForm) {
        heroSearchForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const q = document.getElementById('heroSearchInput')?.value.trim();
            if (q) {
                const match = ALL_TOOLS.find(t => t.name.toLowerCase().includes(q.toLowerCase()));
                window.location.href = match ? BASE_URL + match.slug : BASE_URL + 'tools?q=' + encodeURIComponent(q);
            }
        });
    }

    // ─── Counter Animation ────────────────────────────────────────────────────
    function animateCounter(el) {
        const target = parseInt(el.dataset.count, 10);
        if (isNaN(target)) return;
        const duration = 1600;
        const start    = performance.now();
        const suffix   = el.dataset.suffix || '';
        function step(now) {
            const pct = Math.min((now - start) / duration, 1);
            const ease = 1 - Math.pow(1 - pct, 3);
            el.textContent = Math.floor(ease * target).toLocaleString() + suffix;
            if (pct < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    const counterEls = document.querySelectorAll('[data-count]');
    if (counterEls.length && 'IntersectionObserver' in window) {
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    animateCounter(e.target);
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        counterEls.forEach(el => obs.observe(el));
    }

    // ─── Copy to Clipboard helper ─────────────────────────────────────────────
    window.nexoraCopy = function (text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            if (btn) {
                const orig = btn.textContent;
                btn.textContent = '✓ Copied!';
                setTimeout(() => { btn.textContent = orig; }, 1800);
            }
        });
    };

    // ─── Smooth anchor scroll ─────────────────────────────────────────────────
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', (e) => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
