@push('styles')
<style>
 .pdf-convert-hero { text-align: center; padding: 3.5rem 1rem; border-radius: 12px; background: #f7f7fb; }
 .pdf-select-btn { background: #e53935; border-color: #e53935; color: #fff; padding: 1.25rem 2.5rem; font-size: 1.25rem; border-radius: 12px; box-shadow: 0 6px 18px rgba(229,57,53,0.12); }
 .pdf-side-btn { width:48px; height:48px; border-radius:50%; background:#e53935; color:#fff; display:inline-flex; align-items:center; justify-content:center; margin-left:.75rem }
</style>
@endpush

<div class="pdf-convert-hero mb-4">
    <h1 class="fw-bold display-5 mb-2">Image to Text (OCR)</h1>
    <p class="mb-3 text-muted">Extract text from images using optical character recognition.</p>
    <p class="small text-muted">Browser-run OCR via Tesseract.js; works offline.</p>

    <div class="d-flex justify-content-center align-items-center mt-4">
        <label class="pdf-select-btn" for="ocr_file">Select Image</label>
        <div class="d-inline-block">
            <button class="pdf-side-btn" title="Google Drive"><i class="fa-brands fa-google-drive"></i></button>
            <button class="pdf-side-btn" title="Dropbox"><i class="fa-brands fa-dropbox"></i></button>
        </div>
    </div>

    <form class="d-none" id="ocr_form">
        @csrf
        <input type="file" class="form-control form-control-lg" id="ocr_file" accept="image/png,image/jpeg,image/jpg,image/webp" style="display:none">
    </form>

    <button type="button" class="btn btn-primary mb-3" id="ocr_btn" disabled>
        <i class="fa-solid fa-font me-2"></i>Extract Text (OCR)
    </button>

    <div id="ocr_result_wrap" class="d-none">
        <label class="form-label text-body-secondary small">Extracted text</label>
        <textarea class="form-control font-monospace" id="ocr_result" rows="8" readonly></textarea>
    </div>

    <p class="small text-body-secondary mt-2">Uses browser-based OCR. For best accuracy, use a clear image with horizontal text.</p>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script>
document.getElementById('ocr_file').addEventListener('change', function() { document.getElementById('ocr_btn').disabled = !this.files.length; });
document.getElementById('ocr_btn').addEventListener('click', function() { var file = document.getElementById('ocr_file').files[0]; if (!file) return; var btn = this; var wrap = document.getElementById('ocr_result_wrap'); var out = document.getElementById('ocr_result'); btn.disabled = true; out.value = 'Processing...'; wrap.classList.remove('d-none'); if (typeof Tesseract === 'undefined') { out.value = 'Tesseract.js not loaded. Check your connection.'; btn.disabled = false; return; } Tesseract.recognize(file, 'eng', { logger: function(m) { if (m.status === 'recognizing text') out.value = 'Recognizing... ' + (m.progress * 100).toFixed(0) + '%'; } }) .then(function(result) { out.value = result.data.text || '(No text detected)'; btn.disabled = false; }) .catch(function(err) { out.value = 'Error: ' + err.message; btn.disabled = false; }); });
</script>
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script>
document.getElementById('ocr_file').addEventListener('change', function() {
    document.getElementById('ocr_btn').disabled = !this.files.length;
});
document.getElementById('ocr_btn').addEventListener('click', function() {
    var file = document.getElementById('ocr_file').files[0];
    if (!file) return;
    var btn = this;
    var wrap = document.getElementById('ocr_result_wrap');
    var out = document.getElementById('ocr_result');
    btn.disabled = true;
    out.value = 'Processing...';
    wrap.classList.remove('d-none');
    if (typeof Tesseract === 'undefined') {
        out.value = 'Tesseract.js not loaded. Check your connection.';
        btn.disabled = false;
        return;
    }
    Tesseract.recognize(file, 'eng', { logger: function(m) { if (m.status === 'recognizing text') out.value = 'Recognizing... ' + (m.progress * 100).toFixed(0) + '%'; } })
        .then(function(result) {
            out.value = result.data.text || '(No text detected)';
            btn.disabled = false;
        })
        .catch(function(err) {
            out.value = 'Error: ' + err.message;
            btn.disabled = false;
        });
});
</script>
@endpush
