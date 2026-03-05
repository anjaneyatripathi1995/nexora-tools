<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tool;

class HomeController extends Controller
{
    /**
     * Homepage: Hero, Search Tools, Popular Tools, Categories, Latest Tools, About Nexora, Footer.
     */
    public function index()
    {
        $categories = collect();
        $popularTools = collect();
        $latestTools = collect();
        try {
            $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
            $popularTools = Tool::where('is_active', 1)->orderBy('name')->limit(12)->get();
            $latestTools = Tool::where('is_active', 1)->orderByDesc('created_at')->limit(8)->get();
        } catch (\Throwable $e) {
            // Tables may not exist yet; homepage still renders
        }

        return view('home', [
            'categories' => $categories,
            'popularTools' => $popularTools,
            'latestTools' => $latestTools,
        ]);
    }
}
