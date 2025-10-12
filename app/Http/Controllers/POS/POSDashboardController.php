<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use Illuminate\Http\Request;

class POSDashboardController extends Controller
{
    /**
     * Display POS dashboard with products
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get all active categories
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
        
        // Get filter parameters
        $categoryId = $request->get('category');
        $search = $request->get('search');
        
        // Build products query
        $query = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0); // Only show products in stock
        
        // Apply category filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }
        
        // Get products
        $products = $query->orderBy('name')->get();
        
        // Get today's sales stats
        $todaySales = Sale::today()->completed()->get();
        $todayStats = [
            'sales' => $todaySales->sum('total_amount'),
            'transactions' => $todaySales->count(),
            'items_sold' => $todaySales->sum(function ($sale) {
                return $sale->saleItems->sum('quantity');
            }),
        ];
        
        return view('pos.dashboard', compact('user', 'products', 'categories', 'categoryId', 'search', 'todayStats'));
    }
}
