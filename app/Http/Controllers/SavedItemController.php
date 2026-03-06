<?php

namespace App\Http\Controllers;

use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SavedItemController extends Controller
{
    public function toggle(Request $request): JsonResponse
    {
        $request->validate([
            'item_type' => 'required|string|in:tool,project,template',
            'item_slug' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $item = SavedItem::where('user_id', $user->id)
            ->where('item_type', $request->item_type)
            ->where('item_slug', $request->item_slug)
            ->first();

        if ($item) {
            $item->delete();
            return response()->json(['saved' => false, 'message' => 'Removed from saved items.']);
        }

        SavedItem::create([
            'user_id' => $user->id,
            'item_type' => $request->item_type,
            'item_slug' => $request->item_slug,
        ]);

        return response()->json(['saved' => true, 'message' => 'Saved.']);
    }
}
