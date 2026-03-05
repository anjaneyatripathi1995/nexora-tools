@extends('layouts.app')

@section('title', 'Meme Generator')

@section('content')
@include('partials.page-banner', [
    'image'       => 'images/utility-banner-2.png',
    'tag'         => 'Fun &amp; Shareable',
    'title'       => 'Meme Generator',
    'subtitle'    => 'Create memes with custom text on your image or a template. Download and share.',
    'icon'        => 'fa-image',
    'accentColor' => '#8b5cf6',
    'breadcrumb'  => [['label'=>'Home','href'=>'/'], ['label'=>'AI Videos','href'=>route('ai-videos.index')], ['label'=>'Meme Generator']],
    'links'       => [],
])

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">Setup</h5>
                <form id="memeGeneratorForm" class="tool-form-wrap">
                    <div class="mb-3">
                        <label for="memeImage" class="form-label fw-semibold">Image</label>
                        <input type="file" class="form-control" id="memeImage" accept="image/*">
                        <p class="small text-body-secondary mt-1 mb-0">Or use the default template below.</p>
                    </div>
                    <div class="mb-3">
                        <label for="topText" class="form-label fw-semibold">Top text</label>
                        <input type="text" class="form-control" id="topText" placeholder="Top text" maxlength="80">
                    </div>
                    <div class="mb-3">
                        <label for="bottomText" class="form-label fw-semibold">Bottom text</label>
                        <input type="text" class="form-control" id="bottomText" placeholder="Bottom text" maxlength="80">
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-primary" id="memePreviewBtn">
                            <i class="fa-solid fa-eye me-1"></i>Update preview
                        </button>
                        <button type="button" class="btn btn-success" id="memeDownloadBtn" disabled>
                            <i class="fa-solid fa-download me-1"></i>Download meme
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">Preview</h5>
                <div class="bg-dark rounded-3 overflow-hidden d-flex align-items-center justify-content-center min-height-300" style="min-height: 300px;">
                    <canvas id="memeCanvas" width="500" height="500" class="img-fluid" style="max-width: 100%; height: auto;"></canvas>
                </div>
                <p class="small text-body-secondary mt-2 mb-0">Add an image and text, then click Update preview. Default template is used until you upload an image.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var canvas = document.getElementById('memeCanvas');
    var ctx = canvas.getContext('2d');
    var topInput = document.getElementById('topText');
    var bottomInput = document.getElementById('bottomText');
    var fileInput = document.getElementById('memeImage');
    var previewBtn = document.getElementById('memePreviewBtn');
    var downloadBtn = document.getElementById('memeDownloadBtn');

    var currentImage = null;
    var defaultImage = null;

    function drawDefault() {
        var w = canvas.width, h = canvas.height;
        var g = ctx.createLinearGradient(0, 0, w, h);
        g.addColorStop(0, '#6366f1');
        g.addColorStop(1, '#8b5cf6');
        ctx.fillStyle = g;
        ctx.fillRect(0, 0, w, h);
        ctx.fillStyle = '#fff';
        ctx.font = '24px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('Your meme template', w/2, h/2);
    }

    function drawMeme(img, top, bottom) {
        var w = canvas.width, h = canvas.height;
        ctx.clearRect(0, 0, w, h);
        if (img) {
            var scale = Math.min(w / img.width, h / img.height);
            var x = (w - img.width * scale) / 2, y = (h - img.height * scale) / 2;
            ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
        } else {
            drawDefault();
        }
        ctx.fillStyle = '#fff';
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 3;
        ctx.textAlign = 'center';
        ctx.font = 'bold 36px Impact, Arial Black, sans-serif';
        var maxWidth = w - 20;
        if (top) {
            ctx.strokeText(top, w/2, 50);
            ctx.fillText(top, w/2, 50);
        }
        if (bottom) {
            ctx.strokeText(bottom, w/2, h - 20);
            ctx.fillText(bottom, w/2, h - 20);
        }
    }

    function updatePreview() {
        var img = currentImage || defaultImage;
        drawMeme(img, (topInput && topInput.value.trim()) || null, (bottomInput && bottomInput.value.trim()) || null);
        downloadBtn.disabled = false;
    }

    if (previewBtn) previewBtn.addEventListener('click', updatePreview);

    fileInput.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (!file || !file.type.startsWith('image/')) { currentImage = null; updatePreview(); return; }
        var reader = new FileReader();
        reader.onload = function(ev) {
            var img = new Image();
            img.onload = function() {
                currentImage = img;
                updatePreview();
            };
            img.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });

    downloadBtn.addEventListener('click', function() {
        var link = document.createElement('a');
        link.download = 'nexora-tools-meme.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });

    drawDefault();
})();
</script>
@endpush
@endsection
