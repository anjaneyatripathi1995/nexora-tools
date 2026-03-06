@extends('layouts.site')

@php
    $faqs = $service['faqs'] ?? [];
    $benefits = $service['benefits'] ?? [];
    $ctaTool = $service['cta_tool'] ?? null;
@endphp

@section('content')
<section class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $service['name'] }}</h1>
            <p>{{ $service['summary'] }}</p>
            <div class="breadcrumb">
                @foreach(($breadcrumbs ?? []) as $i => $crumb)
                    @if($i) / @endif
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                @endforeach
            </div>
            @if($ctaTool)
                <a href="{{ route('tools.show', ['slug' => $ctaTool]) }}" class="btn btn-primary mt-3">Try it now</a>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid" style="display:grid;grid-template-columns:2fr 1fr;gap:28px;">
            <div>
                <h2>Why this service</h2>
                <ul class="feature-list">
                    @foreach($benefits as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>

                <h2>How it works</h2>
                <ol class="numbered-list">
                    <li>Upload or drop your files.</li>
                    <li>Select the desired action (convert, compress, lock, etc.).</li>
                    <li>Download instantly with no server-side storage.</li>
                </ol>

                <h2>FAQs</h2>
                <div class="faq-list">
                    @foreach($faqs as $item)
                        <div class="faq-item">
                            <h3>{{ $item['q'] }}</h3>
                            <p>{{ $item['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <aside>
                <div class="sidebar-card">
                    <h3>Related services</h3>
                    <ul class="sidebar-list">
                        @foreach($related as $slug => $rel)
                            <li><a href="{{ route('services.show', ['service' => $slug]) }}">{{ $rel['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar-card">
                    <h3>Popular tools</h3>
                    <ul class="sidebar-list">
                        <li><a href="{{ route('tools.show', ['slug' => 'pdf-merger']) }}">Merge PDF</a></li>
                        <li><a href="{{ route('tools.show', ['slug' => 'compress-pdf']) }}">Compress PDF</a></li>
                        <li><a href="{{ route('tools.show', ['slug' => 'pdf-to-word']) }}">PDF to Word</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
