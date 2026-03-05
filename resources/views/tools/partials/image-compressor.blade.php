<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="img_file" class="form-label">Select image</label>
        <div class="fancy-upload">
            <input type="file" id="img_file" accept="image/jpeg,image/png,image/webp" class="d-none">
            <label for="img_file" class="fancy-upload__btn">
                <i class="fa-solid fa-cloud-arrow-up me-2"></i>Select image
            </label>
            <div class="fancy-upload__hint">or drop it here</div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="img_quality" class="form-label">Quality (1–100)</label>
            <input type="range" class="form-range" id="img_quality" min="1" max="100" value="80">
            <span id="img_quality_val">80</span>%
        </div>
        <div class="col-md-6">
            <label for="img_max_w" class="form-label">Max width (px)</label>
            <input type="number" class="form-control" id="img_max_w" placeholder="e.g. 1200" value="1200" min="100">
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="img_compress_btn" disabled>
        <i class="fa-solid fa-compress me-2"></i>Compress & Download
    </button>
    <div id="img_preview_wrap" class="mb-3 d-none">
        <label class="form-label text-body-secondary small">Preview</label>
        <div class="border rounded p-2 bg-light">
            <img id="img_preview" alt="Preview" style="max-width: 100%; max-height: 300px;">
        </div>
        <p class="small text-body-secondary mb-0 mt-2"><span id="img_original_size"></span> → <span id="img_new_size"></span></p>
    </div>
</div>

@push('scripts')
<script>
var imgFile = document.getElementById('img_file');
var imgQuality = document.getElementById('img_quality');
var imgQualityVal = document.getElementById('img_quality_val');
var imgMaxW = document.getElementById('img_max_w');
var btn = document.getElementById('img_compress_btn');
var previewWrap = document.getElementById('img_preview_wrap');
var preview = document.getElementById('img_preview');
var origSize = document.getElementById('img_original_size');
var newSize = document.getElementById('img_new_size');

imgQuality.addEventListener('input', function() { imgQualityVal.textContent = this.value; });
imgFile.addEventListener('change', function() {
    btn.disabled = !this.files.length;
    previewWrap.classList.add('d-none');
});

btn.addEventListener('click', function() {
    if (!imgFile.files.length) return;
    var file = imgFile.files[0];
    var reader = new FileReader();
    reader.onload = function() {
        var img = new Image();
        img.onload = function() {
            var w = Math.min(img.width, parseInt(imgMaxW.value) || 1200);
            var scale = w / img.width;
            var h = Math.round(img.height * scale);
            var c = document.createElement('canvas');
            c.width = w;
            c.height = h;
            var ctx = c.getContext('2d');
            ctx.drawImage(img, 0, 0, w, h);
            c.toBlob(function(blob) {
                var url = URL.createObjectURL(blob);
                var a = document.createElement('a');
                a.href = url;
                a.download = 'compressed-' + (file.name || 'image.jpg');
                a.click();
                URL.revokeObjectURL(url);
                origSize.textContent = (file.size / 1024).toFixed(1) + ' KB';
                newSize.textContent = (blob.size / 1024).toFixed(1) + ' KB';
                preview.src = url;
                previewWrap.classList.remove('d-none');
            }, 'image/jpeg', parseInt(imgQuality.value, 10) / 100);
        };
        img.src = reader.result;
    };
    reader.readAsDataURL(file);
});
</script>
@endpush
