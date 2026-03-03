<div class="tool-form-wrap">
    <p class="text-body-secondary small mb-3">Compare two texts to see how similar they are (word overlap). Useful for checking originality between your text and another source.</p>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <label for="plag_text1" class="form-label">Text 1 (e.g. original / reference)</label>
            <textarea class="form-control" id="plag_text1" rows="6" placeholder="Paste first text..."></textarea>
        </div>
        <div class="col-md-6">
            <label for="plag_text2" class="form-label">Text 2 (e.g. your text to check)</label>
            <textarea class="form-control" id="plag_text2" rows="6" placeholder="Paste second text..."></textarea>
        </div>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="plag_btn">
        <i class="fa-solid fa-copy me-2"></i>Compare Similarity
    </button>
    <div id="plag_result" class="alert d-none" role="alert"></div>
</div>

@push('scripts')
<script>
function normalize(t) {
    return t.toLowerCase().replace(/[^\w\s]/g, ' ').replace(/\s+/g, ' ').trim().split(/\s+/).filter(Boolean);
}
function wordSet(arr) {
    var s = {};
    arr.forEach(function(w) { s[w] = true; });
    return s;
}
document.getElementById('plag_btn').addEventListener('click', function() {
    var t1 = document.getElementById('plag_text1').value.trim();
    var t2 = document.getElementById('plag_text2').value.trim();
    var el = document.getElementById('plag_result');
    if (!t1 || !t2) {
        el.className = 'alert alert-warning';
        el.textContent = 'Please enter both texts.';
        el.classList.remove('d-none');
        return;
    }
    var w1 = normalize(t1);
    var w2 = normalize(t2);
    var set1 = wordSet(w1);
    var set2 = wordSet(w2);
    var common = 0;
    for (var w in set1) { if (set2[w]) common++; }
    var total = Object.keys(set1).length + Object.keys(set2).length - common;
    var similarity = total === 0 ? 0 : Math.round((common / total) * 100);
    el.className = 'alert ' + (similarity > 60 ? 'alert-warning' : similarity > 30 ? 'alert-info' : 'alert-success');
    el.innerHTML = '<strong>Similarity: ' + similarity + '%</strong><br>Common unique words: ' + common + ' / Combined unique: ' + total +
        '<br><small>High similarity may indicate overlap. This is a simple word-overlap check, not full plagiarism detection.</small>';
    el.classList.remove('d-none');
});
</script>
@endpush
