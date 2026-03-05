<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm" id="mainNavbar">
  <div class="container">
    <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="/">
      <span class="navbar-brand-icon"><i class="fa-solid fa-layer-group"></i></span>
      <span>Nexora Tools</span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto align-items-lg-center gap-lg-1">

        {{-- ── TOOLS Mega Dropdown ── --}}
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-wrench"></i> Tools <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i>
          </a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">

              {{-- Finance & Date --}}
              <div class="mega-col">
                <a href="/tools#finance" class="mega-col-head">
                  <i class="fa-solid fa-coins text-warning"></i> Finance & Date
                </a>
                <ul class="mega-links">
                  <li><a href="/tools/emi-calculator"><i class="fa-solid fa-calculator fa-fw text-primary me-2"></i>EMI Calculator</a></li>
                  <li><a href="/tools/sip-calculator"><i class="fa-solid fa-chart-line fa-fw text-primary me-2"></i>SIP Calculator</a></li>
                  <li><a href="/tools/fd-rd-calculator"><i class="fa-solid fa-piggy-bank fa-fw text-info me-2"></i>FD / RD Calculator</a></li>
                  <li><a href="/tools/gst-calculator"><i class="fa-solid fa-percent fa-fw text-warning me-2"></i>GST Calculator</a></li>
                  <li><a href="/tools/age-calculator"><i class="fa-solid fa-birthday-cake fa-fw text-primary me-2"></i>Age Calculator</a></li>
                  <li><a href="/tools/month-to-date-converter"><i class="fa-solid fa-calendar-days fa-fw text-success me-2"></i>Date Converter</a></li>
                </ul>
              </div>

              {{-- PDF & File --}}
              <div class="mega-col">
                <a href="/tools#pdf" class="mega-col-head">
                  <i class="fa-solid fa-file-pdf text-danger"></i> PDF & File
                </a>
                <ul class="mega-links">
                  <li><a href="/tools/pdf-merger"><i class="fa-solid fa-object-group fa-fw text-danger me-2"></i>Merge PDF</a></li>
                  <li><a href="/tools/split-pdf"><i class="fa-solid fa-scissors fa-fw text-warning me-2"></i>Split PDF</a></li>
                  <li><a href="/tools/compress-pdf"><i class="fa-solid fa-file-zipper fa-fw text-primary me-2"></i>Compress PDF</a></li>
                  <li><a href="/tools/pdf-to-word"><i class="fa-solid fa-file-word fa-fw text-primary me-2"></i>PDF to Word</a></li>
                  <li><a href="/tools/pdf-to-image"><i class="fa-solid fa-file-image fa-fw text-info me-2"></i>PDF to Image</a></li>
                  <li><a href="/tools/lock-unlock-pdf"><i class="fa-solid fa-lock fa-fw text-secondary me-2"></i>Lock / Unlock PDF</a></li>
                </ul>
              </div>

              {{-- Text & Content --}}
              <div class="mega-col">
                <a href="/tools#text" class="mega-col-head">
                  <i class="fa-solid fa-pen-fancy text-primary"></i> Text & Content
                </a>
                <ul class="mega-links">
                  <li><a href="/tools/word-counter"><i class="fa-solid fa-calculator fa-fw text-info me-2"></i>Word Counter</a></li>
                  <li><a href="/tools/grammar-checker"><i class="fa-solid fa-spell-check fa-fw text-success me-2"></i>Grammar Checker</a></li>
                  <li><a href="/tools/paraphraser"><i class="fa-solid fa-pen-fancy fa-fw text-primary me-2"></i>Paraphraser</a></li>
                  <li><a href="/tools/case-converter"><i class="fa-solid fa-font fa-fw text-primary me-2"></i>Case Converter</a></li>
                  <li><a href="/tools/plagiarism-checker"><i class="fa-solid fa-copy fa-fw text-danger me-2"></i>Plagiarism Checker</a></li>
                  <li><a href="/tools/resume-builder"><i class="fa-solid fa-id-card fa-fw text-info me-2"></i>Resume Builder</a></li>
                </ul>
              </div>

              {{-- Developer + Image --}}
              <div class="mega-col">
                <a href="/tools#developer" class="mega-col-head">
                  <i class="fa-solid fa-code text-dark"></i> Developer
                </a>
                <ul class="mega-links">
                  <li><a href="/tools/json-formatter"><i class="fa-solid fa-braces fa-fw text-warning me-2"></i>JSON Formatter</a></li>
                  <li><a href="/tools/qr-code-generator"><i class="fa-solid fa-qrcode fa-fw text-dark me-2"></i>QR Code Generator</a></li>
                  <li><a href="/tools/regex-tester"><i class="fa-solid fa-code fa-fw text-info me-2"></i>Regex Tester</a></li>
                  <li><a href="/tools/base64-encoder"><i class="fa-solid fa-terminal fa-fw text-secondary me-2"></i>Base64 Encoder</a></li>
                  <li><a href="/tools/url-encoder"><i class="fa-solid fa-link fa-fw text-primary me-2"></i>URL Encoder</a></li>
                </ul>
                <a href="/tools#image" class="mega-col-head mt-3">
                  <i class="fa-solid fa-image text-info"></i> Image
                </a>
                <ul class="mega-links">
                  <li><a href="/tools/image-resizer"><i class="fa-solid fa-expand fa-fw text-primary me-2"></i>Image Resizer</a></li>
                  <li><a href="/tools/background-remover"><i class="fa-solid fa-eraser fa-fw text-danger me-2"></i>Background Remover</a></li>
                  <li><a href="/tools/image-compressor"><i class="fa-solid fa-image fa-fw text-warning me-2"></i>Image Compressor</a></li>
                </ul>
              </div>

              {{-- CTA panel --}}
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-rocket fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">32+ Free Tools</div>
                  <div class="mega-cta-sub">No signup required. All tools work right in your browser.</div>
                  <a href="/tools" class="btn btn-light btn-sm mt-3 fw-semibold">Browse All Tools →</a>
                </div>
              </div>

            </div>
          </div>
        </li>

        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/projects" data-bs-toggle="dropdown"><i class="fa-solid fa-briefcase me-1"></i>Projects <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <!-- Example project categories -->
              <div class="mega-col">
                <a href="/projects/featured" class="mega-col-head">
                  <i class="fa-solid fa-star text-warning"></i> Featured
                </a>
                <ul class="mega-links">
                  <li><a href="/projects/featured"><i class="fa-solid fa-star fa-fw text-warning me-2"></i>Top projects</a></li>
                  <li><a href="/projects/trending"><i class="fa-solid fa-fire fa-fw text-danger me-2"></i>Trending</a></li>
                  <li><a href="/projects/recent"><i class="fa-solid fa-clock fa-fw text-info me-2"></i>Recent</a></li>
                </ul>
              </div>
              <div class="mega-col">
                <a href="/projects/web" class="mega-col-head">
                  <i class="fa-solid fa-globe text-primary"></i> Web
                </a>
                <ul class="mega-links">
                  <li><a href="/projects/web/app1"><i class="fa-solid fa-code fa-fw text-secondary me-2"></i>App 1</a></li>
                  <li><a href="/projects/web/app2"><i class="fa-solid fa-code fa-fw text-secondary me-2"></i>App 2</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-rocket fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">Browse Projects</div>
                  <div class="mega-cta-sub">Hundreds of open-source and demo projects.</div>
                  <a href="/projects" class="btn btn-light btn-sm mt-3 fw-semibold">View all →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/apps" data-bs-toggle="dropdown"><i class="fa-solid fa-mobile-screen-button me-1"></i>Apps <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <div class="mega-col">
                <a href="/apps" class="mega-col-head">
                  <i class="fa-solid fa-mobile-screen-button text-primary"></i> Apps
                </a>
                <ul class="mega-links">
                  <li><a href="/apps/json-formatter"><i class="fa-solid fa-braces fa-fw text-warning me-2"></i>JSON Formatter</a></li>
                  <li><a href="/apps/qr-code-generator"><i class="fa-solid fa-qrcode fa-fw text-dark me-2"></i>QR Code</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-download fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">Apps Library</div>
                  <div class="mega-cta-sub">Quick tools you can install or use.</div>
                  <a href="/apps" class="btn btn-light btn-sm mt-3 fw-semibold">Browse all →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/templates" data-bs-toggle="dropdown"><i class="fa-solid fa-palette me-1"></i>Templates <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <div class="mega-col">
                <a href="/templates" class="mega-col-head">
                  <i class="fa-solid fa-palette text-secondary"></i> Templates
                </a>
                <ul class="mega-links">
                  <li><a href="/templates/landing"><i class="fa-solid fa-paper-plane fa-fw text-primary me-2"></i>Landing pages</a></li>
                  <li><a href="/templates/dashboard"><i class="fa-solid fa-chart-pie fa-fw text-success me-2"></i>Dashboards</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-th-large fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">Template Gallery</div>
                  <div class="mega-cta-sub">Beautiful starter kits for your projects.</div>
                  <a href="/templates" class="btn btn-light btn-sm mt-3 fw-semibold">View all →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/ai-videos" data-bs-toggle="dropdown"><i class="fa-solid fa-video me-1"></i>AI Videos <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <div class="mega-col">
                <a href="/ai-videos" class="mega-col-head">
                  <i class="fa-solid fa-robot text-info"></i> AI Videos
                </a>
                <ul class="mega-links">
                  <li><a href="/ai-videos/create"><i class="fa-solid fa-video fa-fw text-primary me-2"></i>Create Video</a></li>
                  <li><a href="/ai-videos/library"><i class="fa-solid fa-film fa-fw text-secondary me-2"></i>Video Library</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-camera fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">AI Studio</div>
                  <div class="mega-cta-sub">Generate videos in seconds with AI.</div>
                  <a href="/ai-videos" class="btn btn-light btn-sm mt-3 fw-semibold">Explore →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/news" data-bs-toggle="dropdown"><i class="fa-solid fa-newspaper me-1"></i>News <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <div class="mega-col">
                <a href="/news" class="mega-col-head">
                  <i class="fa-solid fa-newspaper text-warning"></i> News
                </a>
                <ul class="mega-links">
                  <li><a href="/news/latest"><i class="fa-solid fa-clock fa-fw text-info me-2"></i>Latest</a></li>
                  <li><a href="/news/trending"><i class="fa-solid fa-fire fa-fw text-danger me-2"></i>Trending</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-newspaper fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">Tech News</div>
                  <div class="mega-cta-sub">Stay updated with the industry.</div>
                  <a href="/news" class="btn btn-light btn-sm mt-3 fw-semibold">Read more →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown mega-dropdown">
          <a class="nav-link fw-semibold" href="/market" data-bs-toggle="dropdown"><i class="fa-solid fa-chart-line me-1"></i>Market <i class="fa-solid fa-chevron-down dropdown-arrow ms-1"></i></a>
          <div class="dropdown-menu mega-menu shadow-lg border-0 p-0">
            <div class="mega-menu-inner">
              <div class="mega-col">
                <a href="/market" class="mega-col-head">
                  <i class="fa-solid fa-chart-line text-success"></i> Market
                </a>
                <ul class="mega-links">
                  <li><a href="/market/stocks"><i class="fa-solid fa-dollar-sign fa-fw text-primary me-2"></i>Stocks</a></li>
                  <li><a href="/market/crypto"><i class="fa-solid fa-bitcoin fa-fw text-warning me-2"></i>Crypto</a></li>
                </ul>
              </div>
              <div class="mega-cta">
                <div class="mega-cta-inner">
                  <i class="fa-solid fa-chart-pie fa-2x mb-3 text-white"></i>
                  <div class="mega-cta-title">Market Insights</div>
                  <div class="mega-cta-sub">Charts, news and analysis.</div>
                  <a href="/market" class="btn btn-light btn-sm mt-3 fw-semibold">Explore →</a>
                </div>
              </div>
            </div>
          </div>
        </li>
      </ul>

      <ul class="navbar-nav align-items-lg-center gap-2">
        @auth
          @if(auth()->user()->isAdmin())
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-cog me-1"></i>Admin</a>
          </li>
          @endif
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="/dashboard"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a>
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
            <a class="nav-link fw-semibold" href="/login"><i class="fa-solid fa-sign-in-alt me-1"></i>Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary px-4 fw-semibold" href="/register">Sign Up</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

{{-- Mega menu + navbar styles are in app.css --}}

@push('scripts')
<script>
// Transparent → solid scroll behaviour (only on homepage)
(function(){
    var nav = document.getElementById('mainNavbar');
    if (!document.body.classList.contains('page-main-hero') && !document.querySelector('.page-main-hero')) return;
    function checkScroll(){
        if(window.scrollY > 60){ nav.classList.remove('navbar-transparent'); nav.classList.add('navbar-scrolled'); }
        else { nav.classList.add('navbar-transparent'); nav.classList.remove('navbar-scrolled'); }
    }
    checkScroll();
    window.addEventListener('scroll', checkScroll, { passive:true });
})();

// When any mega dropdown opens/ closes toggle body class to prevent page scroll
(function(){
    var megaItems = document.querySelectorAll('.mega-dropdown');
    megaItems.forEach(function(item){
        item.addEventListener('show.bs.dropdown', function(){ document.body.classList.add('mega-open'); });
        item.addEventListener('hide.bs.dropdown', function(){ document.body.classList.remove('mega-open'); });
    });
})();
</script>
@endpush
