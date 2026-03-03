@extends('layouts.app')

@section('title', $template['name'])

@section('content')
<div class="container py-5 mt-4">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="d-flex template-detail-hero">
                <div class="template-preview-large">
                    <div class="panel-card">
                        <img src="{{ $template['image_large'] ?? asset('images/placeholder-1200x700.svg') }}" alt="{{ $template['name'] }} preview" style="width:100%; height:520px; object-fit:cover; border-radius:12px;">
                    </div>
                    <div class="row g-3 mt-3">
                        <div class="col-4"><img src="{{ $template['image_1'] ?? asset('images/placeholder-320x180.svg') }}" class="img-fluid rounded" alt="Preview 1"></div>
                        <div class="col-4"><img src="{{ $template['image_2'] ?? asset('images/placeholder-320x180.svg') }}" class="img-fluid rounded" alt="Preview 2"></div>
                        <div class="col-4"><img src="{{ $template['image_3'] ?? asset('images/placeholder-320x180.svg') }}" class="img-fluid rounded" alt="Preview 3"></div>
                    </div>
                </div>

                <aside class="template-info">
                    <h2 class="h4 fw-bold mb-2">{{ $template['name'] }}</h2>
                    <div class="text-muted mb-3">{{ $template['category'] }}</div>
                    <p class="text-muted">{{ $template['description'] }}</p>

                    <div class="mt-4 mb-3">
                        <h6 class="fw-semibold">Key features</h6>
                        <div class="mt-2">
                            @foreach($template['features'] as $feature)
                            <div class="template-feature mb-2">
                                <i class="fa-solid fa-circle-check"></i>
                                <div>{{ $feature }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="template-actions mt-4">
                        <a href="{{ $template['preview_url'] }}" target="_blank" class="btn btn-{{ $template['preview_color'] }} mb-2"><i class="fa-solid fa-eye me-2"></i>Live Preview</a>
                        <a href="{{ $template['download_url'] }}" class="btn btn-outline-{{ $template['preview_color'] }} mb-2"><i class="fa-solid fa-download me-2"></i>Download</a>
                        <a href="#" class="btn btn-secondary"><i class="fa-solid fa-code me-2"></i>View HTML</a>
                    </div>

                    <div class="mt-4 text-muted small">
                        <strong>License:</strong> Free to use for personal projects
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
@endsection
