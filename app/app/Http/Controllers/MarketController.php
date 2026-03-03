<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index()
    {
        // Placeholder market data - in production, fetch from API
        $marketData = [
            'nifty' => [
                'value' => 24500.50,
                'change' => 125.30,
                'change_percent' => 0.51
            ],
            'sensex' => [
                'value' => 80500.75,
                'change' => 350.20,
                'change_percent' => 0.44
            ],
            'top_gainers' => [],
            'top_losers' => []
        ];

        return view('market.index', compact('marketData'));
    }
}
