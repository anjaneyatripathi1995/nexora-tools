{{-- ─── Temp Mail Tool ────────────────────────────────────────────────────────
     Uses the public mail.tm REST API (https://api.mail.tm) — no backend needed.
     Email address + JWT are persisted in localStorage and auto-expire after
     10 minutes. Inbox auto-polls every 15 seconds.
──────────────────────────────────────────────────────────────────────────── --}}

@push('head_styles')
<style>
/* ═══════════════════════════════════════════════════════════
   TEMP MAIL — scoped under .tmail-lab
═══════════════════════════════════════════════════════════ */

/* ── Wrapper ── */
.tmail-lab {
    background: linear-gradient(135deg, #f0f4ff 0%, #faf0ff 100%);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 1.25rem 1.25rem 1rem;
    box-shadow: var(--shadow-md);
}
html[data-theme="dark"] .tmail-lab {
    background: linear-gradient(135deg, rgba(15,23,42,0.7) 0%, rgba(49,10,72,0.4) 100%);
    border-color: rgba(255,255,255,0.08);
    box-shadow: 0 12px 36px rgba(0,0,0,0.35);
}

/* ── Header ── */
.tmail-lab__header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

/* ── Address card ── */
.tmail-address-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: var(--shadow-sm);
}
.tmail-address-card__top {
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    padding: 1.1rem 1.25rem 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.tmail-address-icon {
    width: 42px;
    height: 42px;
    background: rgba(255,255,255,0.18);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.tmail-address-card__label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.7);
    margin-bottom: 0.15rem;
}
.tmail-address-card__email {
    font-family: 'Fira Code', 'Cascadia Code', Consolas, monospace;
    font-size: 1.05rem;
    font-weight: 700;
    color: #ffffff;
    letter-spacing: 0.02em;
    word-break: break-all;
}
.tmail-address-card__actions {
    display: flex;
    gap: 0.5rem;
    margin-left: auto;
    flex-shrink: 0;
}
.tmail-icon-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1.5px solid rgba(255,255,255,0.3);
    background: rgba(255,255,255,0.12);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.15s ease;
    flex-shrink: 0;
}
.tmail-icon-btn:hover {
    background: rgba(255,255,255,0.25);
    border-color: rgba(255,255,255,0.5);
    transform: translateY(-1px);
}

