{{-- ─── NAVBAR ─────────────────────────────────────────────────────────────── --}}
{{-- Identical design to includes/header.php on flat PHP pages --}}
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

            {{-- ALL TOOLS — mega dropdown showing every category --}}
            <li class="nav-dropdown has-mega">
                <a href="{{ route('tools.index') }}" class="nav-link">
                    🛠 All Tools
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="mega-menu" id="megaMenu">
                    <div class="mega-grid">
                        @php $catalog = \App\Http\Controllers\ToolController::fullCatalog(); @endphp
                        @foreach($catalog as $categoryName => $tools)
                        @php
                            $catColors = [
                                'Developer Tools' => ['bg'=>'#DBEAFE','color'=>'#2563EB','icon'=>'💻'],
                                'PDF & File Tools'=> ['bg'=>'#FEE2E2','color'=>'#EF4444','icon'=>'📄'],
                                'Image Tools'     => ['bg'=>'#D1FAE5','color'=>'#10B981','icon'=>'🖼'],
                                'Finance & Date'  => ['bg'=>'#FEF3C7','color'=>'#D97706','icon'=>'📊'],
                                'Text & Content'  => ['bg'=>'#EDE9FE','color'=>'#7C3AED','icon'=>'✍️'],
                                'SEO Tools'       => ['bg'=>'#FCE7F3','color'=>'#DB2777','icon'=>'🔍'],
                                'AI Tools'        => ['bg'=>'#F0FDF4','color'=>'#059669','icon'=>'🤖'],
                            ];
                            $meta = $catColors[$categoryName] ?? ['bg'=>'#F1F5F9','color'=>'#475569','icon'=>'🔧'];
                            $slug = strtolower(str_replace([' ','&'],['','-'],$categoryName));
                            $slug = str_replace(['--'],'-',$slug);
                        @endphp
                        <div class="mega-col">
                            <div class="mega-col-head">
                                <span class="mega-cat-icon" style="background:{{ $meta['bg'] }};color:{{ $meta['color'] }}">{{ $meta['icon'] }}</span>
                                <div>
                                    <a href="{{ url('/'.$slug) }}" class="mega-cat-name">{{ $categoryName }}</a>
                                    <span class="mega-cat-count" style="color:{{ $meta['color'] }}">{{ count($tools) }} tools</span>
                                </div>
                            </div>
                            <ul class="mega-tool-list">
                                @foreach(array_slice($tools, 0, 5) as $tool)
                                <li>
                                    <a href="{{ route('tools.show', $tool['slug']) }}" class="mega-tool-item">
                                        <span class="mega-tool-emoji"><i class="fa-solid {{ $tool['icon'] ?? 'fa-wrench' }}"></i></span>
                                        <span>{{ $tool['name'] }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <a href="{{ url('/'.$slug) }}" class="mega-view-all" style="color:{{ $meta['color'] }}">View All {{ $categoryName }} →</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </li>

            {{-- Category nav items (matching flat PHP home page) --}}
            @php
            $navCats = [
                ['slug'=>'developer-tools', 'name'=>'Developer',  'icon'=>'💻'],
                ['slug'=>'pdf-file-tools',  'name'=>'PDF & Files','icon'=>'📄'],
                ['slug'=>'image-tools',     'name'=>'Image',      'icon'=>'🖼'],
                ['slug'=>'finance-date',    'name'=>'Finance',    'icon'=>'📊'],
                ['slug'=>'ai-tools',        'name'=>'AI Tools',   'icon'=>'🤖'],
            ];
            @endphp
            @foreach($navCats as $nc)
            <li class="nav-dropdown">
                <a href="{{ url('/'.$nc['slug']) }}" class="nav-link {{ request()->is($nc['slug'].'*') ? 'active' : '' }}">
                    {{ $nc['icon'] }} {{ $nc['name'] }}
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                @php
                $catTools = collect(\App\Http\Controllers\ToolController::fullCatalog())
                    ->first(fn($v,$k) => strtolower(str_replace([' ','&','--'],['-','-','-'],$k)) === $nc['slug'] ||
                                         str_contains(strtolower($k), strtolower(explode('-',$nc['slug'])[0])));
                @endphp
                @if($catTools)
                <div class="dropdown-menu">
                    @foreach($catTools as $tool)
                    <a href="{{ route('tools.show', $tool['slug']) }}" class="dropdown-item">
                        <span class="dd-icon"><i class="fa-solid {{ $tool['icon'] ?? 'fa-wrench' }}"></i></span>
                        <span>{{ $tool['name'] }}</span>
                    </a>
                    @endforeach
                    <div class="dd-footer">
                        <a href="{{ url('/'.$nc['slug']) }}" class="dd-view-all">View All {{ $nc['name'] }} →</a>
                    </div>
                </div>
                @endif
            </li>
            @endforeach

            {{-- News --}}
            <li class="nav-dropdown">
                <a href="#" class="nav-link">
                    📰 News
                    <svg class="chevron" width="12" height="12" viewBox="0 0 12 12"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round"/></svg>
                </a>
                <div class="dropdown-menu" style="min-width:200px">
                    <a href="{{ route('news.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#DBEAFE;color:#3B82F6">💻</span>
                        <span>Tech News</span>
                    </a>
                    <a href="{{ route('news.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#D1FAE5;color:#10B981">📊</span>
                        <span>Finance News</span>
                    </a>
                    <a href="{{ route('market.index') }}" class="dropdown-item">
                        <span class="dd-icon" style="background:#FEE2E2;color:#EF4444">📈</span>
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
                <div style="position:relative;display:inline-block" class="nav-dropdown">
                    <button class="btn btn-ghost btn-sm" style="display:flex;align-items:center;gap:6px;background:none;border:1.5px solid var(--border);cursor:pointer">
                        <span style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#2563EB,#7C3AED);color:#fff;font-size:.7rem;font-weight:800;display:inline-flex;align-items:center;justify-content:center">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
                        {{ auth()->user()->name }}
                    </button>
                    <div class="dropdown-menu" style="left:auto;right:0;transform:none;min-width:180px">
                        <a href="/profile" class="dropdown-item">
                            <span class="dd-icon" style="background:#DBEAFE;color:#2563EB">👤</span>
                            <span>Profile</span>
                        </a>
                        <div class="dd-footer">
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" style="all:unset;cursor:pointer" class="dd-view-all" style="color:#EF4444">Logout →</button>
                            </form>
                        </div>
                    </div>
                </div>
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
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            <input type="text" class="search-overlay-input" id="searchInput" placeholder="Search 42+ tools…" autocomplete="off">
            <kbd class="search-kbd">ESC</kbd>
            <button class="search-close" id="searchClose" aria-label="Close">✕</button>
        </div>
        <div class="search-results" id="searchResults"></div>
    </div>
</div>
<div class="search-backdrop" id="searchBackdrop"></div>

{{-- ─── STICKY SIDE PLUGIN ──────────────────────────────────────────────────── --}}
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

@push('scripts')
<script>
(function(){
    'use strict';
    // ── Navbar scroll shadow ──────────────────────────────────────────────────
    var navbar = document.getElementById('navbar');
    if(navbar){
        var onScroll = function(){ navbar.classList.toggle('scrolled', window.scrollY > 10); };
        window.addEventListener('scroll', onScroll, {passive:true});
        onScroll();
    }

    // ── Mobile hamburger ──────────────────────────────────────────────────────
    var hamburger = document.getElementById('hamburger');
    var navLinks  = document.getElementById('navLinks');
    if(hamburger && navLinks){
        hamburger.addEventListener('click', function(){
            var open = navLinks.classList.toggle('open');
            hamburger.classList.toggle('open', open);
        });
        document.addEventListener('click', function(e){
            if(navbar && !navbar.contains(e.target)){
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

    var ALL_TOOLS = [];
    @php
    try {
        $allTools = collect(\App\Http\Controllers\ToolController::fullCatalog())
            ->flatten(1)->map(fn($t) => ['slug'=>$t['slug'],'name'=>$t['name'],'description'=>$t['description']??''])->values()->toArray();
        echo 'ALL_TOOLS = ' . json_encode($allTools) . ';';
    } catch(\Throwable $e) { echo 'ALL_TOOLS = [];'; }
    @endphp

    function openSearch(){ if(!searchOverlay)return; searchOverlay.classList.add('open'); if(searchBackdrop)searchBackdrop.classList.add('open'); setTimeout(function(){ if(searchInput)searchInput.focus(); },80); }
    function closeSearch(){ if(!searchOverlay)return; searchOverlay.classList.remove('open'); if(searchBackdrop)searchBackdrop.classList.remove('open'); if(searchInput)searchInput.value=''; if(searchResults)searchResults.innerHTML=''; }

    if(searchToggle)  searchToggle.addEventListener('click', openSearch);
    if(searchClose)   searchClose.addEventListener('click', closeSearch);
    if(searchBackdrop)searchBackdrop.addEventListener('click', closeSearch);
    document.addEventListener('keydown', function(e){
        if((e.ctrlKey||e.metaKey) && e.key==='k'){ e.preventDefault(); openSearch(); }
        if(e.key==='Escape'){ closeSearch(); }
    });

    function renderResults(q){
        if(!searchResults) return;
        q = q.toLowerCase().trim();
        if(!q){ searchResults.innerHTML=''; return; }
        var hits = ALL_TOOLS.filter(function(t){ return t.name.toLowerCase().includes(q) || (t.description||'').toLowerCase().includes(q); }).slice(0,8);
        if(!hits.length){ searchResults.innerHTML='<div style="padding:16px 20px;color:var(--text-3);font-size:.875rem">No tools found for "'+q+'"</div>'; return; }
        searchResults.innerHTML = hits.map(function(t){
            return '<a href="/tools/'+t.slug+'" style="display:flex;align-items:center;gap:12px;padding:10px 16px;text-decoration:none;color:var(--text);transition:background .12s;border-bottom:1px solid var(--border)" onmouseover="this.style.background=\'var(--bg-elevated)\'" onmouseout="this.style.background=\'\'"><span style="font-size:1.1rem">🔧</span><div><div style="font-weight:600;font-size:.875rem">'+t.name+'</div><div style="font-size:.78rem;color:var(--text-3)">'+( t.description||'').slice(0,60)+'</div></div></a>';
        }).join('');
    }

    if(searchInput) searchInput.addEventListener('input', function(){ renderResults(this.value); });

    // ── Theme toggle (side plugin) ─────────────────────────────────────────
    var themeToggle = document.getElementById('themeToggle');
    if(themeToggle){
        themeToggle.addEventListener('click', function(){
            var current = document.documentElement.getAttribute('data-theme');
            var next    = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('nexora-theme', next);
        });
    }
})();
</script>
@endpush
