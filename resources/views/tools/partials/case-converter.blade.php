<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="case_input" class="form-label">Enter text</label>
        <textarea class="form-control" id="case_input" rows="6" placeholder="Type or paste text to convert..."></textarea>
    </div>
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button type="button" class="btn btn-primary" onclick="caseConvert('upper')">UPPERCASE</button>
        <button type="button" class="btn btn-outline-primary" onclick="caseConvert('lower')">lowercase</button>
        <button type="button" class="btn btn-outline-primary" onclick="caseConvert('title')">Title Case</button>
        <button type="button" class="btn btn-outline-primary" onclick="caseConvert('sentence')">Sentence case</button>
    </div>
    <div class="mb-2">
        <label class="form-label text-body-secondary small">Result</label>
        <textarea class="form-control" id="case_output" rows="6" readonly placeholder="Converted text"></textarea>
    </div>
</div>

@push('scripts')
<script>
function caseConvert(mode) {
    var t = document.getElementById('case_input').value;
    var out = '';
    if (mode === 'upper') out = t.toUpperCase();
    else if (mode === 'lower') out = t.toLowerCase();
    else if (mode === 'title') out = t.toLowerCase().replace(/(?:^|\s)\w/g, function(c) { return c.toUpperCase(); });
    else if (mode === 'sentence') {
        out = t.toLowerCase().replace(/(^\s*\w|\.\s*\w)/g, function(c) { return c.toUpperCase(); });
    }
    document.getElementById('case_output').value = out;
}
</script>
@endpush
