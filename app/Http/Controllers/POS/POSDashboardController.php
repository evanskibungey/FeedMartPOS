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

    /**
     * Get product details including price range for POS
     */
    public function getProduct($id)
    {
        try {
            $product = Product::with(['category', 'brand'])
                ->where('status', 'active')
                ->findOrFail($id);

            // Check if min/max selling price columns exist (migration may not have run)
            $hasMinMaxPrice = \Schema::hasColumn('products', 'min_selling_price');
            
            $minPrice = $hasMinMaxPrice && $product->min_selling_price 
                ? $product->min_selling_price 
                : $product->cost_price;
                
            $maxPrice = $hasMinMaxPrice && $product->max_selling_price 
                ? $product->max_selling_price 
                : $product->price;

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'category' => $product->category->name,
                    'brand' => $product->brand->name,
                    'unit' => $product->unit,
                    'quantity_in_stock' => $product->quantity_in_stock,
                    'price' => $product->price,
                    'min_selling_price' => $minPrice,
                    'max_selling_price' => $maxPrice,
                    'default_selling_price' => $maxPrice,
                    'tax_rate' => $product->tax_rate,
                    'image_url' => $product->image_url,
                    'price_range' => [
                        'min' => number_format($minPrice, 2),
                        'max' => number_format($maxPrice, 2),
                        'currency' => 'KES',
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching product for POS: ' . $e->getMessage(), [
                'product_id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch product details: ' . $e->getMessage()
            ], 500);
        }
    }
}
