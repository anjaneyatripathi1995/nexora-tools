<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Nexora Tools</title>
    <meta name="description" content="@yield('meta_description', 'Your dashboard')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-light">
<div class="panel-wrap">
    <aside class="panel-sidebar" id="userSidebar">
        <a href="{{ route('dashboard') }}" class="panel-sidebar-header text-decoration-none text-body">
            <div class="avatar" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="info">
                <div class="name">{{ auth()->user()->name ?? 'User' }}</div>
                <div class="role">Member</div>
            </div>
        </a>
        <nav class="panel-sidebar-nav">
            <div class="panel-nav-section">
                <div class="panel-nav-section-title">Dashboard</div>
                <a href="{{ route('dashboard') }}" class="panel-nav-link {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> Overview
                </a>
                <a href="{{ route('dashboard.usages') }}" class="panel-nav-link {{ request()->routeIs('dashboard.usages') ? 'active' : '' }}">
                    <i class="fa-solid fa-list"></i> Usages
                </a>
                <a href="{{ route('dashboard.analytics') }}" class="panel-nav-link {{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Analytics
                </a>
            </div>
            <div class="panel-nav-section">
                <div class="panel-nav-section-title">Explore</div>
                <a href="{{ route('tools.index') }}" class="panel-nav-link"><i class="fa-solid fa-wrench"></i> Tools</a>
                <a href="{{ url('/') }}" class="panel-nav-link"><i class="fa-solid fa-home"></i> Home</a>
            </div>
        </nav>
        <div class="panel-footer">
            <a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-1"></i> Profile</a>
        </div>
    </aside>

    <div class="panel-main">
        <header class="panel-topbar">
            <button type="button" class="panel-sidebar-toggle d-lg-none" id="userSidebarToggle" aria-label="Toggle menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="panel-topbar-brand d-none d-lg-block">@yield('title', 'Dashboard')</div>
            <div class="panel-topbar-actions ms-auto">
                <a href="{{ url('/') }}" class="text-decoration-none" title="Home"><i class="fa-solid fa-external-link"></i></a>
                <div class="dropdown">
                    <button class="dropdown-toggle border-0 bg-transparent p-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <div class="avatar-sm" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #fff;">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 py-2" style="min-width: 200px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold text-body">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">@csrf<button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Log out</button></form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="panel-content">
            @yield('content')
        </main>
    </div>
</div>
<div class="panel-sidebar-overlay d-lg-none" id="userSidebarOverlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; transition: opacity 0.3s ease;"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
(function() {
    var sidebar = document.getElementById('userSidebar');
    var toggle = document.getElementById('userSidebarToggle');
    var overlay = document.getElementById('userSidebarOverlay');
    if (toggle) toggle.addEventListener('click', function() {
        sidebar.classList.toggle('open');
        if (overlay) { overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none'; setTimeout(function() { overlay.style.opacity = sidebar.classList.contains('open') ? '1' : '0'; }, 10); }
    });
    if (overlay) overlay.addEventListener('click', function() {
        sidebar.classList.remove('open');
        overlay.style.opacity = '0';
        setTimeout(function() { overlay.style.display = 'none'; }, 300);
    });
})();
</script>
</body>
</html>