/* ── Expiry bar ── */
.tmail-expiry-bar {
    padding: 0.65rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
    border-bottom: 1px solid var(--border);
}
.tmail-expiry-label {
    font-size: 0.775rem;
    color: var(--text-2);
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.tmail-expiry-label strong {
    font-weight: 700;
    font-variant-numeric: tabular-nums;
    min-width: 38px;
    display: inline-block;
}
.tmail-expiry-progress {
    flex: 1;
    height: 5px;
    background: var(--border);
    border-radius: 3px;
    overflow: hidden;
    min-width: 60px;
}
.tmail-expiry-fill {
    height: 100%;
    border-radius: 3px;
    background: linear-gradient(90deg, #10b981, #4ade80);
    transition: width 1s linear, background-color 1s;
    width: 100%;
}
.tmail-expiry-fill.warn  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.tmail-expiry-fill.danger { background: linear-gradient(90deg, #ef4444, #f87171); }

/* ── Security badges ── */
.tmail-badges {
    display: flex;
    gap: 0.65rem;
    flex-wrap: wrap;
    padding: 0.65rem 1.25rem;
    align-items: center;
}
.tmail-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.73rem;
    font-weight: 600;
    color: var(--text-2);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    padding: 0.2rem 0.65rem;
    border-radius: 100px;
}
.tmail-badge i { color: var(--success); }

/* ── Inbox section ── */
.tmail-inbox {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}
.tmail-inbox__header {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.1rem;
    border-bottom: 1px solid var(--border);
    gap: 0.75rem;
    flex-wrap: wrap;
    background: var(--bg-elevated);
}
.tmail-inbox__title {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.tmail-inbox__count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 0.4rem;
    background: var(--primary);
    color: #fff;
    border-radius: 100px;
    font-size: 0.68rem;
    font-weight: 700;
}
.tmail-inbox__refresh {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.775rem;
    color: var(--text-3);
    white-space: nowrap;
}
.tmail-inbox__refresh-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.775rem;
    font-weight: 600;
    color: var(--primary);
    background: var(--primary-light);
    border: none;
    border-radius: 6px;
    padding: 0.3rem 0.65rem;
    cursor: pointer;
    transition: all 0.15s;
}
.tmail-inbox__refresh-btn:hover { filter: brightness(0.92); }
.tmail-inbox__refresh-btn i.spinning {
    animation: tmail-spin 0.7s linear infinite;
}
@keyframes tmail-spin { to { transform: rotate(360deg); } }

/* ── Message rows ── */
.tmail-message {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.8rem 1.1rem;
    border-bottom: 1px solid var(--border);
    cursor: pointer;
    transition: background 0.12s ease;
    text-decoration: none;
    color: inherit;
    position: relative;
}
.tmail-message:last-child { border-bottom: none; }
.tmail-message:hover { background: var(--bg-elevated); }
.tmail-message--unread { background: rgba(79,70,229,0.04); }
html[data-theme="dark"] .tmail-message--unread { background: rgba(79,70,229,0.1); }
.tmail-message--unread::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: var(--accent);
    border-radius: 0 2px 2px 0;
}
.tmail-message__avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 700;
    flex-shrink: 0;
    background: var(--primary-light);
    color: var(--primary);
    text-transform: uppercase;
}
.tmail-message__body {
    flex: 1;
    min-width: 0;
}
.tmail-message__from {
    font-size: 0.83rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tmail-message--unread .tmail-message__from { color: var(--primary); }
.tmail-message__subject {
    font-size: 0.8rem;
    color: var(--text-2);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-top: 0.1rem;
}
.tmail-message__meta {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.3rem;
    flex-shrink: 0;
}
.tmail-message__time {
    font-size: 0.73rem;
    color: var(--text-3);
    white-space: nowrap;
}
.tmail-message__arrow {
    font-size: 0.75rem;
    color: var(--text-3);
}

/* ── Skeleton loader ── */
.tmail-skeleton {
    padding: 0.8rem 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-bottom: 1px solid var(--border);
}
.tmail-skeleton:last-child { border-bottom: none; }
.tmail-skel-circle {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(90deg, var(--bg-elevated) 25%, var(--border) 50%, var(--bg-elevated) 75%);
    background-size: 200% 100%;
    animation: tmail-shimmer 1.4s infinite;
    flex-shrink: 0;
}
.tmail-skel-lines { flex: 1; display: flex; flex-direction: column; gap: 0.4rem; }
.tmail-skel-line {
    height: 10px;
    border-radius: 5px;
    background: linear-gradient(90deg, var(--bg-elevated) 25%, var(--border) 50%, var(--bg-elevated) 75%);
    background-size: 200% 100%;
    animation: tmail-shimmer 1.4s infinite;
}
.tmail-skel-line--short { width: 45%; animation-delay: 0.1s; }
.tmail-skel-line--long  { width: 80%; animation-delay: 0.2s; }
@keyframes tmail-shimmer {
    0%   { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* ── Empty state ── */
.tmail-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2.5rem 1rem;
    gap: 0.75rem;
    text-align: center;
}
.tmail-empty__icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 0.25rem;
}
.tmail-empty__title {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text);
}
.tmail-empty__sub {
    font-size: 0.82rem;
    color: var(--text-3);
    max-width: 240px;
    line-height: 1.5;
    margin: 0;
}

/* ── Email viewer ── */
.tmail-viewer {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-top: 0.875rem;
    animation: tmail-slide-in 0.2s ease;
}
@keyframes tmail-slide-in {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.tmail-viewer__header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1.1rem;
    border-bottom: 1px solid var(--border);
    background: var(--bg-elevated);
    flex-wrap: wrap;
}
.tmail-viewer__back {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--primary);
    background: var(--primary-light);
    border: none;
    border-radius: 7px;
    padding: 0.3rem 0.75rem;
    cursor: pointer;
    transition: filter 0.15s;
    flex-shrink: 0;
}
.tmail-viewer__back:hover { filter: brightness(0.9); }
.tmail-viewer__subject {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--text);
    flex: 1;
    min-width: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tmail-viewer__meta {
    padding: 0.75rem 1.1rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}
