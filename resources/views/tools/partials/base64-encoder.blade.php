<div class="json-lab" id="base64Lab">
    <div class="mb-2 text-end">
        <div class="btn-group btn-group-sm" role="group" aria-label="Color mode">
            <button type="button" class="btn btn-outline-secondary" onclick="base64LocalTheme('light')">Light</button>
            <button type="button" class="btn btn-outline-secondary" onclick="base64LocalTheme('dark')">Dark</button>
        </div>
    </div>
    <div class="json-panels">
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Input</div>
                <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyBase64Input()">
                    <i class="fa-solid fa-copy me-1"></i>Copy
                </button>
            </div>
            <textarea class="json-editor form-control font-monospace" id="base64_input" rows="8" placeholder="Enter text or Base64..."></textarea>
        </div>
        <!-- mobile controls -->
        <div class="d-lg-none text-center my-3">
            <button type="button" class="btn btn-primary me-2" onclick="base64Encode()">Encode</button>
            <button type="button" class="btn btn-secondary" onclick="base64Decode()">Decode</button>
        </div>
        <div class="json-panel-actions d-none d-lg-flex">
            <div class="json-panel-actions__inner">
                <button type="button" class="json-circle-btn" onclick="base64Encode()" title="Encode ▶">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
                <div class="json-flow-hint">Encode</div>
                <button type="button" class="json-circle-btn" onclick="base64Decode()" title="Decode ◀">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </button>
                <div class="json-flow-hint">Decode</div>
            </div>
        </div>
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-code-branch me-2 text-success"></i>Result</div>
                <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyBase64Output()">
                    <i class="fa-solid fa-copy me-1"></i>Copy
                </button>
            </div>
            <textarea class="json-output form-control font-monospace" id="base64_output" rows="8"></textarea>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function(){
    function showError(msg) {
        if(window.showFlash) { window.showFlash(msg,'error',4000); }
    }

    window.base64LocalTheme = function(mode) {
        var lab = document.getElementById('base64Lab');
        if (!lab) return;
        lab.classList.remove('mode-light', 'mode-dark');
        lab.classList.add('mode-' + mode);
        var btns = document.querySelectorAll('#base64Lab .btn-group .btn');
        btns.forEach(function (btn, i) {
            btn.classList.toggle('active', (mode === 'light' && i === 0) || (mode === 'dark' && i === 1));
        });
    };
    // default light mode
    base64LocalTheme('light');
    
    window.base64Encode = function() {
        var t = document.getElementById('base64_input').value;
        try {
            document.getElementById('base64_output').value = btoa(unescape(encodeURIComponent(t)));
        } catch(e) {
            showError(e.message);
        }
    };
    window.base64Decode = function() {
        var t = document.getElementById('base64_input').value.replace(/\s/g,'');
        try {
            document.getElementById('base64_output').value = decodeURIComponent(escape(atob(t)));
        } catch(e) {
            showError('Invalid Base64: '+e.message);
        }
    };
    window.copyBase64Input = function() {
        navigator.clipboard.writeText(document.getElementById('base64_input').value)
            .then(function () { if (window.showFlash) window.showFlash('Copied input', 'success', 2000); })
            .catch(function () { if (window.showFlash) window.showFlash('Copy failed', 'error', 2000); });
    };
    window.copyBase64Output = function() {
        navigator.clipboard.writeText(document.getElementById('base64_output').value)
            .then(function () { if (window.showFlash) window.showFlash('Copied output', 'success', 2000); })
            .catch(function () { if (window.showFlash) window.showFlash('Copy failed', 'error', 2000); });
    };

    // sync scroll positions between input and output
    var inEl = document.getElementById('base64_input');
    var outEl = document.getElementById('base64_output');
    function syncScroll(e) {
        if (e.target === inEl) {
            outEl.scrollTop = inEl.scrollTop;
            outEl.scrollLeft = inEl.scrollLeft;
        } else {
            inEl.scrollTop = outEl.scrollTop;
            inEl.scrollLeft = outEl.scrollLeft;
        }
    }
    inEl.addEventListener('scroll', syncScroll);
    outEl.addEventListener('scroll', syncScroll);
})();
</script>
@endpush
