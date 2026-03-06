@props([
    'title' => null,
    'description' => null,
    'keywords' => null,
    'canonical' => null,
    'image' => null,
    'type' => 'website',
    'robots' => null,
    'locale' => null,
    'structuredData' => null,
    'og' => [],
    'twitter' => [],
])

@php
    $site = config('nexora.site', []);
    $defaults = [
        'title' => ($site['name'] ?? config('app.name', 'Nexora Tools')),
        'description' => $site['desc'] ?? '',
        'keywords' => config('seo.keywords', config('nexora.seo.keywords', 'online tools, free tools, pdf tools, seo tools, developer tools, nexora tools')),
        'canonical' => url()->current(),
        'image' => url(config('seo.default_image', config('nexora.seo.default_image', '/assets/images/og-image.svg'))),
        'type' => 'website',
        'robots' => app()->environment('production') ? 'index,follow' : 'noindex,nofollow',
        'locale' => str_replace('_', '-', app()->getLocale()),
        'site_name' => $site['name'] ?? 'Nexora Tools',
        'author' => $site['company'] ?? ($site['name'] ?? 'Nexora Tools'),
    ];

    $meta = [
        'title' => $title ?: $defaults['title'],
        'description' => $description ?: $defaults['description'],
        'keywords' => $keywords ?: $defaults['keywords'],
        'canonical' => $canonical ?: $defaults['canonical'],
        'image' => $image
            ? (\Illuminate\Support\Str::startsWith($image, ['http://', 'https://', '//']) ? $image : url($image))
            : $defaults['image'],
        'type' => $type ?: $defaults['type'],
        'robots' => $robots ?: $defaults['robots'],
        'locale' => $locale ?: $defaults['locale'],
        'site_name' => $defaults['site_name'],
        'author' => $defaults['author'],
    ];

    if (!\Illuminate\Support\Str::contains($meta['title'], $meta['site_name'])) {
        $meta['title'] = trim($meta['title']) . ' | ' . $meta['site_name'];
    }

    $ogDefaults = [
        'title' => $meta['title'],
        'description' => $meta['description'],
        'url' => $meta['canonical'],
        'type' => $meta['type'],
        'image' => $meta['image'],
        'site_name' => $meta['site_name'],
    ];
    $og = array_merge($ogDefaults, array_filter($og));

    $twitterDefaults = [
        'card' => 'summary_large_image',
        'title' => $meta['title'],
        'description' => $meta['description'],
        'image' => $meta['image'],
        'site' => $site['twitter'] ?? config('seo.twitter'),
    ];
    $twitter = array_merge($twitterDefaults, array_filter($twitter));
@endphp

<title>{{ $meta['title'] }}</title>
<meta name="description" content="{{ $meta['description'] }}">
<meta name="keywords" content="{{ $meta['keywords'] }}">
<meta name="author" content="{{ $meta['author'] }}">
<link rel="canonical" href="{{ $meta['canonical'] }}">
<meta name="robots" content="{{ $meta['robots'] }}">
<meta property="og:title" content="{{ $og['title'] }}">
<meta property="og:description" content="{{ $og['description'] }}">
<meta property="og:url" content="{{ $og['url'] }}">
<meta property="og:type" content="{{ $og['type'] }}">
<meta property="og:site_name" content="{{ $og['site_name'] }}">
<meta property="og:image" content="{{ $og['image'] }}">
<meta name="twitter:card" content="{{ $twitter['card'] }}">
<meta name="twitter:title" content="{{ $twitter['title'] }}">
<meta name="twitter:description" content="{{ $twitter['description'] }}">
<meta name="twitter:image" content="{{ $twitter['image'] }}">
@if(!empty($twitter['site']))
<meta name="twitter:site" content="{{ $twitter['site'] }}">
@endif
<meta property="og:locale" content="{{ $meta['locale'] }}">
@if ($structuredData)
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
@endif
