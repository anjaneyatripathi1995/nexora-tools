@extends('layouts.app')

@section('title', 'Web & Mobile Projects')
@section('meta_description', 'Explore full-stack web and mobile projects by Tripathi Nexora Technologies — source code, demos and APKs.')

@section('content')
<div class="sub-banner">
    <div class="sub-banner__overlay"></div>
    <div class="container">
        <div class="sub-banner__content">
            <div class="sub-banner__anim">
                <h1 class="sub-banner__title">Web &amp; Mobile <span class="text-primary">Projects</span></h1>
                <p class="sub-banner__sub">Real-world projects with full source code, live demos, and documentation.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($projects as $project)
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('projects.show', $project['slug']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-3 p-3 bg-{{ $project['color'] }} bg-opacity-10">
                                    <i class="fa-solid {{ $project['icon'] }} fa-2x text-{{ $project['color'] }}"></i>
                                </div>
                                <h5 class="mb-0 fw-700 text-dark">{{ $project['name'] }}</h5>
                            </div>
                            <p class="text-muted small mb-3">{{ $project['description'] }}</p>
                            <ul class="list-unstyled mb-0">
                                @foreach(array_slice($project['features'], 0, 3) as $f)
                                <li class="small text-muted mb-1"><i class="fa-solid fa-check text-success me-2"></i>{{ $f }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <span class="btn btn-outline-{{ $project['color'] }} btn-sm w-100">View Project <i class="fa-solid fa-arrow-right ms-1"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
