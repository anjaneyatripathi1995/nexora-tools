<?php
/**
 * Nexora Tools — One-click cache & compiled-view clearer
 * Access: https://tripathinexora.com/clear-cache.php?key=YOUR_SECRET
 *
 * Usage:
 *  1. Set a secret key below (or via CACHE_CLEAR_KEY env var).
 *  2. Open the URL with ?key=YOUR_SECRET in your browser.
 *  3. DELETE or rename this file after use — never leave it public!
 */

$secret = getenv('CACHE_CLEAR_KEY') ?: 'nexora-clear-2026';   // ← change this

if (($_GET['key'] ?? '') !== $secret) {
    http_response_code(403);
    echo '<h2>403 Forbidden</h2><p>Pass ?key=YOUR_SECRET to proceed.</p>';
    exit;
}

$root = dirname(__DIR__);

// ── Locate bootstrap cache ────────────────────────────────────────────────────
$bootstrapCache = $root . '/bootstrap/cache';
$cleared = [];
$errors  = [];

function rmdir_files(string $dir, array &$cleared, array &$errors): void {
    if (!is_dir($dir)) return;
    foreach (glob($dir . '/*') as $f) {
        if (is_file($f) && basename($f) !== '.gitkeep') {
            if (@unlink($f)) { $cleared[] = $f; }
            else             { $errors[]  = "Cannot delete: $f"; }
        }
    }
}

// 1. Bootstrap config/route cache
rmdir_files($bootstrapCache, $cleared, $errors);

// 2. Compiled Blade views
rmdir_files($root . '/storage/framework/views', $cleared, $errors);

// 3. Framework cache data
rmdir_files($root . '/storage/framework/cache/data', $cleared, $errors);

// 4. Logs (optional – comment out if you want to keep logs)
// rmdir_files($root . '/storage/logs', $cleared, $errors);

// ── Report ────────────────────────────────────────────────────────────────────
$ok   = count($cleared);
$fail = count($errors);
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Cache Cleared – Nexora Tools</title>
<style>
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0f172a;color:#e2e8f0;padding:40px 24px;margin:0}
.box{max-width:640px;margin:0 auto;background:#1e293b;border:1px solid #334155;border-radius:12px;padding:32px}
h1{color:#38bdf8;margin:0 0 8px;font-size:1.4rem}
.ok{color:#4ade80}.err{color:#f87171}.item{font-size:.8rem;opacity:.7;margin:2px 0}
.warn{background:#451a03;border:1px solid #92400e;border-radius:8px;padding:12px 16px;margin-top:20px;font-size:.85rem;color:#fcd34d}
</style>
</head>
<body>
<div class="box">
    <h1>&#10003; Cache Cleared</h1>
    <p class="ok">Deleted <?= $ok ?> file(s).</p>
    <?php if ($fail): ?>
    <p class="err">Failed to delete <?= $fail ?> file(s):</p>
    <?php foreach ($errors as $e): ?><p class="item"><?= htmlspecialchars($e) ?></p><?php endforeach; ?>
    <?php endif; ?>
    <?php if ($ok): ?>
    <p style="margin-top:12px;font-size:.85rem;opacity:.7">Cleared:</p>
    <?php foreach ($cleared as $f): ?><p class="item">&#10007; <?= htmlspecialchars(str_replace($root.'/', '', $f)) ?></p><?php endforeach; ?>
    <?php endif; ?>
    <div class="warn">
        &#9888; <strong>Security reminder:</strong> Delete or rename <code>clear-cache.php</code> after use.
    </div>
</div>
</body>
</html>
<?php
