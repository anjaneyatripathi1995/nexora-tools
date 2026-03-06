@extends('layouts.site')

@php
    $pageTitle = 'Page Not Found';
@endphp

@section('content')
<section class="section">
    <div class="container">
        <div class="page-404">
            <div class="err-num gradient-text">404</div>
            <h2>Oops! Page Not Found</h2>
            <p>The page or tool you're looking for doesn't exist or may have moved.</p>
            <div class="flex flex-center gap-16" style="flex-wrap:wrap;margin-top:32px">
                <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Go Home</a>
                <a href="{{ route('tools.index') }}" class="btn btn-ghost btn-lg">Browse All Tools</a>
            </div>
        </div>
    </div>
</section>
@endsection

