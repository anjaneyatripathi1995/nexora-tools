<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Http\Controllers\ToolController;

class ToolSeeder extends Seeder
{
    /** First 10 SaaS tools (app/Tools modules) — always seeded. */
    protected array $nexoraTen = [
        ['name' => 'Temp Mail', 'slug' => 'temp-mail', 'category' => 'Developer Tools', 'description' => 'Disposable temporary email address.', 'icon' => 'fa-envelope'],
        ['name' => 'JSON Formatter', 'slug' => 'json-formatter', 'category' => 'Developer Tools', 'description' => 'Format, validate, and beautify JSON.', 'icon' => 'fa-braces'],
        ['name' => 'Base64 Encoder', 'slug' => 'base64-encoder', 'category' => 'Developer Tools', 'description' => 'Encode and decode Base64.', 'icon' => 'fa-terminal'],
        ['name' => 'Password Generator', 'slug' => 'password-generator', 'category' => 'Developer Tools', 'description' => 'Generate strong random passwords.', 'icon' => 'fa-key'],
        ['name' => 'Word Counter', 'slug' => 'word-counter', 'category' => 'SEO Tools', 'description' => 'Count words, characters, sentences.', 'icon' => 'fa-calculator'],
        ['name' => 'Image Compressor', 'slug' => 'image-compressor', 'category' => 'Image Tools', 'description' => 'Compress images to reduce file size.', 'icon' => 'fa-image'],
        ['name' => 'PDF Merger', 'slug' => 'pdf-merger', 'category' => 'PDF Tools', 'description' => 'Merge multiple PDFs into one.', 'icon' => 'fa-file-pdf'],
        ['name' => 'URL Encoder', 'slug' => 'url-encoder', 'category' => 'Developer Tools', 'description' => 'Encode and decode URL strings.', 'icon' => 'fa-link'],
        ['name' => 'UUID Generator', 'slug' => 'uuid-generator', 'category' => 'Developer Tools', 'description' => 'Generate UUID v4 identifiers.', 'icon' => 'fa-fingerprint'],
        ['name' => 'Markdown Preview', 'slug' => 'markdown-preview', 'category' => 'Developer Tools', 'description' => 'Preview Markdown as HTML.', 'icon' => 'fa-markdown'],
    ];

    public function run(): void
    {
        foreach ($this->nexoraTen as $t) {
            Tool::updateOrCreate(
                ['slug' => $t['slug']],
                [
                    'name' => $t['name'],
                    'category' => $t['category'],
                    'description' => $t['description'],
                    'icon' => $t['icon'],
                    'is_active' => 1,
                ]
            );
        }

        $implemented = ToolController::implementedSlugs();
        $catalog = ToolController::fullCatalog();

        foreach ($catalog as $category => $tools) {
            foreach ($tools as $t) {
                $slug = $t['slug'] ?? null;
                if (!$slug || !in_array($slug, $implemented, true)) {
                    continue;
                }
                Tool::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $t['name'],
                        'category' => $category,
                        'description' => $t['description'] ?? '',
                        'icon' => $t['icon'] ?? 'fa-wrench',
                        'is_active' => 1,
                    ]
                );
            }
        }
    }
}
