@php
    $site = config('nexora.site');
    $appVersion = config('nexora.version', '1.0.0');
    $categories = config('nexora.categories', []);
    $tools = config('nexora.tools', []);

    $toolsByCat = [];
    foreach ($categories as $slug => $cat) {
        $toolsByCat[$slug] = array_values(array_filter($tools, fn ($t) => ($t['cat'] ?? null) === $slug));
    }

    $pageTitle = $pageTitle ?? ($site['name'] ?? 'Nexora Tools');
    $pageDesc = $pageDesc ?? ($site['desc'] ?? '');
    $pageKeywords = $pageKeywords ?? config('seo.keywords', 'online tools, free tools, pdf tools, seo tools, developer tools');
    $canonical = $canonical ?? url()->current();
    $baseUrl = rtrim(url('/'), '/') . '/';
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <x-seo :title="$pageTitle" :description="$pageDesc" :keywords="$pageKeywords" :canonical="$canonical" :image="$baseUrl . 'assets/images/og-image.svg'" />
    @include('partials.schema')

    <link rel="icon" type="image/svg+xml" href="{{ $baseUrl }}assets/images/favicon.svg">
    <link rel="preload" href="{{ $baseUrl }}assets/css/style.css?v={{ $appVersion }}" as="style">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('head_styles')
    <link rel="stylesheet" href="{{ $baseUrl }}assets/css/style.css?v={{ $appVersion }}">
    @stack('styles')

    <script>
        (function(){
            var t = localStorage.getItem('nexora-theme');
            if(!t && window.matchMedia('(prefers-color-scheme:dark)').matches) t='dark';
            if(t) document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
</head>
<body>
@include('partials.progress-bar')

<nav class="navbar" id="navbar">
    <div class="nav-inner">
        <a href="{{ $baseUrl }}" class="nav-logo">
            <span class="nav-logo-icon">N</span>
            <span class="nav-logo-text">
                <span class="logo-nexora">Nexora</span>
                <span class="logo-badge">Tools</span>
            </span>
        </a>

        <ul class="nav-links" id="navLinks">
            <li class="nav-dropdown has-mega">
                <a href="{{ route('tools.index') }}" class="nav-link {{ request()->routeIs('tools.index') ? 'active' : '' }}">
                    🛠 All Tools
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="mega-menu" id="megaMenu">
                    <div class="mega-grid">
                        @foreach ($categories as $catSlug => $cat)
                            @php
                                $megaTools = array_slice($toolsByCat[$catSlug] ?? [], 0, 5);
                                $megaTotal = count($toolsByCat[$catSlug] ?? []);
                                $isDev = $catSlug === 'dev';
                            @endphp
                            <div class="mega-col{{ $isDev ? ' mega-col--dev' : '' }}">
                                <div class="mega-col-head">
                                    <span class="mega-cat-icon" style="background:{{ $cat['bg'] }};color:{{ $cat['color'] }}">{{ $cat['icon'] }}</span>
                                    <div>
                                        <a href="{{ route('categories.show', ['category' => $catSlug]) }}" class="mega-cat-name">{{ $cat['name'] }}</a>
                                        <span class="mega-cat-count" style="color:{{ $cat['color'] }}">{{ $megaTotal }} tools</span>
                                    </div>
                                </div>
                                <ul class="mega-tool-list">
                                    @foreach ($megaTools as $t)
                                        <li>
                                            <a href="{{ route('tools.show', ['slug' => $t['slug']]) }}" class="mega-tool-item">
                                                <span class="mega-tool-emoji">{{ $t['icon'] }}</span>
                                                <span>{{ $t['name'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('categories.show', ['category' => $catSlug]) }}" class="mega-view-all" style="color:{{ $cat['color'] }}">View All {{ $cat['name'] }} →</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </li>

            @php $navHide = ['text','seo']; @endphp
            @foreach ($categories as $catSlug => $cat)
                @if (in_array($catSlug, $navHide, true)) @continue @endif
                <li class="nav-dropdown">
                    <a href="{{ route('categories.show', ['category' => $catSlug]) }}" class="nav-link {{ (request()->routeIs('categories.show') && request()->route('category') === $catSlug) ? 'active' : '' }}">
                        {{ $cat['icon'] }} {{ $cat['name'] }}
                        <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                    </a>
                    <div class="dropdown-menu">
                        @foreach (($toolsByCat[$catSlug] ?? []) as $t)
                            <a href="{{ route('tools.show', ['slug' => $t['slug']]) }}" class="dropdown-item">
                                <span class="dd-icon" style="background:{{ $categories[$t['cat']]['bg'] ?? '#F3F4F6' }};color:{{ $categories[$t['cat']]['color'] ?? '#6B7280' }}">{{ $t['icon'] }}</span>
                                <span>{{ $t['name'] }}</span>
                            </a>
                        @endforeach
                        <div class="dd-footer">
                            <a href="{{ route('categories.show', ['category' => $catSlug]) }}" class="dd-view-all" style="color:{{ $cat['color'] }}">View All {{ $cat['name'] }} →</a>
                        </div>
                    </div>
                </li>
            @endforeach

            <li class="nav-dropdown">
                <a href="{{ $baseUrl }}#news-section" class="nav-link">
                    📰 News
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="dropdown-menu" style="min-width:200px">
                    <a href="{{ $baseUrl }}#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=tech]')?.click()">
                        <span class="dd-icon" style="background:#DBEAFE;color:#3B82F6">💻</span>
                        <span>Tech News</span>
                    </a>
                    <a href="{{ $baseUrl }}#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=finance]')?.click()">
                        <span class="dd-icon" style="background:#D1FAE5;color:#10B981">📊</span>
                        <span>Finance News</span>
                    </a>
                    <a href="{{ $baseUrl }}#news-section" class="dropdown-item" onclick="document.querySelector('[data-type=stock]')?.click()">
                        <span class="dd-icon" style="background:#FEE2E2;color:#EF4444">📈</span>
                        <span>Market News</span>
                    </a>
                    <div class="dd-footer">
                        <a href="{{ $baseUrl }}#market-section" class="dd-view-all" style="color:#3B82F6">📈 Stock Market Overview →</a>
                    </div>
                </div>
            </li>
        </ul>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm nav-btn-login">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Profile</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm nav-btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Sign Up</a>
            @endauth
            <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
        </div>
    </div>
</nav>

<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-inner">
        <div class="search-overlay-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" class="search-overlay-input" id="searchInput" placeholder="Search 42+ tools…" autocomplete="off">
            <kbd class="search-kbd">ESC</kbd>
            <button class="search-close" id="searchClose" aria-label="Close">✕</button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>
<div class="search-backdrop" id="searchBackdrop"></div>

<div class="side-plugin" id="sidePlugin">
    <button class="side-btn" id="searchToggle" title="Search tools (Ctrl+K)" aria-label="Search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <span class="side-btn-label">Search</span>
    </button>
    <div class="side-divider"></div>
    <button class="side-btn theme-toggle" id="themeToggle" title="Toggle dark / light mode" aria-label="Toggle theme">
        <svg class="icon-sun"  width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg class="icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        <span class="side-btn-label">Theme</span>
    </button>
</div>

<main class="main-content">
    @yield('content')
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ $baseUrl }}" class="footer-logo">
                    <span class="nav-logo-icon">N</span>
                    <span class="logo-nexora">Nexora</span>
                    <span class="logo-badge">Tools</span>
                </a>
                <p class="footer-tagline">{{ $site['tagline'] ?? '' }}. Free online tools for developers, designers, and everyone.</p>
                <div class="footer-social">
                    <a href="#" class="social-link" title="Twitter" aria-label="Twitter">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="#" class="social-link" title="LinkedIn" aria-label="LinkedIn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                    <a href="https://github.com/anjaneyatripathi1995/nexora-tools" class="social-link" title="GitHub" aria-label="GitHub">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Popular Tools</h4>
                <ul class="footer-links">
                    <li><a href="{{ $baseUrl }}json-formatter">JSON Formatter</a></li>
                    <li><a href="{{ $baseUrl }}password-generator">Password Generator</a></li>
                    <li><a href="{{ route('tools.show', ['slug' => 'pdf-to-word']) }}">PDF to Word</a></li>
                    <li><a href="{{ route('tools.show', ['slug' => 'image-resizer']) }}">Image Resizer</a></li>
                    <li><a href="{{ route('tools.show', ['slug' => 'emi-calculator']) }}">EMI Calculator</a></li>
                    <li><a href="{{ route('tools.show', ['slug' => 'word-counter']) }}">Word Counter</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Categories</h4>
                <ul class="footer-links">
                    @foreach ($categories as $catSlug => $cat)
                        <li><a href="{{ route('categories.show', ['category' => $catSlug]) }}">{{ $cat['icon'] }} {{ $cat['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-heading">Company</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}">Terms of Service</a></li>
                    <li><a href="mailto:{{ $site['email'] ?? '' }}">Support</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $site['company'] ?? '' }}. All rights reserved.</p>
            <p>Made with ❤️ in India &nbsp;·&nbsp; <a href="{{ route('privacy') }}">Privacy</a> &nbsp;·&nbsp; <a href="{{ route('terms') }}">Terms</a></p>
        </div>
    </div>
</footer>

<script>
    window.NEXORA_TOOLS = @json($tools, JSON_UNESCAPED_UNICODE);
    window.BASE_URL = '{{ $baseUrl }}';
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('img:not([loading])').forEach(function (img) {
            img.setAttribute('loading', 'lazy');
            if (!img.getAttribute('alt')) img.setAttribute('alt', 'Nexora asset');
        });
    });
</script>
<script src="{{ $baseUrl }}assets/js/app.js?v={{ $appVersion }}"></script>
@stack('scripts')
</body>
</html>
