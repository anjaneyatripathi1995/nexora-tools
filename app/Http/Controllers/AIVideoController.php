<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIVideoController extends Controller
{
    public function index()
    {
        return view('ai-videos.index');
    }

    public function generator()
    {
        return view('ai-videos.generator');
    }

    public function memeGenerator()
    {
        return view('ai-videos.meme-generator');
    }

    public function loveCalculator()
    {
        return view('ai-videos.love-calculator');
    }

    public function captionGenerator()
    {
        return view('ai-videos.caption-generator');
    }
}
