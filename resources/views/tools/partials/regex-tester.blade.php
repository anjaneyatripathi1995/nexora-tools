{{-- ─── Regex Tester ──────────────────────────────────────────────────────────
     Full client-side regex engine — live preview, match highlighting,
     capture group display, flags toggles, cheatsheet, and common presets.
──────────────────────────────────────────────────────────────────────────── --}}

@push('head_styles')
<style>
/* ═══════════════════════════════════════════════════════════
   REGEX LAB — scoped under .regex-lab
═══════════════════════════════════════════════════════════ */
.regex-lab {
    background: linear-gradient(135deg, #dbeafe 0%, #ede9fe 100%);
    border: 1px solid #c7d7fc;
    border-radius: 18px;
    padding: 1.25rem 1.25rem 1rem;
    box-shadow: var(--shadow-md);
}
html[data-theme="dark"] .regex-lab {
    background: linear-gradient(135deg, rgba(37,99,235,0.22) 0%, rgba(124,58,237,0.18) 100%);
    border-color: rgba(124,58,237,0.3);
    box-shadow: 0 12px 36px rgba(0,0,0,0.35);
}

/* ── Header ── */
.regex-lab__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.1rem;
}

/* ── Section labels ── */
.regex-field-label {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text-2);
    margin-bottom: 0.4rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

/* ── Pattern row: /pattern/flags ── */
.regex-pattern-wrap {
    display: flex;
    align-items: center;
    background: var(--bg-card);
    border: 1.5px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color 0.15s;
}
.regex-pattern-wrap:focus-within {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
}
.regex-pattern-wrap.has-error { border-color: var(--danger); }
.regex-pattern-wrap.has-error:focus-within { box-shadow: 0 0 0 3px rgba(239,68,68,0.12); }
.regex-pattern-wrap.has-match { border-color: var(--success); }
.regex-delim {
    padding: 0.55rem 0.75rem;
    font-family: 'Fira Code', 'Cascadia Code', Consolas, monospace;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
    background: var(--bg-elevated);
    border-right: 1px solid var(--border);
    user-select: none;
    flex-shrink: 0;
}
.regex-delim:last-of-type {
    border-right: none;
    border-left: 1px solid var(--border);
}
.regex-pattern-input {
    flex: 1;
    border: none;
    outline: none;
    background: transparent;
    font-family: 'Fira Code', 'Cascadia Code', Consolas, monospace;
    font-size: 0.92rem;
    color: var(--text);
    padding: 0.55rem 0.5rem;
    min-width: 0;
}
.regex-pattern-input::placeholder { color: var(--text-3); font-style: italic; }

/* ── Flags ── */
.regex-flags {
    display: flex;
    gap: 1px;
    padding: 0 0.35rem;
    background: var(--bg-elevated);
    border-left: 1px solid var(--border);
    align-self: stretch;
    align-items: center;
}
.regex-flag {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1.5px solid transparent;
    background: transparent;
    font-family: 'Fira Code', Consolas, monospace;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-3);
    cursor: pointer;
    transition: all 0.12s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.regex-flag:hover { background: var(--border); color: var(--text); }
.regex-flag.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary-dark);
}

/* ── Toolbar ── */
.regex-toolbar {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.5rem;
}

/* ── Test string textarea ── */
.regex-test-input {
    font-family: 'Fira Code', 'Cascadia Code', Consolas, monospace;
    font-size: 0.855rem;
    line-height: 1.65;
    background: var(--bg-card) !important;
    color: var(--text) !important;
    border: 1.5px solid var(--border) !important;
    border-radius: 10px !important;
    resize: vertical;
    transition: border-color 0.15s;
}
.regex-test-input:focus {
    border-color: var(--primary) !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
    outline: none;
}

/* ── Status bar ── */
.regex-status {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
    padding: 0.6rem 0.875rem;
    border-radius: 10px;
    font-size: 0.84rem;
    font-weight: 600;
    margin-top: 0.875rem;
}
.regex-status--match {
    background: rgba(16,185,129,0.1);
    border: 1px solid rgba(16,185,129,0.3);
    color: #065f46;
}
html[data-theme="dark"] .regex-status--match { color: #6ee7b7; }
.regex-status--none {
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    color: var(--text-2);
}
.regex-status--error {
    background: rgba(239,68,68,0.09);
    border: 1px solid rgba(239,68,68,0.3);
    color: var(--danger);
    font-family: 'Fira Code', Consolas, monospace;
    font-size: 0.82rem;
    font-weight: 500;
}
.regex-match-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 0.45rem;
    background: var(--success);
    color: #fff;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 700;
}

