<div class="tool-form-wrap">
    <div class="mb-3">
        <label for="para_input" class="form-label">Enter or paste text to rephrase</label>
        <textarea class="form-control" id="para_input" rows="6" placeholder="Type or paste your text here..."></textarea>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="para_btn">
        <i class="fa-solid fa-pen-fancy me-2"></i>Rephrase
    </button>
    <div class="mb-2">
        <label class="form-label text-body-secondary small">Rephrased text</label>
        <textarea class="form-control" id="para_output" rows="6" readonly placeholder="Result will appear here"></textarea>
    </div>
    <p class="small text-body-secondary">Uses simple synonym replacement. For best results, use clear sentences.</p>
</div>

@push('scripts')
<script>
(function() {
    var synonyms = {
        'good': ['great', 'fine', 'nice', 'excellent'],
        'bad': ['poor', 'weak', 'negative', 'unfavorable'],
        'big': ['large', 'huge', 'major', 'significant'],
        'small': ['little', 'tiny', 'minor', 'slight'],
        'important': ['significant', 'key', 'vital', 'critical'],
        'use': ['utilize', 'apply', 'employ', 'adopt'],
        'make': ['create', 'produce', 'build', 'generate'],
        'get': ['obtain', 'receive', 'acquire', 'gain'],
        'think': ['consider', 'believe', 'feel', 'suppose'],
        'know': ['understand', 'recognize', 'realize', 'see'],
        'want': ['need', 'desire', 'wish', 'require'],
        'give': ['provide', 'offer', 'deliver', 'supply'],
        'help': ['assist', 'support', 'aid', 'facilitate'],
        'show': ['display', 'demonstrate', 'present', 'reveal'],
        'try': ['attempt', 'endeavor', 'seek', 'aim'],
        'start': ['begin', 'commence', 'initiate', 'launch'],
        'end': ['finish', 'conclude', 'complete', 'close'],
        'change': ['modify', 'alter', 'adjust', 'transform'],
        'different': ['distinct', 'various', 'diverse', 'alternative'],
        'many': ['numerous', 'multiple', 'several', 'various'],
        'new': ['recent', 'modern', 'fresh', 'current'],
        'old': ['previous', 'earlier', 'former', 'ancient'],
        'right': ['correct', 'accurate', 'proper', 'suitable'],
        'wrong': ['incorrect', 'mistaken', 'inaccurate', 'flawed'],
        'same': ['identical', 'similar', 'equivalent', 'alike'],
        'first': ['initial', 'primary', 'foremost', 'leading'],
        'last': ['final', 'ultimate', 'concluding', 'latest']
    };
    function reword(w) {
        var key = w.toLowerCase().replace(/[^a-z]/g, '');
        if (synonyms[key]) {
            var list = synonyms[key];
            return list[Math.floor(Math.random() * list.length)];
        }
        return w;
    }
    document.getElementById('para_btn').addEventListener('click', function() {
        var text = document.getElementById('para_input').value.trim();
        if (!text) {
            document.getElementById('para_output').value = '';
            return;
        }
        var words = text.split(/\b/);
        var out = [];
        for (var i = 0; i < words.length; i++) {
            if (/^[a-zA-Z]+$/.test(words[i]) && Math.random() < 0.45) {
                out.push(reword(words[i]));
            } else {
                out.push(words[i]);
            }
        }
        document.getElementById('para_output').value = out.join('');
    });
})();
</script>
@endpush
