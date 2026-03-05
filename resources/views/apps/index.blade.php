@extends('layouts.app')

@section('title', 'App Solutions')
@section('meta_description', 'Browse 21+ mobile and web app solutions by Tripathi Nexora Technologies — download APK, view source code and live demo.')

@section('content')
<div class="sub-banner">
    <div class="sub-banner__overlay"></div>
    <div class="container">
        <div class="sub-banner__content">
            <div class="sub-banner__anim">
                <h1 class="sub-banner__title">App <span class="text-primary">Solutions</span></h1>
                <p class="sub-banner__sub">21+ ready-to-use mobile and web app solutions with source code and live demos.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-3">
            @foreach($apps as $app)
            <div class="col-6 col-sm-4 col-lg-3">
                <a href="{{ route('apps.show', $app['slug']) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-card text-center p-3">
                        <div class="rounded-3 p-3 bg-{{ $app['color'] }} bg-opacity-10 mb-3 mx-auto" style="width:60px;height:60px;display:flex;align-items:center;justify-content:center">
                            <i class="fa-solid {{ $app['icon'] }} fa-xl text-{{ $app['color'] }}"></i>
                        </div>
                        <h6 class="fw-700 text-dark mb-0 small">{{ $app['name'] }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
