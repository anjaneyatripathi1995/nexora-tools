<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ToolCatalog;

class HomeController extends Controller
{
    public function __invoke(ToolCatalog $catalog)
    {
        $tools = $catalog->tools();

        return view('pages.home', [
            'tools' => $tools,
            'popular' => $catalog->popularTools(8),
            'categories' => $catalog->categories(),
            'toolsByCat' => array_reduce(array_keys($catalog->categories()), function ($acc, $cat) use ($catalog) {
                $acc[$cat] = $catalog->toolsByCategory($cat);
                return $acc;
            }, []),
        ]);
    }
}

