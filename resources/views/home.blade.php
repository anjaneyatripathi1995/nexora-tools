@extends('layouts.app')

@section('title', 'All-in-One Tech Solution Hub')
@section('main_class', 'page-main-hero')

@section('content')

<!-- ============================================================
     HERO SECTION — full-screen banner slider with overlay
     ============================================================ -->
<section class="hero-section hero-banner-full position-relative overflow-hidden">

    <!-- Background image slider -->
    <div class="hero-slider">
        <div class="hero-slide active">
            <img src="{{ asset('images/utility-banner-1.png') }}" alt="Utility tools dashboard">
        </div>
        <div class="hero-slide">
            <img src="{{ asset('images/utility-banner-2.png') }}" alt="Online utility tools kit">
        </div>
        <div class="hero-slide">
            <img src="{{ asset('images/utility-banner-3.png') }}" alt="Tech productivity toolkit">
        </div>
    </div>

    <!-- Deep gradient overlay — left dark, right lighter -->
    <div class="hero-banner-overlay" aria-hidden="true"></div>

    <!-- Hero content -->
    <div class="hero-content-wrapper">
        <div class="container">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-8 col-xl-7">
                    <div class="hero-content">

                        <!-- Animated badge -->
                        <div class="hero-badge animate-badge">
                            <span class="badge-dot"></span>
                            ✨ &nbsp;All-in-One Tech Platform
                        </div>

                        <!-- Main headline -->
                        <h1 class="hero-title animate-fadeup" style="animation-delay:.1s">
                            Your Complete<br>
                            <span class="hero-title-highlight">Tech Solution</span> Hub
                        </h1>

                        <!-- Sub-text -->
                        <p class="hero-lead animate-fadeup" style="animation-delay:.25s">
                            Utilities, Projects, Templates, AI Videos & Market Updates —
                            all in one powerful platform built for developers and creators.
                        </p>

                        <!-- CTA buttons -->
                        <div class="hero-buttons d-flex flex-wrap gap-3 animate-fadeup" style="animation-delay:.4s">
                            <a href="#utility-tools" class="btn-hero-primary btn-hero-primary--invert">
                                <i class="fa-solid fa-rocket me-2"></i>Explore Tools
                            </a>
                            <a href="/register" class="btn-hero-outline">
                                Get Started Free <i class="fa-solid fa-arrow-right ms-2"></i>
                            </a>
                        </div>

                        <!-- Inline stats -->
                        <div class="hero-stats animate-fadeup" style="animation-delay:.55s">
                            <div class="hero-stat">
                                <span class="hero-stat-num">32+</span>
                                <span class="hero-stat-label">Tools</span>
                            </div>
                            <div class="hero-stat-divider"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">7</span>
                                <span class="hero-stat-label">Projects</span>
                            </div>
                            <div class="hero-stat-divider"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">21</span>
                                <span class="hero-stat-label">Apps</span>
                            </div>
                            <div class="hero-stat-divider"></div>
                            <div class="hero-stat">
                                <span class="hero-stat-num">4</span>
                                <span class="hero-stat-label">Templates</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide dots -->
    <div class="hero-slider-dots-wrapper">
        <div class="hero-slider-dots">
            <button class="hero-slider-dot active" data-slide="0" aria-label="Slide 1"></button>
            <button class="hero-slider-dot" data-slide="1" aria-label="Slide 2"></button>
            <button class="hero-slider-dot" data-slide="2" aria-label="Slide 3"></button>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="hero-scroll-indicator">
        <span>Scroll</span>
        <div class="scroll-arrow"></div>
    </div>
</section>

<!-- ============================================================
     SEARCH TOOLS
     ============================================================ -->
