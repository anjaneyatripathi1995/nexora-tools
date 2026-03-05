<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /** Spec categories: DevTools, SeoTools, PdfTools, ImageTools, UtilityTools, AiTools */
    public function run(): void
    {
        $categories = [
            ['name' => 'Dev Tools', 'slug' => 'dev-tools', 'description' => 'JSON formatter, Base64, URL encoder, Password generator, Temp mail, and more.', 'icon' => 'fa-code', 'sort_order' => 1],
            ['name' => 'SEO Tools', 'slug' => 'seo-tools', 'description' => 'Word counter, SEO analysis and content helpers.', 'icon' => 'fa-search', 'sort_order' => 2],
            ['name' => 'PDF Tools', 'slug' => 'pdf-tools', 'description' => 'Merge, split, compress PDFs.', 'icon' => 'fa-file-pdf', 'sort_order' => 3],
            ['name' => 'Image Tools', 'slug' => 'image-tools', 'description' => 'Compress, resize, convert images.', 'icon' => 'fa-image', 'sort_order' => 4],
            ['name' => 'Utility Tools', 'slug' => 'utility-tools', 'description' => 'Calculators, converters, and everyday utilities.', 'icon' => 'fa-wrench', 'sort_order' => 5],
            ['name' => 'AI Tools', 'slug' => 'ai-tools', 'description' => 'AI-powered utilities and generators.', 'icon' => 'fa-robot', 'sort_order' => 6],
        ];

        foreach ($categories as $i => $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }
}
