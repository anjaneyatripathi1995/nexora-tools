<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | TechHub</title>
    <meta name="description" content="@yield('meta_description', 'All-in-One Tech Solution Hub')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- VITE ONLY -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>
<body>

@include('partials.navbar')

<main class="@yield('main_class', 'page-main') overflow-x-hidden" style="overflow-x:hidden; width:100%; min-height:calc(100vh - 76px);">
    @yield('content')
</main>

@include('partials.footer')

@stack('scripts')
</body>
</html>