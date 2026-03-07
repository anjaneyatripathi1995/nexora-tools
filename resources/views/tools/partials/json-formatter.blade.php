<div class="json-lab">
    <div class="json-lab__header">
        <div>
            <h2 class="h4 fw-bold mb-1">JSON Studio</h2>
            <p class="text-body-secondary mb-0">Beautify, explore, and share JSON instantly – all in your browser.</p>
        </div>
        <div class="json-pill-tray">
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-shield-halved me-1"></i>Local only</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-bolt me-1"></i>Instant</span>
        </div>
    </div>

    <div class="json-toolbar">
        <div class="json-toolbar__row json-toolbar__row--inline">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadSampleJson()"><i class="fa-solid fa-wand-magic-sparkles me-1"></i>Sample</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyJsonOutput()"><i class="fa-solid fa-copy me-1"></i>Copy</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="pasteFromClipboard()"><i class="fa-solid fa-clipboard me-1"></i>Paste</button>
            <label class="json-upload btn btn-outline-secondary btn-sm mb-0">
                <i class="fa-solid fa-upload me-1"></i>Upload
                <input type="file" id="jsonFileInput" accept=".json,.txt,application/json" hidden>
            </label>

            <button type="button" class="btn btn-primary btn-sm" onclick="formatJson()"><i class="fa-solid fa-wand-magic-sparkles me-1"></i>Beautify</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearEditors()"><i class="fa-solid fa-eraser me-1"></i>Clear</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="downloadJson()"><i class="fa-solid fa-download me-1"></i>Download</button>

            <div class="json-indent ms-2 d-inline-flex align-items-center gap-2 flex-shrink-0">
                <span class="text-body-secondary small">Indent</span>
                <select id="jsonIndent" class="form-select form-select-sm w-auto">
                    <option value="2" selected>2 spaces</option>
                    <option value="4">4 spaces</option>
                    <option value="8">8 spaces</option>
                    <option value="tab">Tab</option>
                </select>
            </div>
        </div>
    </div>

    <div class="json-panels">
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Input</div>
                <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyInputText()">
                    <i class="fa-solid fa-copy me-1"></i>Copy
                </button>
            </div>
            <textarea class="json-editor form-control font-monospace" id="jsonInput" rows="14" placeholder='{"key": "value"}'></textarea>
        </div>
        <div class="json-panel-actions d-none d-lg-flex">
            <div class="json-panel-actions__inner">
                <button type="button" class="json-circle-btn" onclick="formatJson()" title="Beautify input → output">
                    <i class="fa-solid fa-arrow-right-long"></i>
                </button>
                <div class="json-flow-hint">Beautify</div>
                <button type="button" class="json-circle-btn" onclick="copyOutputToInput()" title="Send output back to input (raw)">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </button>
                <div class="json-flow-hint">Send back</div>
            </div>
        </div>
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title-group">
                    <div class="json-panel__title"><i class="fa-solid fa-code-branch me-2 text-success"></i>Output</div>
                    <button type="button" class="btn btn-light btn-sm json-copy-btn" onclick="copyJsonOutput()">
                        <i class="fa-solid fa-copy me-1"></i>Copy
                    </button>
                </div>
                <div class="json-view-toggle">
                    <button class="btn btn-sm btn-light active" data-json-view="pretty" onclick="setJsonView('pretty')">Pretty</button>
                    <button class="btn btn-sm btn-light" data-json-view="tree" onclick="setJsonView('tree')">Tree</button>
                    <button class="btn btn-sm btn-light" data-json-view="raw" onclick="setJsonView('raw')">Raw</button>
                </div>
            </div>
            <pre id="jsonOutput" class="json-output" contenteditable="true" aria-label="Formatted JSON output (editable)"></pre>
            <div id="jsonTree" class="json-tree d-none"></div>
        </div>
    </div>

    <div id="jsonError" class="d-none"></div>
    <div id="jsonSuccess" class="d-none"></div>
</div>

