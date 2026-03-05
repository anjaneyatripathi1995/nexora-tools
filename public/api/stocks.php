<?php
/**
 * Nexora Tools — Stock Market Proxy
 * Fetches live market data from Yahoo Finance and returns JSON.
 * Server-side to bypass CORS restrictions.
 */
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: public, max-age=60'); // cache 1 min

$indices = [
    ['^NSEI',    'NIFTY 50',   '🇮🇳', 'INR'],
    ['^BSESN',   'SENSEX',     '🇮🇳', 'INR'],
    ['^IXIC',    'NASDAQ',     '🇺🇸', 'USD'],
    ['^DJI',     'DOW JONES',  '🇺🇸', 'USD'],
    ['GC=F',     'Gold',       '🥇',  'USD'],
    ['USDINR=X', 'USD / INR',  '💱',  ''],
];

$results = [];

foreach ($indices as [$symbol, $name, $flag, $currency]) {
    $url = 'https://query1.finance.yahoo.com/v8/finance/chart/'
         . urlencode($symbol)
         . '?interval=1d&range=1d';

    $ctx = stream_context_create(['http' => [
        'timeout'    => 4,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
        'method'     => 'GET',
        'header'     => "Accept: application/json\r\n",
    ]]);

    $raw = @file_get_contents($url, false, $ctx);
    if (!$raw) continue;

    $data = json_decode($raw, true);
    $meta = $data['chart']['result'][0]['meta'] ?? null;
    if (!$meta) continue;

    $price  = (float)($meta['regularMarketPrice']    ?? 0);
    $prev   = (float)($meta['previousClose']          ?? $price);
    $change    = $price - $prev;
    $change_pct = $prev > 0 ? ($change / $prev * 100) : 0;

    // Format price sensibly
    $decimals = ($currency === 'INR' || $price > 1000) ? 2 : 4;

    $results[] = [
        'symbol'     => $symbol,
        'name'       => $name,
        'flag'       => $flag,
        'currency'   => $currency,
        'price'      => number_format($price, $decimals),
        'change'     => ($change >= 0 ? '+' : '') . number_format($change, 2),
        'change_pct' => ($change_pct >= 0 ? '+' : '') . number_format($change_pct, 2) . '%',
        'up'         => $change >= 0,
        'market_state' => $meta['marketState'] ?? 'CLOSED',
    ];
}

echo json_encode([
    'indices'    => $results,
    'fetched_at' => date('H:i'),
    'date'       => date('D, M j'),
]);
