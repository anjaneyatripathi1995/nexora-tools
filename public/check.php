<?php
/**
 * Nexora Tools — Server Diagnostic
 *
 * Access via: https://tripathinexora.com/check.php?key=nexora2026
 *
 * IMPORTANT: Delete this file or change the key after diagnosis is complete.
 */

// ── Secret key guard ─────────────────────────────────────────────────────────
if (($_GET['key'] ?? '') !== 'nexora2026') {
    http_response_code(403);
    exit('403 Forbidden');
}

$root   = dirname(__DIR__);
$public = __DIR__;

// ── Checks ───────────────────────────────────────────────────────────────────
function chk(string $label, bool $ok, string $detail = ''): void
{
    $icon  = $ok ? '✅' : '❌';
    $color = $ok ? '#4ade80' : '#f87171';
    echo "<tr><td>{$icon} {$label}</td><td style='color:{$color}'>" . ($ok ? 'OK' : 'FAIL') . "</td><td>{$detail}</td></tr>";
}

function chkFile(string $label, string $path): void
{
    chk($label, file_exists($path), $path);
}

function chkDir(string $label, string $path, bool $needsWrite = false): void
{
    $exists   = is_dir($path);
    $writable = $needsWrite ? (is_writable($path) ? ' (writable ✓)' : ' (NOT WRITABLE ❌)') : '';
    chk($label, $exists, $path . $writable);
}

$checks = [];

header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Nexora Server Check</title>
<style>
  body { font-family: monospace; background: #0f172a; color: #e2e8f0; padding: 24px; }
  h2   { color: #60a5fa; }
  table{ border-collapse: collapse; width: 100%; max-width: 900px; }
  th,td{ padding: 8px 14px; border: 1px solid #334155; text-align: left; font-size: .9rem; }
  th   { background: #1e293b; color: #94a3b8; }
  .section { color: #818cf8; font-weight: bold; font-size: 1.05rem; padding-top: 18px; }
</style>
</head>
<body>
<h2>&#9889; Nexora Tools — Server Diagnostic</h2>
<table>
<tr><th>Check</th><th>Status</th><th>Detail</th></tr>

<!-- PHP -->
<tr><td class="section" colspan="3">PHP</td></tr>
<?php
$phpVer = PHP_VERSION;
chk('PHP version ≥ 8.1', version_compare($phpVer, '8.1.0', '>='), "PHP $phpVer");
chk('PDO MySQL extension', extension_loaded('pdo_mysql'), extension_loaded('pdo_mysql') ? 'loaded' : 'MISSING — contact host');
chk('mbstring extension',  extension_loaded('mbstring'),  extension_loaded('mbstring')  ? 'loaded' : 'MISSING');
chk('openssl extension',   extension_loaded('openssl'),   extension_loaded('openssl')   ? 'loaded' : 'MISSING');
chk('fileinfo extension',  extension_loaded('fileinfo'),  extension_loaded('fileinfo')  ? 'loaded' : 'MISSING');
chk('ZIP extension',       extension_loaded('zip'),       extension_loaded('zip')       ? 'loaded' : 'MISSING (needed for PDF tools)');
?>

<!-- Directories & Files -->
<tr><td class="section" colspan="3">Files & Directories</td></tr>
<?php
chkFile('.env file',                  "$root/.env");
chkFile('vendor/autoload.php',        "$root/vendor/autoload.php");
chkFile('bootstrap/app.php',          "$root/bootstrap/app.php");
chkFile('Vite manifest',              "$public/build/manifest.json");
chkFile('app.css asset',              "$public/build/assets/" . (function() use ($public) {
    $m = @json_decode(@file_get_contents("$public/build/manifest.json"), true);
    return $m['resources/css/app.css']['file'] ?? '(manifest not found)';
})());
chkDir('storage/logs',                "$root/storage/logs",                      true);
chkDir('storage/framework/sessions',  "$root/storage/framework/sessions",        true);
chkDir('storage/framework/views',     "$root/storage/framework/views",           true);
chkDir('storage/framework/cache',     "$root/storage/framework/cache",           true);
chkDir('bootstrap/cache',             "$root/bootstrap/cache",                   true);
?>

<!-- Environment -->
<tr><td class="section" colspan="3">Environment (.env)</td></tr>
<?php
$envPath = "$root/.env";
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath) ?: [];
    chk('APP_KEY set',    !empty($env['APP_KEY']),    $env['APP_KEY'] ? 'set (' . strlen($env['APP_KEY']) . ' chars)' : 'MISSING — run: php artisan key:generate');
    chk('APP_ENV',        isset($env['APP_ENV']),     $env['APP_ENV'] ?? '?');
    chk('APP_URL',        !empty($env['APP_URL']),    $env['APP_URL'] ?? '?');
    chk('DB_DATABASE',    !empty($env['DB_DATABASE']), $env['DB_DATABASE'] ?? '?');
    chk('DB_USERNAME',    !empty($env['DB_USERNAME']), $env['DB_USERNAME'] ?? '?');
} else {
    echo '<tr><td colspan="3" style="color:#f87171">❌ .env file not found at ' . htmlspecialchars($envPath) . '</td></tr>';
}
?>

<!-- Database -->
<tr><td class="section" colspan="3">Database</td></tr>
<?php
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath) ?: [];
    try {
        $pdo = new PDO(
            'mysql:host=' . ($env['DB_HOST'] ?? '127.0.0.1') . ';port=' . ($env['DB_PORT'] ?? 3306) . ';dbname=' . ($env['DB_DATABASE'] ?? ''),
            $env['DB_USERNAME'] ?? '',
            $env['DB_PASSWORD'] ?? ''
        );
        chk('DB connection',  true, 'Connected to ' . ($env['DB_DATABASE'] ?? '?'));

        $tables = ['users', 'tools', 'sessions', 'cache'];
        foreach ($tables as $tbl) {
            $r = $pdo->query("SHOW TABLES LIKE '$tbl'");
            chk("Table: $tbl", $r && $r->rowCount() > 0, $r && $r->rowCount() > 0 ? 'exists' : 'MISSING — run: php artisan migrate');
        }

        $toolCount = $pdo->query("SELECT COUNT(*) FROM tools")->fetchColumn();
        chk('Tools seeded', $toolCount > 0, "$toolCount tools in DB");

    } catch (PDOException $e) {
        echo '<tr><td colspan="3" style="color:#f87171">❌ DB error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
    }
}
?>

<!-- Paths -->
<tr><td class="section" colspan="3">Paths (server context)</td></tr>
<?php
chk('ROOT resolved',   is_dir($root),   $root);
chk('PUBLIC resolved', is_dir($public), $public);
echo "<tr><td>DOCUMENT_ROOT</td><td>—</td><td>" . htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? 'n/a') . "</td></tr>";
echo "<tr><td>SCRIPT_FILENAME</td><td>—</td><td>" . htmlspecialchars($_SERVER['SCRIPT_FILENAME'] ?? 'n/a') . "</td></tr>";
echo "<tr><td>PHP_SAPI</td><td>—</td><td>" . PHP_SAPI . "</td></tr>";
?>

</table>
<p style="color:#64748b;margin-top:20px;font-size:.8rem">
  Delete this file after diagnosis: <code>rm public_html/check.php</code>
</p>
</body>
</html>
