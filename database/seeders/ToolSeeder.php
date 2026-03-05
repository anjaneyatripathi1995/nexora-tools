<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Http\Controllers\ToolController;

class ToolSeeder extends Seeder
{
    public function run(): void
    {
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
