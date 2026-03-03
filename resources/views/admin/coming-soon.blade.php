@extends('layouts.admin')

@section('title', 'Manage ' . $section)

@section('content')
<div class="panel-welcome mb-4">
    <h1 class="h3 fw-bold text-body mb-1">Manage {{ $section }}</h1>
    <p class="text-muted mb-0 small">This section is coming soon.</p>
</div>
<div class="panel-card">
    <div class="card-body text-center py-5">
        <i class="fa-solid fa-hourglass-half fa-3x text-muted mb-3"></i>
        <h4>Manage {{ $section }}</h4>
        <p class="text-muted mb-0">This section is coming soon. You will be able to manage {{ strtolower($section) }} from here.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
</div>
@endsection
