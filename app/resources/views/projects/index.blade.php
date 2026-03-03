@extends('layouts.app')

@section('title', 'Web & Mobile Project Solutions')
@section('meta_description', 'Full code-based app solutions with demo and documentation: Tax, Restaurant Booking, Expense Tracker, To-Do, Online Teaching, CEO Dashboard, Employee Orientation.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/projects-banner.png',
    'tag'         => '7 Production-Ready Projects',
    'title'       => '💼 Web &amp; Mobile Projects',
    'subtitle'    => 'Full code-based solutions with demo and documentation — perfect for portfolios, learning references, and client work.',
    'icon'        => 'fa-briefcase',
    'accentColor' => '#10b981',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'Projects']],
    'links'       => [
        ['label'=>'Web Apps',    'href'=>'#projects'],
        ['label'=>'Mobile Apps', 'href'=>'#projects'],
        ['label'=>'Source Code', 'href'=>'#projects'],
    ],
])

<div class="container py-5">
    <div class="row g-4">
        @foreach($projects as $index => $project)
        <div class="col-md-6 col-lg-4">
            <div class="project-card-item h-100">
                <div class="project-card-icon bg-{{ $project['color'] }} bg-opacity-25 rounded-3 p-3 mb-3">
                    <i class="fa-solid {{ $project['icon'] }} fa-3x text-{{ $project['color'] }}"></i>
                </div>
                <h3 class="h5 fw-bold mb-2">{{ $project['name'] }}</h3>
                <p class="text-white-50 small mb-3">{{ $project['description'] }}</p>
                <ul class="list-unstyled small mb-3">
                    @foreach(array_slice($project['features'], 0, 3) as $f)
                    <li><i class="fa-solid fa-check text-success me-2"></i>{{ $f }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('projects.show', $project['slug']) }}" class="btn btn-sm btn-{{ $project['color'] }}">
                    View Project <i class="fa-solid fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
