<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Http\Request;

class SavedItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Toggle save state for a tool or project. Expects item_type (tool|project) and item_slug.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:tool,project',
            'item_slug' => 'required|string|max:120',
        ]);

        $user = $request->user();
        $existing = SavedItem::where('user_id', $user->id)
            ->where('item_type', $request->item_type)
            ->where('item_slug', $request->item_slug)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['saved' => false, 'message' => 'Removed from saved items.']);
        }

        SavedItem::create([
            'user_id' => $user->id,
            'item_type' => $request->item_type,
            'item_slug' => $request->item_slug,
        ]);

        return response()->json(['saved' => true, 'message' => 'Saved for later.']);
    }
}
