<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class POSDashboardController extends Controller
{
    /**
     * Display POS dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        return view('pos.dashboard', compact('user'));
    }
}
