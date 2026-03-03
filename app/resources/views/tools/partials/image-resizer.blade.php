<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="resizer_file" class="form-label">Select image</label>
        <div class="fancy-upload">
            <input type="file" id="resizer_file" accept="image/jpeg,image/png,image/webp,image/gif" class="d-none">
            <label for="resizer_file" class="fancy-upload__btn">
                <i class="fa-solid fa-cloud-arrow-up me-2"></i>Select image
            </label>
            <div class="fancy-upload__hint">or drop it here</div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="resizer_width" class="form-label">Width (px)</label>
            <input type="number" class="form-control" id="resizer_width" placeholder="e.g. 800" min="1" max="10000">
        </div>
        <div class="col-md-6">
            <label for="resizer_height" class="form-label">Height (px)</label>
            <input type="number" class="form-control" id="resizer_height" placeholder="e.g. 600" min="1" max="10000">
        </div>
    </div>
    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="resizer_ratio" checked>
            <label class="form-check-label" for="resizer_ratio">Maintain aspect ratio (use width; height auto)</label>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="resizer_format" class="form-label">Output format</label>
            <select class="form-select" id="resizer_format">
                <option value="jpeg">JPEG</option>
                <option value="png">PNG</option>
                <option value="webp">WebP</option>
            </select>
        </div>
        <div class="col-md-6" id="resizer_quality_wrap">
            <label for="resizer_quality" class="form-label">Quality (1–100)</label>
            <input type="range" class="form-range" id="resizer_quality" min="1" max="100" value="90">
            <span id="resizer_quality_val">90</span>%
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="resizer_btn" disabled>
        <i class="fa-solid fa-expand me-2"></i>Resize & Download
    </button>
    <div id="resizer_preview_wrap" class="mb-3 d-none">
        <label class="form-label text-body-secondary small">Preview</label>
        <div class="border rounded p-2 bg-light">
            <img id="resizer_preview" alt="Preview" style="max-width: 100%; max-height: 300px;">
        </div>
        <p class="small text-body-secondary mb-0 mt-2"><span id="resizer_original"></span> → <span id="resizer_new"></span></p>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var fileIn = document.getElementById('resizer_file');
    var widthIn = document.getElementById('resizer_width');
    var heightIn = document.getElementById('resizer_height');
    var ratioCb = document.getElementById('resizer_ratio');
    var formatSel = document.getElementById('resizer_format');
    var qualityIn = document.getElementById('resizer_quality');
    var qualityVal = document.getElementById('resizer_quality_val');
    var qualityWrap = document.getElementById('resizer_quality_wrap');
    var btn = document.getElementById('resizer_btn');
    var previewWrap = document.getElementById('resizer_preview_wrap');
    var preview = document.getElementById('resizer_preview');
    var origSpan = document.getElementById('resizer_original');
    var newSpan = document.getElementById('resizer_new');

    qualityIn.addEventListener('input', function() { qualityVal.textContent = this.value; });
    formatSel.addEventListener('change', function() {
        qualityWrap.style.display = (this.value === 'png') ? 'none' : 'block';
    });

    fileIn.addEventListener('change', function() {
        if (!this.files.length) { btn.disabled = true; return; }
        var f = this.files[0];
        var reader = new FileReader();
        reader.onload = function() {
            var img = new Image();
            img.onload = function() {
                widthIn.value = img.width;
                if (ratioCb.checked) heightIn.value = img.height;
                else heightIn.value = img.height;
                btn.disabled = false;
            };
            img.src = reader.result;
        };
        reader.readAsDataURL(f);
        previewWrap.classList.add('d-none');
    });

    btn.addEventListener('click', function() {
        if (!fileIn.files.length) return;
        var file = fileIn.files[0];
        var w = parseInt(widthIn.value, 10) || 800;
        var h = parseInt(heightIn.value, 10) || 600;
        var keepRatio = ratioCb.checked;
        var format = formatSel.value;
        var quality = parseInt(qualityIn.value, 10) / 100;

        var reader = new FileReader();
        reader.onload = function() {
            var img = new Image();
            img.onload = function() {
                var outW = w;
                var outH = h;
                if (keepRatio) {
                    outW = w;
                    outH = Math.round(img.height * (w / img.width));
                    if (outH < 1) outH = 1;
                } else {
                    outW = Math.max(1, w);
                    outH = Math.max(1, h);
                }
                var canvas = document.createElement('canvas');
                canvas.width = outW;
                canvas.height = outH;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, outW, outH);

                var mime = format === 'png' ? 'image/png' : (format === 'webp' ? 'image/webp' : 'image/jpeg');
                var qualityArg = (format === 'png') ? undefined : quality;
                canvas.toBlob(function(blob) {
                    var url = URL.createObjectURL(blob);
                    var ext = format === 'png' ? 'png' : (format === 'webp' ? 'webp' : 'jpg');
                    var name = (file.name || 'image').replace(/\.[^.]+$/, '') + '-resized.' + ext;
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = name;
                    a.click();
                    URL.revokeObjectURL(url);
                    origSpan.textContent = img.width + '×' + img.height;
                    newSpan.textContent = outW + '×' + outH + ' (' + (blob.size / 1024).toFixed(1) + ' KB)';
                    preview.src = url;
                    previewWrap.classList.remove('d-none');
                }, mime, qualityArg);
            };
            img.src = reader.result;
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
