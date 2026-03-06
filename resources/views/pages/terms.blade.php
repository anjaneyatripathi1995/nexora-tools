@extends('layouts.site')

@php
    $pageTitle = 'Terms of Service';
    $pageDesc = 'Terms and conditions for using Nexora Tools.';
    $canonical = route('terms');
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>Terms of Service</h1>
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
                    ['Acceptance of Terms','By using Nexora Tools you agree to these terms. If you disagree, discontinue use.'],
                    ['Use of the Service','For lawful purposes only. Do not process or distribute illegal or harmful content.'],
                    ['Intellectual Property','All content, design, and branding is owned by ' . ($site['company'] ?? '') . '. Do not copy without permission.'],
                    ['Disclaimer','The Service is provided "as is" without warranties. Tool results are informational only.'],
                    ['Limitation of Liability',($site['company'] ?? '') . ' shall not be liable for indirect or consequential damages arising from your use.'],
                    ['Modifications','We reserve the right to modify the Service or these Terms at any time.'],
                    ['Governing Law','These Terms are governed by the laws of India.'],
                    ['Contact','Questions: ' . ($site['email'] ?? '')],
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
