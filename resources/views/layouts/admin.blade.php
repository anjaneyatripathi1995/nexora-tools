<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | TechHub Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <!-- early theme script to prevent flash -->
    <script>
        (function(){
            var t = localStorage.getItem('theme');
            if(!t) {
                t = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            if(t === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            }
        })();
    </script>
</head>
<body class="bg-light">
<div class="panel-wrap">
    <!-- Sidebar - no header, clean nav -->
    <aside class="panel-sidebar" id="adminSidebar">
        <div class="panel-sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center text-decoration-none text-body flex-grow-1">
                <div class="avatar" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div class="info">
                    <div class="name">TechHub</div>
                    <div class="role">Admin Panel</div>
                </div>
            </a>
            <a href="#" class="text-muted ms-2" title="Settings"><i class="fa-solid fa-gear"></i></a>
        </div>
        <nav class="panel-sidebar-nav">
            <div class="panel-nav-section">
                <div class="panel-nav-section-title">Main</div>
                <a href="{{ route('admin.dashboard') }}" class="panel-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i> Dashboard
                </a>
            </div>
            <div class="panel-nav-section">
                <div class="panel-nav-section-title">Content</div>
                @if(auth()->user()->canManage('tools'))
                <a href="{{ route('admin.tools.index') }}" class="panel-nav-link {{ request()->routeIs('admin.tools.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-wrench"></i> Tools
                </a>
                @endif
                @if(auth()->user()->canManage('projects'))
                <a href="{{ route('admin.projects.index') }}" class="panel-nav-link {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-folder"></i> Projects
                </a>
                @endif
                @if(auth()->user()->canManage('apps'))
                <a href="{{ route('admin.apps.index') }}" class="panel-nav-link {{ request()->routeIs('admin.apps.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-mobile-screen"></i> Apps
                </a>
                @endif
                @if(auth()->user()->canManage('templates'))
                <a href="{{ route('admin.templates.index') }}" class="panel-nav-link {{ request()->routeIs('admin.templates.index') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-code"></i> Templates
                </a>
                @endif
            </div>
            @if(auth()->user()->isMasterAdmin())
            <div class="panel-nav-section">
                <div class="panel-nav-section-title">System</div>
                <a href="{{ route('admin.admins.index') }}" class="panel-nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-cog"></i> Manage Admins
                </a>
            </div>
            @endif
        </nav>
        <div class="panel-footer">
            <a href="{{ url('/') }}" class="text-decoration-none"><i class="fa-solid fa-external-link me-1"></i> View Site</a>
            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-user me-1"></i> My Dashboard</a>
        </div>
    </aside>

    <div class="panel-main">
        <!-- Minimal topbar - no big header -->
        <header class="panel-topbar">
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="panel-sidebar-toggle d-lg-none" id="sidebarToggle" aria-label="Toggle menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="panel-topbar-brand d-none d-lg-block">@yield('title', 'Dashboard')</div>
            </div>

            <div class="d-flex align-items-center flex-grow-1 justify-content-center">
                <div class="panel-topbar-search d-none d-md-flex w-50">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search..." class="form-control border-0 bg-transparent">
                </div>
            </div>

            <div class="panel-topbar-actions ms-auto">
                <a href="#" title="Language"><i class="fa-solid fa-flag-usa"></i></a>
                <a href="#" title="Shortcuts"><i class="fa-solid fa-share-nodes"></i></a>
                <a href="#" title="Cart" class="position-relative"><i class="fa-solid fa-cart-shopping"></i><span class="badge bg-danger" style="position: absolute; top: -6px; right: -6px; font-size: 10px;">4</span></a>
                <a href="#" title="Toggle theme" data-theme-toggle><i class="fa-solid fa-moon"></i></a>
                <a href="#" title="Notifications"><i class="fa-solid fa-bell"></i></a>
                <a href="{{ url('/') }}" class="text-decoration-none d-none d-lg-inline" title="View site"><i class="fa-solid fa-external-link"></i></a>
                <div class="dropdown">
                    <button class="dropdown-toggle border-0 bg-transparent p-0 d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown">
                        <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 py-2" style="min-width: 220px;">
                        <li class="px-3 py-2 border-bottom">
                            <div class="fw-semibold text-body">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profile') }}"><i class="fa-solid fa-user me-2 text-muted"></i> Profile</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge me-2 text-muted"></i> My Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">@csrf<button type="submit" class="dropdown-item py-2 text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i> Log out</button></form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <main class="panel-content">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<div class="panel-sidebar-overlay d-lg-none" id="adminSidebarOverlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 999; opacity: 0; transition: opacity 0.3s ease;"></div>
@stack('scripts')
<script>
(function() {
    var sidebar = document.getElementById('adminSidebar');
    var toggle = document.getElementById('sidebarToggle');
    var overlay = document.getElementById('adminSidebarOverlay');
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
