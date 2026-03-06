<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ToolCatalog;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'seo:generate-sitemap';
    protected $description = 'Generate public/sitemap.xml from dynamic routes';

    public function handle(ToolCatalog $catalog): int
    {
        $urls = [
            url('/'),
            route('tools.index'),
            route('about'),
            route('privacy'),
            route('terms'),
            route('contact'),
        ];

        foreach (array_keys(config('seo.services', [])) as $slug) {
            $urls[] = url('/services/' . $slug);
        }
        foreach (array_keys(config('seo.industries', [])) as $slug) {
            $urls[] = url('/industry/' . $slug);
        }
        foreach (array_keys(config('seo.solutions', [])) as $slug) {
            $urls[] = url('/solutions/' . $slug);
        }
        foreach ($catalog->tools() as $tool) {
            $urls[] = route('tools.show', ['slug' => $tool['slug']]);
        }

        $lastmod = now()->toAtomString();

        $xml = view('sitemap.xml', [
            'urls' => collect($urls)->unique()->map(fn ($loc) => [
                'loc' => $loc,
                'changefreq' => 'weekly',
                'priority' => '0.8',
                'lastmod' => $lastmod,
            ])->all(),
        ])->render();

        File::put(public_path('sitemap.xml'), $xml);
        $this->info('sitemap.xml regenerated with ' . count($urls) . ' URLs.');

        return Command::SUCCESS;
    }
}
