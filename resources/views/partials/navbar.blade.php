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

        {{-- Tools — full-screen overlay --}}
        <li class="nav-item">
          <button class="nav-link fw-semibold d-flex align-items-center gap-1 border-0 bg-transparent" id="toolsMenuBtn" style="white-space:nowrap">
            <i class="fa-solid fa-wrench me-1 text-primary" style="font-size:.8rem"></i>Tools
            <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem;opacity:0.6"></i>
          </button>
        </li>

        {{-- Projects --}}
        <li class="nav-item dropdown">
          <a class="nav-link fw-semibold d-flex align-items-center gap-1" href="{{ route('projects.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space:nowrap">
            Projects <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem;opacity:0.6"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-clean shadow border-0 rounded-3 py-2 px-1 mt-1">
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('projects.index') }}">
                <span class="nav-dd-icon bg-primary-subtle text-primary"><i class="fa-solid fa-briefcase"></i></span>
                <div><div class="fw-600 small">All Projects</div><div class="text-muted" style="font-size:.72rem">Web & mobile projects</div></div>
              </a>
            </li>
            <li><hr class="dropdown-divider my-1 mx-2"></li>
            @foreach([
              ['slug'=>'tax-invoicing','name'=>'Tax / Invoicing App','icon'=>'fa-receipt'],
              ['slug'=>'restaurant-booking','name'=>'Restaurant Booking','icon'=>'fa-utensils'],
              ['slug'=>'expense-tracker','name'=>'Expense Tracker','icon'=>'fa-wallet'],
              ['slug'=>'todo-list','name'=>'To-Do List App','icon'=>'fa-list-check'],
              ['slug'=>'online-teaching','name'=>'Online Teaching Platform','icon'=>'fa-chalkboard-teacher'],
              ['slug'=>'ceo-dashboard','name'=>'CEO Dashboard','icon'=>'fa-chart-line'],
              ['slug'=>'employee-orientation','name'=>'Employee Orientation','icon'=>'fa-users'],
            ] as $p)
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('projects.show', $p['slug']) }}">
                <span class="nav-dd-icon-sm"><i class="fa-solid {{ $p['icon'] }} text-primary"></i></span>
                <span class="small fw-500">{{ $p['name'] }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>

        {{-- Apps --}}
        <li class="nav-item dropdown">
          <a class="nav-link fw-semibold d-flex align-items-center gap-1" href="{{ route('apps.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space:nowrap">
            Apps <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem;opacity:0.6"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-clean shadow border-0 rounded-3 py-2 px-1 mt-1" style="min-width:220px">
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('apps.index') }}">
                <span class="nav-dd-icon bg-success-subtle text-success"><i class="fa-solid fa-mobile-screen"></i></span>
                <div><div class="fw-600 small">All Apps</div><div class="text-muted" style="font-size:.72rem">21+ app solutions</div></div>
              </a>
            </li>
          </ul>
        </li>

        {{-- Templates --}}
        <li class="nav-item dropdown">
          <a class="nav-link fw-semibold d-flex align-items-center gap-1" href="{{ route('templates.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space:nowrap">
            Templates <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem;opacity:0.6"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-clean shadow border-0 rounded-3 py-2 px-1 mt-1" style="min-width:240px">
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('templates.index') }}">
                <span class="nav-dd-icon bg-info-subtle text-info"><i class="fa-solid fa-palette"></i></span>
                <div><div class="fw-600 small">All Templates</div><div class="text-muted" style="font-size:.72rem">HTML templates & UI kits</div></div>
              </a>
            </li>
            <li><hr class="dropdown-divider my-1 mx-2"></li>
            @foreach([
              ['slug'=>'business','name'=>'Business Landing Pages','icon'=>'fa-building'],
              ['slug'=>'admin','name'=>'Admin Dashboards','icon'=>'fa-chart-pie'],
              ['slug'=>'bootstrap','name'=>'Bootstrap UI Kits','icon'=>'fa-bootstrap'],
              ['slug'=>'responsive','name'=>'Responsive Web Pages','icon'=>'fa-laptop'],
            ] as $t)
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('templates.show', $t['slug']) }}">
                <span class="nav-dd-icon-sm"><i class="fa-solid {{ $t['icon'] }} text-info"></i></span>
                <span class="small fw-500">{{ $t['name'] }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>

        {{-- AI Videos --}}
        <li class="nav-item dropdown">
          <a class="nav-link fw-semibold d-flex align-items-center gap-1" href="{{ route('ai-videos.index') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space:nowrap">
            AI Videos <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem;opacity:0.6"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-clean shadow border-0 rounded-3 py-2 px-1 mt-1" style="min-width:220px">
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route('ai-videos.index') }}">
                <span class="nav-dd-icon bg-purple-subtle text-purple"><i class="fa-solid fa-robot"></i></span>
                <div><div class="fw-600 small">AI Videos</div><div class="text-muted" style="font-size:.72rem">AI-powered video tools</div></div>
              </a>
            </li>
            <li><hr class="dropdown-divider my-1 mx-2"></li>
            @foreach([
              ['route'=>'ai-videos.generator','name'=>'AI Video Generator','icon'=>'fa-video'],
              ['route'=>'ai-videos.meme-generator','name'=>'Meme Generator','icon'=>'fa-face-laugh'],
              ['route'=>'ai-videos.love-calculator','name'=>'Love Calculator','icon'=>'fa-heart'],
              ['route'=>'ai-videos.caption-generator','name'=>'Caption Generator','icon'=>'fa-closed-captioning'],
            ] as $v)
            <li>
              <a class="dropdown-item rounded-2 d-flex align-items-center gap-2" href="{{ route($v['route']) }}">
                <span class="nav-dd-icon-sm"><i class="fa-solid {{ $v['icon'] }} text-purple"></i></span>
                <span class="small fw-500">{{ $v['name'] }}</span>
              </a>
            </li>
            @endforeach
          </ul>
        </li>

        {{-- News --}}
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('news.index') }}" style="white-space:nowrap">News</a>
        </li>

        {{-- Market --}}
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('market.index') }}" style="white-space:nowrap">Market</a>
        </li>

        {{-- About --}}
        <li class="nav-item">
          <a class="nav-link fw-semibold" href="{{ route('about') }}" style="white-space:nowrap">About</a>
        </li>

      </ul>

      <ul class="navbar-nav align-items-lg-center gap-2 ms-2">
        @auth
          @if(auth()->user()->isAdmin())
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="{{ route('admin.dashboard') }}" style="white-space:nowrap">Admin</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="/dashboard" style="white-space:nowrap">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center gap-2 fw-semibold" href="#" data-bs-toggle="dropdown" style="white-space:nowrap">
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
@php $catalog = \App\Http\Controllers\ToolController::fullCatalog(); @endphp

<div id="toolsOverlay" class="tools-overlay" aria-hidden="true">
  <div class="tools-overlay__inner">
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

// ── Tools full-screen overlay ─────────────────────────────
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
        document.body.style.overflow='hidden';
        if(searchEl){ searchEl.value=''; filterTools(''); setTimeout(()=>searchEl.focus(),120); }
    }
    function closeOverlay(){
        overlay.classList.remove('open');
        backdrop.classList.remove('open');
        overlay.setAttribute('aria-hidden','true');
        document.body.style.overflow='';
    }
    btn.addEventListener('click', openOverlay);
    closeBtn.addEventListener('click', closeOverlay);
    backdrop.addEventListener('click', closeOverlay);
    document.addEventListener('keydown', e => { if(e.key==='Escape') closeOverlay(); });

    function filterTools(q){
        var items  = overlay.querySelectorAll('.tools-overlay__item');
        var blocks = overlay.querySelectorAll('.tools-overlay__cat-block');
        q = q.toLowerCase();
        items.forEach(function(item){
            item.style.display = (!q || item.dataset.name.includes(q) || item.dataset.desc.includes(q)) ? '' : 'none';
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
