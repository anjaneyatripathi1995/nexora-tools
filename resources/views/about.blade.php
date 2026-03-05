@extends('layouts.app')

@section('title', 'About Us — Tripathi Nexora Technologies')
@section('meta_description', 'Tripathi Nexora Technologies is a forward-thinking digital solutions company building scalable web platforms, SaaS products, and intelligent technology systems.')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────── --}}
<section class="about-hero">
    <div class="about-hero__bg" aria-hidden="true"></div>
    <div class="container position-relative" style="z-index:2">
        <div class="row justify-content-center text-center">
            <div class="col-lg-9">
                <div class="about-hero__eyebrow">Tripathi Nexora Technologies</div>
                <h1 class="about-hero__title">
                    Engineering the <span class="about-hero__accent">Next Era</span><br>of Digital Innovation
                </h1>
                <p class="about-hero__lead">
                    We deliver scalable SaaS solutions, web platforms, and all-in-one tech utilities
                    for businesses and individuals — built for the future, ready today.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
                    <a href="{{ route('tools.index') }}" class="btn btn-primary btn-lg px-4">
                        <i class="fa-solid fa-rocket me-2"></i>Explore Our Products
                    </a>
                    <a href="mailto:contact@tripathinexora.com" class="btn btn-outline-light btn-lg px-4">
                        <i class="fa-solid fa-phone me-2"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-- Floating stat cards --}}
    <div class="container position-relative" style="z-index:2;margin-top:3rem">
        <div class="row justify-content-center g-3">
            @foreach([
                ['value'=>'32+','label'=>'Free Tools','icon'=>'fa-wrench'],
                ['value'=>'7+','label'=>'Projects Built','icon'=>'fa-briefcase'],
                ['value'=>'21+','label'=>'App Solutions','icon'=>'fa-mobile-screen'],
                ['value'=>'100%','label'=>'Client Focus','icon'=>'fa-heart'],
            ] as $stat)
            <div class="col-6 col-md-3">
                <div class="about-stat-card">
                    <i class="fa-solid {{ $stat['icon'] }} about-stat-icon"></i>
                    <div class="about-stat-value">{{ $stat['value'] }}</div>
                    <div class="about-stat-label">{{ $stat['label'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── WHO WE ARE ─────────────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="section-eyebrow">About Us</div>
                <h2 class="section-title-lg">Who We Are</h2>
                <p class="text-muted lh-lg mb-3">
                    <strong>Tripathi Nexora Technologies</strong> is a forward-thinking digital solutions company
                    focused on building the next generation of scalable web platforms, SaaS products, and
                    intelligent technology systems.
                </p>
                <p class="text-muted lh-lg mb-3">
                    Founded with a vision to engineer innovative and practical digital solutions, we specialise in
                    web development, automation tools, cloud-ready applications, and all-in-one technology utilities
                    designed to simplify modern digital needs.
                </p>
                <p class="text-muted lh-lg mb-4">
                    Our mission is to bridge the gap between powerful technology and real-world usability by creating
                    solutions that are <strong>secure, scalable, and performance-driven</strong>.
                </p>
                <div class="d-flex gap-3 align-items-center flex-wrap">
                    <div class="about-badge"><i class="fa-solid fa-shield-halved me-2 text-primary"></i>Secure</div>
                    <div class="about-badge"><i class="fa-solid fa-arrows-up-down me-2 text-primary"></i>Scalable</div>
                    <div class="about-badge"><i class="fa-solid fa-bolt me-2 text-primary"></i>Performance-Driven</div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-card-grid">
                    <div class="about-info-card about-info-card--blue">
                        <i class="fa-solid fa-bullseye fa-2x mb-3"></i>
                        <h5 class="fw-700">Our Mission</h5>
                        <p class="mb-0 small opacity-90">Bridge the gap between powerful technology and real-world usability — making digital tools accessible to everyone.</p>
                    </div>
                    <div class="about-info-card about-info-card--purple">
                        <i class="fa-solid fa-eye fa-2x mb-3"></i>
                        <h5 class="fw-700">Our Vision</h5>
                        <p class="mb-0 small opacity-90">Build future-ready digital ecosystems — not just software, but scalable platforms that grow with your business.</p>
                    </div>
                    <div class="about-info-card about-info-card--teal">
                        <i class="fa-solid fa-gem fa-2x mb-3"></i>
                        <h5 class="fw-700">Our Values</h5>
                        <p class="mb-0 small opacity-90">Innovation, reliability, transparency, and an obsession with quality — in every line of code we ship.</p>
                    </div>
                    <div class="about-info-card about-info-card--dark">
                        <i class="fa-solid fa-map-location-dot fa-2x mb-3"></i>
                        <h5 class="fw-700">Our Base</h5>
                        <p class="mb-0 small opacity-90">D-71, 3rd Floor, West Vinod Nagar,<br>Delhi – 110092, India</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── BRAND MEANING ──────────────────────────────────────── --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">Brand Identity</div>
                <h2 class="section-title-lg">What Our Name Stands For</h2>
                <p class="text-muted">Every word in our name carries purpose and direction.</p>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            @foreach([
                ['word'=>'Tripathi','icon'=>'fa-user-tie','color'=>'primary','meaning'=>'Personal authority & trust — the human commitment behind every product we ship.'],
                ['word'=>'Nexora','icon'=>'fa-arrow-trend-up','color'=>'purple','meaning'=>'"Next Era of Innovation" — we build for tomorrow, not just today.'],
                ['word'=>'Technologies','icon'=>'fa-microchip','color'=>'teal','meaning'=>'Corporate-level service capability — enterprise-grade quality for every client.'],
            ] as $item)
            <div class="col-md-4">
                <div class="brand-word-card">
                    <div class="brand-word-icon brand-word-icon--{{ $item['color'] }}">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                    </div>
                    <h4 class="brand-word fw-800 mt-3 mb-2">{{ $item['word'] }}</h4>
                    <p class="text-muted small mb-0">{{ $item['meaning'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="brand-tagline-box">
                    <i class="fa-solid fa-quote-left text-primary opacity-50 fa-2x mb-3"></i>
                    <p class="brand-tagline">"Delivering next-generation technology solutions."</p>
                    <p class="text-muted small">— Tripathi Nexora Technologies Brand Promise</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── SERVICES ────────────────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">What We Do</div>
                <h2 class="section-title-lg">Our Services</h2>
                <p class="text-muted">End-to-end digital solutions — from concept to deployment.</p>
            </div>
        </div>
        <div class="row g-4">
            @php
            $services = [
                ['icon'=>'fa-code','color'=>'blue','title'=>'Web Development','desc'=>'Custom, high-performance websites and web applications built with modern frameworks — Laravel, React, Vue.js and more. Mobile-first, SEO-ready, and built to scale.','points'=>['Custom Web Applications','E-commerce Platforms','REST API Development','Frontend & Backend Engineering']],
                ['icon'=>'fa-cloud','color'=>'purple','title'=>'SaaS Product Development','desc'=>'End-to-end SaaS product design and development — from MVP to enterprise-scale. We architect systems that handle millions of users without breaking a sweat.','points'=>['Product Architecture','Multi-tenant SaaS','Subscription Billing','Dashboard & Analytics']],
                ['icon'=>'fa-robot','color'=>'teal','title'=>'AI & Automation Tools','desc'=>'Intelligent automation solutions — chatbots, document processing, workflow automation, and AI-powered utilities that save hours of manual work.','points'=>['AI Content Tools','Process Automation','Smart Workflows','Data Processing Pipelines']],
                ['icon'=>'fa-handshake','color'=>'orange','title'=>'IT Consulting & Digital Solutions','desc'=>'Strategic technology consulting for businesses ready to go digital — from cloud migration and infrastructure planning to tech stack selection and digital transformation.','points'=>['Technology Strategy','Cloud Migration','Digital Transformation','Performance Audits']],
            ];
            @endphp
            @foreach($services as $svc)
            <div class="col-md-6">
                <div class="service-card h-100">
                    <div class="service-card__icon service-card__icon--{{ $svc['color'] }}">
                        <i class="fa-solid {{ $svc['icon'] }}"></i>
                    </div>
                    <h4 class="service-card__title">{{ $svc['title'] }}</h4>
                    <p class="service-card__desc text-muted">{{ $svc['desc'] }}</p>
                    <ul class="service-card__list">
                        @foreach($svc['points'] as $p)
                        <li><i class="fa-solid fa-check-circle text-success me-2"></i>{{ $p }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── PRODUCT SHOWCASE ─────────────────────────────────────── --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">Our Products</div>
                <h2 class="section-title-lg">What We've Built</h2>
                <p class="text-muted">Flagship product — Nexora Tools, under Tripathi Nexora Technologies.</p>
            </div>
        </div>

        {{-- Main product --}}
        <div class="row align-items-center g-5 mb-5">
            <div class="col-lg-6">
                <div class="product-main-card">
                    <div class="product-main-card__badge">Flagship Product</div>
                    <div class="product-main-card__icon">
                        <i class="fa-solid fa-layer-group fa-3x text-white"></i>
                    </div>
                    <h3 class="fw-800 mt-3 mb-2">Nexora Tools</h3>
                    <p class="text-muted mb-0">All-in-One Tech Utility Platform</p>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="fw-700 mb-3">The All-in-One Tech Platform for Developers & Creators</h4>
                <p class="text-muted mb-4">
                    Nexora Tools is our flagship product — a comprehensive web platform offering 32+ free online tools
                    across finance, PDF, developer utilities, image processing, text tools, and AI-powered features.
                    Built for speed, simplicity, and scale.
                </p>
                <div class="row g-3">
                    @foreach([
                        ['icon'=>'fa-envelope','color'=>'primary','name'=>'Temp Mail','desc'=>'Disposable email in seconds'],
                        ['icon'=>'fa-calculator','color'=>'success','name'=>'Finance Calculators','desc'=>'EMI, SIP, GST & more'],
                        ['icon'=>'fa-code','color'=>'warning','name'=>'Developer Utilities','desc'=>'JSON, Base64, UUID, Regex'],
                        ['icon'=>'fa-file-pdf','color'=>'danger','name'=>'PDF Tools','desc'=>'Merge, split, compress PDFs'],
                    ] as $prod)
                    <div class="col-sm-6">
                        <div class="product-mini-card">
                            <div class="product-mini-icon text-{{ $prod['color'] }}"><i class="fa-solid {{ $prod['icon'] }}"></i></div>
                            <div>
                                <div class="fw-700 small">{{ $prod['name'] }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $prod['desc'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('tools.index') }}" class="btn btn-primary mt-4">
                    <i class="fa-solid fa-arrow-right me-2"></i>Explore All Tools
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ────────────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">Why Us</div>
                <h2 class="section-title-lg">Why Choose Tripathi Nexora Technologies</h2>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['icon'=>'fa-lightbulb','color'=>'yellow','title'=>'Innovation-Driven','desc'=>'We don\'t follow trends — we set them. Every solution is built with emerging technologies and forward-looking design principles.'],
                ['icon'=>'fa-arrows-up-down','color'=>'blue','title'=>'Scalable Architecture','desc'=>'Our products are architected to grow with your needs — from prototype to millions of users without re-engineering from scratch.'],
                ['icon'=>'fa-shield-halved','color'=>'green','title'=>'Secure & Reliable','desc'=>'Security is not an afterthought. We implement industry best practices — encryption, access controls, and vulnerability testing at every layer.'],
                ['icon'=>'fa-microchip','color'=>'purple','title'=>'Modern Tech Stack','desc'=>'Laravel, React, Vue.js, AI APIs, Cloud infrastructure — we use the right tools for the job, not just what\'s comfortable.'],
                ['icon'=>'fa-handshake','color'=>'orange','title'=>'Client-First Approach','desc'=>'Your success is our metric. We build relationships, not just deliverables — with transparent communication at every stage.'],
                ['icon'=>'fa-rocket','color'=>'red','title'=>'Fast Delivery','desc'=>'Agile development, rapid prototyping, and lean execution — we ship working products faster than traditional agencies.'],
            ] as $why)
            <div class="col-sm-6 col-lg-4">
                <div class="why-card">
                    <div class="why-card__icon why-card__icon--{{ $why['color'] }}">
                        <i class="fa-solid {{ $why['icon'] }}"></i>
                    </div>
                    <h5 class="why-card__title">{{ $why['title'] }}</h5>
                    <p class="why-card__desc">{{ $why['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── TECH STACK ───────────────────────────────────────────── --}}
<section class="py-5" style="background:#f8fafc">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">Technology</div>
                <h2 class="section-title-lg">Our Tech Stack</h2>
                <p class="text-muted">Enterprise-grade technologies powering every product we build.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="tech-stack-grid">
                    @foreach([
                        ['icon'=>'fa-brands fa-laravel','label'=>'Laravel','color'=>'#ef4444'],
                        ['icon'=>'fa-brands fa-react','label'=>'React','color'=>'#38bdf8'],
                        ['icon'=>'fa-brands fa-vuejs','label'=>'Vue.js','color'=>'#4ade80'],
                        ['icon'=>'fa-brands fa-node','label'=>'Node.js','color'=>'#86efac'],
                        ['icon'=>'fa-solid fa-database','label'=>'MySQL','color'=>'#60a5fa'],
                        ['icon'=>'fa-brands fa-php','label'=>'PHP','color'=>'#818cf8'],
                        ['icon'=>'fa-solid fa-cloud','label'=>'Cloud','color'=>'#38bdf8'],
                        ['icon'=>'fa-solid fa-robot','label'=>'AI APIs','color'=>'#c084fc'],
                        ['icon'=>'fa-brands fa-git-alt','label'=>'Git','color'=>'#fb923c'],
                        ['icon'=>'fa-brands fa-bootstrap','label'=>'Bootstrap','color'=>'#a78bfa'],
                    ] as $tech)
                    <div class="tech-chip">
                        <i class="{{ $tech['icon'] }}" style="color:{{ $tech['color'] }};font-size:1.4rem"></i>
                        <span>{{ $tech['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CONTACT INFO ─────────────────────────────────────────── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="section-eyebrow">Get In Touch</div>
                <h2 class="section-title-lg">Contact Tripathi Nexora Technologies</h2>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-sm-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="contact-info-card__icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="fw-700 mb-1">General Enquiries</div>
                    <a href="mailto:contact@tripathinexora.com" class="text-primary small text-decoration-none">contact@tripathinexora.com</a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="contact-info-card__icon"><i class="fa-solid fa-headset"></i></div>
                    <div class="fw-700 mb-1">Support</div>
                    <a href="mailto:support@tripathinexora.com" class="text-primary small text-decoration-none">support@tripathinexora.com</a>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="contact-info-card__icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="fw-700 mb-1">Address</div>
                    <p class="text-muted small mb-0">D-71, 3rd Floor, West Vinod Nagar, Delhi – 110092, India</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="contact-info-card">
                    <div class="contact-info-card__icon"><i class="fa-brands fa-linkedin"></i></div>
                    <div class="fw-700 mb-1">LinkedIn</div>
                    <a href="#" class="text-primary small text-decoration-none">Tripathi Nexora Technologies</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── CALL TO ACTION ───────────────────────────────────────── --}}
<section class="about-cta">
    <div class="about-cta__bg" aria-hidden="true"></div>
    <div class="container position-relative text-center" style="z-index:2">
        <h2 class="about-cta__title">Let's Build the Future Together.</h2>
        <p class="about-cta__sub">
            Whether you need a web platform, a SaaS product, or just the right tech utility —<br>
            Tripathi Nexora Technologies is ready to engineer it for you.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap mt-4">
            <a href="mailto:contact@tripathinexora.com" class="btn btn-white btn-lg px-5">
                <i class="fa-solid fa-envelope me-2"></i>Contact Us
            </a>
            <a href="{{ route('tools.index') }}" class="btn btn-outline-light btn-lg px-5">
                <i class="fa-solid fa-wrench me-2"></i>Try Our Tools
            </a>
        </div>
    </div>
</section>

@endsection