<section class="home-section py-5 bg-light-subtle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="text-center mb-3">
                    <h2 class="fw-800 fs-4 mb-1">Search Tools</h2>
                    <p class="text-muted small mb-0">32+ free tools — just type to find what you need</p>
                </div>
                <form action="{{ route('tools.index') }}" method="get" id="searchForm" autocomplete="off">
                    <div class="search-box-wrapper position-relative">
                        <span class="search-icon-left"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input
                            type="search"
                            name="q"
                            id="toolSearchInput"
                            class="form-control form-control-lg search-input-styled"
                            placeholder="Search tools (e.g. JSON, PDF, password)..."
                            value="{{ request('q') }}"
                            aria-label="Search tools"
                            autocomplete="off"
                        >
                        <button type="submit" class="btn btn-primary search-btn-styled">
                            <i class="fa-solid fa-search me-1"></i> Search
                        </button>

                        <!-- Suggestions dropdown -->
                        <ul id="searchSuggestions" class="search-suggestions" role="listbox" aria-label="Suggestions"></ul>
                    </div>
                </form>

                <!-- Popular quick-links -->
                <div class="search-quick-tags mt-3 text-center">
                    <span class="text-muted small me-2">Popular:</span>
                    @php
                        $quickLinks = [
                            ['label'=>'JSON Formatter','slug'=>'json-formatter'],
                            ['label'=>'EMI Calculator','slug'=>'emi-calculator'],
                            ['label'=>'Password Generator','slug'=>'password-generator'],
                            ['label'=>'PDF Merger','slug'=>'pdf-merger'],
                            ['label'=>'QR Code','slug'=>'qr-code-generator'],
                            ['label'=>'Word Counter','slug'=>'word-counter'],
                        ];
                    @endphp
                    @foreach($quickLinks as $ql)
                    <a href="{{ route('tools.show', $ql['slug']) }}" class="search-quick-tag">{{ $ql['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     STATS STRIP
     ============================================================ -->
<section class="stats-strip">
    <div class="container">
        <div class="row g-0 justify-content-center">
            <div class="col-6 col-md-3">
                <div class="stats-item" data-count="32">
                    <span class="stats-num" data-target="32">0</span>
                    <span class="stats-plus">+</span>
                    <div class="stats-label">Utility Tools</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-item" data-count="7">
                    <span class="stats-num" data-target="7">0</span>
                    <div class="stats-label">Web & Mobile Projects</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-item" data-count="21">
                    <span class="stats-num" data-target="21">0</span>
                    <span class="stats-plus">+</span>
                    <div class="stats-label">App Solutions</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stats-item" data-count="4">
                    <span class="stats-num" data-target="4">0</span>
                    <div class="stats-label">HTML Templates</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     CATEGORIES
     ============================================================ -->
@if(isset($categories) && $categories->isNotEmpty())
<section id="categories" class="home-section">
    <div class="container">
        <div class="section-head reveal">
            <h2 class="section-title">Categories</h2>
            <p class="section-sub">Browse tools by category</p>
        </div>
        <div class="row g-3">
            @foreach($categories as $cat)
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <a href="{{ route('tools.index', ['category' => $cat->slug]) }}" class="text-decoration-none">
                    <div class="card h-100 border shadow-sm hover-shadow">
                        <div class="card-body text-center">
                            @if($cat->icon)<i class="fa-solid {{ $cat->icon }} fa-2x text-primary mb-2"></i>@endif
                            <div class="fw-semibold text-dark">{{ $cat->name }}</div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ============================================================
     POPULAR / UTILITY TOOLS
     ============================================================ -->
<section id="utility-tools" class="home-section bg-light-subtle">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">⚡ Popular Tools</h2>
            <p class="section-sub">Quick, user-friendly online tools for everyday developer & productivity tasks</p>
        </div>

        <div class="row g-4">
            <!-- Finance -->
            <div class="col-md-6 col-lg-3 reveal" style="--delay:.05s">
                <div class="home-card home-card--blue h-100">
                    <div class="home-card__head">
                        <div class="home-card__icon"><i class="fa-solid fa-coins"></i></div>
                        <div>
                            <h4>Finance &amp; Date</h4>
                            <span class="home-card__badge">6 Tools</span>
                        </div>
                    </div>
                    <div class="home-card__body">
                        <ul>
                            <li><a href="/tools/emi-calculator"><i class="fa-solid fa-calculator"></i>EMI Calculator</a></li>
                            <li><a href="/tools/sip-calculator"><i class="fa-solid fa-chart-line"></i>SIP Calculator</a></li>
                            <li><a href="/tools/fd-rd-calculator"><i class="fa-solid fa-piggy-bank"></i>FD / RD Calculator</a></li>
                            <li><a href="/tools/gst-calculator"><i class="fa-solid fa-percent"></i>GST Calculator</a></li>
                            <li><a href="/tools/age-calculator"><i class="fa-solid fa-birthday-cake"></i>Age Calculator</a></li>
                            <li><a href="/tools/month-to-date-converter"><i class="fa-solid fa-calendar-days"></i>Date Converter</a></li>
                        </ul>
                    </div>
                    <div class="home-card__footer">
                        <a href="/tools#finance" class="home-card__btn">View All <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- PDF -->
            <div class="col-md-6 col-lg-3 reveal" style="--delay:.1s">
                <div class="home-card home-card--red h-100">
                    <div class="home-card__head">
                        <div class="home-card__icon"><i class="fa-solid fa-file-pdf"></i></div>
                        <div>
                            <h4>PDF &amp; File</h4>
                            <span class="home-card__badge">10 Tools</span>
                        </div>
                    </div>
                    <div class="home-card__body">
                        <ul>
                            <li><a href="/tools/pdf-merger"><i class="fa-solid fa-object-group"></i>Merge PDF</a></li>
                            <li><a href="/tools/split-pdf"><i class="fa-solid fa-scissors"></i>Split PDF</a></li>
                            <li><a href="/tools/compress-pdf"><i class="fa-solid fa-file-zipper"></i>Compress PDF</a></li>
                            <li><a href="/tools/pdf-to-word"><i class="fa-solid fa-file-word"></i>PDF to Word</a></li>
                            <li><a href="/tools/pdf-to-image"><i class="fa-solid fa-file-image"></i>PDF to Image</a></li>
                            <li><a href="/tools/lock-unlock-pdf"><i class="fa-solid fa-lock"></i>Lock / Unlock PDF</a></li>
                        </ul>
                    </div>
                    <div class="home-card__footer">
                        <a href="/tools#pdf" class="home-card__btn">View All <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Text -->
            <div class="col-md-6 col-lg-3 reveal" style="--delay:.15s">
                <div class="home-card home-card--teal h-100">
                    <div class="home-card__head">
                        <div class="home-card__icon"><i class="fa-solid fa-pen-fancy"></i></div>
                        <div>
                            <h4>Text &amp; Content</h4>
                            <span class="home-card__badge">7 Tools</span>
                        </div>
                    </div>
                    <div class="home-card__body">
                        <ul>
                            <li><a href="/tools/word-counter"><i class="fa-solid fa-calculator"></i>Word Counter</a></li>
                            <li><a href="/tools/grammar-checker"><i class="fa-solid fa-spell-check"></i>Grammar Checker</a></li>
                            <li><a href="/tools/paraphraser"><i class="fa-solid fa-pen-fancy"></i>Paraphraser</a></li>
                            <li><a href="/tools/plagiarism-checker"><i class="fa-solid fa-copy"></i>Plagiarism Checker</a></li>
                            <li><a href="/tools/resume-builder"><i class="fa-solid fa-id-card"></i>Resume Builder</a></li>
                            <li><a href="/tools/essay-letter-generator"><i class="fa-solid fa-envelope-open-text"></i>Essay Generator</a></li>
                        </ul>
                    </div>
                    <div class="home-card__footer">
                        <a href="/tools#text" class="home-card__btn">View All <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Dev -->
            <div class="col-md-6 col-lg-3 reveal" style="--delay:.2s">
                <div class="home-card home-card--amber h-100">
                    <div class="home-card__head">
                        <div class="home-card__icon"><i class="fa-solid fa-code"></i></div>
                        <div>
                            <h4>Developer Tools</h4>
                            <span class="home-card__badge">6 Tools</span>
                        </div>
                    </div>
                    <div class="home-card__body">
                        <ul>
                            <li><a href="/tools/json-formatter"><i class="fa-solid fa-braces"></i>JSON Formatter</a></li>
                            <li><a href="/tools/qr-code-generator"><i class="fa-solid fa-qrcode"></i>QR Code Generator</a></li>
                            <li><a href="/tools/regex-tester"><i class="fa-solid fa-code"></i>Regex Tester</a></li>
                            <li><a href="/tools/base64-encoder"><i class="fa-solid fa-terminal"></i>Base64 Encoder</a></li>
                            <li><a href="/tools/url-encoder"><i class="fa-solid fa-link"></i>URL Encoder</a></li>
                            <li><a href="/tools/minifier"><i class="fa-solid fa-compress"></i>Code Minifier</a></li>
                        </ul>
                    </div>
                    <div class="home-card__footer">
                        <a href="/tools#developer" class="home-card__btn">View All <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 reveal">
            <a href="/tools" class="btn-section-cta">View All 32+ Tools <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>


<!-- ============================================================
     PROJECT SOLUTIONS
     ============================================================ -->
<section id="project-solutions" class="home-section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">💼 Web &amp; Mobile Projects</h2>
            <p class="section-sub">Production-ready code solutions with documentation &amp; demo</p>
        </div>

        <div class="row g-4">
            @php
            $projects = [
                ['icon'=>'fa-receipt',         'name'=>'Tax / Invoicing App',       'desc'=>'Complete invoicing & tax management',   'color'=>'green',  'slug'=>'tax-invoicing'],
                ['icon'=>'fa-utensils',         'name'=>'Restaurant Booking App',    'desc'=>'Web + Mobile reservation system',        'color'=>'red',    'slug'=>'restaurant-booking'],
                ['icon'=>'fa-wallet',           'name'=>'Expense Tracker App',       'desc'=>'Track & manage expenses efficiently',    'color'=>'blue',   'slug'=>'expense-tracker'],
                ['icon'=>'fa-list-check',       'name'=>'To-Do List App',            'desc'=>'Productive task management app',          'color'=>'indigo', 'slug'=>'todo-list'],
                ['icon'=>'fa-chalkboard-user',  'name'=>'Online Teaching Platform',  'desc'=>'Complete e-learning management system',  'color'=>'amber',  'slug'=>'online-teaching'],
                ['icon'=>'fa-chart-line',       'name'=>'CEO Dashboard',             'desc'=>'Executive analytics & insights',         'color'=>'purple', 'slug'=>'ceo-dashboard'],
            ];
            $pColors = ['green'=>'#10b981','red'=>'#ef4444','blue'=>'#2563eb','indigo'=>'#6366f1','amber'=>'#f59e0b','purple'=>'#8b5cf6'];
            @endphp

            @foreach($projects as $i => $p)
            <div class="col-md-6 col-lg-4 reveal" style="--delay:{{ $i * 0.07 }}s">
                <div class="proj-card h-100">
                    <div class="proj-card__icon" style="background:{{ $pColors[$p['color']] }}1a; color:{{ $pColors[$p['color']] }}">
                        <i class="fa-solid {{ $p['icon'] }}"></i>
                    </div>
                    <h5>{{ $p['name'] }}</h5>
                    <p>{{ $p['desc'] }}</p>
                    <a href="/projects/{{ $p['slug'] }}" class="proj-card__link">
                        View Project <i class="fa-solid fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="/projects" class="btn-section-cta btn-section-cta--outline">View All Projects <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>


<!-- ============================================================
     APP SUITE
     ============================================================ -->
<section id="app-suite" class="home-section bg-light-subtle">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">📱 Mobile &amp; Web App Suite</h2>
            <p class="section-sub">21+ downloadable app solutions — APK + Source Code + Live Demo</p>
        </div>

        @php
        $apps = [
            ['icon'=>'fa-dumbbell',         'name'=>'Fitness App',            'color'=>'#ef4444'],
            ['icon'=>'fa-language',         'name'=>'Language Learning',      'color'=>'#2563eb'],
            ['icon'=>'fa-car',              'name'=>'Car Parking App',        'color'=>'#10b981'],
            ['icon'=>'fa-robot',            'name'=>'Chatbots',               'color'=>'#6366f1'],
            ['icon'=>'fa-folder-open',      'name'=>'Docket Management',      'color'=>'#f59e0b'],
            ['icon'=>'fa-heart',            'name'=>'Mental Health App',      'color'=>'#ec4899'],
            ['icon'=>'fa-credit-card',      'name'=>'Payments App',           'color'=>'#10b981'],
            ['icon'=>'fa-calendar-check',   'name'=>'Reservation Platform',   'color'=>'#2563eb'],
            ['icon'=>'fa-radio',            'name'=>'YouTube Radio',          'color'=>'#6366f1'],
            ['icon'=>'fa-book',             'name'=>'Book Review App',        'color'=>'#f59e0b'],
            ['icon'=>'fa-charging-station', 'name'=>'EV Charging Finder',     'color'=>'#10b981'],
            ['icon'=>'fa-graduation-cap',   'name'=>'Exam Study App',         'color'=>'#8b5cf6'],
        ];
        @endphp

        <div class="row g-3">
            @foreach($apps as $i => $app)
            <div class="col-6 col-md-4 col-lg-2 reveal" style="--delay:{{ $i * 0.04 }}s">
                <a href="/apps/{{ strtolower(str_replace([' ','/'], ['-','-'], $app['name'])) }}" class="app-pill">
                    <div class="app-pill__icon" style="color:{{ $app['color'] }}; background:{{ $app['color'] }}1a">
                        <i class="fa-solid {{ $app['icon'] }}"></i>
                    </div>
                    <span>{{ $app['name'] }}</span>
                </a>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="/apps" class="btn-section-cta">View All 21+ Apps <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>


<!-- ============================================================
     TEMPLATES
     ============================================================ -->
<section id="templates" class="home-section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">🖼️ HTML Templates</h2>
            <p class="section-sub">Modern, responsive UI templates — preview & download instantly</p>
        </div>

        <div class="row g-4">
            @php
            $tpls = [
                ['name'=>'Business Landing Pages','icon'=>'fa-building',        'desc'=>'Professional landing page templates',  'color'=>'#2563eb', 'slug'=>'business'],
                ['name'=>'Admin Dashboards',      'icon'=>'fa-gauge-high',       'desc'=>'Complete admin panel templates',        'color'=>'#10b981', 'slug'=>'admin'],
                ['name'=>'Bootstrap UI Kits',     'icon'=>'fa-puzzle-piece',     'desc'=>'Ready-to-use Bootstrap components',     'color'=>'#8b5cf6', 'slug'=>'bootstrap'],
                ['name'=>'Responsive Web Pages',  'icon'=>'fa-mobile-screen',    'desc'=>'Mobile-first responsive designs',       'color'=>'#f59e0b', 'slug'=>'responsive'],
            ];
            @endphp

            @foreach($tpls as $i => $t)
            <div class="col-md-6 col-lg-3 reveal" style="--delay:{{ $i * 0.08 }}s">
                <div class="tpl-card h-100">
                    <div class="tpl-card__bar" style="background:{{ $t['color'] }}"></div>
                    <div class="tpl-card__icon" style="color:{{ $t['color'] }}">
                        <i class="fa-solid {{ $t['icon'] }}"></i>
                    </div>
                    <h5>{{ $t['name'] }}</h5>
                    <p>{{ $t['desc'] }}</p>
                    <a href="/templates/{{ $t['slug'] }}" class="tpl-card__link" style="color:{{ $t['color'] }}">
                        Preview <i class="fa-solid fa-eye ms-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="/templates" class="btn-section-cta btn-section-cta--outline">Browse All Templates <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>


<!-- ============================================================
     AI VIDEOS / FUN
     ============================================================ -->
<section id="ai-videos" class="home-section home-section--dark">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title" style="color:#fff">🎉 Fun &amp; AI Tools</h2>
            <p class="section-sub" style="color:rgba(255,255,255,.7)">AI-generated entertainment and creative content tools</p>
        </div>

        <div class="row g-4 justify-content-center">
            @php
            $aiTools = [
                ['icon'=>'fa-video',  'name'=>'AI Video Generator', 'desc'=>'Generate fun or motivational videos from text prompts',  'href'=>'/ai-videos/generator',       'color'=>'#ef4444'],
                ['icon'=>'fa-face-grin-squint-tears', 'name'=>'Meme Generator', 'desc'=>'Create hilarious memes in seconds',           'href'=>'/ai-videos/meme-generator',  'color'=>'#f59e0b'],
                ['icon'=>'fa-heart',  'name'=>'Love Calculator',    'desc'=>'Calculate compatibility between names (fully working!)', 'href'=>'/ai-videos/love-calculator', 'color'=>'#ec4899'],
                ['icon'=>'fa-comment-dots', 'name'=>'Caption Generator', 'desc'=>'Generate captions & short stories from a prompt',   'href'=>'/ai-videos/caption-generator','color'=>'#6366f1'],
            ];
            @endphp

            @foreach($aiTools as $i => $tool)
            <div class="col-md-6 col-lg-3 reveal" style="--delay:{{ $i * 0.1 }}s">
                <div class="ai-card h-100">
                    <div class="ai-card__icon" style="background:{{ $tool['color'] }}22; color:{{ $tool['color'] }}">
                        <i class="fa-solid {{ $tool['icon'] }}"></i>
                    </div>
                    <h5>{{ $tool['name'] }}</h5>
                    <p>{{ $tool['desc'] }}</p>
                    <a href="{{ $tool['href'] }}" class="ai-card__btn" style="background:{{ $tool['color'] }}">Try Now</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="/ai-videos" class="btn-hero-outline" style="display:inline-flex">Explore All AI Tools <i class="fa-solid fa-arrow-right ms-2"></i></a>
        </div>
    </div>
</section>


<!-- ============================================================
     NEWS & MARKET
     ============================================================ -->
<section id="news-market" class="home-section">
    <div class="container">

        <div class="section-head reveal">
            <h2 class="section-title">📰 News &amp; Market</h2>
            <p class="section-sub">Trending tech news and live stock market data in one place</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 reveal" style="--delay:.05s">
                <div class="nm-card nm-card--news h-100">
                    <div class="nm-card__header">
                        <i class="fa-solid fa-newspaper"></i>
                        <h4>Tech News</h4>
                    </div>
                    <p>Auto-updated news on Tech, Startups, and World Affairs — curated for developers.</p>
                    <ul>
                        <li><i class="fa-solid fa-circle-check"></i> Tech Industry Updates</li>
                        <li><i class="fa-solid fa-circle-check"></i> Startup Announcements</li>
                        <li><i class="fa-solid fa-circle-check"></i> World Affairs</li>
                    </ul>
                    <a href="/news" class="nm-card__btn">Read News <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>

            <div class="col-md-6 reveal" style="--delay:.1s">
                <div class="nm-card nm-card--market h-100">
                    <div class="nm-card__header">
                        <i class="fa-solid fa-chart-line"></i>
                        <h4>Stock Market Live</h4>
                    </div>
                    <p>Real-time stock market updates and trends — Nifty, Sensex, and more.</p>
                    <ul>
                        <li><i class="fa-solid fa-circle-check"></i> Nifty 50 &amp; Sensex</li>
                        <li><i class="fa-solid fa-circle-check"></i> Stock Trends</li>
                        <li><i class="fa-solid fa-circle-check"></i> Market Movers</li>
                    </ul>
                    <a href="/market" class="nm-card__btn">View Market <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     LATEST TOOLS
     ============================================================ -->
@if(isset($latestTools) && $latestTools->isNotEmpty())
<section id="latest-tools" class="home-section">
    <div class="container">
        <div class="section-head reveal">
            <h2 class="section-title">Latest Tools</h2>
            <p class="section-sub">Recently added or updated tools</p>
        </div>
        <div class="row g-3">
            @foreach($latestTools as $t)
            <div class="col-6 col-md-4 col-lg-3 reveal">
                <a href="{{ route('tools.show', $t->slug) }}" class="text-decoration-none">
                    <div class="card h-100 border shadow-sm">
                        <div class="card-body d-flex align-items-center gap-2">
                            @if($t->icon)<i class="fa-solid {{ $t->icon }} text-primary"></i>@endif
                            <span class="fw-semibold text-dark">{{ $t->name }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('tools.index') }}" class="btn btn-outline-primary">View all tools</a>
        </div>
    </div>
</section>
@endif

<!-- ============================================================
     USER FEATURES CTA
     ============================================================ -->
<section id="user-features" class="home-section cta-section">
    <div class="container">
        <div class="cta-card reveal">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <h2 class="cta-title">Unlock Your <span class="cta-highlight">Personal Dashboard</span></h2>
                    <p class="cta-sub">
                        Sign up free to save tools, bookmark projects, track your usage history, and access personalized analytics.
                    </p>
                    <ul class="cta-features">
                        <li><i class="fa-solid fa-circle-check"></i> Save favourite tools &amp; projects</li>
                        <li><i class="fa-solid fa-circle-check"></i> Personalized dashboard &amp; analytics</li>
                        <li><i class="fa-solid fa-circle-check"></i> AI video &amp; content generation</li>
                        <li><i class="fa-solid fa-circle-check"></i> Full usage history tracking</li>
                    </ul>
                    <div class="d-flex flex-wrap gap-3 mt-4">
                        @auth
                            <a href="/dashboard" class="btn-hero-primary">Go to Dashboard <i class="fa-solid fa-arrow-right ms-2"></i></a>
                        @else
                            <a href="/register" class="btn-hero-primary">Sign Up Free <i class="fa-solid fa-rocket ms-2"></i></a>
                            <a href="/login" class="btn-hero-outline" style="border-color:#2563eb;color:#2563eb">Login</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <div class="cta-visual">
                        <div class="cta-visual__ring cta-visual__ring--1"></div>
                        <div class="cta-visual__ring cta-visual__ring--2"></div>
                        <div class="cta-visual__ring cta-visual__ring--3"></div>
                        <i class="fa-solid fa-user-gear cta-visual__icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     ABOUT NEXORA / SEO CONTENT
     ============================================================ -->
<section id="about-nexora" class="home-section">
    <div class="container">
        <div class="section-head reveal">
            <h2 class="section-title">About Nexora Tools</h2>
            <p class="section-sub">By Tripathi Nexora Technologies — tripathinexora.com</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p class="lead">Nexora Tools is a multi-tool SaaS platform offering free online utilities for developers, content creators, and businesses. We provide PDF tools, image tools, developer tools, SEO tools, finance calculators, and AI-powered utilities — all in one place, with no sign-up required for most tools.</p>
                <p>Our platform is built for scale and supports 100+ tools. Use our tools for temp mail, JSON formatting, Base64 encoding, password generation, word counting, image compression, PDF merging, URL encoding, UUID generation, Markdown preview, and many more.</p>
            </div>
        </div>
    </div>
</section>

@endsection


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* -------------------------------------------------------
   HOME PAGE — EXTRA DESIGN LAYER
   ------------------------------------------------------- */

/* --- HERO BADGE --- */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.12);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,.3);
    border-radius: 50px;
    padding: 8px 22px;
    color: #fff;
    font-size: .9rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    letter-spacing: .3px;
}
.badge-dot {
    width: 8px; height: 8px;
    background: #4ade80;
    border-radius: 50%;
    animation: blink 1.6s infinite;
}
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* --- HERO TITLE --- */
.hero-title {
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.12;
    color: #fff;
    text-shadow: 0 3px 20px rgba(0,0,0,.45);
    margin-bottom: 1.4rem;
}
.hero-title-highlight {
    background: linear-gradient(90deg,#60a5fa,#a78bfa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* --- HERO LEAD --- */
.hero-lead {
    font-size: clamp(1rem, 1.5vw, 1.2rem);
    color: rgba(255,255,255,.92);
    text-shadow: 0 1px 6px rgba(0,0,0,.35);
    max-width: 560px;
    line-height: 1.75;
    margin-bottom: 2rem;
}

/* --- CTA BUTTONS --- */
.btn-hero-primary {
    display: inline-flex;
    align-items: center;
    background: #2563eb;
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    padding: 14px 32px;
    border-radius: 10px;
    text-decoration: none;
    border: 2px solid #2563eb;
    transition: all .25s ease;
    box-shadow: 0 6px 24px rgba(37,99,235,.35);
}
.btn-hero-primary:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(37,99,235,.45);
}
.btn-hero-primary--invert {
    background: #2563eb;
    border-color: #2563eb;
    color: #fff;
    position: relative;
    overflow: hidden;
    isolation: isolate;
    box-shadow: 0 6px 24px rgba(37,99,235,.35);
}
.btn-hero-primary--invert::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0);
    transform: scaleX(1);
    transform-origin: right center;
    transition: transform .38s ease;
    z-index: -1;
}
.btn-hero-primary--invert:hover {
    background: transparent;
    border-color: #fff;
    color: #fff;
    box-shadow: 0 8px 26px rgba(0,0,0,.22);
}
.btn-hero-primary--invert:hover::before {
    transform: scaleX(0);
}
.btn-hero-outline {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    color: #fff;
    font-weight: 600;
    font-size: 1rem;
    padding: 14px 32px;
    border-radius: 10px;
    text-decoration: none;
    border: 2px solid rgba(255,255,255,.7);
    transition: all .25s ease;
    position: relative;
    overflow: hidden;
    isolation: isolate;
}
.btn-hero-outline::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, #2563eb 0%, #3b82f6 100%);
    transform: scaleX(0);
    transform-origin: left center;
    transition: transform .35s ease;
    z-index: -1;
}
.btn-hero-outline > * {
    position: relative;
    z-index: 1;
}
.btn-hero-outline:hover {
    background: transparent;
    border-color: #fff;
    color: #fff;
    transform: translateY(-3px);
}
.btn-hero-outline:hover::before {
    transform: scaleX(1);
}

