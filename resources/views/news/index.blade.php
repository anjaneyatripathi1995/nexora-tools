@extends('layouts.app')

@section('title', 'Trending & Tech News')
@section('meta_description', 'Auto-updated news on Tech, Startups, and World Affairs.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-1.png',
    'tag'         => 'Auto-Updated Daily',
    'title'       => '📰 Trending &amp; Tech News',
    'subtitle'    => 'Stay ahead with auto-updated news on Technology, Startups, and World Affairs — curated for developers and creators.',
    'icon'        => 'fa-newspaper',
    'accentColor' => '#2563eb',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'News']],
    'links'       => [
        ['label'=>'Tech',     'href'=>'#news'],
        ['label'=>'Startups', 'href'=>'#news'],
        ['label'=>'World',    'href'=>'#news'],
    ],
])

<div class="container py-5" id="news">
    @if(!empty($apiSource))
    <p class="text-body-secondary small mb-3"><i class="fa-solid fa-bolt me-1"></i>Live from {{ $apiSource }}</p>
    @endif
    <div class="row g-4">
        @foreach($news as $item)
        <div class="col-md-6 col-lg-4">
            <article class="news-card-item h-100 d-flex flex-column">
                @if(!empty($item['image']))
                <a href="{{ $item['url'] ?? '#' }}" target="_blank" rel="noopener" class="news-card-image rounded-3 mb-3 overflow-hidden d-block" style="height: 200px;">
                    <img src="{{ $item['image'] }}" alt="" class="w-100 h-100 object-fit-cover" loading="lazy" onerror="this.style.background='linear-gradient(135deg,#e0e7ff,#c7d2fe)';this.src='';">
                </a>
                @else
                <div class="news-card-image rounded-3 mb-3 overflow-hidden" style="height: 200px;"></div>
                @endif
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge bg-primary">{{ $item['category'] ?? 'News' }}</span>
                    @if(!empty($item['source']))<span class="text-body-secondary small">{{ $item['source'] }}</span>@endif
                </div>
                <h4 class="fw-bold mb-2 fs-6"><a href="{{ $item['url'] ?? '#' }}" target="_blank" rel="noopener" class="text-decoration-none text-dark">{{ $item['title'] }}</a></h4>
                <p class="small mb-2 flex-grow-1">{{ Str::limit($item['excerpt'] ?? '', 120) }}</p>
                <small class="text-body-secondary">{{ isset($item['date']) ? (is_object($item['date']) ? $item['date']->diffForHumans() : $item['date']) : '' }}</small>
            </article>
        </div>
        @endforeach
    </div>
    @if(empty($apiSource))
    <div class="alert alert-info mt-4 text-center border-0 shadow-sm">
        <i class="fa-solid fa-info-circle me-2"></i>
        <strong>Tip:</strong> Set <code>NEWS_API_KEY</code> in your <code>.env</code> to fetch live tech headlines from NewsAPI.
    </div>
    @endif
</div>
@endsection
