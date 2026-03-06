<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use App\Models\ToolHistory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $savedCount = 0;
        $toolsUsedCount = 0;
        $totalToolUsages = 0;
        $savedTools = collect();
        $savedProjects = collect();
        $recentActivity = collect();

        try {
            $savedCount = SavedItem::where('user_id', $user->id)->count();
            $toolsUsedCount = (int) ToolHistory::where('user_id', $user->id)->whereNotNull('tool_slug')->distinct()->count('tool_slug');
            $totalToolUsages = ToolHistory::where('user_id', $user->id)->count();
            $savedTools = SavedItem::where('user_id', $user->id)->where('item_type', 'tool')->latest()->take(6)->get();
            $savedProjects = SavedItem::where('user_id', $user->id)->where('item_type', 'project')->latest()->take(4)->get();
            $recentActivity = ToolHistory::where('user_id', $user->id)->latest()->take(10)->get();
        } catch (\Throwable $e) {
            // Tables may not exist yet
        }

        return view('dashboard', [
            'savedCount' => $savedCount,
            'toolsUsedCount' => $toolsUsedCount,
            'totalToolUsages' => $totalToolUsages,
            'savedTools' => $savedTools,
            'savedProjects' => $savedProjects,
            'recentActivity' => $recentActivity,
        ]);
    }

    public function usages(Request $request): View
    {
        $user = $request->user();
        try {
            $usages = ToolHistory::where('user_id', $user->id)->latest()->paginate(20);
        } catch (\Throwable $e) {
            $usages = new LengthAwarePaginator([], 0, 20);
        }
        return view('dashboard.usages', compact('usages'));
    }

    public function analytics(Request $request): View
    {
        $user = $request->user();
        $byTool = collect();
        $total = 0;
        try {
            $byTool = ToolHistory::where('user_id', $user->id)
                ->whereNotNull('tool_slug')
                ->selectRaw('tool_slug, count(*) as count')
                ->groupBy('tool_slug')
                ->orderByDesc('count')
                ->get();
            $total = ToolHistory::where('user_id', $user->id)->count();
        } catch (\Throwable $e) {
        }
        return view('dashboard.analytics', compact('byTool', 'total'));
    }
}
