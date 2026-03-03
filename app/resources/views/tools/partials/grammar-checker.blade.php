<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="grammar_input" class="form-label">Paste text to check</label>
        <textarea class="form-control" id="grammar_input" rows="8" placeholder="Paste your text here for grammar and spell check..."></textarea>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="grammar_btn">
        <i class="fa-solid fa-spell-check me-2"></i>Check Grammar
    </button>
    <div id="grammar_loading" class="alert alert-secondary d-none">Checking...</div>
    <div id="grammar_result" class="d-none">
        <label class="form-label text-body-secondary small">Issues found</label>
        <div id="grammar_list" class="mb-3"></div>
        <p class="small text-body-secondary mb-0">Powered by LanguageTool. For full checks, use their desktop or browser extension.</p>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('grammar_btn').addEventListener('click', function() {
    var text = document.getElementById('grammar_input').value.trim();
    var loading = document.getElementById('grammar_loading');
    var result = document.getElementById('grammar_result');
    var list = document.getElementById('grammar_list');
    if (!text) {
        result.classList.add('d-none');
        return;
    }
    loading.classList.remove('d-none');
    result.classList.add('d-none');
    var formData = new FormData();
    formData.append('text', text);
    formData.append('_token', '{{ csrf_token() }}');
    fetch('{{ route("tools.process.grammar-check") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        loading.classList.add('d-none');
        if (data.error && data.matches.length === 0) {
            list.innerHTML = '<div class="alert alert-warning">' + data.error + '</div>';
        } else {
            var issues = data.matches || [];
            if (issues.length === 0) {
                list.innerHTML = '<div class="alert alert-success">No issues found.</div>';
            } else {
                list.innerHTML = issues.slice(0, 20).map(function(m) {
                    var msg = m.message || 'Suggestion';
                    var repl = (m.replacements && m.replacements[0]) ? m.replacements[0].value : '';
                    var ctx = (m.context && m.context.text) ? m.context.text : '';
                    return '<div class="border rounded p-2 mb-2"><strong>' + msg + '</strong>' +
                        (repl ? ' → Try: ' + repl : '') +
                        (ctx ? '<br><small class="text-body-secondary">' + ctx + '</small>' : '') + '</div>';
                }).join('');
            }
        }
        result.classList.remove('d-none');
    })
    .catch(function() {
        loading.classList.add('d-none');
        list.innerHTML = '<div class="alert alert-warning">Request failed. Try again later.</div>';
        result.classList.remove('d-none');
    });
});
</script>
@endpush
