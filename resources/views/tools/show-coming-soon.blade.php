@extends('layouts.site')

@php
    $categories = config('nexora.categories', []);
    $catColor = '#2563EB';
    $catBg = '#DBEAFE';
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $name ?? 'Tool' }}</h1>
            <p>{{ $description ?? 'Coming soon.' }}</p>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('tools.index') }}">Tools</a> /
                {{ $name ?? 'Tool' }}
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container" style="max-width:640px">
        <div class="tool-coming-soon-card" style="background:var(--bg-card);border:1px solid var(--border);border-radius:var(--radius-lg);padding:3rem 2rem;text-align:center">
            <div style="font-size:4rem;margin-bottom:1rem;line-height:1">🛠</div>
            <h2 style="font-size:1.5rem;font-weight:700;margin-bottom:0.5rem;color:var(--text)">{{ $name ?? 'Tool' }}</h2>
            <p style="color:var(--text-2);margin-bottom:1.5rem">{{ $description ?? 'This tool is under development.' }}</p>
            <div style="background:var(--bg-elevated);color:var(--text-2);padding:1rem 1.25rem;border-radius:var(--radius-md);margin-bottom:1.5rem;font-size:0.9rem">
                <strong style="color:var(--text)">Coming soon.</strong> We're working on it. Check back later.
            </div>
            <a href="{{ route('tools.index') }}" class="btn btn-primary">Browse all tools</a>
        </div>
    </div>
</section>
@endsection
