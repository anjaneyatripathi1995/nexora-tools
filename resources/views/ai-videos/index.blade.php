@extends('layouts.app')

@section('title', 'Fun & AI Video Section')
@section('meta_description', 'AI-generated videos, meme generator, love calculator, AI caption and story generator. Fun and entertainment tools.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-2.png',
    'tag'         => 'AI Entertainment Zone',
    'title'       => '🎉 Fun &amp; AI Tools',
    'subtitle'    => 'Generate videos, create memes, calculate love compatibility, and produce AI-powered captions and stories — all in one place.',
    'icon'        => 'fa-wand-magic-sparkles',
    'accentColor' => '#ec4899',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'AI Videos']],
    'links'       => [
        ['label'=>'AI Video',  'href'=>'/ai-videos/generator'],
        ['label'=>'Meme',      'href'=>'/ai-videos/meme-generator'],
        ['label'=>'Love Calc', 'href'=>'/ai-videos/love-calculator'],
        ['label'=>'Captions',  'href'=>'/ai-videos/caption-generator'],
    ],
])

<div class="container py-5">
    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="video-card-item h-100">
                <div class="video-card-icon bg-danger bg-opacity-25 rounded-3 p-3 mb-3 text-center">
                    <i class="fa-solid fa-video fa-3x text-danger"></i>
                </div>
                <h4 class="fw-bold mb-2">AI Video Generator</h4>
                <p class="text-white-50 small mb-3">Type your idea, get a 1–2 min AI-generated fun/comedy/motivational video.</p>
                <a href="{{ route('ai-videos.generator') }}" class="btn btn-sm btn-danger">Coming Soon</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="video-card-item h-100">
                <div class="video-card-icon bg-primary bg-opacity-25 rounded-3 p-3 mb-3 text-center">
                    <i class="fa-solid fa-image fa-3x text-primary"></i>
                </div>
                <h4 class="fw-bold mb-2">Meme Generator</h4>
                <p class="text-white-50 small mb-3">Create hilarious memes with templates or custom text.</p>
                <a href="{{ route('ai-videos.meme-generator') }}" class="btn btn-sm btn-primary">Coming Soon</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="video-card-item h-100">
                <div class="video-card-icon bg-danger bg-opacity-25 rounded-3 p-3 mb-3 text-center">
                    <i class="fa-solid fa-heart fa-3x text-danger"></i>
                </div>
                <h4 class="fw-bold mb-2">Love Calculator</h4>
                <p class="text-white-50 small mb-3">Calculate compatibility between two names.</p>
                <a href="{{ route('ai-videos.love-calculator') }}" class="btn btn-sm btn-danger">Calculate</a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="video-card-item h-100">
                <div class="video-card-icon bg-info bg-opacity-25 rounded-3 p-3 mb-3 text-center">
                    <i class="fa-solid fa-quote-right fa-3x text-info"></i>
                </div>
                <h4 class="fw-bold mb-2">AI Caption / Story Generator</h4>
                <p class="text-white-50 small mb-3">Generate captions and short stories for social media.</p>
                <a href="{{ route('ai-videos.caption-generator') }}" class="btn btn-sm btn-info">Coming Soon</a>
            </div>
        </div>
    </div>
</div>
@endsection
