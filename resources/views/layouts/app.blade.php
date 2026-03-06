<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    {{-- Apply saved theme BEFORE any CSS renders to prevent flash --}}
    <script>
    (function(){
        var t = localStorage.getItem('nexora-theme');
        if (!t && window.matchMedia && window.matchMedia('(prefers-color-scheme:dark)').matches) t = 'dark';
        if (t) document.documentElement.setAttribute('data-theme', t);
    })();
    </script>
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
    @php
        try {
            // Normal path — reads public/build/manifest.json
            echo app(\Illuminate\Foundation\Vite::class)(['resources/css/app.css', 'resources/js/app.js']);
        } catch (\Exception $e) {
            // Manifest missing: try reading it manually from the public path
            $manifestPath = public_path('build/manifest.json');
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true) ?? [];
                $cssFile  = $manifest['resources/css/app.css']['file']  ?? null;
                $jsFile   = $manifest['resources/js/app.js']['file']    ?? null;
                if ($cssFile) echo '<link rel="stylesheet" href="' . asset('build/' . $cssFile) . '">';
                if ($jsFile)  echo '<script src="' . asset('build/' . $jsFile) . '" defer></script>';
            }
        }
    @endphp
    {{-- Google Fonts (Inter) — same as flat PHP pages --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
@include('layouts.header')
<main class="@yield('main_class', 'page-main') overflow-x-hidden" style="overflow-x:hidden; width:100%; min-height:calc(100vh - 64px);">
    @yield('content')
</main>
@include('layouts.footer')
@stack('scripts')
</body>
</html>