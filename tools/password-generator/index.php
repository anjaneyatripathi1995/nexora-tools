<?php
$page_title = 'Password Generator — Strong & Secure';
$page_desc  = 'Generate strong, random, and secure passwords instantly. Customize length and character types. Free and private — no data stored.';
require ROOT . '/includes/header.php';
?>

<div class="sub-banner">
    <div class="container">
        <div class="sub-banner-inner">
            <h1>🔑 Password Generator</h1>
            <p>Generate strong, random passwords instantly</p>
            <div class="breadcrumb">
                <a href="<?= BASE_URL ?>">Home</a> / <a href="<?= BASE_URL ?>tools">Tools</a> / Password Generator
            </div>
        </div>
    </div>
</div>

<section class="tool-page">
    <div class="container" style="max-width:640px">
        <div class="tool-wrap">

            <!-- Generated Password -->
            <div style="background:var(--bg-elevated);border:1.5px solid var(--border);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:12px;margin-bottom:24px">
                <code id="passwordOutput" style="flex:1;font-size:1.1rem;font-family:monospace;word-break:break-all;color:var(--text)">Click Generate</code>
                <button class="btn btn-ghost btn-sm" onclick="copyPassword()">📋 Copy</button>
            </div>

            <!-- Strength Bar -->
            <div style="margin-bottom:24px">
                <div style="display:flex;justify-content:space-between;font-size:0.82rem;color:var(--text-2);margin-bottom:6px">
                    <span>Password Strength</span>
                    <span id="strengthLabel" style="font-weight:600">—</span>
                </div>
                <div style="height:6px;background:var(--border);border-radius:3px;overflow:hidden">
                    <div id="strengthBar" style="height:100%;width:0;border-radius:3px;transition:width 0.4s,background 0.4s"></div>
                </div>
            </div>

            <!-- Options -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:24px">

                <!-- Length -->
                <div class="form-group" style="grid-column:span 2;margin-bottom:0">
                    <label class="form-label">Length: <strong id="lenDisplay">16</strong></label>
                    <input type="range" id="lengthSlider" min="6" max="64" value="16" style="width:100%;accent-color:var(--primary)">
                </div>

                <!-- Checkboxes -->
                <?php $opts = [
                    ['uppercase', 'Uppercase (A-Z)', true],
                    ['lowercase', 'Lowercase (a-z)', true],
                    ['numbers',   'Numbers (0-9)', true],
                    ['symbols',   'Symbols (!@#$)', true],
                ]; foreach ($opts as [$id, $label, $checked]): ?>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:0.875rem;font-weight:500;color:var(--text-2)">
                    <input type="checkbox" id="<?= $id ?>" <?= $checked ? 'checked' : '' ?> style="accent-color:var(--primary);width:16px;height:16px">
                    <?= $label ?>
                </label>
                <?php endforeach; ?>
            </div>

            <!-- Count -->
            <div class="form-group">
                <label class="form-label">Number of passwords</label>
                <select id="count" class="form-select">
                    <option value="1">1 password</option>
                    <option value="5">5 passwords</option>
                    <option value="10">10 passwords</option>
                </select>
            </div>

            <button class="btn btn-primary w-full btn-lg" onclick="generate()">🔑 Generate Password</button>

            <!-- Multiple passwords output -->
            <div id="multiOutput" style="margin-top:20px;display:none">
                <label class="form-label">Generated passwords</label>
                <div id="multiList" class="result-box" style="min-height:80px"></div>
            </div>

        </div>

        <!-- Tips -->
        <div class="tool-wrap" style="margin-top:20px">
            <h3 style="margin-bottom:12px">💡 Password Security Tips</h3>
            <ul style="display:flex;flex-direction:column;gap:8px;color:var(--text-2);font-size:0.875rem">
                <li>✅ Use at least 12 characters for strong security</li>
                <li>✅ Mix uppercase, lowercase, numbers, and symbols</li>
                <li>✅ Use a unique password for every website</li>
                <li>✅ Store passwords in a trusted password manager</li>
                <li>❌ Never reuse passwords across sites</li>
                <li>❌ Never share passwords via email or chat</li>
            </ul>
        </div>
    </div>
</section>

<script>
const charset = {
    uppercase: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    lowercase: 'abcdefghijklmnopqrstuvwxyz',
    numbers:   '0123456789',
    symbols:   '!@#$%^&*()_+-=[]{}|;:,.<>?'
};

const slider = document.getElementById('lengthSlider');
const lenDisplay = document.getElementById('lenDisplay');
slider.addEventListener('input', () => { lenDisplay.textContent = slider.value; });

function generate() {
    const len      = parseInt(slider.value);
    const count    = parseInt(document.getElementById('count').value);
    const selected = Object.entries(charset).filter(([k]) => document.getElementById(k)?.checked).map(([,v]) => v);

    if (!selected.length) { alert('Please select at least one character type.'); return; }

    const pool = selected.join('');
    const passwords = Array.from({ length: count }, () => {
        const arr = new Uint8Array(len);
        crypto.getRandomValues(arr);
        return Array.from(arr).map(b => pool[b % pool.length]).join('');
    });

    const main = passwords[0];
    document.getElementById('passwordOutput').textContent = main;
    updateStrength(main, selected.length);

    if (count > 1) {
        document.getElementById('multiOutput').style.display = 'block';
        document.getElementById('multiList').textContent = passwords.join('\n');
    } else {
        document.getElementById('multiOutput').style.display = 'none';
    }
}

function updateStrength(pw, types) {
    const bar   = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (pw.length >= 8)  score++;
    if (pw.length >= 12) score++;
    if (pw.length >= 16) score++;
    if (types >= 2) score++;
    if (types >= 4) score++;
    const levels = [
        [20, '#EF4444', 'Very Weak'],
        [40, '#F97316', 'Weak'],
        [60, '#F59E0B', 'Fair'],
        [80, '#10B981', 'Strong'],
        [100,'#059669', 'Very Strong'],
    ];
    const [pct, color, text] = levels[Math.min(score, 4)];
    bar.style.width = pct + '%';
    bar.style.background = color;
    label.textContent = text;
    label.style.color = color;
}

function copyPassword() {
    const pw = document.getElementById('passwordOutput').textContent;
    if (pw !== 'Click Generate') window.nexoraCopy(pw, event.target);
}

// Generate on load
generate();
</script>

<?php require ROOT . '/includes/footer.php'; ?>
