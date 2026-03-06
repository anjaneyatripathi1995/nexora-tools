<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ToolCatalog;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index(Request $request, ToolCatalog $catalog)
    {
        $q = trim((string) $request->query('q', ''));

        return view('pages.tools', [
            'q' => $q,
            'tools' => $catalog->tools(),
            'categories' => $catalog->categories(),
            'toolsByCat' => array_reduce(array_keys($catalog->categories()), function ($acc, $cat) use ($catalog) {
                $acc[$cat] = $catalog->toolsByCategory($cat);
                return $acc;
            }, []),
        ]);
    }
}

