@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="panel-welcome mb-4">
    <h1 class="h3 fw-bold text-body mb-1">Welcome back, {{ auth()->user()->name }}</h1>
    <p class="text-muted mb-0 small">Here’s what’s happening with your content today.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 animate-in stagger-1">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ $stats['tools_count'] }}</div>
                    <div class="panel-card-label">Tools</div>
                    <a href="{{ route('admin.tools.index') }}" class="panel-card-cta">Manage <i class="fa-solid fa-arrow-right"></i></a>
                </div>
                <div class="panel-card-icon-wrap bg-primary pulse" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%) !important;">
                    <i class="fa-solid fa-wrench"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-in stagger-2">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ $stats['users_count'] }}</div>
                    <div class="panel-card-label">Users</div>
                </div>
                <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 animate-in stagger-3">
        <div class="panel-card h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="panel-card-value">{{ number_format($stats['usages_count']) }}</div>
                    <div class="panel-card-label">Total tool usages</div>
                </div>
                <div class="panel-card-icon-wrap" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<h5 class="fw-bold text-body mb-3 animate-in stagger-4">Manage content</h5>
<div class="row g-3">
    @forelse($sections as $section)
    <div class="col-md-6 col-lg-3 animate-in stagger-{{ min(5, 4 + $loop->index) }}">
        <a href="{{ route($section['route']) }}" class="text-decoration-none">
            <div class="panel-card h-100 text-center">
                <div class="panel-card-icon-wrap mx-auto mb-2" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                    <i class="fa-solid {{ $section['icon'] }}"></i>
                </div>
                <h6 class="mb-0 text-body">{{ $section['name'] }}</h6>
            </div>
        </a>
    </div>
    @empty
    <div class="col-12 animate-in stagger-5">
        <div class="panel-card">
            <p class="text-muted mb-0">No sections assigned to your account. Contact an administrator.</p>
        </div>
    </div>
    @endforelse
</div>
@endsection