@push('scripts')
<script>
(function() {
    var inputEl   = document.getElementById('jsonInput');
    var outputEl  = document.getElementById('jsonOutput');
    var treeEl    = document.getElementById('jsonTree');
    var indentSel = document.getElementById('jsonIndent');
    var fileInput = document.getElementById('jsonFileInput');
    var currentObj = null;

    fileInput.addEventListener('change', function(e) {
        var file = e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(ev) {
            inputEl.value = ev.target.result;
            formatJson();
        };
        reader.readAsText(file);
        fileInput.value = '';
    });

    function showSuccess(msg) {
        if (window.showFlash) {
            window.showFlash(msg, 'success', 3000);
        }
    }
    function showError(msg) {
        if (window.showFlash) {
            window.showFlash(msg, 'error', 4000);
        }
    }
    function parseInput() {
        var text = inputEl.value.trim();
        if (!text) { throw new Error('Please enter JSON.'); }
        var obj = JSON.parse(text);
        currentObj = obj;
        return obj;
    }
    function renderOutput(obj, mode) {
        var indentValue = indentSel.value === 'tab' ? '\t' : parseInt(indentSel.value, 10);
        if (mode === 'tree') {
            outputEl.classList.add('d-none');
            outputEl.setAttribute('contenteditable', 'false');
            treeEl.classList.remove('d-none');
            treeEl.innerHTML = buildTree(obj);
        } else {
            treeEl.classList.add('d-none');
            outputEl.classList.remove('d-none');
            outputEl.setAttribute('contenteditable', 'true');
            outputEl.textContent = mode === 'pretty'
                ? JSON.stringify(obj, null, indentValue)
                : JSON.stringify(obj);
        }
    }
    function buildTree(value) {
        if (typeof value === 'object' && value !== null) {
            var entries = Array.isArray(value)
                ? value.map(function(v, i) { return [i, v]; })
                : Object.entries(value);
            var children = entries.map(function(entry) {
                var key = entry[0], val = entry[1];
                if (typeof val === 'object' && val !== null) {
                    return '<li><details><summary><span class=\"json-tree__key\">' + escapeHtml(key) + '</span> ' + summaryLabel(val) + '</summary>' + buildTree(val) + '</details></li>';
                }
                return '<li><span class=\"json-tree__key\">' + escapeHtml(key) + '</span>: <span class=\"json-tree__value json-tree__value--' + typeof val + '\">' + escapeHtml(formatPrimitive(val)) + '</span></li>';
            }).join('');
            return '<ul class=\"json-tree__list\">' + children + '</ul>';
        }
        return '<span class=\"json-tree__value json-tree__value--' + typeof value + '\">' + escapeHtml(formatPrimitive(value)) + '</span>';
    }
    function summaryLabel(val) {
        return Array.isArray(val) ? '[Array ' + val.length + ']' : '{Object ' + Object.keys(val).length + '}';
    }
    function formatPrimitive(v) {
        if (v === null) return 'null';
        if (typeof v === 'string') return '"' + v + '"';
        return String(v);
    }
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }
    function setViewButton(mode) {
        document.querySelectorAll('[data-json-view]').forEach(function(btn) {
            btn.classList.toggle('active', btn.getAttribute('data-json-view') === mode);
        });
    }

    window.formatJson = function() {
        try {
            var obj = parseInput();
            renderOutput(obj, 'pretty');
            setViewButton('pretty');
            showSuccess('Formatted.');
        } catch (e) {
            showError('Invalid JSON: ' + e.message);
        }
    };
    window.copyJsonOutput = function() {
        var textToCopy = outputEl.classList.contains('d-none') ? treeEl.innerText.trim() : outputEl.textContent;
        if (!textToCopy) return;
        navigator.clipboard.writeText(textToCopy).then(function() {
            showSuccess('Copied to clipboard.');
        });
    };
    window.downloadJson = function() {
        var text = outputEl.classList.contains('d-none') ? inputEl.value.trim() : outputEl.textContent;
        if (!text) { showError('Nothing to download yet.'); return; }
        var blob = new Blob([text], { type: 'application/json' });
        var a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = 'data.json';
        a.click();
        URL.revokeObjectURL(a.href);
        showSuccess('Download ready.');
    };
    window.clearEditors = function() {
        inputEl.value = '';
        outputEl.textContent = '';
        treeEl.innerHTML = '';
        currentObj = null;
        outputEl.classList.remove('d-none');
        treeEl.classList.add('d-none');
        showSuccess('Cleared.');
    };
    window.setJsonView = function(mode) {
        if (!currentObj) {
            showError('Format or validate first to populate output.');
            return;
        }
        renderOutput(currentObj, mode);
        setViewButton(mode);
        if (mode === 'tree') { showSuccess('Tree view generated.'); }
    };
    window.pasteFromClipboard = function() {
        navigator.clipboard.readText().then(function(text) {
            inputEl.value = text;
            showSuccess('Pasted from clipboard.');
        }).catch(function() {
            showError('Clipboard access was blocked.');
        });
    };
    window.loadSampleJson = function() {
        var sample = {
            status: "success",
            message: "Sample data",
            user: { id: 101, name: "Taylor", roles: ["reader", "editor"] },
            items: [
                { sku: "A1", qty: 2, price: 9.99 },
                { sku: "B4", qty: 1, price: 19.5 }
            ]
        };
        inputEl.value = JSON.stringify(sample, null, 2);
        formatJson();
    };
    window.copyInputToOutput = function() {
        var text = inputEl.value.trim();
        if (!text) { showError('Nothing to send.'); return; }
        outputEl.textContent = text;
        treeEl.classList.add('d-none');
        outputEl.classList.remove('d-none');
        currentObj = null;
        setViewButton('raw');
        showSuccess('Sent input to output.');
    };
    window.copyInputText = function() {
        var text = inputEl.value.trim();
        if (!text) { showError('Nothing to copy from input.'); return; }
        navigator.clipboard.writeText(text).then(function() {
            showSuccess('Input copied.');
        });
    };
    window.copyOutputToInput = function() {
        var text = outputEl.classList.contains('d-none') ? treeEl.innerText.trim() : outputEl.textContent;
        if (!text && !currentObj) { showError('Nothing to bring back.'); return; }

        if (currentObj) {
            inputEl.value = JSON.stringify(currentObj);
            showSuccess('Output sent to input as raw JSON.');
            return;
        }

        try {
            var parsed = JSON.parse(text);
            inputEl.value = JSON.stringify(parsed);
            showSuccess('Output sent to input as raw JSON.');
        } catch (e) {
            // Fallback to plain copy if parsing fails (e.g., tree view text)
            inputEl.value = text;
            showError('Could not parse output as JSON; pasted as-is.');
        }
    };
})();
</script>
@endpush