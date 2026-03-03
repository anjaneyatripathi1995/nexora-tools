@extends('layouts.app')

@section('title', 'AI Video Generator')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-2.png',
    'tag'         => 'Coming Soon',
    'title'       => 'AI Video Generator',
    'subtitle'    => 'Generate short comedy, motivational, or educational videos from text prompts — with synchronized audio.',
    'icon'        => 'fa-video',
    'accentColor' => '#dc2626',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'AI Videos','href'=>route('ai-videos.index')], ['label'=>'AI Video Generator']],
    'links'       => [],
])

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="rounded-3 bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fa-solid fa-video fa-3x text-danger"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-2">Prompt-to-video</h1>
                        <p class="text-body-secondary mb-0">Describe your idea; we’ll generate a short video (API integration coming soon).</p>
                    </div>

                    <form id="videoGeneratorForm" class="tool-form-wrap">
                        <div class="mb-4">
                            <label for="prompt" class="form-label fw-semibold">Video idea or prompt</label>
                            <textarea class="form-control" id="prompt" rows="4" placeholder="E.g.: A funny cat playing piano in space, with dramatic music" maxlength="500"></textarea>
                            <div class="form-text">Keep it short and clear for best results.</div>
                        </div>
                        <div class="mb-4">
                            <label for="videoType" class="form-label fw-semibold">Video type</label>
                            <select class="form-select" id="videoType">
                                <option value="fun">Fun / Comedy</option>
                                <option value="motivational">Motivational</option>
                                <option value="educational">Educational</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg w-100 btn-generate-video">
                            <span class="btn-text"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Generate video</span>
                        </button>
                    </form>

                    <div id="videoResult" class="mt-4 d-none">
                        <div class="alert alert-info border-0 shadow-sm d-flex align-items-start gap-3">
                            <i class="fa-solid fa-info-circle fa-2x text-info flex-shrink-0"></i>
                            <div>
                                <h5 class="alert-heading fw-bold">API coming soon</h5>
                                <p class="mb-0">AI video generation will be available once we integrate a prompt-to-video service. You’ll get a short clip with optional synchronized audio.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('videoGeneratorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var btn = this.querySelector('.btn-generate-video');
    if (btn) { btn.classList.add('loading'); btn.disabled = true; }
    var resultEl = document.getElementById('videoResult');
    setTimeout(function() {
        if (resultEl) resultEl.classList.remove('d-none');
        if (btn) { btn.classList.remove('loading'); btn.disabled = false; }
    }, 800);
});
</script>
@endpush
@endsection
