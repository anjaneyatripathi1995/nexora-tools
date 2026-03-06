<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\ToolHistory;
use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ToolController extends Controller
{
    /** Slugs that have a working partial view (tools/partials/{slug}.blade.php) */
    public static function implementedSlugs(): array
    {
        return [
            'emi-calculator',
            'sip-calculator',
            'fd-rd-calculator',
            'gst-calculator',
            'age-calculator',
            'month-to-date-converter',
            'json-formatter',
            'base64-encoder',
            'url-encoder',
            'regex-tester',
            'qr-code-generator',
            'minifier',
            'word-counter',
            'case-converter',
            'paraphraser',
            'grammar-checker',
            'plagiarism-checker',
            'resume-builder',
            'essay-letter-generator',
            'pdf-to-word',
            'pdf-to-excel',
            'pdf-to-image',
            'pdf-merger',
            'split-pdf',
            'compress-pdf',
            'lock-unlock-pdf',
            'ocr',
            'zip-compressor',
            'image-compressor',
            'image-resizer',
            'background-remover',
            'image-ocr',
        ];
    }

    /** Partial view name for a slug (e.g. image-ocr -> ocr). */
    public static function partialForSlug(string $slug): string
    {
        return match ($slug) {
            'image-ocr' => 'ocr',
            default => $slug,
        };
    }

    /**
     * Full catalog of ALL tools.
     * Category order and names match the flat PHP CATEGORIES constant exactly
     * so the mega menu looks identical on every page of the site.
     * Keys: category name => [ tools ]
     */
    public static function fullCatalog(): array
    {
        return [
            // Order: dev, pdf, text, image, seo, finance, ai  (matches flat PHP)
            'Developer' => [
                ['name' => 'JSON Formatter',       'slug' => 'json-formatter',       'icon' => 'fa-code',              'color' => 'warning',   'description' => 'Format, validate & beautify JSON'],
                ['name' => 'Base64 Encoder',       'slug' => 'base64-encoder',       'icon' => 'fa-terminal',          'color' => 'secondary', 'description' => 'Encode/decode Base64 strings'],
                ['name' => 'Password Generator',   'slug' => 'password-generator',   'icon' => 'fa-key',               'color' => 'info',      'description' => 'Generate strong, secure passwords'],
                ['name' => 'URL Encoder / Decoder','slug' => 'url-encoder',          'icon' => 'fa-link',              'color' => 'primary',   'description' => 'Encode or decode URL strings'],
                ['name' => 'UUID Generator',       'slug' => 'uuid-generator',       'icon' => 'fa-fingerprint',       'color' => 'secondary', 'description' => 'Generate UUID v4'],
                ['name' => 'Regex Tester',         'slug' => 'regex-tester',         'icon' => 'fa-code-branch',       'color' => 'info',      'description' => 'Test regular expressions'],
                ['name' => 'QR Code Generator',    'slug' => 'qr-code-generator',    'icon' => 'fa-qrcode',            'color' => 'dark',      'description' => 'Generate QR codes for any URL or text'],
                ['name' => 'HTML/CSS/JS Minifier', 'slug' => 'minifier',             'icon' => 'fa-compress',          'color' => 'success',   'description' => 'Minify front-end code'],
                ['name' => 'Markdown Preview',     'slug' => 'markdown-preview',     'icon' => 'fa-file-code',         'color' => 'success',   'description' => 'Preview Markdown as HTML'],
                ['name' => 'Temp Mail',            'slug' => 'temp-mail',            'icon' => 'fa-envelope',          'color' => 'primary',   'description' => 'Disposable temporary email address'],
            ],
            'PDF & File' => [
                ['name' => 'PDF to Word',        'slug' => 'pdf-to-word',      'icon' => 'fa-file-word',    'color' => 'primary',   'description' => 'Convert PDF to editable Word documents'],
                ['name' => 'PDF to Excel',       'slug' => 'pdf-to-excel',     'icon' => 'fa-file-excel',   'color' => 'success',   'description' => 'Extract tables from PDF to Excel'],
                ['name' => 'PDF to Image',       'slug' => 'pdf-to-image',     'icon' => 'fa-file-image',   'color' => 'info',      'description' => 'Convert PDF pages to PNG/JPG images'],
                ['name' => 'Merge PDF',          'slug' => 'pdf-merger',       'icon' => 'fa-object-group', 'color' => 'danger',    'description' => 'Combine multiple PDFs into one'],
                ['name' => 'Split PDF',          'slug' => 'split-pdf',        'icon' => 'fa-scissors',     'color' => 'warning',   'description' => 'Split PDF into separate pages or ranges'],
                ['name' => 'Compress PDF',       'slug' => 'compress-pdf',     'icon' => 'fa-file-zipper',  'color' => 'primary',   'description' => 'Reduce PDF size without quality loss'],
                ['name' => 'Lock / Unlock PDF',  'slug' => 'lock-unlock-pdf',  'icon' => 'fa-lock',         'color' => 'secondary', 'description' => 'Password protect or unlock PDFs'],
                ['name' => 'OCR - Image to Text','slug' => 'ocr',              'icon' => 'fa-font',         'color' => 'info',      'description' => 'Extract text from images using OCR'],
                ['name' => 'ZIP Compressor',     'slug' => 'zip-compressor',   'icon' => 'fa-file-zipper',  'color' => 'success',   'description' => 'Compress files into a ZIP archive'],
                ['name' => 'Image Compressor',   'slug' => 'image-compressor', 'icon' => 'fa-image',        'color' => 'warning',   'description' => 'Compress images without visible quality loss'],
            ],
            'Text & Content' => [
                ['name' => 'Word & Character Counter', 'slug' => 'word-counter',           'icon' => 'fa-calculator',        'color' => 'info',    'description' => 'Count words, characters, sentences'],
                ['name' => 'Case Converter',           'slug' => 'case-converter',         'icon' => 'fa-font',              'color' => 'primary', 'description' => 'Convert text to any case instantly'],
                ['name' => 'Paraphraser / Rewriter',   'slug' => 'paraphraser',            'icon' => 'fa-pen-fancy',         'color' => 'primary', 'description' => 'Rewrite text in a unique way'],
                ['name' => 'Grammar Checker',          'slug' => 'grammar-checker',        'icon' => 'fa-spell-check',       'color' => 'success', 'description' => 'Fix grammar, spelling & punctuation'],
                ['name' => 'Plagiarism Checker',       'slug' => 'plagiarism-checker',     'icon' => 'fa-copy',              'color' => 'danger',  'description' => 'Check content for duplicate text'],
                ['name' => 'Resume Builder',           'slug' => 'resume-builder',         'icon' => 'fa-id-card',           'color' => 'info',    'description' => 'Create a professional resume online'],
                ['name' => 'Essay / Letter Generator', 'slug' => 'essay-letter-generator', 'icon' => 'fa-envelope-open-text','color' => 'warning', 'description' => 'Generate essays and formal letters'],
            ],
            'Image Tools' => [
                ['name' => 'Image Resizer',      'slug' => 'image-resizer',      'icon' => 'fa-expand',       'color' => 'primary', 'description' => 'Resize images to any dimensions'],
                ['name' => 'Background Remover', 'slug' => 'background-remover', 'icon' => 'fa-eraser',       'color' => 'danger',  'description' => 'Remove image background automatically'],
                ['name' => 'OCR Tool',           'slug' => 'image-ocr',          'icon' => 'fa-font',         'color' => 'info',    'description' => 'Extract text from images'],
            ],
            'SEO Tools' => [
                ['name' => 'Meta Tag Generator',      'slug' => 'meta-tag-generator', 'icon' => 'fa-tags',             'color' => 'pink',    'description' => 'Generate SEO meta tags for any page'],
                ['name' => 'Keyword Density Checker', 'slug' => 'keyword-density',    'icon' => 'fa-magnifying-glass', 'color' => 'pink',    'description' => 'Analyse keyword usage in your content'],
                ['name' => 'Sitemap Generator',       'slug' => 'sitemap-generator',  'icon' => 'fa-sitemap',          'color' => 'pink',    'description' => 'Generate XML sitemap for your website'],
            ],
            'Finance & Date' => [
                ['name' => 'EMI Calculator',          'slug' => 'emi-calculator',          'icon' => 'fa-calculator',   'color' => 'success', 'description' => 'Calculate loan EMI instantly'],
                ['name' => 'SIP Calculator',          'slug' => 'sip-calculator',          'icon' => 'fa-chart-line',   'color' => 'success', 'description' => 'Calculate SIP returns & wealth growth'],
                ['name' => 'FD/RD Calculator',        'slug' => 'fd-rd-calculator',        'icon' => 'fa-piggy-bank',   'color' => 'success', 'description' => 'Fixed & recurring deposit returns'],
                ['name' => 'GST Calculator',          'slug' => 'gst-calculator',          'icon' => 'fa-percent',      'color' => 'success', 'description' => 'Add or remove GST from any amount'],
                ['name' => 'Age Calculator',          'slug' => 'age-calculator',          'icon' => 'fa-birthday-cake','color' => 'success', 'description' => 'Calculate exact age from date of birth'],
                ['name' => 'Month-to-Date Converter', 'slug' => 'month-to-date-converter', 'icon' => 'fa-calendar-days','color' => 'success', 'description' => 'Convert months to exact date ranges'],
            ],
            'AI Tools' => [
                ['name' => 'AI Text Humanizer',  'slug' => 'ai-text-humanizer',  'icon' => 'fa-robot',     'color' => 'cyan',    'description' => 'Convert AI-generated text to human-like'],
                ['name' => 'AI Content Writer',  'slug' => 'ai-content-writer',  'icon' => 'fa-pen-fancy', 'color' => 'cyan',    'description' => 'Generate blog posts and articles with AI'],
                ['name' => 'AI Summarizer',      'slug' => 'ai-summarizer',      'icon' => 'fa-compress',  'color' => 'cyan',    'description' => 'Summarize long articles in seconds'],
            ],
        ];
    }

    public function index(Request $request)
    {
        $catalog = self::fullCatalog();

        // DB may be unavailable on shared hosting – degrade gracefully
        try {
            $dbTools = Tool::where('is_active', 1)->get()->keyBy('slug');
        } catch (\Throwable $e) {
            $dbTools = collect();
        }

        return view('tools.index', [
            'catalog'        => $catalog,
            'dbTools'        => $dbTools,
            'categoryFilter' => $request->get('category'),
        ]);
    }

    public function show($slug)
    {
        // ── Try fetching from DB (may fail if table missing / bad connection) ──
        $tool = null;
        try {
            $tool = Tool::where('slug', $slug)->where('is_active', 1)->first();
        } catch (\Throwable $e) {
            // DB unavailable – will fall through to static catalog below
        }

        if ($tool) {
            // Track history – non-fatal if it fails
            if (auth()->check()) {
                try {
                    ToolHistory::create([
                        'user_id'   => auth()->id(),
                        'tool_id'   => $tool->id,
                        'tool_slug' => $tool->slug,
                    ]);
                } catch (\Throwable $e) { /* ignore */ }
            }

            $hasPartial = in_array($tool->slug, self::implementedSlugs(), true);

            $catalog         = self::fullCatalog();
            $currentCategory = null;
            $relatedTools    = [];
            foreach ($catalog as $cat => $tools) {
                foreach ($tools as $t) {
                    if (($t['slug'] ?? '') === $slug) {
                        $currentCategory = $cat;
                        $relatedTools    = array_filter($tools, fn($t) => $t['slug'] !== $slug);
                        break 2;
                    }
                }
            }
            $otherCategories = array_filter(array_keys($catalog), fn($c) => $c !== $currentCategory);

            $isSaved = false;
            try {
                $isSaved = auth()->check() && SavedItem::where('user_id', auth()->id())
                    ->where('item_type', 'tool')
                    ->where('item_slug', $tool->slug)
                    ->exists();
            } catch (\Throwable $e) { /* ignore */ }

            return view('tools.show', [
                'tool'            => $tool,
                'tool_partial'    => $hasPartial ? self::partialForSlug($tool->slug) : null,
                'currentCategory' => $currentCategory,
                'relatedTools'    => array_values($relatedTools),
                'allCategories'   => $catalog,
                'otherCategories' => array_values($otherCategories),
                'isSaved'         => $isSaved,
            ]);
        }

        // ── Tool not in DB (or DB unavailable) – use static catalog ──────────
        foreach (self::fullCatalog() as $category => $tools) {
            foreach ($tools as $t) {
                if (($t['slug'] ?? '') === $slug) {
                    // If the tool has an implemented partial, show the full tool page
                    if (in_array($slug, self::implementedSlugs(), true)) {
                        // Build a minimal stdClass that mirrors Eloquent so the view works
                        $fakeTool = new \stdClass();
                        $fakeTool->id          = 0;
                        $fakeTool->slug        = $t['slug'];
                        $fakeTool->name        = $t['name'];
                        $fakeTool->description = $t['description'] ?? '';
                        $fakeTool->icon        = $t['icon'] ?? 'fa-wrench';
                        $fakeTool->color       = $t['color'] ?? 'primary';
                        $fakeTool->category    = $category;
                        $fakeTool->is_active   = 1;
                        $fakeTool->meta_title       = $t['name'] . ' – Free Online Tool';
                        $fakeTool->meta_description = $t['description'] ?? '';
                        $fakeTool->faq         = null;

                        $relatedTools = array_values(array_filter($tools, fn($x) => $x['slug'] !== $slug));
                        $catalog      = self::fullCatalog();

                        return view('tools.show', [
                            'tool'            => $fakeTool,
                            'tool_partial'    => self::partialForSlug($slug),
                            'currentCategory' => $category,
                            'relatedTools'    => $relatedTools,
                            'allCategories'   => $catalog,
                            'otherCategories' => array_values(array_filter(array_keys($catalog), fn($c) => $c !== $category)),
                            'isSaved'         => false,
                        ]);
                    }

                    // Tool exists in catalog but not yet implemented → show coming-soon
                    return view('tools.show-coming-soon', [
                        'name'        => $t['name'],
                        'description' => $t['description'] ?? '',
                        'icon'        => $t['icon'] ?? 'fa-wrench',
                        'color'       => $t['color'] ?? 'primary',
                    ]);
                }
            }
        }

        abort(404);
    }

    /**
     * Proxy for LanguageTool grammar check (avoids CORS).
     */
    public function grammarCheck(Request $request)
    {
        $text = $request->input('text', '');
        if (strlen($text) > 20000) {
            return response()->json(['matches' => [], 'error' => 'Text too long']);
        }
        try {
            $res = Http::asForm()->timeout(10)->post('https://api.languagetool.org/v2/check', [
                'text'     => $text,
                'language' => 'en',
            ]);
            if ($res->successful()) {
                return response()->json($res->json());
            }
            return response()->json(['matches' => [], 'error' => 'Grammar API unavailable']);
        } catch (\Throwable $e) {
            return response()->json(['matches' => [], 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove image background via remove.bg API when REMOVEBG_API_KEY is set.
     */
    public function backgroundRemover(Request $request)
    {
        $request->validate(['image' => 'required|file|image|max:10240']);
        $apiKey = config('services.removebg.api_key') ?? env('REMOVEBG_API_KEY');
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'Background removal is not configured. Add REMOVEBG_API_KEY to your .env file.',
            ], 503);
        }
        $file = $request->file('image');
        try {
            $response = Http::withHeaders(['X-Api-Key' => $apiKey])
                ->timeout(60)
                ->attach('image_file', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post('https://api.remove.bg/v1.0/removebg', ['size' => 'auto']);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Service error: ' . $e->getMessage()], 502);
        }
        if (!$response->successful()) {
            $body = $response->json();
            $msg  = $body['errors'][0]['title'] ?? $response->body();
            return response()->json(['error' => $msg], $response->status());
        }
        $contentType = $response->header('Content-Type') ?: 'image/png';
        return response($response->body(), 200, [
            'Content-Type'        => $contentType,
            'Content-Disposition' => 'attachment; filename="no-bg.png"',
        ]);
    }
}
