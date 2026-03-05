@extends('layouts.app')

@section('title', 'HTML Templates')
@section('meta_description', 'Modern UI templates: Business landing pages, admin dashboards, Bootstrap UI kits, responsive web pages. Preview and download.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-3.png',
    'tag'         => '4 Modern HTML Templates — Free Download',
    'title'       => '🖼️ HTML Templates',
    'subtitle'    => 'Professionally designed, responsive UI templates — preview live and download free for your next project or client work.',
    'icon'        => 'fa-palette',
    'accentColor' => '#8b5cf6',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'Templates']],
    'links'       => [
        ['label'=>'Business',   'href'=>'/templates/business'],
        ['label'=>'Admin',      'href'=>'/templates/admin'],
        ['label'=>'Bootstrap',  'href'=>'/templates/bootstrap'],
        ['label'=>'Responsive', 'href'=>'/templates/responsive'],
    ],
])

<div class="container py-5">
    <div class="row g-4 templates-grid">
        @foreach($templates as $template)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="template-card-item h-100">
                <a href="{{ route('templates.show', $template['slug']) }}" class="text-decoration-none text-body">
                    <div class="template-thumb mb-3">
                        <img src="{{ $template['image'] ?? asset('images/placeholder-640x360.svg') }}" alt="{{ $template['name'] }} preview">
                        <div class="template-badge">WIX Harmony</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="template-card-title">{{ $template['name'] }}</div>
                            <div class="template-meta">{{ $template['category'] }}</div>
                        </div>
                        <div class="text-end text-muted" style="font-size:0.85rem;">Free</div>
                    </div>
                    <p class="text-muted small mt-2 mb-0">{{ $template['description'] }}</p>
                </a>
                <div class="template-card-cta mt-3 d-flex gap-2">
                    <a href="{{ route('templates.show', $template['slug']) }}" class="btn btn-sm btn-outline-{{ $template['preview_color'] }} flex-grow-1">Preview</a>
                    <a href="#" class="btn btn-sm btn-{{ $template['preview_color'] }}">Use</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
