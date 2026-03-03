<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\ToolHistory;
use Illuminate\Http\Request;

class EmiController extends Controller
{
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric|min:1',
            'rate' => 'required|numeric|min:0',
            'months' => 'required|integer|min:1',
        ]);

        $r = $data['rate'] / 12 / 100;
        $emi = ($data['amount'] * $r * pow(1+$r, $data['months']))
              / (pow(1+$r, $data['months']) - 1);

        // Save history
        $tool = Tool::where('slug', 'emi-calculator')->first();
        if ($tool && auth()->id()) {
            ToolHistory::create([
                'user_id' => auth()->id(),
                'tool_id' => $tool->id,
                'tool_slug' => $tool->slug,
                'metadata' => $data,
            ]);
        }

        return response()->json([
            'emi' => round($emi, 2),
            'total' => round($emi * $data['months'], 2),
        ]);
    }
}