/* ── Highlight panel ── */
.regex-preview {
    margin-top: 0.875rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    overflow: hidden;
}
.regex-preview__head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.45rem 0.875rem;
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
    font-size: 0.775rem;
    font-weight: 700;
    color: var(--text-2);
}
.regex-preview__content {
    padding: 0.875rem;
    font-family: 'Fira Code', 'Cascadia Code', Consolas, monospace;
    font-size: 0.84rem;
    line-height: 1.75;
    white-space: pre-wrap;
    word-break: break-all;
    max-height: 260px;
    overflow-y: auto;
    color: var(--text);
}
.regex-mark {
    background: rgba(251,191,36,0.45);
    color: #92400e;
    border-radius: 3px;
    padding: 0 1px;
    outline: 1.5px solid rgba(245,158,11,0.5);
    font-weight: 600;
}
html[data-theme="dark"] .regex-mark {
    background: rgba(251,191,36,0.25);
    color: #fde68a;
    outline-color: rgba(251,191,36,0.4);
}
/* Cycle colours for multiple matches */
.regex-mark:nth-of-type(6n+2) { background:rgba(167,139,250,0.3); color:#5b21b6; outline-color:rgba(167,139,250,0.5); }
.regex-mark:nth-of-type(6n+3) { background:rgba(52,211,153,0.25); color:#065f46; outline-color:rgba(52,211,153,0.5); }
.regex-mark:nth-of-type(6n+4) { background:rgba(96,165,250,0.3);  color:#1e3a8a; outline-color:rgba(96,165,250,0.5); }
.regex-mark:nth-of-type(6n+5) { background:rgba(251,113,133,0.25);color:#9f1239; outline-color:rgba(251,113,133,0.5); }
.regex-mark:nth-of-type(6n+6) { background:rgba(251,146,60,0.25); color:#9a3412; outline-color:rgba(251,146,60,0.5); }
html[data-theme="dark"] .regex-mark:nth-of-type(6n+2) { color:#c4b5fd; }
html[data-theme="dark"] .regex-mark:nth-of-type(6n+3) { color:#6ee7b7; }
html[data-theme="dark"] .regex-mark:nth-of-type(6n+4) { color:#93c5fd; }
html[data-theme="dark"] .regex-mark:nth-of-type(6n+5) { color:#fda4af; }
html[data-theme="dark"] .regex-mark:nth-of-type(6n+6) { color:#fed7aa; }

/* ── Match cards ── */
.regex-match-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 0.875rem;
}
.regex-match-card {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.65rem 0.875rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 10px;
    font-size: 0.835rem;
}
.regex-match-num {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--primary-light);
    color: var(--primary);
    font-size: 0.72rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}
.regex-match-val {
    font-family: 'Fira Code', Consolas, monospace;
    font-weight: 700;
    color: var(--text);
    word-break: break-all;
}
.regex-match-pos {
    font-size: 0.73rem;
    color: var(--text-3);
    margin-top: 0.15rem;
}
.regex-match-groups {
    margin-top: 0.3rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.3rem;
}
.regex-group-pill {
    font-family: 'Fira Code', Consolas, monospace;
    font-size: 0.72rem;
    padding: 0.1rem 0.45rem;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    border-radius: 5px;
    color: var(--text-2);
}
.regex-group-label {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-3);
    letter-spacing: 0.05em;
    margin-right: 0.15rem;
}

/* ── Cheatsheet ── */
.regex-cheatsheet {
    margin-top: 0.875rem;
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
}
.regex-cheatsheet__toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem 0.875rem;
    cursor: pointer;
    background: var(--bg-elevated);
    border: none;
    width: 100%;
    text-align: left;
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text-2);
    transition: background 0.12s;
}
.regex-cheatsheet__toggle:hover { background: var(--border); }
.regex-cheatsheet__body {
    display: none;
    padding: 0.875rem;
    overflow-x: auto;
}
.regex-cheatsheet__body.open { display: block; }
.regex-cheat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 0.875rem;
}
.regex-cheat-group h6 {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    color: var(--text-3);
    margin-bottom: 0.4rem;
}
.regex-cheat-row {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
    font-size: 0.8rem;
    margin-bottom: 0.3rem;
}
.regex-cheat-token {
    font-family: 'Fira Code', Consolas, monospace;
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--primary);
    background: var(--primary-light);
    padding: 0.06rem 0.35rem;
    border-radius: 4px;
    white-space: nowrap;
    flex-shrink: 0;
    cursor: pointer;
    transition: filter 0.12s;
}
.regex-cheat-token:hover { filter: brightness(0.88); }
.regex-cheat-desc { color: var(--text-2); font-size: 0.77rem; }

/* ── Responsive ── */
@media (max-width: 576px) {
    .regex-flags { gap: 0; }
    .regex-flag  { width: 24px; height: 24px; font-size: 0.72rem; }
    .regex-toolbar { gap: 0.3rem; }
    .regex-cheat-grid { grid-template-columns: 1fr 1fr; }
}
</style>
@endpush

{{-- ─── Markup ─────────────────────────────────────────────────────────────── --}}
<div class="regex-lab" id="regexLab">

    {{-- Header --}}
    <div class="regex-lab__header">
        <div>
            <h2 class="h4 fw-bold mb-1">Regex Tester</h2>
            <p class="text-body-secondary mb-0 small">
                Build, test, and debug regular expressions live in your browser — with match highlighting and capture groups.
            </p>
        </div>
        <div class="json-pill-tray">
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-bolt me-1"></i>Live</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-shield-halved me-1"></i>Client-side</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-highlighter me-1"></i>Highlighting</span>
        </div>
    </div>

    {{-- ── Pattern input ── --}}
    <div class="mb-3">
        <label for="regex_pattern" class="regex-field-label">
            <i class="fa-solid fa-code text-body-secondary"></i>
            Regular Expression
            <span class="text-body-secondary fw-normal ms-1" style="font-size:0.75rem;">(Ctrl+Enter to test)</span>
        </label>

        <div class="regex-pattern-wrap" id="regexPatternWrap">
            <span class="regex-delim" aria-hidden="true">/</span>
            <input type="text"
                   id="regex_pattern"
                   class="regex-pattern-input"
                   placeholder="pattern"
                   autocomplete="off" autocorrect="off" spellcheck="false"
                   aria-label="Regular expression pattern">
            <span class="regex-delim" aria-hidden="true">/</span>
            <div class="regex-flags" id="regexFlagBar" role="group" aria-label="Regex flags">
                <button class="regex-flag active" data-flag="g" title="Global — find all matches">g</button>
                <button class="regex-flag"        data-flag="i" title="Ignore case">i</button>
                <button class="regex-flag"        data-flag="m" title="Multiline (^ and $ match line boundaries)">m</button>
                <button class="regex-flag"        data-flag="s" title="Dot-all (. matches newline too)">s</button>
                <button class="regex-flag"        data-flag="u" title="Unicode mode">u</button>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="regex-toolbar">
            {{-- Common presets dropdown --}}
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false" title="Insert a common pattern">
                    <i class="fa-solid fa-wand-magic-sparkles me-1"></i>Presets
                </button>
                <ul class="dropdown-menu dropdown-menu-sm" style="min-width:220px; font-size:0.82rem;">
                    <li><h6 class="dropdown-header" style="font-size:0.7rem;">Common Patterns</h6></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('[a-zA-Z0-9._%+\\-]+@[a-zA-Z0-9.\\-]+\\.[a-zA-Z]{2,}')">📧 Email address</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('https?:\\/\\/[^\\s]+')">🔗 URL</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('\\+?[1-9]\\d{1,14}')">📞 Phone (E.164)</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('\\b(?:\\d{1,3}\\.){3}\\d{1,3}\\b')">🌐 IPv4 address</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('\\d{4}-\\d{2}-\\d{2}')">📅 Date (YYYY-MM-DD)</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})\\b')">🎨 Hex colour</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('^\\d+$')">🔢 Numbers only</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('^[a-zA-Z]+$')">🔤 Letters only</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('^[a-zA-Z0-9_]{3,20}$')">👤 Username (3–20 chars)</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('^(?=.*[A-Z])(?=.*\\d).{8,}$')">🔒 Strong password</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('<[^>]+>')">🏷️ HTML tags</a></li>
                    <li><a class="dropdown-item" href="#" onclick="return regexInsertPreset('\\/\\/.*|\\*[\\s\\S]*?\\*\\/')">💬 Code comments</a></li>
                </ul>
            </div>
            <button class="btn btn-outline-secondary btn-sm" onclick="regexCopyPattern()" title="Copy pattern to clipboard">
                <i class="fa-solid fa-copy me-1"></i>Copy
            </button>
            <button class="btn btn-outline-secondary btn-sm" onclick="regexClearAll()" title="Clear pattern and test string">
                <i class="fa-solid fa-trash-can me-1"></i>Clear
            </button>
            <button class="btn btn-primary btn-sm ms-auto" id="regexRunBtn" onclick="regexRun()">
                <i class="fa-solid fa-play me-1"></i>Test
            </button>
        </div>
    </div>

    {{-- ── Test string ── --}}
    <div class="mb-0">
        <label for="regex_test" class="regex-field-label">
            <i class="fa-solid fa-align-left text-body-secondary"></i>
            Test String
        </label>
        <textarea id="regex_test"
                  class="form-control regex-test-input"
                  rows="7"
                  placeholder="Enter text to test against the regular expression…"
                  autocomplete="off" autocorrect="off" spellcheck="false"
                  aria-label="Test string"></textarea>
    </div>

    {{-- ── Status / result bar ── --}}
    {{-- (kept for backward compat — regexError and regexMatches IDs still exist) --}}
    <div id="regexError"   class="d-none"></div>{{-- hidden legacy holder --}}
    <div id="regexMatches" class="d-none"></div>{{-- hidden legacy holder --}}

    <div class="regex-status d-none" id="regexStatusBar" role="status" aria-live="polite"></div>

    {{-- ── Highlighted preview ── --}}
    <div class="regex-preview d-none" id="regexPreview">
        <div class="regex-preview__head">
            <span><i class="fa-solid fa-highlighter me-1"></i>Match preview</span>
            <span id="regexPreviewNote" style="font-weight:400;color:var(--text-3)"></span>
        </div>
        <div class="regex-preview__content" id="regexHighlight" aria-label="Highlighted matches in test string"></div>
    </div>

    {{-- ── Match detail cards ── --}}
    <div class="regex-match-list d-none" id="regexMatchList" aria-label="Match details"></div>

    {{-- ── Cheatsheet ── --}}
    <div class="regex-cheatsheet" id="regexCheatsheet">
        <button class="regex-cheatsheet__toggle"
                onclick="regexToggleCheat(this)"
                aria-expanded="false"
                aria-controls="regexCheatBody">
            <span><i class="fa-solid fa-book-open me-1"></i>Regex Cheatsheet</span>
            <i class="fa-solid fa-chevron-down" id="regexCheatIcon" style="transition:transform 0.2s"></i>
        </button>
        <div class="regex-cheatsheet__body" id="regexCheatBody">
            <div class="regex-cheat-grid">
                <div class="regex-cheat-group">
                    <h6>Character classes</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('.')">.</code><span class="regex-cheat-desc">Any character except newline</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\d')">\d</code><span class="regex-cheat-desc">Digit [0–9]</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\D')">\D</code><span class="regex-cheat-desc">Non-digit</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\w')">\w</code><span class="regex-cheat-desc">Word [a-zA-Z0-9_]</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\W')">\W</code><span class="regex-cheat-desc">Non-word</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\s')">\s</code><span class="regex-cheat-desc">Whitespace</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\S')">\S</code><span class="regex-cheat-desc">Non-whitespace</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('[abc]')">[abc]</code><span class="regex-cheat-desc">Character set</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('[^abc]')">[^abc]</code><span class="regex-cheat-desc">Negated set</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('[a-z]')">[a-z]</code><span class="regex-cheat-desc">Range</span></div>
                </div>
                <div class="regex-cheat-group">
                    <h6>Quantifiers</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('*')">*</code><span class="regex-cheat-desc">0 or more (greedy)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('+')">+</code><span class="regex-cheat-desc">1 or more (greedy)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('?')">?</code><span class="regex-cheat-desc">0 or 1 (optional)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('{3}')">{n}</code><span class="regex-cheat-desc">Exactly n times</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('{2,5}')">{n,m}</code><span class="regex-cheat-desc">Between n and m</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('+?')">+?</code><span class="regex-cheat-desc">1 or more (lazy)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('*?')">*?</code><span class="regex-cheat-desc">0 or more (lazy)</span></div>
                </div>
                <div class="regex-cheat-group">
                    <h6>Anchors &amp; boundaries</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('^')">^</code><span class="regex-cheat-desc">Start of string/line</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('$')">$</code><span class="regex-cheat-desc">End of string/line</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\b')">\b</code><span class="regex-cheat-desc">Word boundary</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\B')">\B</code><span class="regex-cheat-desc">Non-word boundary</span></div>
                </div>
                <div class="regex-cheat-group">
                    <h6>Groups</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(abc)')">(abc)</code><span class="regex-cheat-desc">Capture group</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(?:abc)')">(?:abc)</code><span class="regex-cheat-desc">Non-capturing group</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(?=abc)')">(?=abc)</code><span class="regex-cheat-desc">Positive lookahead</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(?!abc)')">(?!abc)</code><span class="regex-cheat-desc">Negative lookahead</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(?<=abc)')">(?&lt;=abc)</code><span class="regex-cheat-desc">Positive lookbehind</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('(?&lt;!abc)')">(?&lt;!abc)</code><span class="regex-cheat-desc">Negative lookbehind</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('a|b')">a|b</code><span class="regex-cheat-desc">Alternation (a or b)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\1')">\1</code><span class="regex-cheat-desc">Backreference to group 1</span></div>
                </div>
                <div class="regex-cheat-group">
                    <h6>Escapes</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\n')">\n</code><span class="regex-cheat-desc">Newline</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\t')">\t</code><span class="regex-cheat-desc">Tab</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\r')">\r</code><span class="regex-cheat-desc">Carriage return</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexInsertToken('\\\\')">\\</code><span class="regex-cheat-desc">Literal backslash</span></div>
                </div>
                <div class="regex-cheat-group">
                    <h6>Flags (click to toggle)</h6>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexToggleFlagExt('g')">g</code><span class="regex-cheat-desc">Global — all matches</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexToggleFlagExt('i')">i</code><span class="regex-cheat-desc">Case insensitive</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexToggleFlagExt('m')">m</code><span class="regex-cheat-desc">Multiline (^/$)</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexToggleFlagExt('s')">s</code><span class="regex-cheat-desc">Dot matches newline</span></div>
                    <div class="regex-cheat-row"><code class="regex-cheat-token" onclick="regexToggleFlagExt('u')">u</code><span class="regex-cheat-desc">Unicode mode</span></div>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /.regex-lab --}}

