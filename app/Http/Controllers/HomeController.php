<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        return view('home');
    }
}
