<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class ServicePageController extends Controller
{
    public function __invoke(string $service)
    {
        $services = config('seo.services', []);
        if (!isset($services[$service])) {
            abort(404);
        }

        $data = $services[$service];
        $related = array_diff_key($services, [$service => true]);
        $breadcrumbs = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Services', 'url' => url('/services')],
            ['name' => $data['name'], 'url' => url('/services/' . $service)],
        ];

        return view('seo.service', [
            'slug' => $service,
            'service' => $data,
            'related' => $related,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => $data['name'],
            'pageDesc' => $data['summary'],
            'pageKeywords' => implode(', ', [$data['name'], 'online pdf tools', 'Nexora services']),
        ]);
    }
}