.tmail-viewer__meta-row {
    font-size: 0.8rem;
    color: var(--text-2);
}
.tmail-viewer__meta-row strong { color: var(--text); margin-right: 0.35rem; }
.tmail-viewer__body {
    padding: 1.1rem;
    font-size: 0.875rem;
    color: var(--text);
    line-height: 1.7;
    max-height: 480px;
    overflow-y: auto;
    word-break: break-word;
}
.tmail-viewer__body-html { width: 100%; border: none; min-height: 300px; }

/* ── Error state ── */
.tmail-error {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    padding: 0.875rem 1.1rem;
    background: rgba(239,68,68,0.08);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 10px;
    color: var(--danger);
    font-size: 0.84rem;
    margin-bottom: 0.875rem;
}

/* ── Address card skeleton (init state) ── */
.tmail-address-card--loading .tmail-address-card__email {
    display: inline-block;
    width: 220px;
    height: 18px;
    background: rgba(255,255,255,0.25);
    border-radius: 5px;
    animation: tmail-shimmer 1.4s infinite;
    background-size: 200% 100%;
}

/* ── Responsive ── */
@media (max-width: 640px) {
    .tmail-address-card__top { padding: 0.875rem 1rem; }
    .tmail-address-card__email { font-size: 0.9rem; }
    .tmail-expiry-bar { gap: 0.5rem; }
    .tmail-badges { gap: 0.4rem; }
    .tmail-inbox__header { gap: 0.5rem; }
    .tmail-inbox__refresh-btn span { display: none; }
}
</style>
@endpush

{{-- ─── Markup ────────────────────────────────────────────────────────────────── --}}
<div class="tmail-lab" id="tmailLab">

    {{-- Header --}}
    <div class="tmail-lab__header">
        <div>
            <h2 class="h4 fw-bold mb-1">Temporary Email</h2>
            <p class="text-body-secondary mb-0 small">
                Generate a free, disposable email address instantly. Receive emails privately — no sign-up, no tracking.
            </p>
        </div>
        <div class="json-pill-tray">
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-shield-halved me-1"></i>Private</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-bolt me-1"></i>Instant</span>
            <span class="json-pill json-pill--ghost"><i class="fa-solid fa-trash me-1"></i>Auto-delete</span>
        </div>
    </div>

    {{-- Global error display --}}
    <div class="tmail-error d-none" id="tmailGlobalError" role="alert">
        <i class="fa-solid fa-circle-xmark flex-shrink-0 mt-1"></i>
        <div><strong>Error:&nbsp;</strong><span id="tmailErrorMsg">Could not connect to mail server.</span>
            <button class="btn btn-sm btn-outline-danger ms-2" onclick="window.tmailInit(true)">
                <i class="fa-solid fa-rotate-right me-1"></i>Retry
            </button>
        </div>
    </div>

    {{-- ── Address card ── --}}
    <div class="tmail-address-card" id="tmailAddressCard">
        <div class="tmail-address-card__top">
            <div class="tmail-address-icon">📧</div>
            <div class="flex-grow-1 min-width-0">
                <div class="tmail-address-card__label">Your disposable address</div>
                <div class="tmail-address-card__email" id="tmailAddressText">Generating…</div>
            </div>
            <div class="tmail-address-card__actions">
                <button class="tmail-icon-btn" id="tmailCopyBtn"
                        onclick="window.tmailCopy()" title="Copy email address">
                    <i class="fa-solid fa-copy"></i>
                </button>
                <button class="tmail-icon-btn" id="tmailNewBtn"
                        onclick="window.tmailNew()" title="Generate new address">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
        </div>

        {{-- Expiry progress bar --}}
        <div class="tmail-expiry-bar">
            <span class="tmail-expiry-label">
                <i class="fa-solid fa-clock text-body-secondary"></i>
                Expires in <strong id="tmailCountdown">10:00</strong>
            </span>
            <div class="tmail-expiry-progress">
                <div class="tmail-expiry-fill" id="tmailExpiryFill"></div>
            </div>
            <button class="btn btn-sm btn-outline-secondary" style="font-size:0.75rem;padding:0.2rem 0.65rem;"
                    onclick="window.tmailNew()" title="Reset timer and get a new address">
                <i class="fa-solid fa-clock-rotate-left me-1"></i>Extend
            </button>
        </div>

        {{-- Security badges --}}
        <div class="tmail-badges">
            <span class="tmail-badge"><i class="fa-solid fa-shield-halved"></i> No registration</span>
            <span class="tmail-badge"><i class="fa-solid fa-eye-slash"></i> No tracking</span>
            <span class="tmail-badge"><i class="fa-solid fa-server"></i> Powered by mail.tm</span>
            <span class="tmail-badge"><i class="fa-solid fa-globe"></i> Works globally</span>
        </div>
    </div>

    {{-- ── Inbox ── --}}
    <div class="tmail-inbox" id="tmailInboxCard">
        <div class="tmail-inbox__header">
            <div class="tmail-inbox__title">
                <i class="fa-solid fa-inbox text-body-secondary"></i>
                Inbox
                <span class="tmail-inbox__count d-none" id="tmailMsgCount">0</span>
            </div>
            <div class="tmail-inbox__refresh">
                <span id="tmailAutoRefreshLabel">Auto-refresh in <strong id="tmailRefreshTick">15</strong>s</span>
                <button class="tmail-inbox__refresh-btn" onclick="window.tmailRefreshInbox()"
                        id="tmailRefreshBtn" title="Refresh inbox now">
                    <i class="fa-solid fa-rotate-right" id="tmailRefreshIcon"></i>
                    <span>Refresh</span>
                </button>
            </div>
        </div>
        {{-- Message list / skeleton / empty state --}}
        <div id="tmailMessageList">
            {{-- JS fills this in --}}
        </div>
    </div>

    {{-- ── Email viewer (hidden until a message is opened) ── --}}
    <div class="tmail-viewer d-none" id="tmailViewer">
        <div class="tmail-viewer__header">
            <button class="tmail-viewer__back" onclick="window.tmailCloseViewer()">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <div class="tmail-viewer__subject" id="tmailViewerSubject">—</div>
        </div>
        <div class="tmail-viewer__meta" id="tmailViewerMeta"></div>
        <div class="tmail-viewer__body" id="tmailViewerBody"></div>
    </div>

