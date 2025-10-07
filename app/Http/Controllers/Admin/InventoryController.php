<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Display inventory dashboard
     */
    public function index()
    {
        // Calculate key metrics
        $totalProducts = Product::count();
        $lowStockCount = Product::whereRaw('quantity_in_stock <= reorder_level')->where('quantity_in_stock', '>', 0)->count();
        $outOfStockCount = Product::where('quantity_in_stock', '<=', 0)->count();
        $totalInventoryValue = Product::sum(DB::raw('quantity_in_stock * cost_price'));

        // Stock by category with counts
        $stockByCategory = Category::withCount([
            'products',
            'products as in_stock_count' => function ($query) {
                $query->whereRaw('quantity_in_stock > reorder_level');
            },
            'products as low_stock_count' => function ($query) {
                $query->whereRaw('quantity_in_stock <= reorder_level')->where('quantity_in_stock', '>', 0);
            },
            'products as out_of_stock_count' => function ($query) {
                $query->where('quantity_in_stock', '<=', 0);
            }
        ])->withSum('products', DB::raw('quantity_in_stock * cost_price'))->get();

        // Recent stock movements
        $recentMovements = StockMovement::with(['product', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.inventory.index', compact(
            'totalProducts',
            'lowStockCount',
            'outOfStockCount',
            'totalInventoryValue',
            'stockByCategory',
            'recentMovements'
        ));
    }

    /**
     * Display stock movements
     */
    public function movements(Request $request)
    {
        $query = StockMovement::with(['product', 'user']);

        // Search by product or reference
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('product', function ($productQuery) use ($request) {
                    $productQuery->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('sku', 'like', '%' . $request->search . '%');
                })->orWhere('reference', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->latest()->paginate(20);

        return view('admin.inventory.movements', compact('movements'));
    }

    /**
     * Show form to adjust stock
     */
    public function adjustStock()
    {
        $products = Product::with(['category', 'brand'])
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.inventory.adjust', compact('products'));
    }

    /**
     * Process stock adjustment
     */
    public function processAdjustment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'adjustment_type' => ['required', 'in:increase,decrease'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['required', 'string', 'max:500'],
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $oldStock = $product->quantity_in_stock;
        $adjustmentQty = $validated['quantity'];

        // Calculate new stock
        if ($validated['adjustment_type'] === 'increase') {
            $newStock = $oldStock + $adjustmentQty;
            $movementType = 'IN';
        } else {
            $newStock = max(0, $oldStock - $adjustmentQty);
            $movementType = 'OUT';
        }

        // Update product stock
        $product->update(['quantity_in_stock' => $newStock]);

        // Record stock movement
        StockMovement::create([
            'product_id' => $product->id,
            'type' => 'ADJUSTMENT',
            'quantity' => $adjustmentQty,
            'reference' => 'Manual Stock Adjustment',
            'notes' => $validated['reason'] . " | Previous: {$oldStock}, New: {$newStock}, Type: {$movementType}",
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('admin.inventory.index')
            ->with('success', "Stock adjusted successfully! {$product->name} updated from {$oldStock} to {$newStock} {$product->unit}.");
    }

    /**
     * Display low stock report
     */
    public function lowStock()
    {
        $lowStockProducts = Product::with(['category', 'brand', 'suppliers'])
            ->whereRaw('quantity_in_stock <= reorder_level')
            ->orderByRaw('(quantity_in_stock / NULLIF(reorder_level, 0)) ASC')
            ->get();

        return view('admin.inventory.low-stock', compact('lowStockProducts'));
    }

    /**
     * Display reorder report
     */
    public function reorderReport()
    {
        $reorderProducts = Product::with(['category', 'brand', 'suppliers'])
            ->whereRaw('quantity_in_stock <= reorder_level')
            ->orderByRaw('(quantity_in_stock / NULLIF(reorder_level, 0)) ASC')
            ->get();

        // Group products by supplier for easy PO creation
        $reorderBySupplier = [];
        foreach ($reorderProducts as $product) {
            if ($product->suppliers && $product->suppliers->count() > 0) {
                foreach ($product->suppliers as $supplier) {
                    if (!isset($reorderBySupplier[$supplier->id])) {
                        $reorderBySupplier[$supplier->id] = [
                            'supplier' => $supplier,
                            'products' => collect(),
                            'total_cost' => 0
                        ];
                    }
                    $reorderBySupplier[$supplier->id]['products']->push($product);
                    $shortage = max(0, $product->reorder_level - $product->quantity_in_stock);
                    $reorderBySupplier[$supplier->id]['total_cost'] += ($shortage * $product->cost_price);
                }
            }
        }

        $reorderBySupplier = collect($reorderBySupplier)->values();

        return view('admin.inventory.reorder', compact('reorderProducts', 'reorderBySupplier'));
    }
}
