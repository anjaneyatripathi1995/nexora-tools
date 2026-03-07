<div class="json-lab" id="urlLab">
    <div style="margin-bottom:16px;text-align:right">
        <div class="btn-group btn-group-sm" role="group" aria-label="Color mode">
            <button type="button" class="btn btn-outline-secondary active" onclick="urlLocalTheme('light')">Light</button>
            <button type="button" class="btn btn-outline-secondary" onclick="urlLocalTheme('dark')">Dark</button>
        </div>
    </div>

    <div class="json-panels">
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Input</div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="pasteUrlInput()" title="Paste from clipboard">
                        <i class="fa-solid fa-clipboard me-1"></i>Paste
                    </button>
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyUrlInput()">
                        <i class="fa-solid fa-copy me-1"></i>Copy
                    </button>
                </div>
            </div>
            <textarea class="json-editor form-control font-monospace" id="url_input" rows="8" placeholder="Enter text or URL to encode..."></textarea>
        </div>
        <!-- mobile controls -->
        <div class="d-lg-none text-center my-3">
            <button type="button" class="btn btn-primary me-2" onclick="urlEncode()">Encode</button>
            <button type="button" class="btn btn-secondary" onclick="urlDecode()">Decode</button>
        </div>
        <div class="json-panel-actions d-none d-lg-flex">
            <div class="json-panel-actions__inner">
                <button type="button" class="json-circle-btn" onclick="urlEncode()" title="Encode to URL format ▶">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
                <div class="json-flow-hint">Encode</div>
                <button type="button" class="json-circle-btn" onclick="urlDecode()" title="Decode from URL format ◀">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </button>
                <div class="json-flow-hint">Decode</div>
            </div>
        </div>
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-code-branch me-2 text-success"></i>Result</div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="pasteUrlOutput()" title="Paste from clipboard">
                        <i class="fa-solid fa-clipboard me-1"></i>Paste
                    </button>
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyUrlOutput()">
                        <i class="fa-solid fa-copy me-1"></i>Copy
                    </button>
                </div>
            </div>
            <textarea class="json-output form-control font-monospace" id="url_output" rows="8"></textarea>
        </div>
    </div>

    <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px;margin-top:20px;font-size:0.95rem;line-height:1.6;color:var(--text)">
        <details style="cursor:pointer">
            <summary style="font-weight:600;color:var(--text-1);user-select:none">
                <i class="fa-solid fa-circle-info me-2"></i>What This Tool Does
            </summary>
            <div style="margin-top:12px;display:flex;flex-direction:column;gap:8px">
                <div><strong>Encode:</strong> Converts special characters and spaces to percent-encoded format (e.g., space → %20, & → %26). Suitable for encoding query parameters and URL segments.</div>
                <div><strong>Decode:</strong> Reverses the encoding process. Replaces + symbols with spaces first (handles form-encoded data). Uses decodeURIComponent() to convert percent-encoded characters back to original. Includes error handling to display decode errors gracefully.</div>
            </div>
        </details>
    </div>
</div>

@push('scripts')
<script>
(function(){
    function showToast(msg, type = 'success') {
        if(window.showFlash) {
            window.showFlash(msg, type, 3000);
        }
    }

    window.urlLocalTheme = function(mode) {
        var lab = document.getElementById('urlLab');
        if (!lab) return;
        lab.classList.remove('mode-light','mode-dark');
        lab.classList.add('mode-' + mode);
        
        // Update button states
        var buttons = document.querySelectorAll('#urlLab .btn-group .btn');
        buttons.forEach(function(btn, index) {
            btn.classList.remove('active');
            if ((mode === 'light' && index === 0) || (mode === 'dark' && index === 1)) {
                btn.classList.add('active');
            }
        });
    };
    
    // default light mode
    urlLocalTheme('light');

    window.urlEncode = function() {
        var input = document.getElementById('url_input').value;
        try {
            document.getElementById('url_output').value = encodeURIComponent(input);
            showToast('URL encoded successfully', 'success');
        } catch(e) {
            showToast('Error: ' + e.message, 'error');
        }
    };

    window.urlDecode = function() {
        var input = document.getElementById('url_input').value;
        try {
            document.getElementById('url_output').value = decodeURIComponent(input.replace(/\+/g, ' '));
            showToast('URL decoded successfully', 'success');
        } catch(e) {
            showToast('Error: ' + e.message, 'error');
        }
    };

    window.copyUrlInput = function() {
        navigator.clipboard.writeText(document.getElementById('url_input').value).then(function() {
            showToast('Input copied!', 'success');
        }).catch(function(err) {
            showToast('Copy failed', 'error');
        });
    };

    window.copyUrlOutput = function() {
        navigator.clipboard.writeText(document.getElementById('url_output').value).then(function() {
            showToast('Result copied!', 'success');
        }).catch(function(err) {
            showToast('Copy failed', 'error');
        });
    };

    window.pasteUrlInput = function() {
        navigator.clipboard.readText().then(function(text) {
            document.getElementById('url_input').value = text;
            showToast('Pasted to input!', 'success');
        }).catch(function(err) {
            showToast('Paste failed', 'error');
        });
    };

    window.pasteUrlOutput = function() {
        navigator.clipboard.readText().then(function(text) {
            document.getElementById('url_output').value = text;
            showToast('Pasted to result!', 'success');
        }).catch(function(err) {
            showToast('Paste failed', 'error');
        });
    };
})();
</script>
@endpush
