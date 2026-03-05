<?php
/**
 * Nexora Tools — Central Configuration
 *
 * BASE_URL is auto-detected to work on:
 *   - XAMPP:     http://localhost/nexora-tools/
 *   - Hostinger: https://tripathinexora.com/
 */

// ─── Base URL Auto-Detection ─────────────────────────────────────────────────
if (!defined('BASE_URL')) {
    $proto  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');

    // Strip /index.php and trailing /public so BASE_URL always points to site root
    // dirname() on Windows returns '\' for root — normalize to forward slashes immediately
    $dir = str_replace('\\', '/', dirname($script)); // e.g. /nexora-tools/public  OR  /  OR \
    $dir = rtrim($dir, '/');                         // remove trailing slashes
    $dir = preg_replace('#/public$#i', '', $dir);    // strip trailing /public
    $dir = trim($dir, '/');                          // remove any remaining stray slashes
    // Re-add single leading slash for sub-path installs; empty string for domain root
    $dir = ($dir !== '' && $dir !== '.') ? '/' . $dir : '';

    define('BASE_URL',  $proto . '://' . $host . $dir . '/');
    define('BASE_PATH', $dir);   // '' on production / Hostinger, '/nexora-tools' on XAMPP
}

// ─── Site Info ───────────────────────────────────────────────────────────────
define('SITE_NAME',    'Nexora Tools');
define('SITE_TAGLINE', 'Your Complete Tech Solution Hub');
define('SITE_DESC',    'Free online tools for PDF, images, developer utilities, SEO, finance & AI — all in one place.');
define('SITE_DOMAIN',  'tripathinexora.com');
define('SITE_EMAIL',   'contact@tripathinexora.com');
define('SITE_COMPANY', 'Tripathi Nexora Technologies');

// ─── Tool Categories ─────────────────────────────────────────────────────────
define('CATEGORIES', [
    'dev'     => ['name' => 'Developer',        'icon' => '⚡', 'color' => '#3B82F6', 'bg' => '#DBEAFE'],
    'pdf'     => ['name' => 'PDF & File',       'icon' => '📄', 'color' => '#EF4444', 'bg' => '#FEE2E2'],
    'text'    => ['name' => 'Text & Content',   'icon' => '✏️', 'color' => '#F59E0B', 'bg' => '#FEF3C7'],
    'image'   => ['name' => 'Image Tools',      'icon' => '🖼️', 'color' => '#8B5CF6', 'bg' => '#EDE9FE'],
    'seo'     => ['name' => 'SEO Tools',        'icon' => '🔍', 'color' => '#EC4899', 'bg' => '#FCE7F3'],
    'finance' => ['name' => 'Finance & Date',   'icon' => '💰', 'color' => '#10B981', 'bg' => '#D1FAE5'],
    'ai'      => ['name' => 'AI Tools',         'icon' => '🤖', 'color' => '#06B6D4', 'bg' => '#CFFAFE'],
]);

