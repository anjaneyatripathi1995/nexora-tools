<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="wc_input" class="form-label">Paste or type text</label>
        <textarea class="form-control" id="wc_input" rows="10" placeholder="Start typing or paste text here..."></textarea>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="border rounded p-3 text-center">
                <div class="fs-4 fw-bold text-primary" id="wc_words">0</div>
                <div class="small text-body-secondary">Words</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded p-3 text-center">
                <div class="fs-4 fw-bold text-success" id="wc_chars">0</div>
                <div class="small text-body-secondary">Characters</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded p-3 text-center">
                <div class="fs-4 fw-bold text-info" id="wc_sentences">0</div>
                <div class="small text-body-secondary">Sentences</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded p-3 text-center">
                <div class="fs-4 fw-bold text-warning" id="wc_paragraphs">0</div>
                <div class="small text-body-secondary">Paragraphs</div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateWordCount() {
    var t = document.getElementById('wc_input').value;
    var words = t.trim() ? t.trim().split(/\s+/).length : 0;
    document.getElementById('wc_words').textContent = words;
    document.getElementById('wc_chars').textContent = t.length;
    var sentences = (t.match(/[.!?]+/g) || []).length;
    document.getElementById('wc_sentences').textContent = sentences;
    var paras = t.trim() ? t.split(/\n\s*\n/).length : 0;
    document.getElementById('wc_paragraphs').textContent = paras;
}
document.getElementById('wc_input').addEventListener('input', updateWordCount);
document.getElementById('wc_input').addEventListener('paste', function(){ setTimeout(updateWordCount, 0); });
</script>
@endpush
