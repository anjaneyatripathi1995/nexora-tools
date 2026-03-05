@extends('layouts.app')

@section('title', 'AI Video Generator')
@section('meta_description', 'Generate videos with AI — create engaging content in seconds using Nexora Tools AI Video Generator.')

@section('content')
<div class="sub-banner">
    <div class="sub-banner__overlay"></div>
    <div class="container">
        <div class="sub-banner__content">
            <div class="sub-banner__anim">
                <h1 class="sub-banner__title"><i class="fa-solid fa-video me-2 text-primary"></i>AI Video Generator</h1>
                <p class="sub-banner__sub">Generate engaging videos from text prompts in seconds using AI.</p>
            </div>
        </div>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-700 mb-3"><i class="fa-solid fa-wand-magic-sparkles me-2 text-primary"></i>Generate Your Video</h5>
                    <div class="mb-3">
                        <label class="form-label fw-600">Describe your video</label>
                        <textarea class="form-control" rows="4" placeholder="e.g. A short explainer video about how solar panels work, in a professional animated style..."></textarea>
                        <div class="form-text">Be specific about style, tone, length, and content.</div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-600">Style</label>
                            <select class="form-select">
                                <option>Animated Explainer</option>
                                <option>Live Action</option>
                                <option>Whiteboard</option>
                                <option>Cinematic</option>
                                <option>Social Media Reel</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-600">Duration</label>
                            <select class="form-select">
                                <option>15 seconds</option>
                                <option>30 seconds</option>
                                <option>60 seconds</option>
                                <option>2 minutes</option>
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-info d-flex gap-2 align-items-start mb-3">
                        <i class="fa-solid fa-circle-info mt-1 flex-shrink-0"></i>
                        <span class="small">AI Video generation requires API integration. This is a preview of the interface — connect your preferred AI video API to enable generation.</span>
                    </div>
                    <button class="btn btn-primary" disabled>
                        <i class="fa-solid fa-rocket me-2"></i>Generate Video (Coming Soon)
                    </button>
                </div>

                <div class="card border-0 shadow-sm p-4">
                    <h6 class="fw-700 mb-3">Other AI Video Tools</h6>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <a href="{{ route('ai-videos.meme-generator') }}" class="card border-0 bg-light text-center p-3 text-decoration-none hover-card d-block">
                                <i class="fa-solid fa-face-laugh fa-2x text-warning mb-2"></i>
                                <div class="small fw-600">Meme Generator</div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('ai-videos.caption-generator') }}" class="card border-0 bg-light text-center p-3 text-decoration-none hover-card d-block">
                                <i class="fa-solid fa-closed-captioning fa-2x text-info mb-2"></i>
                                <div class="small fw-600">Caption Generator</div>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="{{ route('ai-videos.love-calculator') }}" class="card border-0 bg-light text-center p-3 text-decoration-none hover-card d-block">
                                <i class="fa-solid fa-heart fa-2x text-danger mb-2"></i>
                                <div class="small fw-600">Love Calculator</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