// ─── Tools Registry ──────────────────────────────────────────────────────────
define('TOOLS', [
    // Finance
    ['slug'=>'emi-calculator',      'name'=>'EMI Calculator',           'desc'=>'Calculate loan EMI instantly',                'cat'=>'finance','icon'=>'🏦','popular'=>true],
    ['slug'=>'sip-calculator',      'name'=>'SIP Calculator',           'desc'=>'Calculate SIP returns & wealth growth',       'cat'=>'finance','icon'=>'📈','popular'=>true],
    ['slug'=>'fd-rd-calculator',    'name'=>'FD/RD Calculator',         'desc'=>'Fixed & recurring deposit returns',           'cat'=>'finance','icon'=>'🏧'],
    ['slug'=>'gst-calculator',      'name'=>'GST Calculator',           'desc'=>'Add or remove GST from any amount',           'cat'=>'finance','icon'=>'🧾'],
    ['slug'=>'age-calculator',      'name'=>'Age Calculator',           'desc'=>'Calculate exact age from date of birth',      'cat'=>'finance','icon'=>'🎂','popular'=>true],
    ['slug'=>'month-to-date-converter', 'name'=>'Month-to-Date Converter',  'desc'=>'Convert months to exact date ranges',         'cat'=>'finance','icon'=>'📅'],
    // PDF
    ['slug'=>'pdf-to-word',         'name'=>'PDF to Word',              'desc'=>'Convert PDF to editable Word documents',      'cat'=>'pdf',    'icon'=>'📝','popular'=>true],
    ['slug'=>'pdf-to-excel',        'name'=>'PDF to Excel',             'desc'=>'Extract tables from PDF to Excel',            'cat'=>'pdf',    'icon'=>'📊'],
    ['slug'=>'pdf-to-image',        'name'=>'PDF to Image',             'desc'=>'Convert PDF pages to PNG/JPG images',         'cat'=>'pdf',    'icon'=>'🖼️'],
    ['slug'=>'pdf-merger',           'name'=>'Merge PDF',                'desc'=>'Combine multiple PDFs into one',              'cat'=>'pdf',    'icon'=>'📎','popular'=>true],
    ['slug'=>'split-pdf',           'name'=>'Split PDF',                'desc'=>'Split PDF into separate pages or ranges',     'cat'=>'pdf',    'icon'=>'✂️'],
    ['slug'=>'compress-pdf',        'name'=>'Compress PDF',             'desc'=>'Reduce PDF size without quality loss',        'cat'=>'pdf',    'icon'=>'🗜️'],
    ['slug'=>'lock-unlock-pdf',     'name'=>'Lock / Unlock PDF',        'desc'=>'Password protect or unlock PDFs',             'cat'=>'pdf',    'icon'=>'🔐'],
    ['slug'=>'ocr',                 'name'=>'OCR — Image to Text',      'desc'=>'Extract text from images using OCR',          'cat'=>'pdf',    'icon'=>'🔎'],
    ['slug'=>'zip-compressor',      'name'=>'ZIP Compressor',           'desc'=>'Compress files into a ZIP archive',           'cat'=>'pdf',    'icon'=>'📦'],
    ['slug'=>'image-compressor',    'name'=>'Image Compressor',         'desc'=>'Compress images without visible quality loss', 'cat'=>'pdf',   'icon'=>'📸'],
    // Text
    ['slug'=>'word-counter',        'name'=>'Word & Character Counter', 'desc'=>'Count words, characters, sentences',          'cat'=>'text',   'icon'=>'🔢','popular'=>true],
    ['slug'=>'case-converter',      'name'=>'Case Converter',           'desc'=>'Convert text to any case instantly',          'cat'=>'text',   'icon'=>'Aa'],
    ['slug'=>'paraphraser',         'name'=>'Paraphraser / Rewriter',   'desc'=>'Rewrite text in a unique way',                'cat'=>'text',   'icon'=>'🔄'],
    ['slug'=>'grammar-checker',     'name'=>'Grammar Checker',          'desc'=>'Fix grammar, spelling & punctuation',         'cat'=>'text',   'icon'=>'✅'],
    ['slug'=>'plagiarism-checker',  'name'=>'Plagiarism Checker',       'desc'=>'Check content for duplicate text',            'cat'=>'text',   'icon'=>'🛡️'],
    ['slug'=>'resume-builder',      'name'=>'Resume Builder',           'desc'=>'Create a professional resume online',         'cat'=>'text',   'icon'=>'📋'],
    ['slug'=>'essay-letter-generator', 'name'=>'Essay / Letter Generator', 'desc'=>'Generate essays and formal letters with AI', 'cat'=>'text',   'icon'=>'📜'],
    // Developer
    ['slug'=>'json-formatter',      'name'=>'JSON Formatter',           'desc'=>'Format, validate & beautify JSON',            'cat'=>'dev',    'icon'=>'{ }','popular'=>true],
    ['slug'=>'base64-encoder',      'name'=>'Base64 Encoder',           'desc'=>'Encode and decode Base64 strings',            'cat'=>'dev',    'icon'=>'🔐'],
    ['slug'=>'password-generator',  'name'=>'Password Generator',       'desc'=>'Generate strong, secure passwords',           'cat'=>'dev',    'icon'=>'🔑','popular'=>true],
    ['slug'=>'url-encoder',         'name'=>'URL Encoder / Decoder',    'desc'=>'Encode or decode URL strings',                'cat'=>'dev',    'icon'=>'🔗'],
    ['slug'=>'uuid-generator',      'name'=>'UUID Generator',           'desc'=>'Generate unique UUID/GUID values',            'cat'=>'dev',    'icon'=>'🆔'],
    ['slug'=>'markdown-preview',    'name'=>'Markdown Preview',         'desc'=>'Write and preview Markdown live',             'cat'=>'dev',    'icon'=>'📝'],
    ['slug'=>'qr-code-generator',   'name'=>'QR Code Generator',        'desc'=>'Generate QR codes for URLs or text',          'cat'=>'dev',    'icon'=>'⬜'],
    ['slug'=>'regex-tester',        'name'=>'Regex Tester',             'desc'=>'Test and debug regular expressions',          'cat'=>'dev',    'icon'=>'🔍'],
    ['slug'=>'minifier',            'name'=>'HTML/CSS/JS Minifier',     'desc'=>'Minify code to reduce file size',             'cat'=>'dev',    'icon'=>'⚡'],
    ['slug'=>'temp-mail',           'name'=>'Temp Mail',                'desc'=>'Get a disposable temporary email address',    'cat'=>'dev',    'icon'=>'📧','popular'=>true],
    // Image
    ['slug'=>'image-resizer',       'name'=>'Image Resizer',            'desc'=>'Resize images to any dimension',              'cat'=>'image',  'icon'=>'📐','popular'=>true],
    ['slug'=>'background-remover',  'name'=>'Background Remover',       'desc'=>'Remove image backgrounds automatically',      'cat'=>'image',  'icon'=>'🎨'],
    ['slug'=>'image-ocr',           'name'=>'OCR Tool',                 'desc'=>'Extract text from any image',                 'cat'=>'image',  'icon'=>'🔡'],
    // SEO
    ['slug'=>'meta-tag-generator',  'name'=>'Meta Tag Generator',       'desc'=>'Generate SEO meta tags for any page',         'cat'=>'seo',    'icon'=>'🏷️','popular'=>true,'new'=>true],
    ['slug'=>'keyword-density',     'name'=>'Keyword Density Checker',  'desc'=>'Analyse keyword usage in your content',       'cat'=>'seo',    'icon'=>'📊','new'=>true],
    ['slug'=>'sitemap-generator',   'name'=>'Sitemap Generator',        'desc'=>'Generate XML sitemap for your website',       'cat'=>'seo',    'icon'=>'🗺️','new'=>true],
    // AI
    ['slug'=>'ai-text-humanizer',   'name'=>'AI Text Humanizer',        'desc'=>'Convert AI-generated text to human-like',     'cat'=>'ai',     'icon'=>'🤖','popular'=>true,'new'=>true],
    ['slug'=>'ai-content-writer',   'name'=>'AI Content Writer',        'desc'=>'Generate blog posts and articles with AI',    'cat'=>'ai',     'icon'=>'✍️','new'=>true],
    ['slug'=>'ai-summarizer',       'name'=>'AI Summarizer',            'desc'=>'Summarize long articles in seconds',          'cat'=>'ai',     'icon'=>'📑','new'=>true],
]);

// ─── Helpers ─────────────────────────────────────────────────────────────────
function tools_by_cat(string $cat): array {
    return array_filter(TOOLS, fn($t) => $t['cat'] === $cat);
}
function popular_tools(int $limit = 9): array {
    return array_slice(array_values(array_filter(TOOLS, fn($t) => !empty($t['popular']))), 0, $limit);
}
function find_tool(string $slug): ?array {
    foreach (TOOLS as $t) { if ($t['slug'] === $slug) return $t; }
    return null;
}
function cat_color(string $cat): string {
    return CATEGORIES[$cat]['color'] ?? '#6B7280';
}
function cat_bg(string $cat): string {
    return CATEGORIES[$cat]['bg'] ?? '#F3F4F6';
}
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
