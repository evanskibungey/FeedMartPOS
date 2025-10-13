<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display customer dashboard
     */
    public function index()
    {
        $user = auth()->user();

        // Get customer's order statistics
        $stats = [
            'total_orders' => $user->orders()->count(),
            'pending_orders' => $user->orders()->pending()->count(),
            'processing_orders' => $user->orders()->processing()->count(),
            'completed_orders' => $user->orders()->completed()->count(),
            'total_spent' => $user->orders()->completed()->sum('total_amount'),
        ];

        // Get recent orders
        $recentOrders = $user->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get cart count
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('dashboard', compact('user', 'stats', 'recentOrders', 'cartCount'));
    }
}
