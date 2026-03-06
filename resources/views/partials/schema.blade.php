@php
    $site = config('nexora.site', []);
    $logo = url('/assets/images/favicon.svg');
    $currentUrl = url()->current();

    $organization = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => $site['name'] ?? 'Nexora Tools',
        'url' => url('/'),
        'logo' => $logo,
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'email' => $site['email'] ?? '',
            'contactType' => 'customer support',
        ],
    ];

    $website = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => $site['name'] ?? 'Nexora Tools',
        'url' => url('/'),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => url('/?q={search_term_string}'),
            'query-input' => 'required name=search_term_string',
        ],
    ];

    $schemas = [$organization, $website];

    if (!empty($breadcrumbs ?? [])) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($breadcrumbs)->values()->map(function ($crumb, $index) {
                return [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $crumb['name'],
                    'item' => $crumb['url'],
                ];
            })->all(),
        ];
    }

    if (!empty($service ?? null)) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'] ?? '',
            'description' => $service['summary'] ?? '',
            'url' => $currentUrl,
            'provider' => ['@type' => 'Organization', 'name' => $site['name'] ?? 'Nexora Tools'],
        ];
    }

    if (!empty($faqs ?? [])) {
        $schemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => collect($faqs)->map(function ($faq) {
                return [
                    '@type' => 'Question',
                    'name' => $faq['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['a'],
                    ],
                ];
            })->all(),
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode($schemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}</script>
