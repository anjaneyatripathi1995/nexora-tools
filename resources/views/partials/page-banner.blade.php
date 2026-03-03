{{--
    Shared Sub-Page Banner
    ───────────────────────────────────────────────────────────────
    Props (pass via @include('partials.page-banner', [...]))
        $image      string   asset path, e.g. 'images/utility-banner-2.png'
        $tag        string   small tag above title, e.g. 'Utility Tools'
        $title      string   main h1 text (HTML allowed)
        $subtitle   string   paragraph below title
        $icon       string   Font Awesome class, e.g. 'fa-screwdriver-wrench'
        $accentColor string  hex, e.g. '#2563eb'   (default blue)
        $links      array    optional pill links  [ ['label'=>'Finance', 'href'=>'#finance'], ... ]
        $breadcrumb array    optional  [ ['label'=>'Home','href'=>'/'], ['label'=>'Tools'] ]
    ──────────────────────────────────────────────────────────────
--}}
@php
    $accentColor = $accentColor ?? '#2563eb';
    $links       = $links       ?? [];
    $breadcrumb  = $breadcrumb  ?? [];
@endphp

<div class="sub-banner" style="background-image:url('{{ asset($image) }}')">

    {{-- Overlay gradient --}}
    <div class="sub-banner__overlay" aria-hidden="true"></div>

    {{-- Decorative animated blobs --}}
    <div class="sub-banner__blob sub-banner__blob--1" style="background:{{ $accentColor }}22" aria-hidden="true"></div>
    <div class="sub-banner__blob sub-banner__blob--2" aria-hidden="true"></div>

    <div class="container position-relative" style="z-index:3">

        {{-- Breadcrumb --}}
        @if(count($breadcrumb))
        <nav aria-label="breadcrumb" class="sub-banner__breadcrumb">
            <ol class="breadcrumb mb-0">
                @foreach($breadcrumb as $crumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if(!$loop->last)
                        <a href="{{ $crumb['href'] }}">{{ $crumb['label'] }}</a>
                    @else
                        {{ $crumb['label'] }}
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
        @endif

        <div class="row align-items-center py-5 g-4">

            {{-- Left: text content --}}
            <div class="col-lg-7">

                {{-- Tag badge --}}
                @if(!empty($tag))
                <div class="sub-banner__tag sub-banner__anim" style="animation-delay:.05s">
                    <span class="sub-banner__tag-dot" style="background:{{ $accentColor }}"></span>
                    {{ $tag }}
                </div>
                @endif

                {{-- Title --}}
                <h1 class="sub-banner__title sub-banner__anim" style="animation-delay:.15s">
                    {!! $title !!}
                </h1>

                {{-- Subtitle --}}
                <p class="sub-banner__sub sub-banner__anim" style="animation-delay:.28s">
                    {{ $subtitle }}
                </p>

                {{-- Optional quick-nav pills --}}
                @if(count($links))
                <div class="sub-banner__links sub-banner__anim" style="animation-delay:.4s">
                    @foreach($links as $link)
                    <a href="{{ $link['href'] }}" class="sub-banner__pill">{{ $link['label'] }}</a>
                    @endforeach
                </div>
                @endif

            </div>

            {{-- Right: decorative icon --}}
            <div class="col-lg-5 text-center d-none d-lg-flex justify-content-center align-items-center">
                <div class="sub-banner__icon-wrap sub-banner__anim" style="animation-delay:.2s; --accent:{{ $accentColor }}">
                    <div class="sub-banner__icon-ring sub-banner__icon-ring--outer"></div>
                    <div class="sub-banner__icon-ring sub-banner__icon-ring--inner"></div>
                    <i class="fa-solid {{ $icon }} sub-banner__icon-fa"></i>
                </div>
            </div>

        </div>
    </div>
</div>
