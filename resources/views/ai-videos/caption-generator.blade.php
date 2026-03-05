@extends('layouts.app')

@section('title', 'AI Caption / Story Generator')
@section('meta_description', 'Generate AI captions and short stories for social media or content.')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-2.png',
    'tag'         => 'Content in seconds',
    'title'       => 'AI Caption / Story Generator',
    'subtitle'    => 'Generate captions and short stories from a topic or keyword. API integration coming soon.',
    'icon'        => 'fa-quote-right',
    'accentColor' => '#0891b2',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'AI Videos','href'=>route('ai-videos.index')], ['label'=>'Caption / Story']],
    'links'       => [],
])

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="rounded-3 bg-info bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fa-solid fa-quote-right fa-3x text-info"></i>
                        </div>
                        <h1 class="h3 fw-bold mb-2">Caption &amp; story from prompt</h1>
                        <p class="text-body-secondary mb-0">Enter a topic; get a short caption or story (demo below until API is connected).</p>
                    </div>

                    <form id="captionForm" class="tool-form-wrap">
                        <div class="mb-4">
                            <label for="topic" class="form-label fw-semibold">Topic or keyword</label>
                            <input type="text" class="form-control form-control-lg" id="topic" placeholder="e.g. summer vacation, tech launch" maxlength="120">
                        </div>
                        <div class="mb-4">
                            <label for="type" class="form-label fw-semibold">Type</label>
                            <select class="form-select" id="type">
                                <option value="caption">Short caption</option>
                                <option value="story">Short story</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info btn-lg w-100">
                            <span class="btn-text"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Generate</span>
                        </button>
                    </form>

                    <div id="captionResult" class="mt-4 d-none">
                        <div class="alert alert-success border-0 shadow-sm">
                            <h6 class="fw-bold mb-2">Sample output (demo)</h6>
                            <p id="captionOutput" class="mb-0"></p>
                            <hr>
                            <p class="small text-body-secondary mb-0">Full AI caption/story will be available once the API is integrated.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('captionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var topic = (document.getElementById('topic').value || 'your topic').trim();
    var type = document.getElementById('type').value;
    var out = document.getElementById('captionOutput');
    var resultEl = document.getElementById('captionResult');
    var sampleCaption = 'Living my best life. ' + topic + ' never looked this good. #vibes #' + topic.replace(/\s+/g, '');
    var sampleStory = 'Once upon a time, ' + topic + ' changed everything. The sun was shining, and possibilities were endless. What started as a simple idea turned into an unforgettable moment. Here\'s to more days like this.';
    if (out) out.textContent = type === 'story' ? sampleStory : sampleCaption;
    if (resultEl) resultEl.classList.remove('d-none');
});
</script>
@endpush
@endsection
