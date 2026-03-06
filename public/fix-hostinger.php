<?php
/**
 * Nexora Tools — Hostinger One-Click Fix Script
 *
 * This script fixes the most common causes of 500 errors on shared hosting:
 *   1. SESSION_DRIVER=database  → patched to file
 *   2. CACHE_STORE=database     → patched to file
 *   3. QUEUE_CONNECTION=database→ patched to sync
 *   4. Stale compiled Blade views, config cache, route cache
 *
 * USAGE:
 *   https://tripathinexora.com/fix-hostinger.php?key=nexora-fix-2026
 *
 * IMPORTANT: Delete this file after running it.
 */

$secret = 'nexora-fix-2026';   // ← change if you want a different key

if (($_GET['key'] ?? '') !== $secret) {
    http_response_code(403);
    echo '<h2>403 Forbidden</h2><p>Pass ?key=' . htmlspecialchars($secret) . ' to proceed.</p>';
    exit;
}

$root    = dirname(__DIR__);
$envFile = $root . '/.env';
$log     = [];
$errors  = [];

// ─── 1. Patch .env ────────────────────────────────────────────────────────────
if (file_exists($envFile)) {
    $env = file_get_contents($envFile);
    $original = $env;

    $patches = [
        // key                    old (regex)          new value
        ['SESSION_DRIVER',  '/^SESSION_DRIVER=.*/m',   'SESSION_DRIVER=file'],
        ['CACHE_STORE',     '/^CACHE_STORE=.*/m',      'CACHE_STORE=file'],
        ['QUEUE_CONNECTION','/^QUEUE_CONNECTION=.*/m', 'QUEUE_CONNECTION=sync'],
    ];

    foreach ($patches as [$label, $pattern, $replacement]) {
        if (preg_match($pattern, $env)) {
            $env = preg_replace($pattern, $replacement, $env);
            $log[] = "Patched $label";
        } else {
            // Key not present — append it
            $env .= "\n$replacement\n";
            $log[] = "Added $label";
        }
    }

    if ($env !== $original) {
        if (file_put_contents($envFile, $env) !== false) {
            $log[] = '.env saved successfully';
        } else {
            $errors[] = 'Could not write to .env — check file permissions';
        }
    } else {
        $log[] = '.env already has correct values — no changes needed';
    }
} else {
    $errors[] = '.env file not found at: ' . $envFile;
}

// ─── 2. Clear compiled views ──────────────────────────────────────────────────
$viewsDir = $root . '/storage/framework/views';
$deleted  = 0;
if (is_dir($viewsDir)) {
    foreach (glob($viewsDir . '/*.php') as $f) {
        if (@unlink($f)) { $deleted++; } else { $errors[] = "Cannot delete: $f"; }
    }
    $log[] = "Deleted $deleted compiled Blade view(s)";
}

// ─── 3. Clear bootstrap config/route cache ────────────────────────────────────
$cacheDir = $root . '/bootstrap/cache';
$cachedFiles = ['config.php', 'routes-v7.php', 'packages.php', 'services.php'];
foreach ($cachedFiles as $cf) {
    $path = $cacheDir . '/' . $cf;
    if (file_exists($path)) {
        if (@unlink($path)) { $log[] = "Deleted bootstrap/cache/$cf"; }
        else { $errors[] = "Cannot delete: $path"; }
    }
}

// ─── 4. Clear framework cache data ───────────────────────────────────────────
$cacheData = $root . '/storage/framework/cache/data';
if (is_dir($cacheData)) {
    $cCount = 0;
    foreach (glob($cacheData . '/*') as $f) {
        if (is_file($f) && basename($f) !== '.gitkeep') {
            if (@unlink($f)) $cCount++;
        }
    }
    $log[] = "Deleted $cCount framework cache file(s)";
}

// ─── 5. Verify storage directories are writable ──────────────────────────────
$writeDirs = [
    'storage/logs',
    'storage/framework/views',
    'storage/framework/sessions',
    'storage/framework/cache/data',
    'bootstrap/cache',
];
foreach ($writeDirs as $d) {
    $full = $root . '/' . $d;
    if (!is_dir($full)) {
        @mkdir($full, 0775, true);
        $log[] = "Created missing directory: $d";
    }
    if (!is_writable($full)) {
        $errors[] = "Not writable: $d — run: chmod 775 $full";
    }
}

// ─── Output ───────────────────────────────────────────────────────────────────
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Hostinger Fix — Nexora Tools</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0f172a; color: #e2e8f0; padding: 32px 16px; }
.wrap { max-width: 680px; margin: 0 auto; }
h1 { color: #38bdf8; font-size: 1.4rem; margin-bottom: 4px; }
h2 { font-size: .95rem; color: #94a3b8; margin-bottom: 20px; font-weight: 400; }
.card { background: #1e293b; border: 1px solid #334155; border-radius: 12px; padding: 20px 24px; margin-bottom: 16px; }
.card h3 { font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: #64748b; margin-bottom: 12px; }
.ok   { color: #4ade80; }
.err  { color: #f87171; }
.item { font-size: .85rem; padding: 4px 0; border-bottom: 1px solid #1e293b; display: flex; align-items: flex-start; gap: 8px; }
.item:last-child { border-bottom: none; }
.warn { background: #451a03; border: 1px solid #92400e; border-radius: 8px; padding: 14px 18px; margin-top: 20px; font-size: .875rem; color: #fcd34d; line-height: 1.6; }
.next { background: #0c2a4a; border: 1px solid #1e4e8c; border-radius: 8px; padding: 14px 18px; margin-top: 16px; font-size: .875rem; color: #93c5fd; line-height: 1.8; }
code { background: #0f172a; padding: 2px 7px; border-radius: 5px; font-size: .8rem; }
</style>
</head>
<body>
<div class="wrap">
    <h1>&#9889; Nexora Tools — Hostinger Fix</h1>
    <h2>One-click repair for common 500 errors on shared hosting</h2>

    <div class="card">
        <h3><?= count($errors) === 0 ? '&#10003; All steps completed' : '&#9888; Completed with errors' ?></h3>
        <?php foreach ($log as $msg): ?>
        <div class="item"><span class="ok">&#10003;</span> <span><?= htmlspecialchars($msg) ?></span></div>
        <?php endforeach; ?>
    </div>

    <?php if (!empty($errors)): ?>
    <div class="card">
        <h3 class="err">&#10007; Errors</h3>
        <?php foreach ($errors as $e): ?>
        <div class="item"><span class="err">&#10007;</span> <span><?= htmlspecialchars($e) ?></span></div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="next">
        <strong>Next steps:</strong><br>
        1. Visit <a href="https://tripathinexora.com/tools/json-formatter" style="color:#60a5fa">https://tripathinexora.com/tools/json-formatter</a> to confirm the 500 is fixed.<br>
        2. If still failing, visit <a href="/check.php?key=nexora-check-2026" style="color:#60a5fa">/check.php</a> for more diagnostics.<br>
        3. <strong>Delete this file</strong> after everything works.
    </div>

    <div class="warn">
        &#9888; <strong>Security:</strong> Delete <code>fix-hostinger.php</code> from your server immediately after use.
    </div>
</div>
</body>
</html>