/* --- HERO STATS --- */
.hero-stats {
    display: flex;
    align-items: center;
    gap: 0;
    margin-top: 2.5rem;
    padding: 18px 26px;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 14px;
    width: fit-content;
    flex-wrap: wrap;
    gap: 0;
}
.hero-stat { text-align: center; padding: 0 22px; }
.hero-stat-num { display: block; font-size: 1.7rem; font-weight: 900; color: #fff; line-height: 1; }
.hero-stat-label { display: block; font-size: .72rem; color: rgba(255,255,255,.7); text-transform: uppercase; letter-spacing: .8px; margin-top: 4px; }
.hero-stat-divider { width: 1px; height: 36px; background: rgba(255,255,255,.25); flex-shrink: 0; }

/* --- SCROLL INDICATOR --- */
.hero-scroll-indicator {
    position: absolute;
    bottom: 4rem;
    right: 3rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,.6);
    font-size: .7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    z-index: 3;
    animation: float 2.5s ease-in-out infinite;
}
.scroll-arrow {
    width: 20px; height: 20px;
    border-right: 2px solid rgba(255,255,255,.6);
    border-bottom: 2px solid rgba(255,255,255,.6);
    transform: rotate(45deg);
    margin-top: -6px;
}
@keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(6px)} }

/* --- HERO OVERLAY (stronger) — must not block clicks --- */
.hero-banner-overlay {
    background: linear-gradient(110deg,
        rgba(10,15,40,.85) 0%,
        rgba(10,15,40,.65) 45%,
        rgba(10,15,40,.3) 100%) !important;
    pointer-events: none !important;
    z-index: 1;
}
.hero-content-wrapper {
    position: relative;
    z-index: 2;
    pointer-events: auto;
}
.hero-content-wrapper a,
.hero-content-wrapper button {
    pointer-events: auto;
    cursor: pointer;
}

