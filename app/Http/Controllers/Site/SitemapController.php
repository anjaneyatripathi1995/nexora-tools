<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ToolCatalog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(ToolCatalog $catalog): Response
    {
        $now = now()->toAtomString();

        $urls = [
            [
                'loc' => url('/'),
                'changefreq' => 'daily',
                'priority' => '1.0',
                'lastmod' => $now,
            ],
            [
                'loc' => route('tools.index'),
                'changefreq' => 'daily',
                'priority' => '0.9',
                'lastmod' => $now,
            ],
            ['loc' => route('about'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => route('privacy'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => route('terms'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.5'],
        ];

        foreach ($catalog->categories() as $slug => $category) {
            $urls[] = [
                'loc' => route('categories.show', ['category' => $slug]),
                'changefreq' => 'weekly',
                'priority' => '0.7',
                'lastmod' => $now,
            ];
        }

        foreach (array_keys(config('seo.services', [])) as $slug) {
            $urls[] = [
                'loc' => url('/services/' . $slug),
                'changefreq' => 'weekly',
                'priority' => '0.7',
                'lastmod' => $now,
            ];
        }

        foreach (array_keys(config('seo.industries', [])) as $slug) {
            $urls[] = [
                'loc' => url('/industry/' . $slug),
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => $now,
            ];
        }

        foreach (array_keys(config('seo.solutions', [])) as $slug) {
            $urls[] = [
                'loc' => url('/solutions/' . $slug),
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => $now,
            ];
        }

        foreach ($catalog->tools() as $tool) {
            $urls[] = [
                'loc' => route('tools.show', ['slug' => $tool['slug']]),
                'changefreq' => 'weekly',
                'priority' => !empty($tool['popular']) ? '0.9' : '0.7',
                'lastmod' => $now,
            ];
        }

        return response()
            ->view('sitemap.xml', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = [];

        if (app()->environment('production')) {
            $lines[] = 'User-agent: *';
            $lines[] = 'Allow: /';
        } else {
            $lines[] = 'User-agent: *';
            $lines[] = 'Disallow: /';
        }

        $lines[] = 'Sitemap: ' . url('/sitemap.xml');

        return response(implode(PHP_EOL, $lines))
            ->header('Content-Type', 'text/plain');
    }
}
