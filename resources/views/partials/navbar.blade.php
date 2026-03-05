<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm" id="mainNavbar">
  <div class="container-fluid px-3 px-lg-5">

    {{-- Brand --}}
    <a class="navbar-brand d-flex align-items-center gap-2" href="/">
      <span class="navbar-brand-icon"><i class="fa-solid fa-layer-group"></i></span>
      <span class="navbar-brand-text">
        <span class="navbar-brand-name">Nexora</span>
        <span class="navbar-brand-tag">Tools</span>
      </span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto align-items-lg-center">

        {{-- Tools — triggers full-screen overlay --}}
        <li class="nav-item">
          <button class="nav-link fw-semibold d-flex align-items-center gap-1 border-0 bg-transparent" id="toolsMenuBtn">
            Tools <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.65rem;opacity:0.7"></i>
          </button>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('projects.index') }}">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('templates.index') }}">Templates</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('news.index') }}">News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('market.index') }}">Market</a>
        </li>
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('about') }}">About</a>
        </li>

      </ul>

      <ul class="navbar-nav align-items-lg-center gap-2">
        @auth
          @if(auth()->user()->isAdmin())
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="{{ route('admin.dashboard') }}">Admin</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="/dashboard">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center gap-2 fw-semibold" href="#" data-bs-toggle="dropdown">
              <span class="navbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="/profile"><i class="fa-solid fa-user me-2"></i>Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="/logout">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-sign-out-alt me-2"></i>Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="/login" style="white-space:nowrap">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary fw-semibold" href="/register" style="white-space:nowrap;padding:0.42rem 1rem;font-size:0.84rem">Sign Up</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

{{-- ============================================================
     FULL-SCREEN TOOLS OVERLAY MENU
     ============================================================ --}}
@php
  $catalog = \App\Http\Controllers\ToolController::fullCatalog();
@endphp
<div id="toolsOverlay" class="tools-overlay" aria-hidden="true">
  <div class="tools-overlay__inner">

    {{-- Header bar --}}
    <div class="tools-overlay__header">
      <div class="d-flex align-items-center gap-3">
        <i class="fa-solid fa-layer-group text-primary fs-4"></i>
        <div>
          <div class="fw-800 fs-5">All Tools</div>
          <div class="text-muted small">{{ collect($catalog)->flatten(1)->count() }}+ free online tools</div>
        </div>
      </div>
      <div class="d-flex align-items-center gap-3">
        <div class="tools-overlay__search position-relative">
          <i class="fa-solid fa-magnifying-glass tools-overlay__search-icon"></i>
          <input type="text" id="overlaySearch" class="form-control form-control-sm" placeholder="Filter tools...">
        </div>
        <button class="tools-overlay__close" id="toolsOverlayClose" aria-label="Close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
    </div>

    {{-- Tool grid by category --}}
    <div class="tools-overlay__body">
      @foreach($catalog as $category => $tools)
      <div class="tools-overlay__cat-block" data-category="{{ strtolower($category) }}">
        <div class="tools-overlay__cat-label">
          <i class="fa-solid
            @if(str_contains(strtolower($category),'finance') || str_contains(strtolower($category),'date')) fa-coins
            @elseif(str_contains(strtolower($category),'pdf') || str_contains(strtolower($category),'file')) fa-file-pdf
            @elseif(str_contains(strtolower($category),'text') || str_contains(strtolower($category),'content')) fa-pen-fancy
            @elseif(str_contains(strtolower($category),'developer') || str_contains(strtolower($category),'dev')) fa-code
            @elseif(str_contains(strtolower($category),'image')) fa-image
            @elseif(str_contains(strtolower($category),'seo')) fa-chart-bar
            @elseif(str_contains(strtolower($category),'ai')) fa-robot
            @else fa-wrench @endif
          "></i>
          {{ $category }}
        </div>
        <div class="tools-overlay__grid">
          @foreach($tools as $tool)
          <a href="{{ route('tools.show', $tool['slug']) }}" class="tools-overlay__item" data-name="{{ strtolower($tool['name']) }}" data-desc="{{ strtolower($tool['description'] ?? '') }}">
            <span class="tools-overlay__item-icon text-{{ $tool['color'] ?? 'primary' }}">
              <i class="fa-solid {{ $tool['icon'] ?? 'fa-wrench' }}"></i>
            </span>
            <span class="tools-overlay__item-name">{{ $tool['name'] }}</span>
          </a>
          @endforeach
        </div>
      </div>
      @endforeach
    </div>

    {{-- Footer --}}
    <div class="tools-overlay__footer">
      <a href="{{ route('tools.index') }}" class="btn btn-primary btn-sm">
        <i class="fa-solid fa-grid-2 me-2"></i>Browse All Tools
      </a>
      <span class="text-muted small ms-3">Press <kbd>Esc</kbd> to close</span>
    </div>

  </div>
</div>
<div class="tools-overlay__backdrop" id="toolsOverlayBackdrop"></div>

@push('scripts')
<script>
// ── Navbar: transparent on hero, solid on scroll ─────────
(function(){
    var nav = document.getElementById('mainNavbar');
    if (!nav) return;
    var isHero = document.body.classList.contains('page-main-hero') || !!document.querySelector('.hero-banner-full');
    if (!isHero) return;
    function sync(){ if(window.scrollY>60){nav.classList.remove('navbar-transparent');nav.classList.add('navbar-scrolled');}else{nav.classList.add('navbar-transparent');nav.classList.remove('navbar-scrolled');} }
    sync(); window.addEventListener('scroll', sync, {passive:true});
})();

// ── Tools full-screen overlay ────────────────────────────
(function(){
    var btn      = document.getElementById('toolsMenuBtn');
    var overlay  = document.getElementById('toolsOverlay');
    var backdrop = document.getElementById('toolsOverlayBackdrop');
    var closeBtn = document.getElementById('toolsOverlayClose');
    var searchEl = document.getElementById('overlaySearch');
    if (!btn || !overlay) return;

    function openOverlay(){
        overlay.classList.add('open');
        backdrop.classList.add('open');
        overlay.setAttribute('aria-hidden','false');
        document.body.style.overflow = 'hidden';
        if(searchEl){ searchEl.value=''; searchEl.focus(); filterTools(''); }
    }
    function closeOverlay(){
        overlay.classList.remove('open');
        backdrop.classList.remove('open');
        overlay.setAttribute('aria-hidden','true');
        document.body.style.overflow = '';
    }
    btn.addEventListener('click', openOverlay);
    closeBtn.addEventListener('click', closeOverlay);
    backdrop.addEventListener('click', closeOverlay);
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeOverlay(); });

    // Filter tools as user types
    function filterTools(q){
        var items = overlay.querySelectorAll('.tools-overlay__item');
        var blocks = overlay.querySelectorAll('.tools-overlay__cat-block');
        q = q.toLowerCase();
        items.forEach(function(item){
            var match = !q || item.dataset.name.includes(q) || item.dataset.desc.includes(q);
            item.style.display = match ? '' : 'none';
        });
        blocks.forEach(function(block){
            var visible = [...block.querySelectorAll('.tools-overlay__item')].some(i => i.style.display !== 'none');
            block.style.display = visible ? '' : 'none';
        });
    }
    if(searchEl) searchEl.addEventListener('input', function(){ filterTools(this.value.trim()); });
})();
</script>
@endpush
