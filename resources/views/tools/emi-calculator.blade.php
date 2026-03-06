@extends('layouts.site')

@php
    $pageTitle = 'EMI Calculator';
    $pageDesc  = 'Calculate your monthly EMI, total interest and loan pay-off date. Includes advanced lump-sum prepayment simulator.';
@endphp

@section('content')
<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>🏦 EMI Calculator</h1>
            <p>Plan your loans with interactive charts &amp; amortization table</p>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> /
                <a href="{{ route('tools.index') }}">Tools</a> /
                EMI Calculator
            </div>
        </div>
    </div>
</div>

<section class="tool-page">
    <div class="container" style="max-width:1100px">
        @include('tools.partials.emi-calculator')
    </div>
</section>
@endsection

