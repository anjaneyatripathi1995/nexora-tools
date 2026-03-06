@extends('layouts.site')

@section('content')
<section class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{{ $post['title'] ?? 'Blog Post' }}</h1>
            <p>{{ $post['excerpt'] ?? '' }}</p>
            <div class="breadcrumb">
                <a href="{{ url('/') }}">Home</a> / <a href="{{ url('/blog') }}">Blog</a> / {{ $post['title'] ?? '' }}
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <article class="prose">
            {!! $post['body'] ?? '<p>Content goes here.</p>' !!}
        </article>
        <hr>
        <h2>Related reads</h2>
        <ul>
            @foreach(($related ?? []) as $item)
                <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
            @endforeach
        </ul>
        <h2>FAQs</h2>
        <div class="faq-list">
            @foreach(($faqs ?? []) as $item)
                <div class="faq-item">
                    <h3>{{ $item['q'] }}</h3>
                    <p>{{ $item['a'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
