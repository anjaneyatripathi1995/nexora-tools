<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $apiSource = null;
        $cacheKey = 'news_feed_' . (config('services.news_api.key') ? 'api' : 'placeholder');
        $news = Cache::remember($cacheKey, 1800, function () use (&$apiSource) {
            $key = config('services.news_api.key');
            if ($key) {
                try {
                    $response = Http::timeout(10)->get('https://newsapi.org/v2/top-headlines', [
                        'apiKey' => $key,
                        'category' => 'technology',
                        'pageSize' => 12,
                        'language' => 'en',
                    ]);
                    if ($response->successful() && ($data = $response->json()) && !empty($data['articles'])) {
                        $apiSource = 'NewsAPI';
                        return collect($data['articles'])->map(function ($a) {
                            return [
                                'title' => $a['title'] ?? 'No title',
                                'excerpt' => $a['description'] ?? '',
                                'category' => 'Tech',
                                'date' => isset($a['publishedAt']) ? \Carbon\Carbon::parse($a['publishedAt']) : now(),
                                'image' => $a['urlToImage'] ?? null,
                                'url' => $a['url'] ?? '#',
                                'source' => $a['source']['name'] ?? null,
                            ];
                        })->toArray();
                    }
                } catch (\Throwable $e) {
                    // fallback to placeholder
                }
            }
            return [
                ['title' => 'Latest Tech Innovation in AI', 'excerpt' => 'Revolutionary AI technology transforms the industry with new breakthroughs.', 'category' => 'Tech', 'date' => now()->subDays(1), 'image' => null, 'url' => '#', 'source' => null],
                ['title' => 'Startup Funding Reaches New Heights', 'excerpt' => 'Tech startups secure record-breaking investments in Q1.', 'category' => 'Startups', 'date' => now()->subDays(2), 'image' => null, 'url' => '#', 'source' => null],
                ['title' => 'World Affairs: Digital Economy Summit', 'excerpt' => 'Global leaders discuss digital economy and tech policy.', 'category' => 'World Affairs', 'date' => now()->subDays(3), 'image' => null, 'url' => '#', 'source' => null],
            ];
        });

        if (config('services.news_api.key')) {
            $apiSource = 'NewsAPI';
        }

        return view('news.index', compact('news', 'apiSource'));
    }
}
