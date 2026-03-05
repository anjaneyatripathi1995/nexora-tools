<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login') | Nexora Tools</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="auth-page auth-page--dark">
    <div class="auth-page__bg" aria-hidden="true"></div>
    <div class="auth-layout">
        <a href="{{ url('/') }}" class="auth-close" title="Back to home" aria-label="Close"><i class="fa-solid fa-times"></i></a>
        <div class="auth-form-wrapper">
            <div class="auth-form-box">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
