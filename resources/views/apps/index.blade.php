@extends('layouts.app')

@section('title', 'Mobile + Web Application Suite')
@section('meta_description', 'Downloadable code, APK, and live demo for Fitness, Language Learning, Payments, EV Charging, and more apps.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-1.png',
    'tag'         => '21+ App Solutions — APK + Source + Demo',
    'title'       => '📱 Mobile &amp; Web App Suite',
    'subtitle'    => 'Every app ships with downloadable source code, APK, and a live demo — ready for learning, portfolio showcase, or deployment.',
    'icon'        => 'fa-mobile-screen-button',
    'accentColor' => '#6366f1',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'Apps']],
    'links'       => [
        ['label'=>'Fitness',   'href'=>'#apps'],
        ['label'=>'Finance',   'href'=>'#apps'],
        ['label'=>'Education', 'href'=>'#apps'],
        ['label'=>'Health',    'href'=>'#apps'],
    ],
])

<div class="container py-5">
    <div class="row g-4">
        @foreach($apps as $app)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <a href="{{ route('apps.show', $app['slug']) }}" class="text-decoration-none">
                <div class="app-card-item h-100">
                    <div class="app-card-icon bg-{{ $app['color'] }} bg-opacity-25 rounded-3 p-3 mb-2 text-center">
                        <i class="fa-solid {{ $app['icon'] }} fa-2x text-{{ $app['color'] }}"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-light small">{{ $app['name'] }}</h5>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
