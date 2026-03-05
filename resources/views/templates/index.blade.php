@extends('layouts.app')

@section('title', 'HTML Templates')
@section('meta_description', 'Download free and premium HTML templates by Tripathi Nexora Technologies — landing pages, admin dashboards, UI kits and more.')

@section('content')
<div class="sub-banner">
    <div class="sub-banner__overlay"></div>
    <div class="container">
        <div class="sub-banner__content">
            <div class="sub-banner__anim">
                <h1 class="sub-banner__title">HTML <span class="text-primary">Templates</span></h1>
                <p class="sub-banner__sub">Ready-to-use HTML templates — landing pages, dashboards, UI kits and more.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($templates as $tpl)
            <div class="col-sm-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="card-img-top bg-{{ $tpl['preview_color'] }} bg-opacity-15 d-flex align-items-center justify-content-center" style="height:160px">
                        <i class="fa-solid fa-palette fa-3x text-{{ $tpl['preview_color'] }}"></i>
                    </div>
                    <div class="card-body">
                        <span class="badge bg-{{ $tpl['preview_color'] }} bg-opacity-15 text-{{ $tpl['preview_color'] }} mb-2 small fw-600">{{ $tpl['category'] }}</span>
                        <h5 class="fw-700 mb-2">{{ $tpl['name'] }}</h5>
                        <p class="text-muted small mb-3">{{ $tpl['description'] }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-3 pb-3 d-flex gap-2">
                        <a href="{{ route('templates.show', $tpl['slug']) }}" class="btn btn-outline-{{ $tpl['preview_color'] }} btn-sm flex-grow-1">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
