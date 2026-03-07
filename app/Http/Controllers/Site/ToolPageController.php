<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SavedItem;
use App\Models\ToolHistory;
use App\Services\ToolCatalog;
use Illuminate\View\View;

class ToolPageController extends Controller
{
    /** Slugs that have a working partial (tools/partials/{slug}.blade.php or mapped name). */
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
            'uuid-generator',
            'password-generator',
            'markdown-editor',
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

    public function show(string $slug, ToolCatalog $catalog): View
    {
        $tool = $catalog->findTool($slug);
        if (!$tool) {
            abort(404);
        }

        $categories = config('nexora.categories', []);
        $catSlug = $tool['cat'] ?? null;
        $currentCategory = $catSlug && isset($categories[$catSlug]) ? $categories[$catSlug]['name'] : null;
        $allTools = $catalog->tools();
        $relatedTools = array_values(array_filter($allTools, fn ($t) => ($t['cat'] ?? null) === $catSlug && ($t['slug'] ?? '') !== $slug));

        $hasPartial = in_array($slug, self::implementedSlugs(), true);
        $partialName = $hasPartial ? self::partialForSlug($slug) : null;
        $partialExists = $partialName && view()->exists('tools.partials.' . $partialName);

        // Track history for authenticated users (same as reference)
        if (auth()->check()) {
            try {
                ToolHistory::create([
                    'user_id' => auth()->id(),
                    'tool_id' => null,
                    'tool_slug' => $slug,
                ]);
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $isSaved = false;
        try {
            $isSaved = auth()->check() && SavedItem::where('user_id', auth()->id())
                ->where('item_type', 'tool')
                ->where('item_slug', $slug)
                ->exists();
        } catch (\Throwable $e) {
            // ignore
        }

        if ($partialExists) {
            $pageDesc = $tool['desc'] ?? 'Try this free online tool on Nexora Tools.';
            $pageKeywords = implode(', ', array_filter([
                $tool['name'] ?? null,
                $currentCategory,
                'online tool',
                'free tool',
                'Nexora Tools',
            ]));
            return view('tools.show', [
                'tool' => $tool,
                'tool_partial' => $partialName,
                'currentCategory' => $currentCategory,
                'relatedTools' => $relatedTools,
                'isSaved' => $isSaved,
                'pageTitle' => ($tool['name'] ?? 'Tool') . ' - Free Online Tool',
                'pageDesc' => $pageDesc,
                'pageKeywords' => $pageKeywords,
                'canonical' => route('tools.show', ['slug' => $slug]),
            ]);
        }

        return view('tools.show-coming-soon', [
            'name' => $tool['name'] ?? 'Tool',
            'description' => $tool['desc'] ?? 'Coming soon.',
            'icon' => $tool['icon'] ?? '🛠',
            'color' => $categories[$catSlug]['color'] ?? '#2563EB',
        ]);
    }

    /** Legacy root tool URLs (e.g. /json-formatter) redirect to /tools/{slug}. */
    public function legacyRoot(string $slug)
    {
        return redirect()->route('tools.show', ['slug' => $slug]);
    }
}
