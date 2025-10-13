<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display all products in the shop
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('quantity_in_stock', '>', 0);

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'name');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();
        $brands = Brand::where('is_active', true)->orderBy('name')->get();

        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('shop.index', compact('products', 'categories', 'brands', 'cartCount'));
    }

    /**
     * Display a single product
     */
    public function show($id)
    {
        $product = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->findOrFail($id);

        $relatedProducts = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('quantity_in_stock', '>', 0)
            ->limit(4)
            ->get();

        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('shop.show', compact('product', 'relatedProducts', 'cartCount'));
    }
}
