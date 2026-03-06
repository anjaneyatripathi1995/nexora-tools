@extends('layouts.site')

@php
    $pageTitle = 'Privacy Policy';
    $pageDesc = 'Read how Nexora Tools collects, uses, and protects your data.';
    $canonical = route('privacy');
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Privacy Policy</h1>
            <p>Last updated: {{ date('F Y') }}</p>
        </div>
    </div>
</div>
<section class="section">
    <div class="container" style="max-width:760px;margin:0 auto">
        <div class="tool-wrap" style="line-height:1.8;color:var(--text-2)">
            @php
                $site = config('nexora.site');
                $secs = [
                    ['Information We Collect','We collect minimal data: anonymised usage analytics, contact form submissions, and browser theme preference stored locally on your device only.'],
                    ['How We Use Information','Solely to improve Nexora Tools. We do NOT sell, rent, or share your personal information with any third parties.'],
                    ['Files & Privacy','Files you process are handled in your browser where possible and never permanently stored on our servers.'],
                    ['Cookies','We use only essential cookies. No tracking or advertising cookies.'],
                    ['Data Security','Industry-standard security measures are in place. No internet transmission is 100% secure.'],
                    ['Changes','We may update this policy periodically. Continued use constitutes acceptance.'],
                    ['Contact','For privacy questions: ' . ($site['email'] ?? '')],
                ];
            @endphp
            @foreach ($secs as $i => [$t, $b])
                <h3 style="color:var(--text);margin:32px 0 10px">{{ $i + 1 }}. {{ $t }}</h3>
                <p>{{ $b }}</p>
            @endforeach
        </div>
    </div>
</section>
@endsection
