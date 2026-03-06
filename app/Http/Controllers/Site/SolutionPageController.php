<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class SolutionPageController extends Controller
{
    public function __invoke(string $solution)
    {
        $solutions = config('seo.solutions', []);
        if (!isset($solutions[$solution])) {
            abort(404);
        }

        $data = $solutions[$solution];
        $related = array_diff_key($solutions, [$solution => true]);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Solutions', 'url' => url('/solutions')],
            ['name' => $data['name'], 'url' => url('/solutions/' . $solution)],
        ];

        return view('seo.solution', [
            'slug' => $solution,
            'solution' => $data,
            'related' => $related,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => $data['name'],
            'pageDesc' => $data['summary'],
            'pageKeywords' => implode(', ', [$data['name'], 'workflow solutions', 'Nexora']),
        ]);
    }
}
