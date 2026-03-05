@extends('layouts.app')

@section('title', $name)
@section('meta_description', $description)

@section('content')
<div class="container py-5 mt-2">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb text-white-50">
            <li class="breadcrumb-item"><a href="{{ route('tools.index') }}" class="text-decoration-none">Tools</a></li>
            <li class="breadcrumb-item active text-light" aria-current="page">{{ $name }}</li>
        </ol>
    </nav>
    <div class="tool-detail-card rounded-4 p-5 text-center">
        <div class="tool-detail-icon rounded-3 p-4 bg-{{ $color }} bg-opacity-25 d-inline-block mb-4">
            <i class="fa-solid {{ $icon }} fa-4x text-{{ $color }}"></i>
        </div>
        <h1 class="h2 fw-bold mb-3">{{ $name }}</h1>
        <p class="text-white-50 mb-4">{{ $description }}</p>
        <div class="alert alert-info d-inline-block">
            <i class="fa-solid fa-clock me-2"></i>This tool is coming soon. We're working on it.
        </div>
        <a href="{{ route('tools.index') }}" class="btn btn-outline-light mt-3">Browse all tools</a>
    </div>
</div>
@endsection
