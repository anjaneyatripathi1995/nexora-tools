<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\User;
use App\Models\ToolHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $stats = [
            'tools_count' => Tool::count(),
            'users_count' => User::count(),
            'usages_count' => ToolHistory::count(),
        ];
        $sections = [];
        if ($user->canManage('tools')) {
            $sections[] = ['name' => 'Tools', 'route' => 'admin.tools.index', 'icon' => 'fa-wrench'];
        }
        if ($user->canManage('projects')) {
            $sections[] = ['name' => 'Projects', 'route' => 'admin.projects.index', 'icon' => 'fa-folder'];
        }
        if ($user->canManage('apps')) {
            $sections[] = ['name' => 'Apps', 'route' => 'admin.apps.index', 'icon' => 'fa-mobile-screen'];
        }
        if ($user->canManage('templates')) {
            $sections[] = ['name' => 'Templates', 'route' => 'admin.templates.index', 'icon' => 'fa-file-code'];
        }

        return view('admin.dashboard', compact('stats', 'sections'));
    }
}
