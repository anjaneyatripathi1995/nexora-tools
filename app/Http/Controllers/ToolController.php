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

    /** Full catalog of all tools (for listing). Keys: category => [ tools ] */
    public static function fullCatalog(): array
    {
        return [
            'Finance & Date' => [
                ['name' => 'EMI Calculator',           'slug' => 'emi-calculator',          'icon' => 'fa-calculator',       'color' => 'primary', 'description' => 'Calculate loan EMI instantly'],
                ['name' => 'SIP Calculator',           'slug' => 'sip-calculator',          'icon' => 'fa-chart-line',       'color' => 'primary', 'description' => 'Systematic Investment Plan returns'],
                ['name' => 'FD/RD Calculator',         'slug' => 'fd-rd-calculator',        'icon' => 'fa-piggy-bank',       'color' => 'info',    'description' => 'Fixed & Recurring Deposit maturity'],
                ['name' => 'GST Calculator',           'slug' => 'gst-calculator',          'icon' => 'fa-percent',          'color' => 'warning', 'description' => 'Calculate GST and reverse GST'],
                ['name' => 'Age Calculator',           'slug' => 'age-calculator',          'icon' => 'fa-birthday-cake',    'color' => 'primary', 'description' => 'Calculate exact age from date of birth'],
                ['name' => 'Month-to-Date Converter',  'slug' => 'month-to-date-converter', 'icon' => 'fa-calendar-days',   'color' => 'success', 'description' => 'Convert month/date formats'],
            ],
            'PDF & File' => [
                ['name' => 'PDF to Word',        'slug' => 'pdf-to-word',     'icon' => 'fa-file-word',    'color' => 'primary',   'description' => 'Convert PDF to editable Word documents'],
                ['name' => 'PDF to Excel',       'slug' => 'pdf-to-excel',    'icon' => 'fa-file-excel',   'color' => 'success',   'description' => 'Extract tables to Excel'],
                ['name' => 'PDF to Image',       'slug' => 'pdf-to-image',    'icon' => 'fa-file-image',   'color' => 'info',      'description' => 'Convert PDF pages to images'],
                ['name' => 'Merge PDF',          'slug' => 'pdf-merger',      'icon' => 'fa-object-group', 'color' => 'danger',    'description' => 'Combine multiple PDFs into one'],
                ['name' => 'Split PDF',          'slug' => 'split-pdf',       'icon' => 'fa-scissors',     'color' => 'warning',   'description' => 'Split PDF by pages'],
                ['name' => 'Compress PDF',       'slug' => 'compress-pdf',    'icon' => 'fa-file-zipper',  'color' => 'primary',   'description' => 'Reduce PDF file size'],
                ['name' => 'Lock / Unlock PDF',  'slug' => 'lock-unlock-pdf', 'icon' => 'fa-lock',         'color' => 'secondary', 'description' => 'Password protect or remove protection'],
                ['name' => 'OCR (Image to Text)','slug' => 'ocr',             'icon' => 'fa-font',         'color' => 'info',      'description' => 'Extract text from images'],
                ['name' => 'ZIP Compressor',     'slug' => 'zip-compressor',  'icon' => 'fa-file-zipper',  'color' => 'success',   'description' => 'Compress files to ZIP'],
                ['name' => 'Image Compressor',   'slug' => 'image-compressor','icon' => 'fa-image',        'color' => 'warning',   'description' => 'Compress images without losing quality'],
            ],
            'Text & Content' => [
                ['name' => 'Word & Character Counter', 'slug' => 'word-counter',          'icon' => 'fa-calculator',        'color' => 'info',    'description' => 'Count words, characters, sentences in text'],
                ['name' => 'Case Converter',           'slug' => 'case-converter',        'icon' => 'fa-font',              'color' => 'primary', 'description' => 'Convert text to UPPER, lower, Title Case'],
                ['name' => 'Paraphraser / Rewriter',   'slug' => 'paraphraser',           'icon' => 'fa-pen-fancy',         'color' => 'primary', 'description' => 'Rewrite text in different words'],
                ['name' => 'Grammar Checker',          'slug' => 'grammar-checker',       'icon' => 'fa-spell-check',       'color' => 'success', 'description' => 'Check and fix grammar'],
                ['name' => 'Plagiarism Checker',       'slug' => 'plagiarism-checker',    'icon' => 'fa-copy',              'color' => 'danger',  'description' => 'Check content originality'],
                ['name' => 'Resume Builder',           'slug' => 'resume-builder',        'icon' => 'fa-id-card',           'color' => 'info',    'description' => 'Create professional resumes'],
                ['name' => 'Essay / Letter Generator', 'slug' => 'essay-letter-generator','icon' => 'fa-envelope-open-text','color' => 'warning', 'description' => 'Generate essays and letters'],
            ],
            'Developer' => [
                ['name' => 'JSON Formatter',       'slug' => 'json-formatter',     'icon' => 'fa-braces',     'color' => 'warning',   'description' => 'Format, validate & beautify JSON'],
                ['name' => 'QR Code Generator',    'slug' => 'qr-code-generator',  'icon' => 'fa-qrcode',     'color' => 'dark',      'description' => 'Generate QR codes'],
                ['name' => 'Regex Tester',         'slug' => 'regex-tester',       'icon' => 'fa-code',       'color' => 'info',      'description' => 'Test regular expressions'],
                ['name' => 'Base64 Encoder',       'slug' => 'base64-encoder',     'icon' => 'fa-terminal',   'color' => 'secondary', 'description' => 'Encode/decode Base64'],
                ['name' => 'URL Encoder',          'slug' => 'url-encoder',        'icon' => 'fa-link',       'color' => 'primary',   'description' => 'Encode/decode URL strings'],
                ['name' => 'HTML/CSS/JS Minifier', 'slug' => 'minifier',           'icon' => 'fa-compress',   'color' => 'success',   'description' => 'Minify front-end code'],
                ['name' => 'Password Generator',   'slug' => 'password-generator', 'icon' => 'fa-key',        'color' => 'info',      'description' => 'Generate strong, secure passwords'],
                ['name' => 'UUID Generator',       'slug' => 'uuid-generator',     'icon' => 'fa-fingerprint','color' => 'secondary', 'description' => 'Generate UUID v4'],
                ['name' => 'Markdown Preview',     'slug' => 'markdown-preview',   'icon' => 'fa-markdown',   'color' => 'success',   'description' => 'Preview Markdown as HTML'],
                ['name' => 'Temp Mail',            'slug' => 'temp-mail',          'icon' => 'fa-envelope',   'color' => 'primary',   'description' => 'Disposable temporary email'],
            ],
            'Image' => [
                ['name' => 'Image Resizer',      'slug' => 'image-resizer',      'icon' => 'fa-expand', 'color' => 'primary', 'description' => 'Resize images to any dimensions'],
                ['name' => 'Background Remover', 'slug' => 'background-remover', 'icon' => 'fa-eraser', 'color' => 'danger',  'description' => 'Remove image background automatically'],
                ['name' => 'OCR Tool',           'slug' => 'image-ocr',          'icon' => 'fa-font',   'color' => 'info',    'description' => 'Extract text from images'],
            ],
        ];
    }

    public function index(Request $request)
    {
        $catalog = self::fullCatalog();
        $dbTools = Tool::where('is_active', 1)->get()->keyBy('slug');

        return view('tools.index', [
            'catalog'        => $catalog,
            'dbTools'        => $dbTools,
            'categoryFilter' => $request->get('category'),
        ]);
    }

    public function show($slug)
    {
        $tool = Tool::where('slug', $slug)->where('is_active', 1)->first();

        if ($tool) {
            if (auth()->check()) {
                ToolHistory::create([
                    'user_id'   => auth()->id(),
                    'tool_id'   => $tool->id,
                    'tool_slug' => $tool->slug,
                ]);
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

            $isSaved = auth()->check() && SavedItem::where('user_id', auth()->id())
                ->where('item_type', 'tool')
                ->where('item_slug', $tool->slug)
                ->exists();

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

        // Tool exists in catalog but not in DB yet → show coming-soon
        foreach (self::fullCatalog() as $category => $tools) {
            foreach ($tools as $t) {
                if (($t['slug'] ?? '') === $slug) {
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
