<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with featured products
     */
    public function index()
    {
        // Get featured/latest products
        $featuredProducts = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0)
            ->latest()
            ->limit(8)
            ->get();

        // Get active categories with product counts
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->limit(4)
            ->get();

        // Get cart count
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('welcome', compact('featuredProducts', 'categories', 'cartCount'));
    }
}
