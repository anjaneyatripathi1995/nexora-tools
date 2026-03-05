<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <title>@yield('title', 'Nexora Tools') | {{ config('app.name', 'Nexora Tools') }}</title>
    <meta name="description" content="@yield('meta_description', 'Free online tools by Tripathi Nexora Technologies — PDF, image, developer, SEO & more.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="@yield('title', 'Nexora Tools') | {{ config('app.name') }}">
    <meta property="og:description" content="@yield('meta_description', 'Free online tools — tripathinexora.com')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Nexora Tools">
    @stack('meta')
    @hasSection('schema')
    <script type="application/ld+json">@yield('schema')</script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
@include('layouts.header')
<main class="@yield('main_class', 'page-main') overflow-x-hidden" style="overflow-x:hidden; width:100%; min-height:calc(100vh - 76px);">
    @yield('content')
</main>
@include('layouts.footer')
@stack('scripts')
</body>
</html>