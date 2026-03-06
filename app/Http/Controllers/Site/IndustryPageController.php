<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class IndustryPageController extends Controller
{
    public function __invoke(string $industry)
    {
        $industries = config('seo.industries', []);
        if (!isset($industries[$industry])) {
            abort(404);
        }

        $data = $industries[$industry];
        $related = array_diff_key($industries, [$industry => true]);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Industry', 'url' => url('/industry')],
            ['name' => $data['name'], 'url' => url('/industry/' . $industry)],
        ];

        return view('seo.industry', [
            'slug' => $industry,
            'industry' => $data,
            'related' => $related,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => $data['name'] . ' Solutions',
            'pageDesc' => $data['summary'],
            'pageKeywords' => implode(', ', [$data['name'], 'industry pdf workflows', 'Nexora']),
        ]);
    }
}
