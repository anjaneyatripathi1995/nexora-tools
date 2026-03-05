<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use App\Models\ToolHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $savedCount = SavedItem::where('user_id', $user->id)->count();
        $toolsUsedCount = ToolHistory::where('user_id', $user->id)->whereNotNull('tool_slug')->distinct('tool_slug')->count('tool_slug');
        $totalToolUsages = ToolHistory::where('user_id', $user->id)->count();
        $savedTools = SavedItem::where('user_id', $user->id)->where('item_type', 'tool')->latest()->take(6)->get();
        $savedProjects = SavedItem::where('user_id', $user->id)->where('item_type', 'project')->latest()->take(4)->get();
        $recentActivity = ToolHistory::where('user_id', $user->id)->with('tool')->latest()->take(10)->get();

        return view('dashboard', [
            'savedCount' => $savedCount,
            'toolsUsedCount' => $toolsUsedCount,
            'totalToolUsages' => $totalToolUsages,
            'savedTools' => $savedTools,
            'savedProjects' => $savedProjects,
            'recentActivity' => $recentActivity,
        ]);
    }

    public function usages(Request $request)
    {
        $user = $request->user();
        $usages = ToolHistory::where('user_id', $user->id)->with('tool')->latest()->paginate(20);
        return view('dashboard.usages', compact('usages'));
    }

    public function analytics(Request $request)
    {
        $user = $request->user();
        $byTool = ToolHistory::where('user_id', $user->id)
            ->whereNotNull('tool_slug')
            ->selectRaw('tool_slug, count(*) as count')
            ->groupBy('tool_slug')
            ->orderByDesc('count')
            ->get();
        $total = ToolHistory::where('user_id', $user->id)->count();
        return view('dashboard.analytics', compact('byTool', 'total'));
    }
}
