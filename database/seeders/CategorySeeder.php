<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Developer Tools', 'slug' => 'developer-tools', 'description' => 'JSON, Base64, URL, UUID, Markdown and more.', 'icon' => 'fa-code', 'sort_order' => 1],
            ['name' => 'SEO Tools', 'slug' => 'seo-tools', 'description' => 'SEO analysis and helpers.', 'icon' => 'fa-search', 'sort_order' => 2],
            ['name' => 'PDF Tools', 'slug' => 'pdf-tools', 'description' => 'Merge, split, compress PDFs.', 'icon' => 'fa-file-pdf', 'sort_order' => 3],
            ['name' => 'Image Tools', 'slug' => 'image-tools', 'description' => 'Compress, resize, convert images.', 'icon' => 'fa-image', 'sort_order' => 4],
            ['name' => 'Finance Tools', 'slug' => 'finance-tools', 'description' => 'EMI, SIP, GST calculators.', 'icon' => 'fa-calculator', 'sort_order' => 5],
            ['name' => 'AI Tools', 'slug' => 'ai-tools', 'description' => 'AI-powered utilities.', 'icon' => 'fa-robot', 'sort_order' => 6],
        ];

        foreach ($categories as $i => $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                array_merge($cat, ['sort_order' => $i + 1, 'is_active' => true])
            );
        }
    }
}
