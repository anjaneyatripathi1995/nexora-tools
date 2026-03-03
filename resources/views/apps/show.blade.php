@extends('layouts.app')

@section('title', $app['name'])

@section('content')
<div class="container py-5 mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="project-detail-card">
                <div class="text-center mb-4">
                    <i class="fa-solid {{ $app['icon'] }} fa-5x text-{{ $app['color'] }} mb-3"></i>
                    <h1 class="display-4 fw-bold">{{ $app['name'] }}</h1>
                    <p class="lead text-muted">{{ $app['description'] }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold mb-3">Features</h3>
                    <ul class="list-unstyled">
                        @foreach($app['features'] as $feature)
                        <li class="mb-2">
                            <i class="fa-solid fa-check-circle text-success me-2"></i>{{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mb-4">
                    <h3 class="fw-bold mb-3">Tech Stack</h3>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($app['tech_stack'] as $tech)
                        <span class="badge bg-{{ $app['color'] }} fs-6">{{ $tech }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ $app['demo_url'] }}" class="btn btn-{{ $app['color'] }} btn-lg">
                        <i class="fa-solid fa-play me-2"></i>Coming Soon
                    </a>
                    <a href="{{ $app['apk_url'] }}" class="btn btn-success btn-lg">
                        <i class="fa-solid fa-download me-2"></i>Coming Soon
                    </a>
                    <a href="{{ $app['github_url'] }}" class="btn btn-outline-light btn-lg">
                        <i class="fa-brands fa-github me-2"></i>Coming Soon
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
