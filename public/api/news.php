<?php
/**
 * Nexora Tools — News Proxy
 * Fetches tech/general news from Google News RSS and returns JSON.
 * Avoids CORS issues by fetching server-side.
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: public, max-age=300'); // cache 5 min

$type = $_GET['type'] ?? 'tech'; // tech | finance | stock

$feeds = [
    'tech'    => 'https://news.google.com/rss/search?q=technology+developer+tools&hl=en-IN&gl=IN&ceid=IN:en',
    'finance' => 'https://news.google.com/rss/search?q=stock+market+India+NSE+BSE&hl=en-IN&gl=IN&ceid=IN:en',
    'stock'   => 'https://news.google.com/rss/search?q=NIFTY+SENSEX+stock+market&hl=en-IN&gl=IN&ceid=IN:en',
];

$url = $feeds[$type] ?? $feeds['tech'];
$ctx = stream_context_create(['http' => [
    'timeout'    => 6,
    'user_agent' => 'Mozilla/5.0 (compatible; NexoraBot/1.0)',
    'method'     => 'GET',
]]);

$xml_str = @file_get_contents($url, false, $ctx);

if (!$xml_str) {
    http_response_code(502);
    echo json_encode(['error' => 'Unable to fetch news feed', 'items' => []]);
    exit;
}

libxml_use_internal_errors(true);
$rss = simplexml_load_string($xml_str);

if (!$rss) {
    http_response_code(502);
    echo json_encode(['error' => 'Invalid RSS feed', 'items' => []]);
    exit;
}

$items = [];
$limit = (int)($_GET['limit'] ?? 6);

foreach ($rss->channel->item as $item) {
    if (count($items) >= $limit) break;

    // Google News titles sometimes contain " - Source" at the end
    $title = html_entity_decode((string)$item->title, ENT_QUOTES, 'UTF-8');
    $source_name = '';
    if (preg_match('/^(.+?)\s+-\s+([^-]+)$/', $title, $m)) {
        $title       = trim($m[1]);
        $source_name = trim($m[2]);
    }

    $items[] = [
        'title'   => $title,
        'link'    => (string)$item->link,
        'pubDate' => date('M j, Y', strtotime((string)$item->pubDate)),
        'source'  => $source_name ?: (string)($item->source ?? 'Google News'),
        'image'   => null,
    ];
}

echo json_encode(['items' => $items, 'type' => $type, 'fetched_at' => date('H:i')]);
