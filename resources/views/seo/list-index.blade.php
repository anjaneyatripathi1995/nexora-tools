@extends('layouts.site')

@section('content')
<section class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $pageTitle ?? 'Listing' }}</h1>
            <p>{{ $pageDesc ?? '' }}</p>
            <div class="breadcrumb">
                @foreach(($breadcrumbs ?? []) as $i => $crumb)
                    @if($i) / @endif
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="tools-grid">
            @foreach(($items ?? []) as $slug => $item)
                <a href="{{ route($routeName ?? 'industry.show', [$routeName === 'solutions.show' ? 'solution' : 'industry' => $slug]) }}" class="tool-card">
                    <div class="tool-card-body">
                        <div class="tool-card-name">{{ $item['name'] }}</div>
                        <div class="tool-card-desc">{{ $item['summary'] ?? '' }}</div>
                        <div class="tool-card-badges">
                            <span class="badge badge-new">{{ $baseTitle ?? 'Item' }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
