{{-- ─── Code Minifier — HTML/CSS/JS ──────────────────────────────────────────
     Uses CodeMirror 5 for syntax-highlighted editing and Terser for real JS
     minification. CSS/HTML are compressed with robust pure-JS routines.
     Everything runs 100% in the browser — no code leaves the page.
──────────────────────────────────────────────────────────────────────────── --}}

@push('head_styles')
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.css"
      crossorigin="anonymous" referrerpolicy="no-referrer">
<style>
/* ── Minifier Lab ─────────────────────────────────────────────────────────── */
.minify-lab {
    background: linear-gradient(135deg, #f0f9ff 0%, #eef2ff 100%);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1.25rem 1.25rem 1rem;
    box-shadow: var(--shadow-md);
}
html[data-theme="dark"] .minify-lab {
    background: linear-gradient(135deg, rgba(15,23,42,0.7) 0%, rgba(30,41,59,0.7) 100%);
    border-color: rgba(255,255,255,0.08);
    box-shadow: 0 12px 36px rgba(0,0,0,0.35);
}

/* ── Header ── */
.minify-lab__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.1rem;
}

/* ── Language tabs ── */
.minify-lang-tabs {
    display: inline-flex;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 10px;
    padding: 3px;
    gap: 2px;
    margin-bottom: 0.875rem;
    flex-wrap: wrap;
}
.minify-lang-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.38rem 1rem;
    border-radius: 7px;
    border: none;
    background: transparent;
    color: var(--text-2);
    font-size: 0.855rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
    white-space: nowrap;
    line-height: 1;
}
.minify-lang-tab:hover:not(.active) {
    background: var(--bg-card);
    color: var(--text);
}
.minify-lang-tab.active {
    background: var(--primary);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(37,99,235,0.4);
}

/* ── Toolbar ── */
.minify-toolbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.875rem;
    padding: 0.6rem 0.875rem;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 10px;
}

/* ── Stats bar ── */
.minify-stats {
    display: flex;
    align-items: stretch;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 0.875rem;
}
.minify-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 0.65rem 1rem;
    flex: 1;
    min-width: 80px;
    text-align: center;
    position: relative;
}
.minify-stat + .minify-stat::before {
    content: '';
    position: absolute;
    left: 0;
    top: 18%;
    bottom: 18%;
    width: 1px;
    background: var(--border);
}
.minify-stat__label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--text-3);
    margin-bottom: 0.2rem;
}
.minify-stat__value {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
    line-height: 1.2;
}
.minify-stat--savings .minify-stat__value { color: var(--success); }
.minify-stat--pct { flex: 1.4; }
.minify-stat__bar-wrap {
    width: 100%;
    height: 4px;
    background: var(--border);
    border-radius: 2px;
    margin: 0.2rem 0 0.15rem;
    overflow: hidden;
}
.minify-stat__bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    border-radius: 2px;
    width: 0%;
    transition: width 0.55s cubic-bezier(0.34,1.56,0.64,1);
}

/* ── Panels grid ── */
.minify-panels {
    display: grid;
    grid-template-columns: 1fr 42px 1fr;
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg-card);
    margin-bottom: 0.875rem;
}
.minify-panel {
    display: flex;
    flex-direction: column;
    min-height: 440px;
    position: relative;
}
.minify-panel__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.875rem;
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
    gap: 0.5rem;
    flex-shrink: 0;
}
.minify-panel__label {
    font-size: 0.775rem;
    font-weight: 600;
    color: var(--text-2);
}
.minify-panel__badge {
    display: inline-flex;
    align-items: center;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    padding: 0.16rem 0.5rem;
    border-radius: 5px;
    background: var(--primary-light);
    color: var(--primary);
}