</div>{{-- /.tmail-lab --}}

@push('scripts')
<script>
(function () {
    'use strict';

    /* ═══════════════════════════════════════════════════════════
       CONSTANTS
    ═══════════════════════════════════════════════════════════ */
    var TTL_MS    = 10 * 60 * 1000;   // 10 minute email lifetime
    var POLL_S    = 15;                // seconds between auto-refreshes
    var LS_ADDR   = 'tmail_address';
    var LS_PASS   = 'tmail_password';
    var LS_TOKEN  = 'tmail_token';
    var LS_BORN   = 'tmail_created_at';
    var LS_SEEN   = 'tmail_seen_ids';   // comma-separated read message IDs

    /* ═══════════════════════════════════════════════════════════
       STATE
    ═══════════════════════════════════════════════════════════ */
    var state = {
        address:   null,
        token:     null,
        messages:  [],
        openId:    null,
        expiryAt:  null,
        expiryTmr: null,
        pollTmr:   null,
        pollTick:  POLL_S,
        seenIds:   new Set()
    };

    /* ═══════════════════════════════════════════════════════════
       HELPERS
    ═══════════════════════════════════════════════════════════ */
    function rand(len) {
        var chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        var out = '';
        for (var i = 0; i < len; i++)
            out += chars[Math.floor(Math.random() * chars.length)];
        return out;
    }

    function relativeTime(iso) {
        var diff = Math.floor((Date.now() - new Date(iso).getTime()) / 1000);
        if (diff < 60)  return diff + 's ago';
        if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
        return Math.floor(diff / 3600) + 'h ago';
    }

    function avatarLetter(from) {
        var m = (from || '').match(/[A-Za-z]/);
        return m ? m[0].toUpperCase() : '?';
    }

    function avatarColor(from) {
        var colors = [
            ['#dbeafe','#2563eb'], ['#f3e8ff','#7c3aed'], ['#dcfce7','#16a34a'],
            ['#fff7ed','#ea580c'], ['#fce7f3','#db2777'], ['#e0f2fe','#0284c7']
        ];
        var idx = (from || '').charCodeAt(0) % colors.length;
        return colors[idx];
    }

    function apiFetch(url, opts) {
        opts = opts || {};
        var csrfMeta = document.querySelector('meta[name="csrf-token"]');
        var csrf     = csrfMeta ? csrfMeta.getAttribute('content') : '';
        var headers  = Object.assign(
            { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            state.token ? { 'Authorization': 'Bearer ' + state.token } : {},
            opts.headers || {}
        );
        return fetch(url, Object.assign({}, opts, { headers: headers }))
            .then(function (res) {
                if (!res.ok) {
                    return res.json().catch(function () { return {}; }).then(function (body) {
                        throw new Error(body.error || body['hydra:description'] || body.detail || 'HTTP ' + res.status);
                    });
                }
                if (res.status === 204) return {};
                return res.json();
            });
    }

    /* ═══════════════════════════════════════════════════════════
       LOCAL STORAGE  helpers
    ═══════════════════════════════════════════════════════════ */
    function saveSession(address, password, token, bornAt) {
        try {
            localStorage.setItem(LS_ADDR,  address);
            localStorage.setItem(LS_PASS,  password);
            localStorage.setItem(LS_TOKEN, token);
            localStorage.setItem(LS_BORN,  String(bornAt));
        } catch (e) { /* private browsing */ }
    }

    function loadSession() {
        try {
            var addr = localStorage.getItem(LS_ADDR);
            var pass = localStorage.getItem(LS_PASS);
            var tok  = localStorage.getItem(LS_TOKEN);
            var born = parseInt(localStorage.getItem(LS_BORN) || '0', 10);
            if (addr && tok && born && (Date.now() - born < TTL_MS)) {
                return { address: addr, password: pass, token: tok, born: born };
            }
        } catch (e) { /* */ }
        return null;
    }

    function clearSession() {
        try {
            [LS_ADDR, LS_PASS, LS_TOKEN, LS_BORN, LS_SEEN].forEach(function (k) {
                localStorage.removeItem(k);
            });
        } catch (e) { /* */ }
    }

    function loadSeenIds() {
        try {
            var raw = localStorage.getItem(LS_SEEN) || '';
            state.seenIds = new Set(raw ? raw.split(',') : []);
        } catch (e) { state.seenIds = new Set(); }
    }

    function markSeen(id) {
        state.seenIds.add(String(id));
        try {
            localStorage.setItem(LS_SEEN, Array.from(state.seenIds).join(','));
        } catch (e) { /* */ }
    }

    /* ═══════════════════════════════════════════════════════════
       INIT — entry point
    ═══════════════════════════════════════════════════════════ */
    window.tmailInit = function (forceNew) {
        hideError();
        loadSeenIds();
        var existing = !forceNew && loadSession();
        if (existing) {
            state.address  = existing.address;
            state.token    = existing.token;
            state.expiryAt = existing.born + TTL_MS;
            setAddressText(existing.address);
            startExpiryTimer();
            tmailRefreshInbox();
            startAutoPoll();
        } else {
            clearSession();
            createNewEmail();
        }
    };

    /* ═══════════════════════════════════════════════════════════
       CREATE NEW EMAIL
    ═══════════════════════════════════════════════════════════ */
    function createNewEmail() {
        setAddressText('Generating…');
        setInboxSkeleton();

        /* Single call to our Laravel proxy — no CORS, no direct mail.tm contact */
        apiFetch('/tools/temp-mail/generate', { method: 'POST' })
            .then(function (data) {
                if (!data.ok) throw new Error(data.error || 'Generation failed');
                return { addr: data.address, pass: data.password, token: data.token };
            })
            .then(function (r) {
                var now = Date.now();
                state.address  = r.addr;
                state.token    = r.token;
                state.expiryAt = now + TTL_MS;
                state.messages = [];
                state.seenIds  = new Set();
                saveSession(r.addr, r.pass, r.token, now);
                setAddressText(r.addr);
                setInboxEmpty();
                startExpiryTimer();
                startAutoPoll();
                if (window.showFlash) window.showFlash('New address ready!', 'success', 2000);
            })
            .catch(function (err) {
                showError('Could not generate email address: ' + err.message);
                setInboxEmpty();
            });
    }

    /* ═══════════════════════════════════════════════════════════
       REFRESH INBOX
    ═══════════════════════════════════════════════════════════ */
    window.tmailRefreshInbox = function () {
        if (!state.token) return;
        setRefreshBtnSpinning(true);

        apiFetch('/tools/temp-mail/inbox')
            .then(function (data) {
                var msgs = (data.ok && data.messages) ? data.messages : [];
                state.messages = msgs;
                renderInbox(msgs);
                /* title notification for new unread */
                var unread = msgs.filter(function (m) {
                    return !state.seenIds.has(String(m.id)) && !m.seen;
                }).length;
                updatePageTitle(unread);
            })
            .catch(function (err) {
                /* silently fail on poll; show error only if it was a manual refresh */
                console.warn('Inbox refresh failed:', err.message);
            })
            .finally(function () {
                setRefreshBtnSpinning(false);
                resetPollTick();
            });
    };

    /* ═══════════════════════════════════════════════════════════
       OPEN MESSAGE
    ═══════════════════════════════════════════════════════════ */
    function openMessage(id) {
        markSeen(id);
        state.openId = id;

        /* Optimistically mark unread dot gone */
        var rowEl = document.querySelector('[data-msg-id="' + id + '"]');
        if (rowEl) rowEl.classList.remove('tmail-message--unread');

        /* Show viewer with skeleton body */
        var viewer = document.getElementById('tmailViewer');
        viewer.classList.remove('d-none');
        document.getElementById('tmailViewerSubject').textContent = 'Loading…';
        document.getElementById('tmailViewerMeta').innerHTML = '';
        document.getElementById('tmailViewerBody').innerHTML =
            '<div class="tmail-skeleton" style="border:0"><div class="tmail-skel-lines">' +
            '<div class="tmail-skel-line tmail-skel-line--long"></div>' +
            '<div class="tmail-skel-line tmail-skel-line--short"></div>' +
            '<div class="tmail-skel-line tmail-skel-line--long" style="margin-top:1rem"></div>' +
            '<div class="tmail-skel-line" style="width:70%"></div>' +
            '</div></div>';
        viewer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        apiFetch('/tools/temp-mail/message/' + id)
            .then(function (data) {
                if (!data.ok) throw new Error(data.error || 'Failed to load message');
                var msg  = data.message;
                var subj = msg.subject || '(no subject)';
                var from = (msg.from && (msg.from.name || msg.from.address)) || 'Unknown';
                var fromAddr = (msg.from && msg.from.address) || '';
                var date = msg.createdAt
                    ? new Date(msg.createdAt).toLocaleString()
                    : '—';

                document.getElementById('tmailViewerSubject').textContent = subj;
                document.getElementById('tmailViewerMeta').innerHTML =
                    '<div class="tmail-viewer__meta-row"><strong>From:</strong>' +
                    escHtml(from) + (fromAddr && from !== fromAddr ? ' &lt;' + escHtml(fromAddr) + '&gt;' : '') +
                    '</div>' +
                    '<div class="tmail-viewer__meta-row"><strong>To:</strong>' + escHtml(state.address) + '</div>' +
                    '<div class="tmail-viewer__meta-row"><strong>Date:</strong>' + escHtml(date) + '</div>';

                var bodyEl = document.getElementById('tmailViewerBody');
                if (msg.html && msg.html.length) {
                    /* Render HTML body in a sandboxed iframe */
                    var iframe = document.createElement('iframe');
                    iframe.className = 'tmail-viewer__body-html';
                    iframe.setAttribute('sandbox', 'allow-same-origin');
                    iframe.setAttribute('loading', 'lazy');
                    bodyEl.innerHTML = '';
                    bodyEl.appendChild(iframe);
                    var doc = iframe.contentDocument || iframe.contentWindow.document;
                    doc.open();
                    doc.write(msg.html.join ? msg.html.join('') : msg.html);
                    doc.close();
                    /* Adjust height to content */
                    setTimeout(function () {
                        try {
                            iframe.style.height = doc.body.scrollHeight + 32 + 'px';
                        } catch (e) { iframe.style.height = '400px'; }
                    }, 200);
                } else {
                    bodyEl.innerHTML = '<pre style="white-space:pre-wrap;font-family:inherit;margin:0">' +
                        escHtml(msg.text || '(empty message)') + '</pre>';
                }
                /* Update message count badge (decrement unread) */
                updateMsgCountBadge();
            })
            .catch(function (err) {
                document.getElementById('tmailViewerSubject').textContent = 'Error';
                document.getElementById('tmailViewerBody').textContent =
                    'Could not load this email: ' + err.message;
            });
    }

    /* ═══════════════════════════════════════════════════════════
       PUBLIC API
    ═══════════════════════════════════════════════════════════ */
    window.tmailNew = function () {
        stopTimers();
        clearSession();
        state.address = null;
        state.token   = null;
        state.messages = [];
        state.seenIds  = new Set();
        closeViewer();
        createNewEmail();
    };

    window.tmailCopy = function () {
        if (!state.address) return;
        navigator.clipboard.writeText(state.address)
            .then(function () {
                if (window.showFlash) window.showFlash('Email copied!', 'success', 2000);
                var btn = document.getElementById('tmailCopyBtn');
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                setTimeout(function () {
                    btn.innerHTML = '<i class="fa-solid fa-copy"></i>';
                }, 1800);
            })
            .catch(function () {
                if (window.showFlash) window.showFlash('Copy failed', 'error', 2000);
            });
    };

    window.tmailCloseViewer = function () {
        closeViewer();
    };

    /* ═══════════════════════════════════════════════════════════
       RENDER HELPERS
    ═══════════════════════════════════════════════════════════ */
    function setAddressText(addr) {
        document.getElementById('tmailAddressText').textContent = addr;
    }

    function setInboxSkeleton() {
        document.getElementById('tmailMessageList').innerHTML =
            skeletonRow() + skeletonRow() + skeletonRow();
    }

    function skeletonRow() {
        return '<div class="tmail-skeleton">' +
            '<div class="tmail-skel-circle"></div>' +
            '<div class="tmail-skel-lines">' +
            '<div class="tmail-skel-line tmail-skel-line--short"></div>' +
            '<div class="tmail-skel-line tmail-skel-line--long"></div>' +
            '</div></div>';
    }

    function setInboxEmpty() {
        document.getElementById('tmailMessageList').innerHTML =
            '<div class="tmail-empty">' +
            '<div class="tmail-empty__icon">📭</div>' +
            '<div class="tmail-empty__title">Inbox is empty</div>' +
            '<p class="tmail-empty__sub">Waiting for incoming messages. Share your address to receive emails here.</p>' +
            '</div>';
        updateMsgCountBadge(0);
    }

    function renderInbox(msgs) {
        var list = document.getElementById('tmailMessageList');
        if (!msgs || !msgs.length) {
            setInboxEmpty();
            return;
        }
        var unread = 0;
        list.innerHTML = msgs.map(function (msg) {
            var from     = (msg.from && (msg.from.name || msg.from.address)) || 'Unknown';
            var subject  = msg.subject || '(no subject)';
            var time     = relativeTime(msg.createdAt || msg.createdAt);
            var isUnread = !state.seenIds.has(String(msg.id)) && !msg.seen;
            if (isUnread) unread++;
            var col = avatarColor(from);
            return '<div class="tmail-message' + (isUnread ? ' tmail-message--unread' : '') + '" ' +
                'data-msg-id="' + escAttr(msg.id) + '" ' +
                'onclick="window.tmailOpenMsg(\'' + escAttr(msg.id) + '\')" ' +
                'role="button" tabindex="0" aria-label="From ' + escAttr(from) + ': ' + escAttr(subject) + '">' +
                '<div class="tmail-message__avatar" style="background:' + col[0] + ';color:' + col[1] + '">' +
                avatarLetter(from) + '</div>' +
                '<div class="tmail-message__body">' +
                '<div class="tmail-message__from">' + escHtml(from) + '</div>' +
                '<div class="tmail-message__subject">' + escHtml(subject) + '</div>' +
                '</div>' +
                '<div class="tmail-message__meta">' +
                '<span class="tmail-message__time">' + escHtml(time) + '</span>' +
                '<i class="fa-solid fa-chevron-right tmail-message__arrow"></i>' +
                '</div></div>';
        }).join('');
        updateMsgCountBadge(unread);

        /* keyboard accessibility */
        list.querySelectorAll('[role="button"]').forEach(function (el) {
            el.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') el.click();
            });
        });
    }

    window.tmailOpenMsg = function (id) { openMessage(id); };

    function closeViewer() {
        document.getElementById('tmailViewer').classList.add('d-none');
        state.openId = null;
    }

    function updateMsgCountBadge(unread) {
        var badge = document.getElementById('tmailMsgCount');
        var total = state.messages.length;
        if (unread === undefined) {
            unread = state.messages.filter(function (m) {
                return !state.seenIds.has(String(m.id));
            }).length;
        }
        if (total > 0) {
            badge.classList.remove('d-none');
            badge.textContent = unread > 0 ? unread : total;
            badge.style.background = unread > 0 ? 'var(--accent)' : 'var(--primary)';
        } else {
            badge.classList.add('d-none');
        }
    }

    function updatePageTitle(unread) {
        if (unread > 0) {
            document.title = '(' + unread + ' new) ' +
                document.title.replace(/^\(\d+ new\) /, '');
        } else {
            document.title = document.title.replace(/^\(\d+ new\) /, '');
        }
    }

    /* ═══════════════════════════════════════════════════════════
       TIMERS
    ═══════════════════════════════════════════════════════════ */
    function startExpiryTimer() {
        stopExpiryTimer();
        state.expiryTmr = setInterval(tickExpiry, 1000);
        tickExpiry();
    }

    function stopExpiryTimer() {
        if (state.expiryTmr) { clearInterval(state.expiryTmr); state.expiryTmr = null; }
    }

    function tickExpiry() {
        var remaining = state.expiryAt - Date.now();
        if (remaining <= 0) {
            stopTimers();
            document.getElementById('tmailCountdown').textContent = 'Expired';
            document.getElementById('tmailExpiryFill').style.width = '0%';
            document.getElementById('tmailExpiryFill').className = 'tmail-expiry-fill danger';
            if (window.showFlash)
                window.showFlash('Your temp email expired. Click "Extend" for a new one.', 'error', 5000);
            return;
        }
        var totalMs   = TTL_MS;
        var pct       = Math.max(0, Math.min(100, remaining / totalMs * 100));
        var mins      = Math.floor(remaining / 60000);
        var secs      = Math.floor((remaining % 60000) / 1000);
        var label     = pad2(mins) + ':' + pad2(secs);
        var fillEl    = document.getElementById('tmailExpiryFill');
        document.getElementById('tmailCountdown').textContent = label;
        fillEl.style.width = pct + '%';
        fillEl.className = 'tmail-expiry-fill' +
            (pct < 25 ? ' danger' : pct < 50 ? ' warn' : '');
    }

    function startAutoPoll() {
        stopAutoPoll();
        state.pollTick = POLL_S;
        state.pollTmr  = setInterval(function () {
            state.pollTick--;
            updatePollTick();
            if (state.pollTick <= 0) {
                state.pollTick = POLL_S;
                window.tmailRefreshInbox();
            }
        }, 1000);
        updatePollTick();
    }

    function stopAutoPoll() {
        if (state.pollTmr) { clearInterval(state.pollTmr); state.pollTmr = null; }
    }

    function stopTimers() {
        stopExpiryTimer();
        stopAutoPoll();
    }

    function resetPollTick() {
        state.pollTick = POLL_S;
        updatePollTick();
    }

    function updatePollTick() {
        var el = document.getElementById('tmailRefreshTick');
        if (el) el.textContent = state.pollTick;
    }

    /* ═══════════════════════════════════════════════════════════
       ERROR UI
    ═══════════════════════════════════════════════════════════ */
    function showError(msg) {
        var el = document.getElementById('tmailGlobalError');
        document.getElementById('tmailErrorMsg').textContent = msg;
        el.classList.remove('d-none');
    }
    function hideError() {
        document.getElementById('tmailGlobalError').classList.add('d-none');
    }

    function setRefreshBtnSpinning(on) {
        var icon = document.getElementById('tmailRefreshIcon');
        if (!icon) return;
        if (on) icon.classList.add('spinning');
        else    icon.classList.remove('spinning');
    }

    /* ═══════════════════════════════════════════════════════════
       ESCAPING
    ═══════════════════════════════════════════════════════════ */
    function escHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
    function escAttr(str) {
        return String(str || '').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
    }

    function pad2(n) { return n < 10 ? '0' + n : String(n); }

    /* ═══════════════════════════════════════════════════════════
       BOOT
    ═══════════════════════════════════════════════════════════ */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { window.tmailInit(false); });
    } else {
        window.tmailInit(false);
    }

})();
</script>
@endpush
