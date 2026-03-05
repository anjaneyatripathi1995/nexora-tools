@extends('layouts.app')

@section('title', $template['name'])
@section('meta_description', $template['description'])

@section('content')
<div class="sub-banner">
    <div class="sub-banner__overlay"></div>
    <div class="container">
        <div class="sub-banner__content">
            <div class="sub-banner__anim">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb mb-0 justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('templates.index') }}" class="text-white-50 text-decoration-none">Templates</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $template['name'] }}</li>
                    </ol>
                </nav>
                <h1 class="sub-banner__title">{{ $template['name'] }}</h1>
                <p class="sub-banner__sub">{{ $template['description'] }}</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body bg-{{ $template['preview_color'] }} bg-opacity-10 d-flex align-items-center justify-content-center" style="min-height:320px;border-radius:12px">
                        <i class="fa-solid fa-palette fa-5x text-{{ $template['preview_color'] }} opacity-50"></i>
                    </div>
                </div>
                <div class="row g-3">
                    @foreach(['image_1','image_2','image_3'] as $img)
                    <div class="col-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body bg-light d-flex align-items-center justify-content-center" style="min-height:100px;border-radius:8px">
                                <i class="fa-solid fa-image fa-2x text-muted"></i>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h4 class="fw-800 mb-1">{{ $template['name'] }}</h4>
                    <span class="badge bg-{{ $template['preview_color'] }} bg-opacity-15 text-{{ $template['preview_color'] }} mb-3">{{ $template['category'] }}</span>
                    <p class="text-muted small mb-4">{{ $template['description'] }}</p>

                    <h6 class="fw-700 mb-3">Features</h6>
                    <ul class="list-unstyled mb-4">
                        @foreach($template['features'] as $f)
                        <li class="mb-2 small"><i class="fa-solid fa-check-circle text-success me-2"></i>{{ $f }}</li>
                        @endforeach
                    </ul>

                    <div class="d-grid gap-2">
                        <a href="{{ $template['preview_url'] }}" class="btn btn-{{ $template['preview_color'] }}" target="_blank">
                            <i class="fa-solid fa-eye me-2"></i>Live Preview
                        </a>
                        <a href="{{ $template['download_url'] }}" class="btn btn-outline-{{ $template['preview_color'] }}">
                            <i class="fa-solid fa-download me-2"></i>Download Free
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