/* CodeMirror editor wrapper */
.minify-panel__editor {
    flex: 1;
    position: relative;
    overflow: hidden;
}
.minify-panel__editor .CodeMirror {
    height: 100%;
    min-height: 400px;
    font-family: 'Fira Code', 'Cascadia Code', 'JetBrains Mono', Consolas, 'Courier New', monospace;
    font-size: 0.83rem;
    line-height: 1.65;
    border: none;
    border-radius: 0;
    background: #ffffff;
    color: #1e293b;
}
.minify-panel__editor .CodeMirror-scroll { min-height: 400px; }
.minify-panel__editor .CodeMirror-gutters {
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
}
.minify-panel__editor .CodeMirror-linenumber { color: #94a3b8; font-size: 0.75rem; }
.minify-panel__editor .CodeMirror-cursor { border-left: 2px solid #2563eb; }
.minify-panel__editor .CodeMirror-selected { background: #dbeafe; }
.minify-panel__editor .CodeMirror-activeline-background { background: rgba(37,99,235,0.04); }
/* Dark mode overrides */
html[data-theme="dark"] .minify-panel__editor .CodeMirror {
    background: #0d1b2e;
    color: #e2e8f0;
}
html[data-theme="dark"] .minify-panel__editor .CodeMirror-gutters {
    background: #081625;
    border-right-color: #1a3a5c;
}
html[data-theme="dark"] .minify-panel__editor .CodeMirror-linenumber { color: #3d5a7a; }
html[data-theme="dark"] .minify-panel__editor .CodeMirror-cursor { border-left-color: #60a5fa; }
html[data-theme="dark"] .minify-panel__editor .CodeMirror-selected { background: rgba(37,99,235,0.28); }
html[data-theme="dark"] .minify-panel__editor .CodeMirror-activeline-background { background: rgba(37,99,235,0.08); }
/* Syntax tokens — dark mode */
html[data-theme="dark"] .cm-keyword   { color: #c084fc !important; }
html[data-theme="dark"] .cm-def       { color: #60a5fa !important; }
html[data-theme="dark"] .cm-variable  { color: #e2e8f0 !important; }
html[data-theme="dark"] .cm-string    { color: #86efac !important; }
html[data-theme="dark"] .cm-number    { color: #fbbf24 !important; }
html[data-theme="dark"] .cm-comment   { color: #4a6a8a !important; font-style: italic; }
html[data-theme="dark"] .cm-operator  { color: #94a3b8 !important; }
html[data-theme="dark"] .cm-property  { color: #7dd3fc !important; }
html[data-theme="dark"] .cm-atom      { color: #f87171 !important; }
html[data-theme="dark"] .cm-tag       { color: #f9a8d4 !important; }
html[data-theme="dark"] .cm-attribute { color: #6ee7b7 !important; }
html[data-theme="dark"] .cm-qualifier { color: #c084fc !important; }
/* Output editor (read-only) — subtle tint */
.minify-panel:last-child .minify-panel__editor .CodeMirror {
    background: #f9fafb;
}
html[data-theme="dark"] .minify-panel:last-child .minify-panel__editor .CodeMirror {
    background: #071120;
}

/* ── Middle separator / run button ── */
.minify-panels__sep {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-elevated);
    border-left: 1px solid var(--border);
    border-right: 1px solid var(--border);
    position: relative;
    z-index: 1;
}
.minify-panels__run {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--primary);
    color: #fff;
    border: 3px solid var(--bg-card);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(37,99,235,0.5);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
    position: relative;
    z-index: 2;
}
.minify-panels__run:hover {
    transform: scale(1.13);
    box-shadow: 0 4px 18px rgba(37,99,235,0.65);
}
.minify-panels__run.is-loading i {
    animation: minify-spin 0.7s linear infinite;
}
@keyframes minify-spin { to { transform: rotate(360deg); } }

/* ── Empty output state ── */
.minify-empty-state {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    pointer-events: none;
    z-index: 5;
    background: #f9fafb;
    transition: opacity 0.2s;
}
html[data-theme="dark"] .minify-empty-state { background: #071120; }
.minify-empty-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: var(--primary);
}
.minify-empty-state p {
    color: var(--text-3);
    font-size: 0.84rem;
    text-align: center;
    max-width: 180px;
    margin: 0;
}

/* ── Drag-over overlay ── */
.minify-panel.drag-over .minify-panel__editor::after {
    content: '⬇ Drop file here';
    position: absolute;
    inset: 0;
    background: rgba(37,99,235,0.1);
    border: 2px dashed var(--primary);
    border-radius: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--primary);
    pointer-events: none;
    z-index: 20;
    letter-spacing: 0.03em;
}

/* ── Error bar ── */
.minify-error {
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
    padding: 0.75rem 1rem;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.3);
    border-radius: 8px;
    color: var(--danger);
    font-size: 0.84rem;
    margin-bottom: 0.875rem;
    font-family: 'Fira Code', Consolas, monospace;
}

/* ── Options bar ── */
.minify-options {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.35rem 1.25rem;
    padding: 0.55rem 0.875rem;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 10px;
}
.minify-options__title {
    font-size: 0.73rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--text-3);
    margin-right: 0.15rem;
    white-space: nowrap;
}

/* ── Responsive ── */
@media (max-width: 880px) {
    .minify-panels {
        grid-template-columns: 1fr;
        grid-template-rows: auto 38px auto;
    }
    .minify-panels__sep {
        height: 38px;
        border-left: none;
        border-right: none;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }
    .minify-panel { min-height: 260px; }
    .minify-panel__editor .CodeMirror,
    .minify-panel__editor .CodeMirror-scroll { min-height: 240px; }
    .minify-stats { flex-wrap: wrap; }
    .minify-stat { min-width: 45%; padding: 0.5rem 0.75rem; }
    .minify-stat + .minify-stat::before { display: none; }
}
@media (max-width: 576px) {
    .minify-lang-tab { padding: 0.35rem 0.65rem; font-size: 0.8rem; }
    .minify-toolbar { padding: 0.5rem 0.65rem; }
}
</style>
@endpush

{{-- ─── Markup ───────────────────────────────────────────────────────────────── --}}
<div class="minify-lab" id="minifyLab">

    {{-- Header --}}
    <div class="minify-lab__header">
        <div>
            <h2 class="h4 fw-bold mb-1">Code Minifier</h2>
            <p class="text-body-secondary mb-0 small">Compress JavaScript, CSS &amp; HTML instantly — 100% client-side, nothing leaves your browser.</p>
        </div>
        <div class="json-pill-tray">
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-shield-halved me-1"></i>Local only</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-bolt me-1"></i>Instant</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-code me-1"></i>Syntax highlight</span>
        </div>
    </div>

    {{-- Language tabs --}}
    <div class="minify-lang-tabs" id="minifyLangTabs" role="tablist" aria-label="Minifier language">
        <button class="minify-lang-tab active" data-lang="js" role="tab" aria-selected="true"
                onclick="window.switchMinifyLang('js')">
            <i class="fa-brands fa-js"></i> JavaScript
        </button>
        <button class="minify-lang-tab" data-lang="css" role="tab" aria-selected="false"
                onclick="window.switchMinifyLang('css')">
            <i class="fa-brands fa-css3-alt"></i> CSS
        </button>
        <button class="minify-lang-tab" data-lang="html" role="tab" aria-selected="false"
                onclick="window.switchMinifyLang('html')">
            <i class="fa-brands fa-html5"></i> HTML
        </button>
    </div>

    {{-- Toolbar --}}
    <div class="minify-toolbar">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button type="button" class="btn btn-primary btn-sm" id="minifyMainBtn"
                    onclick="window.runMinify()" title="Minify (Ctrl+Enter)">
                <i class="fa-solid fa-bolt me-1"></i>Minify
            </button>
            <label class="btn btn-outline-secondary btn-sm mb-0" style="cursor:pointer;"
                   title="Upload a .js, .css, or .html file">
                <i class="fa-solid fa-upload me-1"></i>Upload
                <input type="file" id="minifyFileInput" accept=".js,.mjs,.css,.html,.htm,.txt" hidden>
            </label>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    onclick="window.pasteMinifyInput()" title="Paste from clipboard">
                <i class="fa-solid fa-paste me-1"></i>Paste
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    onclick="window.loadMinifySample()" title="Load sample code for selected language">
                <i class="fa-solid fa-file-code me-1"></i>Sample
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    onclick="window.clearMinify()" title="Clear input and output">
                <i class="fa-solid fa-trash-can me-1"></i>Clear
            </button>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
            <div class="form-check form-switch mb-0 d-flex align-items-center gap-2"
                 title="Minify automatically as you type (600 ms debounce)">
                <input class="form-check-input" type="checkbox" id="minifyInstant" role="switch">
                <label class="form-check-label small fw-semibold" for="minifyInstant">Instant</label>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    onclick="window.copyMinifyOutput()" title="Copy minified output to clipboard">
                <i class="fa-solid fa-copy me-1"></i>Copy
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    onclick="window.downloadMinified()" title="Download minified file">
                <i class="fa-solid fa-download me-1"></i>Download
            </button>
        </div>
    </div>

    {{-- Stats bar (hidden until first minify) --}}
    <div class="minify-stats" id="minifyStats" style="display:none;">
        <div class="minify-stat">
            <span class="minify-stat__label">Original</span>
            <span class="minify-stat__value" id="mStatOrig">—</span>
        </div>
        <div class="minify-stat">
            <span class="minify-stat__label">Minified</span>
            <span class="minify-stat__value" id="mStatMin">—</span>
        </div>
        <div class="minify-stat minify-stat--savings">
            <span class="minify-stat__label">Saved</span>
            <span class="minify-stat__value" id="mStatSaved">—</span>
        </div>
        <div class="minify-stat minify-stat--pct">
            <span class="minify-stat__label">Reduction</span>
            <div class="minify-stat__bar-wrap">
                <div class="minify-stat__bar" id="mStatBar"></div>
            </div>
            <span class="minify-stat__value" id="mStatPct">—</span>
        </div>
    </div>

    {{-- Error display --}}
    <div class="minify-error d-none" id="minifyError" role="alert">
        <i class="fa-solid fa-circle-xmark flex-shrink-0 mt-1"></i>
        <div><strong>Error:&nbsp;</strong><span id="minifyErrorMsg"></span></div>
    </div>

    {{-- Two-panel editor area --}}
    <div class="minify-panels" id="minifyPanels">

        {{-- INPUT panel --}}
        <div class="minify-panel" id="minifyInputPanel">
            <div class="minify-panel__head">
                <span class="minify-panel__label">
                    <i class="fa-solid fa-code me-1 opacity-50"></i>Input Code
                </span>
                <span class="minify-panel__badge" id="mInBadge">JS</span>
            </div>
            <div class="minify-panel__editor" id="minifyInputWrap">
                <textarea id="minifyInput" spellcheck="false" autocomplete="off"
                          autocorrect="off" autocapitalize="off"></textarea>
            </div>
        </div>

        {{-- Middle ⚡ button --}}
        <div class="minify-panels__sep" aria-hidden="true">
            <button type="button" class="minify-panels__run" id="minifyRunBtn"
                    onclick="window.runMinify()" title="Minify (Ctrl+Enter)">
                <i class="fa-solid fa-bolt"></i>
            </button>
        </div>

        {{-- OUTPUT panel --}}
        <div class="minify-panel" id="minifyOutputPanel">
            <div class="minify-panel__head">
                <span class="minify-panel__label">
                    <i class="fa-solid fa-compress me-1 opacity-50"></i>Minified Output
                </span>
                <span class="minify-panel__badge" id="mOutBadge">JS</span>
            </div>
            <div class="minify-panel__editor" id="minifyOutputWrap">
                <textarea id="minifyOutput" spellcheck="false" readonly></textarea>
            </div>
            {{-- Empty state overlay --}}
            <div class="minify-empty-state" id="minifyEmptyState">
                <div class="minify-empty-icon"><i class="fa-solid fa-bolt"></i></div>
                <p>Click <strong>Minify</strong> to see compressed output here.</p>
            </div>
        </div>

    </div>

    {{-- Options row --}}
    <div class="minify-options" id="minifyOptionsBar">
        {{-- JS options --}}
        <div id="mOptJs" class="d-flex align-items-center flex-wrap gap-2">
            <span class="minify-options__title">JS:</span>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptMangle" checked>
                <label class="form-check-label small" for="mOptMangle" title="Shorten variable and function names">Mangle names</label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptCompress" checked>
                <label class="form-check-label small" for="mOptCompress" title="Apply dead-code elimination and other optimisations">Compress</label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptSourcemap">
                <label class="form-check-label small" for="mOptSourcemap" title="Embed an inline source map in the output">Source map</label>
            </div>
        </div>
        {{-- CSS options --}}
        <div id="mOptCss" class="d-flex align-items-center flex-wrap gap-2" style="display:none !important;">
            <span class="minify-options__title">CSS:</span>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptCssComments">
                <label class="form-check-label small" for="mOptCssComments" title="Preserve /* comment */ blocks">Keep comments</label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptCssZeros" checked>
                <label class="form-check-label small" for="mOptCssZeros" title="Remove units from zero values (0px → 0)">Strip zero units</label>
            </div>
        </div>
        {{-- HTML options --}}
        <div id="mOptHtml" class="d-flex align-items-center flex-wrap gap-2" style="display:none !important;">
            <span class="minify-options__title">HTML:</span>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptHtmlComments">
                <label class="form-check-label small" for="mOptHtmlComments" title="Preserve HTML comment blocks">Keep comments</label>
            </div>
            <div class="form-check form-check-inline mb-0">
                <input class="form-check-input" type="checkbox" id="mOptHtmlInline" checked>
                <label class="form-check-label small" for="mOptHtmlInline" title="Also compress &lt;style&gt; and &lt;script&gt; tag contents">Minify inline JS/CSS</label>
            </div>
        </div>
    </div>

</div>{{-- /.minify-lab --}}

{{-- ─── Scripts ─────────────────────────────────────────────────────────────── --}}
@push('scripts')
{{-- Terser: real JS minification in the browser --}}
<script src="https://cdn.jsdelivr.net/npm/terser@5.36.0/dist/bundle.min.js"
        crossorigin="anonymous"></script>
{{-- CodeMirror 5 core --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/codemirror.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Language modes --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/javascript/javascript.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/css/css.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/xml/xml.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/mode/htmlmixed/htmlmixed.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- Addons --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/edit/matchbrackets.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/selection/active-line.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.16/addon/display/placeholder.min.js"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
(function () {
    'use strict';

    /* ═══════════════════════════════════════════════════════════
       STATE
    ═══════════════════════════════════════════════════════════ */
    var lang         = 'js';
    var inputEditor  = null;
    var outputEditor = null;
    var instantTimer = null;

    /* ═══════════════════════════════════════════════════════════
       CODEMIRROR INIT
    ═══════════════════════════════════════════════════════════ */
    function initEditors() {
        var shared = {
            lineNumbers: true,
            matchBrackets: true,
            styleActiveLine: true,
            indentWithTabs: false,
            indentUnit: 2,
            tabSize: 2,
            lineWrapping: false,
            extraKeys: {
                'Ctrl-Enter': function () { window.runMinify(); },
                'Cmd-Enter':  function () { window.runMinify(); }
            }
        };

        inputEditor = CodeMirror.fromTextArea(
            document.getElementById('minifyInput'),
            Object.assign({}, shared, {
                mode:        'javascript',
                placeholder: 'Paste your JavaScript here, or click "Sample"…'
            })
        );

        outputEditor = CodeMirror.fromTextArea(
            document.getElementById('minifyOutput'),
            Object.assign({}, shared, {
                mode:     'javascript',
                readOnly: 'nocursor',
                lineNumbers: true
            })
        );

        /* Fill panel height */
        inputEditor.setSize('100%', '100%');
        outputEditor.setSize('100%', '100%');

        /* Instant minify listener */
        inputEditor.on('change', function () {
            if (document.getElementById('minifyInstant').checked) {
                clearTimeout(instantTimer);
                instantTimer = setTimeout(window.runMinify, 650);
            }
        });

        /* Init empty state */
        setOutput('');
    }

    /* ═══════════════════════════════════════════════════════════
       LANGUAGE SWITCH
    ═══════════════════════════════════════════════════════════ */
    var LANG_MODES    = { js: 'javascript', css: 'css', html: 'htmlmixed' };
    var LANG_BADGES   = { js: 'JS',  css: 'CSS',  html: 'HTML' };
    var LANG_EXTS     = { js: 'js',  css: 'css',  html: 'html' };
    var LANG_HOLDERS  = {
        js:   'Paste your JavaScript here, or click "Sample"…',
        css:  'Paste your CSS here, or click "Sample"…',
        html: 'Paste your HTML here, or click "Sample"…'
    };

    window.switchMinifyLang = function (newLang) {
        lang = newLang;

        /* tabs */
        document.querySelectorAll('.minify-lang-tab').forEach(function (btn) {
            var sel = btn.dataset.lang === newLang;
            btn.classList.toggle('active', sel);
            btn.setAttribute('aria-selected', sel ? 'true' : 'false');
        });

        /* editor modes */
        var mode = LANG_MODES[newLang];
        if (inputEditor)  inputEditor.setOption('mode', mode);
        if (outputEditor) outputEditor.setOption('mode', mode);

        /* placeholder */
        if (inputEditor) inputEditor.setOption('placeholder', LANG_HOLDERS[newLang]);

        /* badges */
        var badge = LANG_BADGES[newLang];
        document.getElementById('mInBadge').textContent  = badge;
        document.getElementById('mOutBadge').textContent = badge;

        /* option panels */
        document.getElementById('mOptJs').style.display   = newLang === 'js'   ? '' : 'none';
        document.getElementById('mOptCss').style.display  = newLang === 'css'  ? '' : 'none';
        document.getElementById('mOptHtml').style.display = newLang === 'html' ? '' : 'none';

        /* clear output & state */
        setOutput('');
        hideError();
        hideStats();
    };

    /* ═══════════════════════════════════════════════════════════
       MINIFY DISPATCHER
    ═══════════════════════════════════════════════════════════ */
    window.runMinify = async function () {
        if (!inputEditor) return;
        var code = inputEditor.getValue();
        if (!code.trim()) {
            showError('Nothing to minify — paste some code or click "Sample".');
            return;
        }
        hideError();
        setBusy(true);
        try {
            var result;
            if (lang === 'js') {
                result = await doMinifyJS(code);
            } else if (lang === 'css') {
                result = doMinifyCSS(code);
            } else {
                result = doMinifyHTML(code);
            }
            setOutput(result);
            renderStats(code, result);
            if (window.showFlash) window.showFlash('Minified successfully!', 'success', 2000);
        } catch (err) {
            showError(String(err.message || err));
        } finally {
            setBusy(false);
        }
    };

    /* ═══════════════════════════════════════════════════════════
       JS MINIFIER — Terser
    ═══════════════════════════════════════════════════════════ */
    async function doMinifyJS(code) {
        if (typeof Terser === 'undefined') {
            throw new Error('Terser library failed to load. Check your internet connection and refresh.');
        }
        var opts = {
            compress: document.getElementById('mOptCompress').checked ? {} : false,
            mangle:   document.getElementById('mOptMangle').checked,
            sourceMap: document.getElementById('mOptSourcemap').checked
                ? { url: 'inline' } : false,
            format: { comments: false }
        };
        var res = await Terser.minify(code, opts);
        if (res.error) throw new Error(res.error.message);
        return res.code;
    }

    /* ═══════════════════════════════════════════════════════════
       CSS MINIFIER — pure JS
    ═══════════════════════════════════════════════════════════ */
    function doMinifyCSS(code, forceKeepComments) {
        var keepComments = forceKeepComments !== undefined
            ? forceKeepComments
            : document.getElementById('mOptCssComments').checked;
        var stripZeros = document.getElementById('mOptCssZeros').checked;

        var out = code;

        /* 1. Protect string contents from manipulation */
        var strings = [];
        out = out.replace(/(["'])(?:(?!\1)[^\\]|\\.)*?\1/g, function (m) {
            strings.push(m);
            return '\x00S' + (strings.length - 1) + '\x00';
        });

        /* 2. Remove comments */
        if (!keepComments) {
            out = out.replace(/\/\*[\s\S]*?\*\//g, '');
        }

        /* 3. Collapse whitespace */
        out = out.replace(/\s+/g, ' ');

        /* 4. Remove spaces around structural characters */
        out = out.replace(/\s*([{}:;,>+~\[\]()\!])\s*/g, '$1');

        /* 5. Remove trailing semicolons before } */
        out = out.replace(/;}/g, '}');

        /* 6. Strip zero units */
        if (stripZeros) {
            out = out.replace(/([:(, ])0(?:px|em|rem|%|vw|vh|ex|ch|vmin|vmax|cm|mm|in|pt|pc)\b/g, '$10');
            out = out.replace(/([:(, ])\.0+\b/g, '$10');
        }

        /* 7. Remove leading zeros (0.5 → .5) */
        out = out.replace(/([^0-9])0+(\.\d)/g, '$1$2');

        /* 8. Restore strings */
        out = out.replace(/\x00S(\d+)\x00/g, function (_, i) { return strings[+i]; });

        return out.trim();
    }

    /* ═══════════════════════════════════════════════════════════
       HTML MINIFIER — pure JS
    ═══════════════════════════════════════════════════════════ */
    function doMinifyHTML(code) {
        var keepComments = document.getElementById('mOptHtmlComments').checked;
        var minifyInline = document.getElementById('mOptHtmlInline').checked;
        var out = code;

        /* 1. Remove HTML comments (preserve IE conditional <!--[if...]--> and SSI <!--#...--> ) */
        if (!keepComments) {
            out = out.replace(/<!--(?!\[if\s|#)[\s\S]*?-->/g, '');
        }

        /* 2. Minify <style> blocks */
        if (minifyInline) {
            out = out.replace(/<style([^>]*)>([\s\S]*?)<\/style>/gi, function (_, attrs, css) {
                return '<style' + attrs + '>' + doMinifyCSS(css, false) + '</style>';
            });
        }

        /* 3. Minify <script> blocks (comment stripping only — no AST for safety) */
        if (minifyInline) {
            var closeTag = '<' + '/script>';
            out = out.replace(/<script([^>]*)>([\s\S]*?)<\/script>/gi, function (_, attrs, js) {
                if (!js.trim()) return '<script' + attrs + '>' + closeTag;
                var minJs = js
                    .replace(/\/\*[\s\S]*?\*\//g, '')
                    .replace(/\/\/[^\n\r]*/g, '')
                    .replace(/\s+/g, ' ')
                    .trim();
                return '<script' + attrs + '>' + minJs + closeTag;
            });
        }

        /* 4. Collapse inter-tag and intra-text whitespace */
        out = out
            .replace(/\s+/g, ' ')
            .replace(/>\s+</g, '><')
            .replace(/\s+\/>/g, '/>');

        return out.trim();
    }

    /* ═══════════════════════════════════════════════════════════
       STATS
    ═══════════════════════════════════════════════════════════ */
    function fmtBytes(n) {
        if (n < 1024) return n + ' B';
        return (n / 1024).toFixed(1) + ' KB';
    }

    function renderStats(original, minified) {
        var origB  = new Blob([original]).size;
        var minB   = new Blob([minified]).size;
        var savedB = Math.max(0, origB - minB);
        var pct    = origB > 0 ? (savedB / origB * 100) : 0;

        document.getElementById('mStatOrig').textContent  = fmtBytes(origB);
        document.getElementById('mStatMin').textContent   = fmtBytes(minB);
        document.getElementById('mStatSaved').textContent = '−' + fmtBytes(savedB);
        document.getElementById('mStatPct').textContent   = pct.toFixed(1) + '%';
        document.getElementById('mStatBar').style.width   = Math.min(100, pct) + '%';
        document.getElementById('minifyStats').style.display = '';
    }

    function hideStats() {
        document.getElementById('minifyStats').style.display = 'none';
    }

    /* ═══════════════════════════════════════════════════════════
       ERROR
    ═══════════════════════════════════════════════════════════ */
    function showError(msg) {
        document.getElementById('minifyErrorMsg').textContent = msg;
        document.getElementById('minifyError').classList.remove('d-none');
    }
    function hideError() {
        document.getElementById('minifyError').classList.add('d-none');
    }

    /* ═══════════════════════════════════════════════════════════
       OUTPUT HELPERS
    ═══════════════════════════════════════════════════════════ */
    function setOutput(val) {
        if (!outputEditor) return;
        outputEditor.setValue(val);
        var empty = !val;
        var emptyEl  = document.getElementById('minifyEmptyState');
        var wrapEl   = outputEditor.getWrapperElement();
        emptyEl.style.display   = empty ? '' : 'none';
        wrapEl.style.opacity    = empty ? '0' : '1';
        wrapEl.style.pointerEvents = empty ? 'none' : '';
    }

    /* ═══════════════════════════════════════════════════════════
       BUSY STATE
    ═══════════════════════════════════════════════════════════ */
    function setBusy(on) {
        var runBtn  = document.getElementById('minifyRunBtn');
        var mainBtn = document.getElementById('minifyMainBtn');
        if (on) {
            runBtn.querySelector('i').className = 'fa-solid fa-spinner';
            runBtn.querySelector('i').classList.add('fa-spin');
            mainBtn.disabled = true;
        } else {
            runBtn.querySelector('i').className = 'fa-solid fa-bolt';
            mainBtn.disabled = false;
        }
    }

    /* ═══════════════════════════════════════════════════════════
       TOOLBAR ACTIONS
    ═══════════════════════════════════════════════════════════ */

    /* Copy output */
    window.copyMinifyOutput = function () {
        if (!outputEditor) return;
        var val = outputEditor.getValue();
        if (!val) { showError('Nothing to copy — minify some code first.'); return; }
        navigator.clipboard.writeText(val)
            .then(function () {
                if (window.showFlash) window.showFlash('Copied to clipboard!', 'success', 2000);
            })
            .catch(function () {
                if (window.showFlash) window.showFlash('Copy failed', 'error', 2000);
            });
    };

    /* Download */
    window.downloadMinified = function () {
        if (!outputEditor) return;
        var val = outputEditor.getValue();
        if (!val) { showError('Nothing to download — minify some code first.'); return; }
        var blob = new Blob([val], { type: 'text/plain;charset=utf-8' });
        var url  = URL.createObjectURL(blob);
        var a    = Object.assign(document.createElement('a'), {
            href: url, download: 'minified.' + LANG_EXTS[lang]
        });
        a.click();
        URL.revokeObjectURL(url);
    };

    /* Paste into input editor */
    window.pasteMinifyInput = function () {
        navigator.clipboard.readText()
            .then(function (text) {
                if (!inputEditor) return;
                inputEditor.setValue(text);
                inputEditor.focus();
                if (window.showFlash) window.showFlash('Pasted!', 'success', 1500);
            })
            .catch(function () {
                if (window.showFlash)
                    window.showFlash('Clipboard access denied — use Ctrl+V inside the editor', 'error', 3500);
            });
    };

    /* Clear */
    window.clearMinify = function () {
        if (!inputEditor) return;
        inputEditor.setValue('');
        setOutput('');
        hideError();
        hideStats();
        inputEditor.focus();
    };

    /* ═══════════════════════════════════════════════════════════
       SAMPLE CODE
    ═══════════════════════════════════════════════════════════ */
    var SAMPLES = {
        js: [
            '// Utility helpers',
            'function debounce(fn, delay) {',
            '    let timer;',
            '    return function (...args) {',
            '        clearTimeout(timer);',
            '        timer = setTimeout(() => fn.apply(this, args), delay);',
            '    };',
            '}',
            '',
            'const formatDate = (date) => {',
            '    const d = new Date(date);',
            '    const y = d.getFullYear();',
            '    const m = String(d.getMonth() + 1).padStart(2, "0");',
            '    const day = String(d.getDate()).padStart(2, "0");',
            '    return `${y}-${m}-${day}`;',
            '};',
            '',
            '// Sum an array of numbers',
            'function arraySum(arr) {',
            '    return arr.reduce((acc, val) => acc + val, 0);',
            '}',
            '',
            'export { debounce, formatDate, arraySum };'
        ].join('\n'),

        css: [
            '/* Card component */',
            '.card {',
            '    background: #ffffff;',
            '    border: 1px solid #e2e8f0;',
            '    border-radius: 12px;',
            '    padding: 24px;',
            '    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);',
            '    transition: transform 0.2s ease, box-shadow 0.2s ease;',
            '}',
            '',
            '.card:hover {',
            '    transform: translateY(-2px);',
            '    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);',
            '}',
            '',
            '/* Primary button */',
            '.btn-primary {',
            '    background: #2563eb;',
            '    color: #ffffff;',
            '    padding: 0.5rem 1.25rem;',
            '    border-radius: 8px;',
            '    border: none;',
            '    font-weight: 600;',
            '    cursor: pointer;',
            '    transition: background 0.2s ease;',
            '}',
            '',
            '.btn-primary:hover {',
            '    background: #1d4ed8;',
            '}'
        ].join('\n'),

        html: [
            '<!DOCTYPE html>',
            '<html lang="en">',
            '<head>',
            '    <meta charset="UTF-8">',
            '    <meta name="viewport" content="width=device-width, initial-scale=1.0">',
            '    <title>Sample Page</title>',
            '    <link rel="stylesheet" href="styles.css">',
            '</head>',
            '<body>',
            '    <!-- Site header -->',
            '    <header class="site-header">',
            '        <nav class="navbar">',
            '            <a href="/" class="logo">MyBrand</a>',
            '            <ul class="nav-links">',
            '                <li><a href="/about">About</a></li>',
            '                <li><a href="/services">Services</a></li>',
            '                <li><a href="/contact">Contact</a></li>',
            '            </ul>',
            '        </nav>',
            '    </header>',
            '    <main>',
            '        <section class="hero">',
            '            <h1>Welcome to My Website</h1>',
            '            <p>A modern, fast, and beautiful website built with care.</p>',
            '            <a href="/get-started" class="btn btn-primary">Get Started</a>',
            '        </section>',
            '    </main>',
            '    <footer>',
            '        <p>&copy; 2025 MyBrand. All rights reserved.</p>',
            '    </footer>',
            '    <script src="app.js"><\/script>',
            '</body>',
            '</html>'
        ].join('\n')
    };

    window.loadMinifySample = function () {
        if (!inputEditor) return;
        inputEditor.setValue(SAMPLES[lang]);
        inputEditor.focus();
        if (window.showFlash) window.showFlash('Sample loaded!', 'success', 1500);
    };

    /* ═══════════════════════════════════════════════════════════
       FILE UPLOAD
    ═══════════════════════════════════════════════════════════ */
    document.getElementById('minifyFileInput').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            if (!inputEditor) return;
            /* auto-detect language from extension */
            var ext = (file.name.split('.').pop() || '').toLowerCase();
            if (ext === 'js' || ext === 'mjs')        window.switchMinifyLang('js');
            else if (ext === 'css')                    window.switchMinifyLang('css');
            else if (ext === 'html' || ext === 'htm') window.switchMinifyLang('html');
            inputEditor.setValue(ev.target.result);
            inputEditor.focus();
            if (window.showFlash) window.showFlash('Loaded: ' + file.name, 'success', 2000);
        };
        reader.readAsText(file);
        e.target.value = '';
    });

    /* ═══════════════════════════════════════════════════════════
       DRAG & DROP onto input panel
    ═══════════════════════════════════════════════════════════ */
    var inputPanel = document.getElementById('minifyInputPanel');

    ['dragenter', 'dragover'].forEach(function (evt) {
        inputPanel.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            inputPanel.classList.add('drag-over');
        });
    });
    ['dragleave', 'drop'].forEach(function (evt) {
        inputPanel.addEventListener(evt, function (e) {
            e.preventDefault();
            e.stopPropagation();
            inputPanel.classList.remove('drag-over');
        });
    });
    inputPanel.addEventListener('drop', function (e) {
        var file = e.dataTransfer.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            var ext = (file.name.split('.').pop() || '').toLowerCase();
            if (ext === 'js' || ext === 'mjs')        window.switchMinifyLang('js');
            else if (ext === 'css')                    window.switchMinifyLang('css');
            else if (ext === 'html' || ext === 'htm') window.switchMinifyLang('html');
            inputEditor.setValue(ev.target.result);
            inputEditor.focus();
            if (window.showFlash) window.showFlash('Dropped: ' + file.name, 'success', 2000);
        };
        reader.readAsText(file);
    });

    /* ═══════════════════════════════════════════════════════════
       GLOBAL KEYBOARD SHORTCUT  Ctrl/Cmd + Enter
    ═══════════════════════════════════════════════════════════ */
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            var lab = document.getElementById('minifyLab');
            if (lab) window.runMinify();
        }
    });

    /* ═══════════════════════════════════════════════════════════
       BOOT
    ═══════════════════════════════════════════════════════════ */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEditors);
    } else {
        initEditors();
    }

})();
</script>
@endpush