@push('scripts')
<script>
(function () {
    'use strict';

    /* ═══════════════════════════════════════════════════════════
       STATE
    ═══════════════════════════════════════════════════════════ */
    var liveTimer = null;
    var MAX_MATCH_CARDS = 50;   // avoid DOM overload on huge match sets

    /* ═══════════════════════════════════════════════════════════
       HELPERS
    ═══════════════════════════════════════════════════════════ */
    function escHtml(s) {
        return String(s)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;');
    }

    function getFlags() {
        var f = '';
        document.querySelectorAll('#regexFlagBar .regex-flag').forEach(function (btn) {
            if (btn.classList.contains('active')) f += btn.dataset.flag;
        });
        return f;
    }

    function getPattern() {
        return document.getElementById('regex_pattern').value;
    }

    function getTestStr() {
        return document.getElementById('regex_test').value;
    }

    /* ═══════════════════════════════════════════════════════════
       STATUS HELPERS
    ═══════════════════════════════════════════════════════════ */
    function clearResults() {
        var sb = document.getElementById('regexStatusBar');
        sb.className = 'regex-status d-none';
        document.getElementById('regexPreview').classList.add('d-none');
        document.getElementById('regexMatchList').classList.add('d-none');
        document.getElementById('regexPatternWrap').classList.remove('has-error','has-match');
    }

    function showStatus(type, html) {
        var sb = document.getElementById('regexStatusBar');
        sb.className = 'regex-status regex-status--' + type;
        sb.innerHTML = html;
    }

    /* ═══════════════════════════════════════════════════════════
       HIGHLIGHT BUILDER
    ═══════════════════════════════════════════════════════════ */
    function buildHighlight(str, spans) {
        /* spans = [{start, end}] sorted by start, non-overlapping */
        var out = '';
        var cursor = 0;
        for (var i = 0; i < spans.length; i++) {
            var s = spans[i];
            if (s.start < cursor) continue;        // skip overlap
            out += escHtml(str.slice(cursor, s.start));
            out += '<mark class="regex-mark">' + escHtml(str.slice(s.start, s.end)) + '</mark>';
            cursor = s.end;
        }
        out += escHtml(str.slice(cursor));
        return out;
    }

    /* ═══════════════════════════════════════════════════════════
       MAIN TEST RUNNER
    ═══════════════════════════════════════════════════════════ */
    window.regexRun = function () {
        var pattern = getPattern();
        var str     = getTestStr();

        clearResults();
        /* Legacy IDs cleared too */
        document.getElementById('regexError').classList.add('d-none');
        document.getElementById('regexMatches').innerHTML = '';

        if (!pattern) {
            showStatus('none', '<i class="fa-solid fa-circle-info me-1"></i>Enter a pattern above and click <strong>Test</strong>.');
            return;
        }

        var flags = getFlags();
        var re;
        try {
            /* Always force 'g' for exec loop; 'u' only when enabled */
            var testFlags = flags.includes('g') ? flags : flags + 'g';
            re = new RegExp(pattern, testFlags);
        } catch (err) {
            document.getElementById('regexPatternWrap').classList.add('has-error');
            showStatus('error',
                '<i class="fa-solid fa-circle-xmark me-1"></i>' +
                '<strong>Invalid regex:</strong>&nbsp;' + escHtml(err.message));
            return;
        }

        /* Collect all matches with full exec (gives index + groups) */
        var matches = [];
        var m;
        var guard = 0;
        re.lastIndex = 0;
        while ((m = re.exec(str)) !== null && guard < 5000) {
            matches.push({
                index:  m.index,
                end:    m.index + m[0].length,
                text:   m[0],
                groups: Array.prototype.slice.call(m, 1),  // capture groups
                named:  m.groups || null
            });
            guard++;
            /* Prevent infinite loop on zero-length matches */
            if (m[0].length === 0) re.lastIndex++;
        }

        if (matches.length === 0) {
            showStatus('none',
                '<i class="fa-solid fa-magnifying-glass me-1"></i>No matches found.');
            return;
        }

        /* ── Status bar ── */
        document.getElementById('regexPatternWrap').classList.add('has-match');
        var globalOn = flags.includes('g');
        var note = globalOn ? '' : ' (only first match — enable <strong>g</strong> flag for all)';
        showStatus('match',
            '<span class="regex-match-badge">' + matches.length + '</span>' +
            '&nbsp;<strong>' + matches.length + ' match' + (matches.length !== 1 ? 'es' : '') + '</strong> found' +
            note);

        /* ── Highlight preview ── */
        var previewEl = document.getElementById('regexPreview');
        previewEl.classList.remove('d-none');
        document.getElementById('regexPreviewNote').textContent =
            matches.length + (matches.length === 5000 ? '+' : '') + ' match' +
            (matches.length !== 1 ? 'es' : '') + ' highlighted';
        document.getElementById('regexHighlight').innerHTML =
            buildHighlight(str, matches.map(function (x) {
                return { start: x.index, end: x.end };
            }));

        /* ── Match cards (cap at MAX_MATCH_CARDS) ── */
        var listEl = document.getElementById('regexMatchList');
        var hasGroups = matches.some(function (x) { return x.groups.length > 0; });
        var shown = Math.min(matches.length, MAX_MATCH_CARDS);
        var cardsHtml = '';
        for (var i = 0; i < shown; i++) {
            var mx = matches[i];
            var groupsHtml = '';
            if (hasGroups && mx.groups.length) {
                groupsHtml = '<div class="regex-match-groups">' +
                    mx.groups.map(function (g, gi) {
                        return '<span class="regex-group-pill"><span class="regex-group-label">$' + (gi + 1) + '</span>' +
                            (g !== undefined ? escHtml(g) : '<em>undefined</em>') + '</span>';
                    }).join('') + '</div>';
            }
            if (mx.named) {
                groupsHtml += '<div class="regex-match-groups">' +
                    Object.keys(mx.named).map(function (k) {
                        return '<span class="regex-group-pill"><span class="regex-group-label">' +
                            escHtml(k) + '</span>' + escHtml(mx.named[k]) + '</span>';
                    }).join('') + '</div>';
            }
            cardsHtml +=
                '<div class="regex-match-card">' +
                '<div class="regex-match-num">' + (i + 1) + '</div>' +
                '<div class="flex-grow-1 min-width-0">' +
                '<div class="regex-match-val">' + escHtml(mx.text || '(empty)') + '</div>' +
                '<div class="regex-match-pos">index&nbsp;<strong>' + mx.index + '</strong>' +
                (mx.text.length ? '&ndash;<strong>' + (mx.end - 1) + '</strong>' : '') +
                '&nbsp;&nbsp;length&nbsp;<strong>' + mx.text.length + '</strong></div>' +
                groupsHtml +
                '</div></div>';
        }
        if (matches.length > MAX_MATCH_CARDS) {
            cardsHtml +=
                '<div class="text-center py-3" style="font-size:0.82rem;color:var(--text-3)">' +
                '… and ' + (matches.length - MAX_MATCH_CARDS) + ' more matches not shown.' +
                '</div>';
        }
        listEl.innerHTML = cardsHtml;
        listEl.classList.remove('d-none');
    };

    /* ═══════════════════════════════════════════════════════════
       FLAG TOGGLES
    ═══════════════════════════════════════════════════════════ */
    document.getElementById('regexFlagBar').addEventListener('click', function (e) {
        var btn = e.target.closest('.regex-flag');
        if (!btn) return;
        btn.classList.toggle('active');
        btn.setAttribute('aria-pressed', btn.classList.contains('active') ? 'true' : 'false');
        scheduleLive();
    });

    /* Toggle from cheatsheet */
    window.regexToggleFlagExt = function (flag) {
        var btn = document.querySelector('#regexFlagBar .regex-flag[data-flag="' + flag + '"]');
        if (btn) { btn.classList.toggle('active'); scheduleLive(); }
    };

    /* ═══════════════════════════════════════════════════════════
       LIVE (DEBOUNCED) RUN
    ═══════════════════════════════════════════════════════════ */
    function scheduleLive() {
        clearTimeout(liveTimer);
        liveTimer = setTimeout(window.regexRun, 220);
    }

    document.getElementById('regex_pattern').addEventListener('input', scheduleLive);
    document.getElementById('regex_test').addEventListener('input', scheduleLive);

    /* Ctrl+Enter to test */
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            var lab = document.getElementById('regexLab');
            if (lab) window.regexRun();
        }
    });

    /* ═══════════════════════════════════════════════════════════
       TOOLBAR ACTIONS
    ═══════════════════════════════════════════════════════════ */
    window.regexCopyPattern = function () {
        var pat = getPattern();
        if (!pat) return;
        var flags = getFlags();
        var full  = '/' + pat + '/' + flags;
        navigator.clipboard.writeText(full)
            .then(function () {
                if (window.showFlash) window.showFlash('Pattern copied!', 'success', 2000);
            })
            .catch(function () {
                if (window.showFlash) window.showFlash('Copy failed', 'error', 2000);
            });
    };

    window.regexClearAll = function () {
        document.getElementById('regex_pattern').value = '';
        document.getElementById('regex_test').value    = '';
        clearResults();
        document.getElementById('regexStatusBar').className = 'regex-status d-none';
        document.getElementById('regex_pattern').focus();
    };

    /* ═══════════════════════════════════════════════════════════
       PRESET / TOKEN INSERT (into pattern input)
    ═══════════════════════════════════════════════════════════ */
    window.regexInsertPreset = function (pattern) {
        document.getElementById('regex_pattern').value = pattern;
        scheduleLive();
        return false;  // prevent href="#" scroll
    };

    window.regexInsertToken = function (token) {
        var input = document.getElementById('regex_pattern');
        var start = input.selectionStart;
        var end   = input.selectionEnd;
        var val   = input.value;
        input.value = val.slice(0, start) + token + val.slice(end);
        input.selectionStart = input.selectionEnd = start + token.length;
        input.focus();
        scheduleLive();
    };

    /* ═══════════════════════════════════════════════════════════
       CHEATSHEET TOGGLE
    ═══════════════════════════════════════════════════════════ */
    window.regexToggleCheat = function (btn) {
        var body = document.getElementById('regexCheatBody');
        var icon = document.getElementById('regexCheatIcon');
        var open = body.classList.toggle('open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        icon.style.transform = open ? 'rotate(180deg)' : '';
    };

    /* ═══════════════════════════════════════════════════════════
       INIT — show helper prompt
    ═══════════════════════════════════════════════════════════ */
    showStatus('none', '<i class="fa-solid fa-circle-info me-1"></i>Enter a pattern and test string — results update live as you type.');

})();
</script>
@endpush
