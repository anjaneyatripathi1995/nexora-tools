<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsProxyController extends Controller
{
    public function __invoke(Request $request)
    {
        $type = (string) $request->query('type', 'tech'); // tech | finance | stock
        $limit = (int) $request->query('limit', 6);
        $limit = max(1, min(20, $limit));

        $feeds = [
            'tech' => 'https://news.google.com/rss/search?q=technology+developer+tools&hl=en-IN&gl=IN&ceid=IN:en',
            'finance' => 'https://news.google.com/rss/search?q=stock+market+India+NSE+BSE&hl=en-IN&gl=IN&ceid=IN:en',
            'stock' => 'https://news.google.com/rss/search?q=NIFTY+SENSEX+stock+market&hl=en-IN&gl=IN&ceid=IN:en',
        ];

        $url = $feeds[$type] ?? $feeds['tech'];
        $ctx = stream_context_create(['http' => [
            'timeout' => 6,
            'user_agent' => 'Mozilla/5.0 (compatible; NexoraBot/1.0)',
            'method' => 'GET',
        ]]);

        $xml = @file_get_contents($url, false, $ctx);
        if (!$xml) {
            return response()
                ->json(['error' => 'Unable to fetch news feed', 'items' => []], 502)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Cache-Control', 'public, max-age=300');
        }

        libxml_use_internal_errors(true);
        $rss = simplexml_load_string($xml);
        if (!$rss) {
            return response()
                ->json(['error' => 'Invalid RSS feed', 'items' => []], 502)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Cache-Control', 'public, max-age=300');
        }

        $items = [];
        foreach ($rss->channel->item as $item) {
            if (count($items) >= $limit) break;

            $title = html_entity_decode((string) $item->title, ENT_QUOTES, 'UTF-8');
            $source = '';
            if (preg_match('/^(.+?)\s+-\s+([^-]+)$/', $title, $m)) {
                $title = trim($m[1]);
                $source = trim($m[2]);
            }

            $items[] = [
                'title' => $title,
                'link' => (string) $item->link,
                'pubDate' => date('M j, Y', strtotime((string) $item->pubDate)),
                'source' => $source ?: (string) ($item->source ?? 'Google News'),
                'image' => null,
            ];
        }

        return response()
            ->json(['items' => $items, 'type' => $type, 'fetched_at' => date('H:i')])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Cache-Control', 'public, max-age=300');
    }
}

