@extends('layouts.app')

@section('title', 'Stock Market Live Updates')
@section('meta_description', 'Nifty, Sensex, stock trends, market movers. Live updates via API or embed.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-3.png',
    'tag'         => 'Live Market Data',
    'title'       => '📈 Stock Market Live',
    'subtitle'    => 'Real-time Nifty 50, Sensex, stock trends and market movers — powered by live API feeds. Stay ahead of the market.',
    'icon'        => 'fa-chart-line',
    'accentColor' => '#10b981',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'Market']],
    'links'       => [
        ['label'=>'Nifty 50', 'href'=>'#nifty'],
        ['label'=>'Sensex',   'href'=>'#sensex'],
        ['label'=>'Movers',   'href'=>'#movers'],
    ],
])

<div class="container py-5">
    <section id="nifty" class="scroll-margin-top">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="market-card rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold mb-0">Nifty 50</h3>
                        <span class="badge bg-success-subtle text-success-emphasis">Index</span>
                    </div>
                    <div class="display-4 fw-bold mb-2 text-dark">{{ number_format($marketData['nifty']['value'], 2) }}</div>
                    <div class="d-flex align-items-center">
                        @if(($marketData['nifty']['change'] ?? 0) >= 0)
                            <i class="fa-solid fa-arrow-up text-success me-2"></i>
                            <span class="text-success fw-bold">+{{ number_format($marketData['nifty']['change'], 2) }} ({{ number_format($marketData['nifty']['change_percent'], 2) }}%)</span>
                        @else
                            <i class="fa-solid fa-arrow-down text-danger me-2"></i>
                            <span class="text-danger fw-bold">{{ number_format($marketData['nifty']['change'], 2) }} ({{ number_format($marketData['nifty']['change_percent'], 2) }}%)</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="market-card rounded-4 p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold mb-0">Sensex</h3>
                        <span class="badge bg-success-subtle text-success-emphasis">Index</span>
                    </div>
                    <div class="display-4 fw-bold mb-2 text-dark">{{ number_format($marketData['sensex']['value'], 2) }}</div>
                    <div class="d-flex align-items-center">
                        @if(($marketData['sensex']['change'] ?? 0) >= 0)
                            <i class="fa-solid fa-arrow-up text-success me-2"></i>
                            <span class="text-success fw-bold">+{{ number_format($marketData['sensex']['change'], 2) }} ({{ number_format($marketData['sensex']['change_percent'], 2) }}%)</span>
                        @else
                            <i class="fa-solid fa-arrow-down text-danger me-2"></i>
                            <span class="text-danger fw-bold">{{ number_format($marketData['sensex']['change'], 2) }} ({{ number_format($marketData['sensex']['change_percent'], 2) }}%)</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="movers" class="scroll-margin-top mt-5">
        <h4 class="h5 fw-bold mb-3">More live data</h4>
        <p class="text-body-secondary small mb-3">For real-time charts and top gainers/losers, use <a href="https://www.tradingview.com/markets/indices/quotes-india/" target="_blank" rel="noopener">TradingView <i class="fa-solid fa-external-link-alt ms-1 small"></i></a> or your broker’s platform. Index values above are placeholder; set up a market API in the app for live numbers.</p>
    </section>

    <div class="alert alert-info mt-4 text-center border-0 shadow-sm">
        <i class="fa-solid fa-chart-line me-2"></i>
        <strong>Tip:</strong> Embed a TradingView widget or connect a market API for live Nifty/Sensex and movers.
    </div>
</div>
@endsection
