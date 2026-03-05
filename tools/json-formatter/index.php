<?php
$page_title = 'JSON Formatter & Validator';
$page_desc  = 'Format, validate, and beautify JSON data online. Free JSON formatter with syntax highlighting and error detection.';
require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>{ } JSON Formatter</h1>
            <p>Format, validate and beautify your JSON data instantly</p>
            <div class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>tools">Tools</a> / JSON Formatter
            </div>
        </div>
    </div>
</div>

<section class="tool-page">
    <div class="container" style="max-width:1100px">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

            <!-- Input -->
            <div class="tool-wrap">
                <div class="tool-header">
                    <h2>Input JSON</h2>
                    <p>Paste your raw JSON below</p>
                </div>
                <div class="form-group">
                    <textarea class="form-textarea" id="jsonInput" style="min-height:320px;font-size:0.82rem" placeholder='{"name":"Nexora","tools":40,"free":true}'></textarea>
                </div>
                <div style="display:flex;gap:10px;flex-wrap:wrap">
                    <button class="btn btn-primary" onclick="formatJson()">Format ✨</button>
                    <button class="btn btn-ghost btn-sm" onclick="minifyJson()">Minify</button>
                    <button class="btn btn-ghost btn-sm" onclick="clearAll()">Clear</button>
                    <button class="btn btn-ghost btn-sm" onclick="loadSample()">Sample</button>
                </div>
            </div>

            <!-- Output -->
            <div class="tool-wrap">
                <div class="tool-header" style="display:flex;align-items:center;justify-content:space-between">
                    <div>
                        <h2>Output</h2>
                        <p id="statusMsg" style="color:var(--success)">Ready</p>
                    </div>
                    <button class="btn btn-ghost btn-sm" onclick="copyOutput()">📋 Copy</button>
                </div>
                <pre class="result-box" id="jsonOutput" style="min-height:320px">Formatted JSON will appear here...</pre>
            </div>

        </div>

        <!-- About This Tool -->
        <div class="tool-wrap" style="margin-top:24px">
            <h3 style="margin-bottom:12px">About JSON Formatter</h3>
            <p style="color:var(--text-2);line-height:1.7;font-size:0.9rem">
                This free JSON Formatter tool validates your JSON for syntax errors and formats it with proper indentation for easy reading.
                Paste raw, minified, or messy JSON — the formatter will clean it up instantly, entirely in your browser with no data sent to any server.
            </p>
        </div>
    </div>
</section>

<script>
const input  = document.getElementById('jsonInput');
const output = document.getElementById('jsonOutput');
const status = document.getElementById('statusMsg');

function setStatus(msg, ok) {
    status.textContent = msg;
    status.style.color = ok ? 'var(--success)' : 'var(--danger)';
}

function formatJson() {
    const raw = input.value.trim();
    if (!raw) { setStatus('Please enter some JSON', false); return; }
    try {
        const parsed = JSON.parse(raw);
        output.textContent = JSON.stringify(parsed, null, 2);
        setStatus('✓ Valid JSON — formatted', true);
    } catch(e) {
        output.textContent = 'Error: ' + e.message;
        setStatus('✗ Invalid JSON', false);
    }
}

function minifyJson() {
    const raw = input.value.trim();
    if (!raw) return;
    try {
        output.textContent = JSON.stringify(JSON.parse(raw));
        setStatus('✓ Minified', true);
    } catch(e) {
        setStatus('✗ ' + e.message, false);
    }
}

function clearAll() {
    input.value = '';
    output.textContent = 'Formatted JSON will appear here...';
    setStatus('Ready', true);
}

function copyOutput() {
    const text = output.textContent;
    if (text) window.nexoraCopy(text, event.target);
}

function loadSample() {
    input.value = JSON.stringify({
        site: "Nexora Tools",
        url: "tripathinexora.com",
        tools: 40,
        categories: ["Finance","PDF","Developer","Image","Text","SEO","AI"],
        free: true,
        meta: { version: "2.0", built_by: "Tripathi Nexora Technologies" }
    });
    formatJson();
}

// Format on Ctrl+Enter
input.addEventListener('keydown', e => { if ((e.ctrlKey||e.metaKey) && e.key === 'Enter') formatJson(); });
</script>

<?php require ROOT . '/includes/footer.php'; ?>
