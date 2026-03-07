/**
 * Nexora Tools — Main JavaScript
 * Served from: /assets/js/app.js
 */
(function () {
    'use strict';

    const BASE_URL  = window.BASE_URL  || '/';
    const ALL_TOOLS = window.NEXORA_TOOLS || [];

    // ── Theme Toggle ────────────────────────────────────────────────────────
    const html        = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const themeLabel  = themeToggle ? themeToggle.querySelector('.side-btn-label') : null;

    function setThemeLabel(currentTheme) {
        if (!themeLabel) return;
        themeLabel.textContent = currentTheme === 'dark' ? 'Light' : 'Dark';
    }

    function applyTheme(t) {
        html.setAttribute('data-theme', t);
        localStorage.setItem('nexora-theme', t);
        setThemeLabel(t);
    }

    const saved = localStorage.getItem('nexora-theme');
    if (saved) {
        applyTheme(saved);
    } else if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        applyTheme('dark');
    } else {
        setThemeLabel(html.getAttribute('data-theme') || 'light');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        });
    }

    // ── Flash Message (Toast) System ─────────────────────────────────────────
    window.showFlash = function(message, type = 'success', duration = 3000) {
        const container = document.getElementById('flashContainer') || createFlashContainer();
        const toast = document.createElement('div');
        toast.className = `flash-toast flash-${type}`;
        toast.textContent = message;
        toast.setAttribute('role', 'alert');
        
        container.appendChild(toast);
        
        // Trigger animation
        requestAnimationFrame(() => toast.classList.add('show'));
        
        // Auto-dismiss
        const timeout = setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, duration);
        
        // Close button handler
        toast.addEventListener('click', () => {
            clearTimeout(timeout);
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        });
    };

    function createFlashContainer() {
        const container = document.createElement('div');
        container.id = 'flashContainer';
        container.className = 'flash-container';
        document.body.appendChild(container);
        return container;
    }

    // ── Navbar scroll shadow ─────────────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    if (navbar) {
        const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 10);
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

    // ── Mobile Menu ───────────────────────────────────────────────────────────
    const hamburger = document.getElementById('hamburger');
    const navLinks  = document.getElementById('navLinks');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', () => {
            const open = navLinks.classList.toggle('open');
            hamburger.classList.toggle('open', open);
        });
        document.addEventListener('click', e => {
            if (navbar && !navbar.contains(e.target)) {
                navLinks.classList.remove('open');
                hamburger.classList.remove('open');
            }
        });
    }

    // ── Search Overlay ───────────────────────────────────────────────────────
    const searchToggle   = document.getElementById('searchToggle');
    const searchOverlay  = document.getElementById('searchOverlay');
    const searchBackdrop = document.getElementById('searchBackdrop');
    const searchInput    = document.getElementById('searchInput');
    const searchResults  = document.getElementById('searchResults');
    const searchClose    = document.getElementById('searchClose');

    function openSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.add('open');
        if (searchBackdrop) searchBackdrop.classList.add('open');
        setTimeout(() => searchInput && searchInput.focus(), 80);
    }
    function closeSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.remove('open');
        if (searchBackdrop) searchBackdrop.classList.remove('open');
        if (searchInput)  searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    if (searchToggle)   searchToggle.addEventListener('click', openSearch);
    if (searchClose)    searchClose.addEventListener('click', closeSearch);
    if (searchBackdrop) searchBackdrop.addEventListener('click', closeSearch);

    document.addEventListener('keydown', e => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); openSearch(); }
        if (e.key === 'Escape') closeSearch();
    });

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            if (!searchResults) return;
            if (!q) { searchResults.innerHTML = ''; return; }
            const hits = ALL_TOOLS.filter(function(t) {
                return t.name.toLowerCase().indexOf(q) !== -1 || (t.desc || '').toLowerCase().indexOf(q) !== -1;
            }).slice(0, 8);
            if (!hits.length) {
                searchResults.innerHTML = '<div style="padding:16px 20px;color:var(--text-3);font-size:.875rem">No tools found for "' + q + '"</div>';
                return;
            }
            searchResults.innerHTML = hits.map(function(t) {
                return '<a href="' + BASE_URL + 'tools/' + t.slug + '" style="display:flex;align-items:center;gap:12px;padding:10px 16px;'
                     + 'text-decoration:none;color:var(--text);transition:background .12s;border-bottom:1px solid var(--border)"'
                     + ' onmouseover="this.style.background=\'var(--bg-elevated)\'" onmouseout="this.style.background=\'\'">'
                     + '<span style="font-size:1rem;width:20px;text-align:center;opacity:.7">' + t.icon + '</span>'
                     + '<div><div style="font-weight:600;font-size:.875rem">' + t.name + '</div>'
                     + '<div style="font-size:.78rem;color:var(--text-3)">' + (t.desc || '').substring(0, 60) + '</div></div></a>';
            }).join('');
        });
    }

    // ── Category Filter ──────────────────────────────────────────────────────
    const catTabs   = document.querySelectorAll('.cat-tab[data-cat]');
    const toolCards = document.querySelectorAll('.tool-card[data-cat]');
    catTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const sel = tab.dataset.cat;
            catTabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            toolCards.forEach(c => c.classList.toggle('hidden', sel !== 'all' && c.dataset.cat !== sel));
        });
    });

    // ── Hero Search ───────────────────────────────────────────────────────────
    const heroForm = document.getElementById('heroSearchForm');
    if (heroForm) {
        heroForm.addEventListener('submit', e => {
            e.preventDefault();
            const q = document.getElementById('heroSearchInput')?.value.trim();
            if (!q) return;
            const match = ALL_TOOLS.find(t => t.name.toLowerCase().includes(q.toLowerCase()));
            window.location.href = match ? BASE_URL + match.slug : BASE_URL + 'tools?q=' + encodeURIComponent(q);
        });
    }

    // ── Counter Animation ────────────────────────────────────────────────────
    function animateCounter(el) {
        const target = parseInt(el.dataset.count, 10);
        if (isNaN(target)) return;
        const suffix = el.dataset.suffix || '';
        const start  = performance.now();
        (function step(now) {
            const pct  = Math.min((now - start) / 1600, 1);
            const ease = 1 - Math.pow(1 - pct, 3);
            el.textContent = Math.floor(ease * target).toLocaleString() + suffix;
            if (pct < 1) requestAnimationFrame(step);
        })(start);
    }
    const counters = document.querySelectorAll('[data-count]');
    if (counters.length && 'IntersectionObserver' in window) {
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) { animateCounter(e.target); obs.unobserve(e.target); } });
        }, { threshold: 0.5 });
        counters.forEach(el => obs.observe(el));
    }

    // ── Copy helper ───────────────────────────────────────────────────────────
    window.nexoraCopy = function (text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            if (btn) { const orig = btn.textContent; btn.textContent = '✓ Copied!'; setTimeout(() => btn.textContent = orig, 1800); }
        });
    };

    // ── Market Overview ───────────────────────────────────────────────────────
    const marketGrid    = document.getElementById('marketGrid');
    const marketTime    = document.getElementById('marketTime');
    const marketRefresh = document.getElementById('marketRefresh');

    function renderMarket(data) {
        if (!marketGrid) return;
        if (!data.indices || !data.indices.length) {
            marketGrid.innerHTML = '<p style="color:var(--text-3);font-size:.85rem;padding:16px 0;grid-column:1/-1">Market data temporarily unavailable.</p>';
            return;
        }
        marketGrid.innerHTML = data.indices.map(idx => `
            <div class="market-card ${idx.up ? 'up' : 'down'}">
                <div class="market-card-flag">${idx.flag}</div>
                <div class="market-card-name">${idx.name}</div>
                <div class="market-card-price">${idx.currency ? idx.currency + ' ' : ''}${idx.price}</div>
                <span class="market-card-change ${idx.up ? 'up' : 'down'}">
                    ${idx.up ? '▲' : '▼'} ${idx.change_pct}
                </span>
                <div class="market-card-state">${idx.market_state === 'REGULAR' ? '🟢 Open' : '🔴 Closed'} · ${idx.change}</div>
            </div>`).join('');
        if (marketTime) marketTime.textContent = `Updated ${data.fetched_at} · ${data.date}`;
    }

    async function loadMarket() {
        if (!marketGrid) return;
        if (marketRefresh) marketRefresh.classList.add('spinning');
        try {
            const res  = await fetch(BASE_URL + 'api/stocks.php');
            const data = await res.json();
            renderMarket(data);
        } catch {
            if (marketGrid) marketGrid.innerHTML = '<p style="color:var(--text-3);font-size:.85rem;padding:16px 0;grid-column:1/-1">Could not load market data. Please refresh.</p>';
        } finally {
            if (marketRefresh) marketRefresh.classList.remove('spinning');
        }
    }

    if (marketGrid) {
        loadMarket();
        if (marketRefresh) marketRefresh.addEventListener('click', loadMarket);
    }

    // ── News Section ──────────────────────────────────────────────────────────
    const newsGrid = document.getElementById('newsGrid');
    const newsTabs = document.getElementById('newsTabs');
    let   currentNewsType = 'tech';

    function renderNews(data) {
        if (!newsGrid) return;
        if (!data.items || !data.items.length) {
            newsGrid.innerHTML = '<p style="color:var(--text-3);font-size:.85rem;padding:16px 0;grid-column:1/-1">News temporarily unavailable.</p>';
            return;
        }
        newsGrid.innerHTML = data.items.map(item => `
            <a href="${item.link}" target="_blank" rel="noopener noreferrer" class="news-card">
                <div class="news-card-source">${item.source}</div>
                <div class="news-card-title">${item.title}</div>
                <div class="news-card-date">🕐 ${item.pubDate}</div>
                <div class="news-card-arrow">Read more →</div>
            </a>`).join('');
    }

    async function loadNews(type) {
        if (!newsGrid) return;
        newsGrid.innerHTML = Array(6).fill(0).map(() =>
            `<div class="news-card skeleton">
                <div class="sk-line sk-w30"></div>
                <div class="sk-line sk-w100 sk-md"></div>
                <div class="sk-line sk-w80"></div>
                <div class="sk-line sk-w50 sk-sm"></div>
            </div>`).join('');
        try {
            const res  = await fetch(BASE_URL + 'api/news.php?type=' + type + '&limit=6');
            const data = await res.json();
            renderNews(data);
        } catch {
            newsGrid.innerHTML = '<p style="color:var(--text-3);font-size:.85rem;padding:16px 0;grid-column:1/-1">Could not load news. Please refresh the page.</p>';
        }
    }

    if (newsGrid) {
        loadNews(currentNewsType);
        if (newsTabs) {
            newsTabs.querySelectorAll('.news-tab').forEach(tab => {
                tab.addEventListener('click', () => {
                    newsTabs.querySelectorAll('.news-tab').forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentNewsType = tab.dataset.type;
                    loadNews(currentNewsType);
                });
            });
        }
    }

})();
