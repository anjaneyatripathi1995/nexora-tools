@extends('layouts.site')

@php
    $benefits = $industry['benefits'] ?? [];
@endphp

@section('content')
<section class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $industry['name'] }}</h1>
            <p>{{ $industry['summary'] }}</p>
            <div class="breadcrumb">
                @foreach(($breadcrumbs ?? []) as $i => $crumb)
                    @if($i) / @endif
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid" style="display:grid;grid-template-columns:2fr 1fr;gap:28px;">
            <div>
                <h2>Workflow highlights</h2>
                <ul class="feature-list">
                    @foreach($benefits as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>

                <h2>Suggested tool stack</h2>
                <p>Combine these tools for {{ strtolower($industry['name']) }} scenarios:</p>
                <ul class="feature-list">
                    <li><a href="{{ route('tools.show', ['slug' => 'pdf-merger']) }}">Merge PDF</a> for assembling packets</li>
                    <li><a href="{{ route('tools.show', ['slug' => 'compress-pdf']) }}">Compress PDF</a> for email/portal limits</li>
                    <li><a href="{{ route('tools.show', ['slug' => 'ocr']) }}">OCR</a> for scanned evidence and notes</li>
                </ul>

                <h2>FAQs</h2>
                <div class="faq-list">
                    <div class="faq-item">
                        <h3>Will files stay private?</h3>
                        <p>All actions run in your browser; files are not stored on Nexora servers.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Can I automate these steps?</h3>
                        <p>Batch flows can be scripted with our upcoming automation endpoints; contact us for access.</p>
                    </div>
                </div>
            </div>
            <aside>
                <div class="sidebar-card">
                    <h3>Other industries</h3>
                    <ul class="sidebar-list">
                        @foreach($related as $slug => $rel)
                            <li><a href="{{ route('industry.show', ['industry' => $slug]) }}">{{ $rel['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar-card">
                    <h3>Quick links</h3>
                    <ul class="sidebar-list">
                        <li><a href="{{ route('services.show', ['service' => 'pdf-workflows']) }}">PDF Workflows</a></li>
                        <li><a href="{{ route('solutions.show', ['solution' => 'remote-teams']) }}">Remote Teams</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