/* --- KEN BURNS on active slide --- */
@keyframes kenburns { 0%{transform:scale(1)} 100%{transform:scale(1.07)} }
.hero-slide.active img { animation: kenburns 9s ease-out forwards; }

/* --- ANIMATE-FADEUP --- */
.animate-fadeup {
    opacity: 0;
    transform: translateY(28px);
    animation: fadeUp .7s ease forwards;
}
.animate-badge {
    opacity: 0;
    animation: fadeDown .6s ease forwards;
}
@keyframes fadeUp   { to{opacity:1;transform:translateY(0)} }
@keyframes fadeDown { from{opacity:0;transform:translateY(-14px)} to{opacity:1;transform:translateY(0)} }

/* -------------------------------------------------------
   STATS STRIP
   ------------------------------------------------------- */
.stats-strip {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 50px 0;
}
.stats-item {
    text-align: center;
    padding: 20px 10px;
    border-right: 1px solid rgba(255,255,255,.15);
    position: relative;
}
.stats-item:last-child { border-right: none; }
.stats-num {
    display: inline-block;
    font-size: 2.6rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
}
.stats-plus { font-size: 1.6rem; font-weight: 700; color: #93c5fd; vertical-align: top; margin-top: 4px; }
.stats-label {
    display: block;
    font-size: .8rem;
    color: rgba(255,255,255,.65);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-top: 8px;
}

/* -------------------------------------------------------
   GENERAL SECTION STYLES
   ------------------------------------------------------- */
.home-section { padding: 50px 0; }
.home-section.bg-light-subtle { background: #f8fafc; }
.home-section--dark {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.section-head { text-align: center; margin-bottom: 2rem; }
.section-tag {
    display: inline-block;
    background: #e0e7ff;
    color: #2563eb;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    padding: 5px 16px;
    border-radius: 50px;
    margin-bottom: 1rem;
}
.section-tag--light { background: rgba(255,255,255,.1); color: rgba(255,255,255,.8); }
.section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 800;
    color: #0f172a;
    margin-bottom: .75rem;
    position: relative;
}
.section-title::after {
    content: '';
    display: block;
    width: 50px; height: 4px;
    background: linear-gradient(90deg,#2563eb,#8b5cf6);
    border-radius: 4px;
    margin: 12px auto 0;
}
.section-sub { font-size: 1.05rem; color: #64748b; max-width: 560px; margin: 0 auto; }

/* Section CTA buttons */
.btn-section-cta {
    display: inline-flex;
    align-items: center;
    background: #2563eb;
    color: #fff;
    font-weight: 700;
    padding: 14px 36px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 1rem;
    transition: all .25s ease;
    box-shadow: 0 4px 16px rgba(37,99,235,.25);
}
.btn-section-cta:hover { background:#1d4ed8; color:#fff; transform:translateY(-3px); box-shadow:0 8px 24px rgba(37,99,235,.35); }
.btn-section-cta--outline {
    background: transparent;
    color: #2563eb;
    border: 2px solid #2563eb;
    box-shadow: none;
}
.btn-section-cta--outline:hover { background:#2563eb; color:#fff; }

/* -------------------------------------------------------
   TOOL CARDS — redesigned with gradient header
   ------------------------------------------------------- */
.home-card {
    background: #fff;
    border-radius: 20px;
    padding: 0;
    border: 1.5px solid #e2e8f0;
    transition: all .3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.home-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 48px rgba(0,0,0,.12);
    border-color: transparent;
}

/* Gradient header band */
.home-card__head {
    padding: 1.5rem 1.75rem 1.25rem;
    display: flex; align-items: center; gap: 1rem;
}
.home-card--blue  .home-card__head { background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); }
.home-card--red   .home-card__head { background: linear-gradient(135deg, #fee2e2 0%, #fff1f2 100%); }
.home-card--teal  .home-card__head { background: linear-gradient(135deg, #ccfbf1 0%, #f0fdfa 100%); }
.home-card--amber .home-card__head { background: linear-gradient(135deg, #fef3c7 0%, #fffbeb 100%); }
.home-card--purple .home-card__head { background: linear-gradient(135deg, #ede9fe 0%, #faf5ff 100%); }

.home-card__icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.home-card--blue  .home-card__icon { background:#2563eb1a; color:#2563eb; }
.home-card--red   .home-card__icon { background:#ef44441a; color:#ef4444; }
.home-card--teal  .home-card__icon { background:#0d94881a; color:#0d9488; }
.home-card--amber .home-card__icon { background:#f59e0b1a; color:#f59e0b; }
.home-card--purple .home-card__icon { background:#8b5cf61a; color:#8b5cf6; }

.home-card h4 { font-size: 1.05rem; font-weight: 800; color: #0f172a; margin: 0; }
.home-card__badge { font-size: .72rem; font-weight: 700; padding: 2px 10px; border-radius: 50px; margin-top: 4px; display: inline-block; }
.home-card--blue  .home-card__badge { background:#dbeafe; color:#2563eb; }
.home-card--red   .home-card__badge { background:#fee2e2; color:#ef4444; }
.home-card--teal  .home-card__badge { background:#ccfbf1; color:#0d9488; }
.home-card--amber .home-card__badge { background:#fef3c7; color:#f59e0b; }

/* Tool list links */
.home-card__body { padding: 1rem 1.75rem; flex: 1; }
.home-card ul { list-style: none; padding: 0; margin: 0; }
.home-card ul li { margin-bottom: 2px; }
.home-card ul li a {
    display: flex; align-items: center; gap: 8px;
    padding: 6px 8px; border-radius: 8px;
    color: #475569; font-size: .88rem; font-weight: 500;
    text-decoration: none; transition: all .15s;
}
.home-card ul li a:hover {
    background: #eff6ff; color: #2563eb;
    padding-left: 14px;
}
.home-card ul li a i { width: 16px; flex-shrink: 0; font-size: .85rem; }

/* Footer */
.home-card__footer {
    padding: .85rem 1.75rem 1.25rem;
    border-top: 1px solid #f1f5f9;
}
.home-card__btn {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: .85rem; font-weight: 700;
    padding: 8px 18px; border-radius: 8px;
    text-decoration: none; transition: all .2s;
    border: 2px solid currentColor;
}
.home-card--blue  .home-card__btn { color:#2563eb; }
.home-card--red   .home-card__btn { color:#ef4444; }
.home-card--teal  .home-card__btn { color:#0d9488; }
.home-card--amber .home-card__btn { color:#f59e0b; }
.home-card__btn:hover { color:#fff !important; }
.home-card--blue  .home-card__btn:hover { background:#2563eb; border-color:#2563eb; }
.home-card--red   .home-card__btn:hover { background:#ef4444; border-color:#ef4444; }
.home-card--teal  .home-card__btn:hover { background:#0d9488; border-color:#0d9488; }
.home-card--amber .home-card__btn:hover { background:#f59e0b; border-color:#f59e0b; }

/* -------------------------------------------------------
   PROJECT CARDS
   ------------------------------------------------------- */
.proj-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.75rem;
    border: 1.5px solid #e2e8f0;
    transition: all .3s ease;
}
.proj-card:hover { transform:translateY(-6px); box-shadow:0 16px 40px rgba(0,0,0,.1); border-color:#2563eb33; }
.proj-card__icon {
    width: 52px; height: 52px;
    border-radius: 12px;
    display: flex; align-items:center; justify-content:center;
    font-size: 1.4rem;
    margin-bottom: 1rem;
}
.proj-card h5 { font-weight: 700; color:#0f172a; margin-bottom: .5rem; }
.proj-card p  { color: #64748b; font-size: .9rem; margin-bottom: 1rem; flex:1; }
.proj-card__link {
    font-size: .88rem; font-weight: 600; color:#2563eb; text-decoration:none;
    display: inline-flex; align-items:center; gap: 4px;
    transition: gap .2s;
}
.proj-card__link:hover { color:#1d4ed8; gap:8px; }

/* -------------------------------------------------------
   APP PILLS
   ------------------------------------------------------- */
.app-pill {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 18px 10px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    text-decoration: none;
    text-align: center;
    transition: all .25s ease;
}
.app-pill:hover { transform:translateY(-5px); box-shadow:0 10px 28px rgba(0,0,0,.1); border-color:#2563eb44; }
.app-pill__icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items:center; justify-content:center;
    font-size: 1.2rem;
}
.app-pill span { font-size: .78rem; font-weight: 600; color:#374151; line-height:1.3; }

/* -------------------------------------------------------
   TEMPLATE CARDS
   ------------------------------------------------------- */
.tpl-card {
    background: #fff;
    border-radius: 16px;
    padding: 2rem 1.75rem;
    border: 1.5px solid #e2e8f0;
    position: relative;
    overflow: hidden;
    transition: all .3s ease;
}
.tpl-card:hover { transform:translateY(-6px); box-shadow:0 16px 36px rgba(0,0,0,.1); }
.tpl-card__bar { position:absolute; top:0;left:0;right:0; height:4px; border-radius:16px 16px 0 0; }
.tpl-card__icon { font-size: 2rem; margin-bottom: 1rem; }
.tpl-card h5   { font-weight: 700; color:#0f172a; margin-bottom:.5rem; }
.tpl-card p    { color:#64748b; font-size:.9rem; margin-bottom:1rem; }
.tpl-card__link { font-size:.88rem; font-weight:600; text-decoration:none; }
.tpl-card__link:hover { opacity:.8; }

/* -------------------------------------------------------
   AI CARDS
   ------------------------------------------------------- */
.ai-card {
    background: rgba(255,255,255,.06);
    border: 1.5px solid rgba(255,255,255,.12);
    border-radius: 16px;
    padding: 2rem 1.75rem;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    transition: all .3s ease;
    backdrop-filter: blur(6px);
}
.ai-card:hover { background:rgba(255,255,255,.1); transform:translateY(-6px); border-color:rgba(255,255,255,.25); }
.ai-card__icon {
    width: 52px; height: 52px;
    border-radius: 13px;
    display: flex; align-items:center; justify-content:center;
    font-size: 1.4rem;
    margin-bottom: 1rem;
}
.ai-card h5 { font-weight:700; color:#fff; margin-bottom:.5rem; }
.ai-card p  { color:rgba(255,255,255,.65); font-size:.9rem; margin-bottom:1.25rem; flex:1; }
.ai-card__btn {
    display:inline-block;
    color:#fff;
    font-size:.85rem;
    font-weight:700;
    padding:8px 20px;
    border-radius:8px;
    text-decoration:none;
    transition:opacity .2s, transform .2s;
}
.ai-card__btn:hover { opacity:.85; transform:translateY(-2px); color:#fff; }

/* -------------------------------------------------------
   NEWS & MARKET CARDS
   ------------------------------------------------------- */
.nm-card {
    border-radius: 16px;
    padding: 2rem;
    border: 1.5px solid #e2e8f0;
    transition: all .3s ease;
    background: #fff;
}
.nm-card:hover { transform:translateY(-5px); box-shadow:0 14px 36px rgba(0,0,0,.1); }
.nm-card__header { display:flex; align-items:center; gap:12px; margin-bottom:1rem; }
.nm-card__header i { font-size:1.6rem; }
.nm-card__header h4 { font-weight:700; color:#0f172a; margin:0; font-size:1.2rem; }
.nm-card--news  .nm-card__header i { color:#2563eb; }
.nm-card--market .nm-card__header i { color:#10b981; }
.nm-card p { color:#64748b; font-size:.9rem; margin-bottom:1rem; }
.nm-card ul { list-style:none; padding:0; margin-bottom:1.5rem; }
.nm-card ul li { display:flex; align-items:center; gap:8px; padding:6px 0; color:#475569; font-size:.9rem; border-bottom:1px dashed #f1f5f9; }
.nm-card ul li:last-child { border-bottom:none; }
.nm-card ul li i { font-size:.85rem; }
.nm-card--news   ul li i { color:#2563eb; }
.nm-card--market ul li i { color:#10b981; }
.nm-card__btn {
    display:inline-flex; align-items:center; gap:6px;
    font-size:.88rem; font-weight:700; text-decoration:none;
    padding:10px 22px; border-radius:8px; color:#fff;
    transition:all .2s;
}
.nm-card--news   .nm-card__btn { background:#2563eb; }
.nm-card--market .nm-card__btn { background:#10b981; }
.nm-card__btn:hover { opacity:.88; transform:translateY(-2px); color:#fff; }

/* -------------------------------------------------------
   CTA SECTION
   ------------------------------------------------------- */
.cta-section { background: #f8fafc; }
.cta-card {
    background: #fff;
    border-radius: 24px;
    padding: 3.5rem;
    box-shadow: 0 4px 60px rgba(37,99,235,.1);
    border: 1.5px solid #e0e7ff;
}
.cta-title { font-size:clamp(1.8rem,3vw,2.4rem); font-weight:800; color:#0f172a; margin:.75rem 0 1rem; }
.cta-highlight { background:linear-gradient(90deg,#2563eb,#8b5cf6); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.cta-sub { color:#64748b; font-size:1.05rem; margin-bottom:1.5rem; max-width:500px; }
.cta-features { list-style:none; padding:0; margin:0; }
.cta-features li { display:flex; align-items:center; gap:10px; padding:8px 0; color:#374151; font-size:.95rem; }
.cta-features li i { color:#2563eb; font-size:1rem; }

/* CTA visual rings */
.cta-visual { position:relative; width:200px; height:200px; margin:0 auto; }
.cta-visual__ring {
    position:absolute; border-radius:50%;
    border: 2px solid;
    animation: spin 14s linear infinite;
}
.cta-visual__ring--1 { inset:0;          border-color:#dbeafe; animation-duration:14s; }
.cta-visual__ring--2 { inset:20px;        border-color:#c7d2fe; animation-duration:10s; animation-direction:reverse; }
.cta-visual__ring--3 { inset:40px;        border-color:#e0e7ff; animation-duration:8s; }
@keyframes spin { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
.cta-visual__icon {
    position:absolute; inset:0;
    display:flex; align-items:center; justify-content:center;
    font-size:3.5rem; color:#2563eb; opacity:.9;
    animation: none;
}

/* -------------------------------------------------------
   SCROLL REVEAL
   ------------------------------------------------------- */
.reveal {
    opacity: 0;
    transform: translateY(32px);
    transition: opacity .6s ease calc(var(--delay,0s)), transform .6s ease calc(var(--delay,0s));
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Ensure all links and buttons are clickable (no overlay blocking) */
.hero-section a,
.hero-section button,
.home-section a,
.home-section button,
.stats-strip a,
.cta-section a {
    pointer-events: auto !important;
    cursor: pointer !important;
}

/* -------------------------------------------------------
   RESPONSIVE
   ------------------------------------------------------- */
@media (max-width: 768px) {
    .hero-stats { flex-wrap: wrap; justify-content:center; }
    .hero-stat-divider { display:none; }
    .hero-stat { width:50%; padding:10px; }
    .cta-card { padding: 2rem 1.5rem; }
    .hero-scroll-indicator { display:none; }
    .stats-item { border-right:none; border-bottom:1px solid rgba(255,255,255,.1); }
    .stats-item:last-child { border-bottom:none; }
}
</style>
@endpush


@push('scripts')
<script>
// ─── HERO SLIDER ───────────────────────────────────────────
const heroSlides = document.querySelectorAll('.hero-slide');
const heroDots   = document.querySelectorAll('.hero-slider-dot');
let heroCurrent  = 0;

function showHeroSlide(index) {
    heroSlides.forEach((s, i) => {
        s.classList.toggle('active', i === index);
        if (i === index) {
            const img = s.querySelector('img');
            if (img) { img.style.animation = 'none'; img.offsetHeight; img.style.animation = ''; }
        }
    });
    heroDots.forEach((d, i) => d.classList.toggle('active', i === index));
    heroCurrent = index;
}
heroDots.forEach(d => d.addEventListener('click', () => showHeroSlide(+d.dataset.slide)));
if (heroSlides.length > 1) setInterval(() => showHeroSlide((heroCurrent + 1) % heroSlides.length), 6000);

// ─── SMOOTH SCROLL ─────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const t = document.querySelector(a.getAttribute('href'));
        if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});

// ─── SCROLL REVEAL ─────────────────────────────────────────
const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObserver.unobserve(e.target); } });
}, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

// ─── COUNTER ANIMATION ─────────────────────────────────────
function animateCounter(el) {
    const target = +el.dataset.target;
    if (!target) return;
    const duration = 1400;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = Math.floor(current);
        if (current >= target) clearInterval(timer);
    }, 16);
}
const statsObserver = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.querySelectorAll('.stats-num[data-target]').forEach(animateCounter);
            statsObserver.unobserve(e.target);
        }
    });
}, { threshold: 0.2 });
const statsStrip = document.querySelector('.stats-strip');
if (statsStrip) statsObserver.observe(statsStrip);

// ─── LIVE SEARCH SUGGESTIONS ───────────────────────────────
const TOOLS = @json(\App\Http\Controllers\ToolController::fullCatalog());
// Flatten catalog into array [{name, slug, category}]
const toolList = [];
Object.entries(TOOLS).forEach(([cat, tools]) => {
    tools.forEach(t => toolList.push({ name: t.name, slug: t.slug, category: cat, desc: t.description || '' }));
});

const searchInput = document.getElementById('toolSearchInput');
const suggestBox  = document.getElementById('searchSuggestions');

function renderSuggestions(q) {
    suggestBox.innerHTML = '';
    if (!q || q.length < 1) { suggestBox.hidden = true; return; }
    const lower = q.toLowerCase();
    const matches = toolList.filter(t =>
        t.name.toLowerCase().includes(lower) ||
        t.category.toLowerCase().includes(lower) ||
        t.desc.toLowerCase().includes(lower)
    ).slice(0, 8);

    if (!matches.length) { suggestBox.hidden = true; return; }

    matches.forEach((t, i) => {
        const li = document.createElement('li');
        li.setAttribute('role', 'option');
        li.innerHTML = `
            <a href="/tools/${t.slug}" class="search-suggestion-item">
                <span class="suggest-icon"><i class="fa-solid fa-wrench"></i></span>
                <span class="suggest-info">
                    <span class="suggest-name">${t.name.replace(new RegExp(q, 'gi'), m => `<mark>${m}</mark>`)}</span>
                    <span class="suggest-cat">${t.category}</span>
                </span>
                <i class="fa-solid fa-arrow-right suggest-arrow"></i>
            </a>`;
        suggestBox.appendChild(li);
    });
    suggestBox.hidden = false;
}

if (searchInput) {
    searchInput.addEventListener('input', () => renderSuggestions(searchInput.value.trim()));
    searchInput.addEventListener('focus',  () => renderSuggestions(searchInput.value.trim()));
    document.addEventListener('click', e => {
        if (!e.target.closest('#searchForm')) { suggestBox.hidden = true; }
    });
    // keyboard nav
    searchInput.addEventListener('keydown', e => {
        const items = suggestBox.querySelectorAll('a');
        if (!items.length) return;
        if (e.key === 'ArrowDown') { e.preventDefault(); items[0].focus(); }
        if (e.key === 'Escape')    { suggestBox.hidden = true; }
    });
    suggestBox.addEventListener('keydown', e => {
        const items = [...suggestBox.querySelectorAll('a')];
        const idx = items.indexOf(document.activeElement);
        if (e.key === 'ArrowDown' && idx < items.length - 1) { e.preventDefault(); items[idx+1].focus(); }
        if (e.key === 'ArrowUp') { e.preventDefault(); idx > 0 ? items[idx-1].focus() : searchInput.focus(); }
        if (e.key === 'Escape') { suggestBox.hidden = true; searchInput.focus(); }
    });
}

// ─── NAVBAR: transparent on hero, solid on scroll ──────────
const navbar = document.querySelector('.navbar');
function updateNavbar() {
    if (window.scrollY < 60) {
        navbar.classList.add('navbar-transparent');
        navbar.classList.remove('navbar-scrolled');
    } else {
        navbar.classList.remove('navbar-transparent');
        navbar.classList.add('navbar-scrolled');
    }
}
if (navbar) { updateNavbar(); window.addEventListener('scroll', updateNavbar, { passive: true }); }
</script>
@endpush
