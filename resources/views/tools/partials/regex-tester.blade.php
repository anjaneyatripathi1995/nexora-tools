<div class="tool-form-wrap">
    <div class="row g-3 mb-3">
        <div class="col-12">
            <label for="regex_pattern" class="form-label">Regular expression</label>
            <input type="text" class="form-control font-monospace" id="regex_pattern" placeholder="e.g. ^[a-z]+$">
        </div>
        <div class="col-12">
            <label for="regex_test" class="form-label">Test string</label>
            <textarea class="form-control font-monospace" id="regex_test" rows="4" placeholder="Enter text to test..."></textarea>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="runRegex()">Test</button>
        </div>
    </div>
    <div id="regexError" class="alert alert-danger d-none mb-2"></div>
    <div id="regexMatches" class="mb-2"></div>
</div>

@push('scripts')
<script>
function runRegex() {
    var pat = document.getElementById('regex_pattern').value;
    var str = document.getElementById('regex_test').value;
    var errEl = document.getElementById('regexError');
    var outEl = document.getElementById('regexMatches');
    errEl.classList.add('d-none');
    if (!pat) { errEl.textContent = 'Enter a regular expression.'; errEl.classList.remove('d-none'); outEl.innerHTML = ''; return; }
    try {
        var re = new RegExp(pat, 'g');
        var matches = [], m;
        while ((m = re.exec(str)) !== null) matches.push(m[0]);
        if (matches.length === 0) outEl.innerHTML = '<div class="alert alert-secondary">No matches.</div>';
        else outEl.innerHTML = '<div class="alert alert-success"><strong>Matches (' + matches.length + '):</strong> ' + matches.map(function(x){ return '"' + x.replace(/"/g,'\\"') + '"'; }).join(', ') + '</div>';
    } catch (e) {
        errEl.textContent = 'Invalid regex: ' + e.message;
        errEl.classList.remove('d-none');
        outEl.innerHTML = '';
    }
}
</script>
@endpush
