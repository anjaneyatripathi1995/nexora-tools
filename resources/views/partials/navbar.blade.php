{{-- ─── NAVBAR ─────────────────────────────────────────────────────────────── --}}
{{-- Identical design to includes/header.php on flat PHP pages.               --}}
{{-- NOTE: No emoji used here — only FA icons — to avoid UTF-8 encoding       --}}
{{-- issues when the file is saved/deployed on Windows/Hostinger.             --}}
<nav class="navbar" id="navbar">
    <div class="nav-inner">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="nav-logo">
            <span class="nav-logo-icon">N</span>
            <span class="nav-logo-text">
                <span class="logo-nexora">Nexora</span>
                <span class="logo-badge">Tools</span>
            </span>
        </a>

        {{-- Desktop Nav --}}
        <ul class="nav-links" id="navLinks">

            {{-- ALL TOOLS mega dropdown --}}
            @php
            // Category meta: keys must EXACTLY match ToolController::fullCatalog() keys
            // Colors/slugs mirror the flat PHP CATEGORIES constant in includes/config.php
            $megaMeta = [
                'Developer'     => ['bg'=>'#DBEAFE','color'=>'#3B82F6','icon'=>'fa-code',            'slug'=>'dev'],
                'PDF & File'    => ['bg'=>'#FEE2E2','color'=>'#EF4444','icon'=>'fa-file-pdf',        'slug'=>'pdf'],
                'Text & Content'=> ['bg'=>'#FEF3C7','color'=>'#F59E0B','icon'=>'fa-pen-fancy',       'slug'=>'text'],
                'Image Tools'   => ['bg'=>'#EDE9FE','color'=>'#8B5CF6','icon'=>'fa-image',           'slug'=>'image'],
                'SEO Tools'     => ['bg'=>'#FCE7F3','color'=>'#EC4899','icon'=>'fa-magnifying-glass', 'slug'=>'seo'],
                'Finance & Date'=> ['bg'=>'#D1FAE5','color'=>'#10B981','icon'=>'fa-calculator',      'slug'=>'finance'],
                'AI Tools'      => ['bg'=>'#CFFAFE','color'=>'#06B6D4','icon'=>'fa-robot',           'slug'=>'ai'],
            ];
            $catalog = \App\Http\Controllers\ToolController::fullCatalog();
            @endphp
            <li class="nav-dropdown has-mega">
                <a href="{{ route('tools.index') }}" class="nav-link">
                    <i class="fa-solid fa-wrench" style="font-size:.85em;opacity:.8"></i>
                    All Tools
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="mega-menu" id="megaMenu">
                    <div class="mega-grid">
                        @foreach($catalog as $catName => $catTools)
                        @php $m = $megaMeta[$catName] ?? ['bg'=>'#F1F5F9','color'=>'#475569','icon'=>'fa-wrench','slug'=>strtolower($catName)]; @endphp
                        <div class="mega-col">
                            <div class="mega-col-head">
                                <span class="mega-cat-icon" style="background:{{ $m['bg'] }};color:{{ $m['color'] }}">
                                    <i class="fa-solid {{ $m['icon'] }}"></i>
                                </span>
                                <div>
                                    <a href="{{ url('/'.$m['slug']) }}" class="mega-cat-name">{{ $catName }}</a>
                                    <span class="mega-cat-count" style="color:{{ $m['color'] }}">{{ count($catTools) }} tools</span>
                                </div>
                            </div>
                            <ul class="mega-tool-list">
                                @foreach(array_slice($catTools, 0, 5) as $tool)
                                <li>
                                    <a href="{{ route('tools.show', $tool['slug']) }}" class="mega-tool-item">
                                        <span class="mega-tool-emoji"><i class="fa-solid {{ $tool['icon'] ?? 'fa-wrench' }}"></i></span>
                                        <span>{{ $tool['name'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{ url('/'.$m['slug']) }}" class="mega-view-all" style="color:{{ $m['color'] }}">View All {{ $catName }} &rarr;</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </li>

            {{-- Category nav items — slugs match flat PHP CATEGORIES keys            --}}
            {{-- Labels match the home page exactly (text/seo hidden, like flat PHP) --}}
            @php
            $navCats = [
                ['slug'=>'dev',     'catKey'=>'Developer',      'name'=>'Developer',      'icon'=>'fa-code'],
                ['slug'=>'pdf',     'catKey'=>'PDF & File',     'name'=>'PDF & File',     'icon'=>'fa-file-pdf'],
                ['slug'=>'image',   'catKey'=>'Image Tools',    'name'=>'Image Tools',    'icon'=>'fa-image'],
                ['slug'=>'finance', 'catKey'=>'Finance & Date', 'name'=>'Finance & Date', 'icon'=>'fa-calculator'],
                ['slug'=>'ai',      'catKey'=>'AI Tools',       'name'=>'AI Tools',       'icon'=>'fa-robot'],
            ];
            @endphp
            @foreach($navCats as $nc)
            @php $catColor = $megaMeta[$nc['catKey']] ?? ['color'=>'#475569']; @endphp
            <li class="nav-dropdown">
                <a href="{{ url('/'.$nc['slug']) }}" class="nav-link {{ request()->is($nc['slug'].'*') ? 'active' : '' }}">
                    <i class="fa-solid {{ $nc['icon'] }}" style="font-size:.8em;opacity:.8"></i>
                    {{ $nc['name'] }}
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                @if(isset($catalog[$nc['catKey']]))
                <div class="dropdown-menu">
                    @foreach($catalog[$nc['catKey']] as $tool)
                    <a href="{{ route('tools.show', $tool['slug']) }}" class="dropdown-item">
                        <span class="dd-icon" style="background:{{ $catColor['bg'] ?? '#F1F5F9' }};color:{{ $catColor['color'] }}">
                            <i class="fa-solid {{ $tool['icon'] ?? 'fa-wrench' }}"></i>
                        </span>
                        <span>{{ $tool['name'] }}</span>
                    </a>
                    @endforeach
                    <div class="dd-footer">
                        <a href="{{ url('/'.$nc['slug']) }}" class="dd-view-all" style="color:{{ $catColor['color'] }}">View All {{ $nc['name'] }} &rarr;</a>
                    </div>
                </div>
                @endif
            </li>
            @endforeach

            {{-- News --}}
            <li class="nav-dropdown">
                <a href="#" class="nav-link">
                    <i class="fa-solid fa-newspaper" style="font-size:.8em;opacity:.8"></i>
                    News
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="dropdown-menu" style="min-width:200px">
                    <a href="{{ route('news.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#DBEAFE;color:#3B82F6"><i class="fa-solid fa-microchip"></i></span>
                        <span>Tech News</span>
                    </a>
                    <a href="{{ route('news.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#D1FAE5;color:#10B981"><i class="fa-solid fa-chart-bar"></i></span>
                        <span>Finance News</span>
                    </a>
                    <a href="{{ route('market.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#FEE2E2;color:#EF4444"><i class="fa-solid fa-chart-line"></i></span>
                        <span>Market News</span>
                    </a>
                </div>
            </li>

        </ul>

        {{-- Nav Right Actions --}}
        <div class="nav-actions">
            @auth
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">Admin</a>
                @endif
                <a href="/dashboard" class="btn btn-ghost btn-sm">Dashboard</a>
                <li class="nav-dropdown" style="list-style:none">
                    <button class="btn btn-ghost btn-sm" style="display:flex;align-items:center;gap:6px;cursor:pointer">
                        <span style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#2563EB,#7C3AED);color:#fff;font-size:.7rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                        {{ Str::limit(auth()->user()->name, 12) }}
                        <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                    </button>
                    <div class="dropdown-menu" style="left:auto;right:0;transform:none;min-width:180px">
                        <a href="/profile" class="dropdown-item">
                            <span class="dd-icon" style="background:#DBEAFE;color:#2563EB"><i class="fa-solid fa-user"></i></span>
                            <span>Profile</span>
                        </a>
                        <div class="dd-footer">
                            <form method="POST" action="/logout" style="margin:0">
                                @csrf
                                <button type="submit" class="dd-view-all" style="background:none;border:none;cursor:pointer;padding:4px 6px;color:#EF4444;font-size:.75rem;font-weight:600">Logout &rarr;</button>
                            </form>
                        </div>
                    </div>
                </li>
            @else
                <a href="{{ url('/login') }}" class="btn btn-ghost btn-sm nav-btn-login">Login</a>
                <a href="{{ url('/register') }}" class="btn btn-primary btn-sm">Sign Up</a>
            @endauth
            <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
        </div>

    </div>
</nav>

{{-- ─── SEARCH OVERLAY ─────────────────────────────────────────────────────── --}}
<div class="search-overlay" id="searchOverlay">
    <div class="search-overlay-inner">
        <div class="search-overlay-box">
            <i class="fa-solid fa-magnifying-glass" style="color:var(--text-3)"></i>
            <input type="text" class="search-overlay-input" id="searchInput" placeholder="Search 42+ tools..." autocomplete="off">
            <kbd class="search-kbd">ESC</kbd>
            <button class="search-close" id="searchClose" aria-label="Close">&times;</button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>
<div class="search-backdrop" id="searchBackdrop"></div>

{{-- ─── STICKY SIDE PLUGIN ──────────────────────────────────────────────────── --}}
<div class="side-plugin" id="sidePlugin">
    <button class="side-btn" id="searchToggle" title="Search tools (Ctrl+K)" aria-label="Search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span class="side-btn-label">Search</span>
    </button>
    <div class="side-divider"></div>
    <button class="side-btn theme-toggle" id="themeToggle" title="Toggle dark / light mode" aria-label="Toggle theme">
        <i class="fa-solid fa-sun  icon-sun" ></i>
        <i class="fa-solid fa-moon icon-moon"></i>
        <span class="side-btn-label">Theme</span>
    </button>
</div>

@push('scripts')
<script>
(function(){
    'use strict';

    // ── Navbar scroll shadow ──────────────────────────────────────────────────
    var navbar = document.getElementById('navbar');
    if (navbar) {
        var onScroll = function(){ navbar.classList.toggle('scrolled', window.scrollY > 10); };
        window.addEventListener('scroll', onScroll, {passive:true});
        onScroll();
    }

    // ── Mobile hamburger ──────────────────────────────────────────────────────
    var hamburger = document.getElementById('hamburger');
    var navLinks  = document.getElementById('navLinks');
    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function(){
            var open = navLinks.classList.toggle('open');
            hamburger.classList.toggle('open', open);
        });
        document.addEventListener('click', function(e){
            if (navbar && !navbar.contains(e.target)){
                navLinks.classList.remove('open');
                hamburger.classList.remove('open');
            }
        });
    }

    // ── Search overlay ────────────────────────────────────────────────────────
    var searchToggle   = document.getElementById('searchToggle');
    var searchOverlay  = document.getElementById('searchOverlay');
    var searchBackdrop = document.getElementById('searchBackdrop');
    var searchInput    = document.getElementById('searchInput');
    var searchResults  = document.getElementById('searchResults');
    var searchClose    = document.getElementById('searchClose');

    // Tool list for search (built server-side, no DB query)
    var ALL_TOOLS = @php
        try {
            $st = [];
            foreach (\App\Http\Controllers\ToolController::fullCatalog() as $cat => $tools) {
                foreach ($tools as $t) {
                    $st[] = ['slug'=>$t['slug'],'name'=>$t['name'],'desc'=>$t['description']??'','icon'=>$t['icon']??'fa-wrench'];
                }
            }
            echo json_encode($st);
        } catch(\Throwable $e) { echo '[]'; }
    @endphp;

    function openSearch(){
        if (!searchOverlay) return;
        searchOverlay.classList.add('open');
        if (searchBackdrop) searchBackdrop.classList.add('open');
        setTimeout(function(){ if (searchInput) searchInput.focus(); }, 80);
    }
    function closeSearch(){
        if (!searchOverlay) return;
        searchOverlay.classList.remove('open');
        if (searchBackdrop) searchBackdrop.classList.remove('open');
        if (searchInput)  searchInput.value = '';
        if (searchResults) searchResults.innerHTML = '';
    }

    if (searchToggle)   searchToggle.addEventListener('click', openSearch);
    if (searchClose)    searchClose.addEventListener('click', closeSearch);
    if (searchBackdrop) searchBackdrop.addEventListener('click', closeSearch);
    document.addEventListener('keydown', function(e){
        if ((e.ctrlKey||e.metaKey) && e.key === 'k'){ e.preventDefault(); openSearch(); }
        if (e.key === 'Escape') closeSearch();
    });

    function renderResults(q){
        if (!searchResults) return;
        q = q.toLowerCase().trim();
        if (!q){ searchResults.innerHTML = ''; return; }
        var hits = ALL_TOOLS.filter(function(t){
            return t.name.toLowerCase().indexOf(q) !== -1 || (t.desc||'').toLowerCase().indexOf(q) !== -1;
        }).slice(0, 8);
        if (!hits.length){
            searchResults.innerHTML = '<div style="padding:16px 20px;color:var(--text-3);font-size:.875rem">No tools found for "' + q + '"</div>';
            return;
        }
        searchResults.innerHTML = hits.map(function(t){
            return '<a href="/tools/' + t.slug + '" style="display:flex;align-items:center;gap:12px;padding:10px 16px;'
                 + 'text-decoration:none;color:var(--text);transition:background .12s;border-bottom:1px solid var(--border)"'
                 + ' onmouseover="this.style.background=\'var(--bg-elevated)\'" onmouseout="this.style.background=\'\'">'
                 + '<i class="fa-solid ' + t.icon + '" style="font-size:1rem;width:20px;text-align:center;opacity:.7"></i>'
                 + '<div><div style="font-weight:600;font-size:.875rem">' + t.name + '</div>'
                 + '<div style="font-size:.78rem;color:var(--text-3)">' + (t.desc||'').substring(0,60) + '</div></div></a>';
        }).join('');
    }
    if (searchInput) searchInput.addEventListener('input', function(){ renderResults(this.value); });

    // ── Theme toggle (side plugin) ─────────────────────────────────────────
    var themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function(){
            var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('nexora-theme', next);
        });
    }

    // Keep sun/moon icon visibility in sync with data-theme
    (function syncThemeIcons(){
        var suns  = document.querySelectorAll('.icon-sun');
        var moons = document.querySelectorAll('.icon-moon');
        function apply(t){
            suns.forEach(function(el){ el.style.display  = t === 'dark' ? '' : 'none'; });
            moons.forEach(function(el){ el.style.display = t === 'dark' ? 'none' : ''; });
        }
        apply(document.documentElement.getAttribute('data-theme') || 'light');
        // Watch for programmatic changes via MutationObserver
        var obs = new MutationObserver(function(){
            apply(document.documentElement.getAttribute('data-theme') || 'light');
        });
        obs.observe(document.documentElement, { attributes: true, attributeFilter: ['data-theme'] });
    })();
})();
</script>
@endpush
