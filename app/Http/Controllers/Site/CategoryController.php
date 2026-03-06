<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ToolCatalog;

class CategoryController extends Controller
{
    public function show(string $category, ToolCatalog $catalog)
    {
        $cats = $catalog->categories();
        $catInfo = $cats[$category] ?? null;

        if (!$catInfo) {
            abort(404);
        }

        return view('pages.category', [
            'categorySlug' => $category,
            'category' => $catInfo,
            'tools' => $catalog->toolsByCategory($category),
        ]);
    }
}

