<div class="json-lab">
    <div class="json-lab__header">
        <div>
            <h2 class="h4 fw-bold mb-1">JSON Studio</h2>
            <p class="text-body-secondary mb-0">Beautify, explore, and share JSON instantly — all in your browser.</p>
        </div>
        <div class="json-pill-tray">
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-shield-halved me-1"></i>Local only</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-bolt me-1"></i>Instant</span>
        </div>
    </div>

    <div class="json-toolbar">
        <div class="json-toolbar__row json-toolbar__row--inline">
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="loadSampleJson()"><i class="fa-solid fa-wand-magic-sparkles me-1"></i>Sample</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="copyJson()"><i class="fa-solid fa-copy me-1"></i>Copy</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="downloadJson()"><i class="fa-solid fa-download me-1"></i>Download</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearJson()"><i class="fa-solid fa-eraser me-1"></i>Clear</button>
        </div>
        <div class="json-toolbar__row json-toolbar__row--inline">
            <label class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="jsonIndentTabs" checked>
                <span class="ms-2">Use tabs</span>
            </label>
            <label class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="jsonSortKeys">
                <span class="ms-2">Sort keys</span>
            </label>
        </div>
    </div>

    <div class="json-grid">
        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title">Input JSON</div>
                <button type="button" class="btn btn-link btn-sm" onclick="formatJson()"><i class="fa-solid fa-wand-magic-sparkles me-1"></i>Format</button>
            </div>
            <textarea id="jsonInput" class="json-textarea" spellcheck="false" placeholder="{&#10;  &quot;hello&quot;: &quot;world&quot;&#10;}"></textarea>
        </div>

        <div class="json-panel">
            <div class="json-panel__head">
                <div class="json-panel__title">Formatted JSON</div>
            </div>
            <pre id="jsonOutput" class="json-output"><code class="language-json"></code></pre>
        </div>
    </div>
</div>
