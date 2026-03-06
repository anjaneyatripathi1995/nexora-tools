@extends('layouts.site')

@php
    $benefits = $solution['benefits'] ?? [];
@endphp

@section('content')
<section class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $solution['name'] }}</h1>
            <p>{{ $solution['summary'] }}</p>
            <div class="breadcrumb">
                @foreach(($breadcrumbs ?? []) as $i => $crumb)
                    @if($i) / @endif
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                @endforeach
            </div>
            @if(!empty($solution['cta_tool']))
                <a href="{{ route('tools.show', ['slug' => $solution['cta_tool']]) }}" class="btn btn-primary mt-3">Launch tool</a>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="grid" style="display:grid;grid-template-columns:2fr 1fr;gap:28px;">
            <div>
                <h2>What’s included</h2>
                <ul class="feature-list">
                    @foreach($benefits as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>

                <h2>Implementation steps</h2>
                <ol class="numbered-list">
                    <li>Select the tools that match your workflow.</li>
                    <li>Create shareable presets for your team.</li>
                    <li>Measure file size reductions and turnaround time.</li>
                </ol>

                <h2>FAQs</h2>
                <div class="faq-list">
                    <div class="faq-item">
                        <h3>Does this require installs?</h3>
                        <p>No, everything runs in the browser. Users only need a modern browser.</p>
                    </div>
                    <div class="faq-item">
                        <h3>Can I white-label the tools?</h3>
                        <p>Contact us for white-label and API options.</p>
                    </div>
                </div>
            </div>
            <aside>
                <div class="sidebar-card">
                    <h3>Related solutions</h3>
                    <ul class="sidebar-list">
                        @foreach($related as $slug => $rel)
                            <li><a href="{{ route('solutions.show', ['solution' => $slug]) }}">{{ $rel['name'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="sidebar-card">
                    <h3>Popular guides</h3>
                    <ul class="sidebar-list">
                        <li><a href="{{ route('tools.show', ['slug' => 'pdf-to-word']) }}">Convert PDFs</a></li>
                        <li><a href="{{ route('tools.show', ['slug' => 'compress-pdf']) }}">Compress PDFs</a></li>
                        <li><a href="{{ route('tools.show', ['slug' => 'pdf-merger']) }}">Merge PDFs</a></li>
                    </ul>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
