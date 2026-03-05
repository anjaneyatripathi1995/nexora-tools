@extends('layouts.user')

@section('title', 'Dashboard')
@section('meta_description', 'Your personalized Nexora Tools dashboard.')

@section('content')
<div class="panel-welcome mb-4">
    <h1 class="h3 fw-bold text-body mb-1">Welcome back, {{ Auth::user()->name ?? 'User' }}</h1>
    <p class="text-muted mb-0 small">Here’s your activity and quick stats.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6 animate-in stagger-1">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ $savedCount ?? 0 }}</div>
                    <div class="panel-card-label">Saved Items</div>
                </div>
                <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                    <i class="fa-solid fa-bookmark"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 animate-in stagger-2">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ $toolsUsedCount ?? 0 }}</div>
                    <div class="panel-card-label">Tools used</div>
                </div>
                <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="fa-solid fa-wrench"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 animate-in stagger-3">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ $totalToolUsages ?? 0 }}</div>
                    <div class="panel-card-label">Total usages</div>
                </div>
                <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6 animate-in stagger-4">
        <a href="{{ route('dashboard.analytics') }}" class="text-decoration-none">
            <div class="panel-card h-100">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="panel-card-value"><small>View</small></div>
                        <div class="panel-card-label">Analytics</div>
                        <span class="panel-card-cta">Open <i class="fa-solid fa-arrow-right"></i></span>
                    </div>
                    <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 animate-in stagger-5">
        <a href="{{ route('dashboard.usages') }}" class="panel-card-cta"><i class="fa-solid fa-list me-1"></i>View all usages</a>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-6 animate-in stagger-5">
        <div class="panel-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-body mb-0">Saved Tools</h5>
                <a href="{{ route('tools.index') }}" class="btn btn-sm btn-outline-primary">All Tools</a>
            </div>
            <div class="row g-2">
                @forelse($savedTools ?? [] as $item)
                <div class="col-12">
                    <a href="{{ route('tools.show', $item->item_slug) }}" class="d-flex align-items-center p-2 rounded-2 text-body text-decoration-none panel-nav-link">
                        <i class="fa-solid fa-wrench me-2 text-primary"></i>
                        <span>{{ Str::title(str_replace('-', ' ', $item->item_slug)) }}</span>
                    </a>
                </div>
                @empty
                <p class="text-muted small mb-0">No saved tools. <a href="{{ route('tools.index') }}">Browse tools</a></p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6 animate-in stagger-6">
        <div class="panel-card h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-body mb-0">Bookmarked Projects</h5>
                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary">All Projects</a>
            </div>
            <div class="row g-2">
                @forelse($savedProjects ?? [] as $item)
                <div class="col-12">
                    <a href="{{ route('projects.show', $item->item_slug) }}" class="d-flex align-items-center p-2 rounded-2 text-body text-decoration-none panel-nav-link">
                        <i class="fa-solid fa-folder me-2 text-success"></i>
                        <span>{{ Str::title(str_replace('-', ' ', $item->item_slug)) }}</span>
                    </a>
                </div>
                @empty
                <p class="text-muted small mb-0">No bookmarks. <a href="{{ route('projects.index') }}">Browse projects</a></p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="animate-in stagger-6">
    <div class="panel-card">
        <h5 class="fw-bold text-body mb-3">Recent Activity</h5>
        <div class="list-group list-group-flush">
            @forelse($recentActivity ?? [] as $act)
            <a href="{{ route('tools.show', $act->tool_slug) }}" class="list-group-item list-group-item-action border-0 px-0 d-flex align-items-center text-body text-decoration-none">
                <i class="fa-solid fa-wrench text-primary me-3"></i>
                <div class="flex-grow-1">
                    <strong>Used {{ $act->tool?->name ?? Str::title(str_replace('-', ' ', $act->tool_slug)) }}</strong>
                    <small class="text-muted d-block">{{ $act->created_at->diffForHumans() }}</small>
                </div>
            </a>
            @empty
            <p class="text-muted mb-0">No recent activity. <a href="{{ route('tools.index') }}">Use a tool</a></p>
            @endforelse
        </div>
    </div>
</div>
@endsection
