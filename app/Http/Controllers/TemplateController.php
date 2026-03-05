<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = [
            [
                'slug' => 'business',
                'name' => 'Business Landing Pages',
                'category' => 'Landing Pages',
                'preview_color' => 'primary',
                'description' => 'Professional landing page templates for businesses. Modern UI with preview + download.',
                'image' => asset('images/placeholder-640x360.svg')
            ],
            [
                'slug' => 'admin',
                'name' => 'Admin Dashboards',
                'category' => 'Dashboards',
                'preview_color' => 'success',
                'description' => 'Complete admin panel templates. Multiple layouts, dark mode, charts.',
                'image' => asset('images/placeholder-640x360.svg')
            ],
            [
                'slug' => 'bootstrap',
                'name' => 'Bootstrap UI Kits',
                'category' => 'UI Kits',
                'preview_color' => 'info',
                'description' => 'Ready-to-use Bootstrap components. Customizable and well documented.',
                'image' => asset('images/placeholder-640x360.svg')
            ],
            [
                'slug' => 'responsive',
                'name' => 'Responsive Web Pages',
                'category' => 'Web Pages',
                'preview_color' => 'warning',
                'description' => 'Fully responsive web page templates. Mobile-first design.',
                'image' => asset('images/placeholder-640x360.svg')
            ],
        ];

        return view('templates.index', compact('templates'));
    }

    public function show($slug)
    {
        $template = $this->getTemplateBySlug($slug);
        
        if (!$template) {
            abort(404);
        }

        return view('templates.show', compact('template'));
    }

    private function getTemplateBySlug($slug)
    {
        $templates = [
            'business' => [
                'name' => 'Business Landing Pages',
                'category' => 'Landing Pages',
                'preview_color' => 'primary',
                'description' => 'Professional landing page templates for businesses',
                'features' => ['Responsive Design', 'Modern UI', 'SEO Optimized', 'Fast Loading'],
                'preview_url' => '#',
                'download_url' => '#',
                'image_large' => asset('images/placeholder-1200x700.svg'),
                'image_1' => asset('images/placeholder-320x180.svg'),
                'image_2' => asset('images/placeholder-320x180.svg'),
                'image_3' => asset('images/placeholder-320x180.svg')
            ],
            'admin' => [
                'name' => 'Admin Dashboards',
                'category' => 'Dashboards',
                'preview_color' => 'success',
                'description' => 'Complete admin panel templates',
                'features' => ['Multiple Layouts', 'Dark Mode', 'Charts & Graphs', 'Data Tables'],
                'preview_url' => '#',
                'download_url' => '#',
                'image_large' => asset('images/placeholder-1200x700.svg'),
                'image_1' => asset('images/placeholder-320x180.svg'),
                'image_2' => asset('images/placeholder-320x180.svg'),
                'image_3' => asset('images/placeholder-320x180.svg')
            ],
            'bootstrap' => [
                'name' => 'Bootstrap UI Kits',
                'category' => 'UI Kits',
                'preview_color' => 'info',
                'description' => 'Ready-to-use Bootstrap components',
                'features' => ['Bootstrap 5', 'Customizable', 'Well Documented', 'Multiple Components'],
                'preview_url' => '#',
                'download_url' => '#',
                'image_large' => asset('images/placeholder-1200x700.svg'),
                'image_1' => asset('images/placeholder-320x180.svg'),
                'image_2' => asset('images/placeholder-320x180.svg'),
                'image_3' => asset('images/placeholder-320x180.svg')
            ],
            'responsive' => [
                'name' => 'Responsive Web Pages',
                'category' => 'Web Pages',
                'preview_color' => 'warning',
                'description' => 'Fully responsive web page templates',
                'features' => ['Mobile-First', 'Cross-Browser', 'Fast Load', 'Clean Code'],
                'preview_url' => '#',
                'download_url' => '#',
                'image_large' => asset('images/placeholder-1200x700.svg'),
                'image_1' => asset('images/placeholder-320x180.svg'),
                'image_2' => asset('images/placeholder-320x180.svg'),
                'image_3' => asset('images/placeholder-320x180.svg')
            ],
        ];

        return $templates[$slug] ?? null;
    }
}
