@extends('layouts.site')

@php
    $pageTitle = $category['name'] ?? 'Tools';
    $pageDesc = ($category['name'] ?? 'Tools') . ' category — browse free online tools on Nexora.';
    $canonical = route('categories.show', ['category' => request()->route('category')]);
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <div style="font-size:3rem;margin-bottom:12px">{{ $category['icon'] ?? '🛠' }}</div>
            <h1>{{ $category['name'] ?? 'Tools' }}</h1>
            <p>{{ count($tools ?? []) }} free tools in this category</p>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('tools.index') }}">Tools</a> /
                {{ $category['name'] ?? 'Tools' }}
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        @if (empty($tools))
            <div style="text-align:center;padding:80px 0;color:var(--text-2)">
                <div style="font-size:3rem;margin-bottom:16px">🚧</div>
                <h3>Coming Soon</h3>
                <p>Tools for this category are being built.</p>
            </div>
        @else
            <div class="tools-grid">
                @foreach ($tools as $t)
                    <a href="{{ url('/tools/' . $t['slug']) }}" class="tool-card">
                        <div class="tool-card-icon" style="background:{{ $category['bg'] ?? '#F3F4F6' }};color:{{ $category['color'] ?? '#2563EB' }}">{{ $t['icon'] }}</div>
                        <div class="tool-card-body">
                            <div class="tool-card-name">{{ $t['name'] }}</div>
                            <div class="tool-card-desc">{{ $t['desc'] }}</div>
                            <div class="tool-card-badges">
                                @if (!empty($t['popular'])) <span class="badge badge-popular">⭐ Popular</span> @endif
                                @if (!empty($t['new'])) <span class="badge badge-new">New</span> @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
