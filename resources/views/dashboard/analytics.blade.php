@extends('layouts.user')

@section('title', 'Analytics')
@section('meta_description', 'Your usage analytics')

@section('content')
<div class="panel-welcome mb-4">
    <h1 class="h3 fw-bold text-body mb-1">Analytics</h1>
    <p class="text-muted mb-0 small">Your tool usage at a glance.</p>
</div>
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Dashboard</a>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="panel-card h-100">
            <div class="panel-card-value">{{ $total ?? 0 }}</div>
            <div class="panel-card-label">Total tool runs</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel-card h-100">
            <div class="panel-card-value">{{ ($byTool ?? collect())->count() }}</div>
            <div class="panel-card-label">Different tools used</div>
        </div>
    </div>
</div>
<div class="panel-card">
    <h5 class="fw-bold text-body mb-3">Most used tools</h5>
    <div class="list-group list-group-flush">
        @forelse($byTool ?? [] as $row)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('tools.show', ['slug' => $row->tool_slug]) }}" class="text-decoration-none text-body">
                {{ \Illuminate\Support\Str::title(str_replace('-', ' ', $row->tool_slug)) }}
            </a>
            <span class="badge bg-primary rounded-pill">{{ $row->count }} {{ $row->count === 1 ? 'time' : 'times' }}</span>
        </div>
        @empty
        <div class="list-group-item text-muted text-center py-4">No usage data yet. <a href="{{ route('tools.index') }}">Use tools</a> to see analytics here.</div>
        @endforelse
    </div>
</div>
@endsection
