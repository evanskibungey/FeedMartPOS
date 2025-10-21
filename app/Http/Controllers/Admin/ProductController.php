<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::select(
            'id', 'name', 'sku', 'category_id', 'brand_id', 
            'price', 'quantity_in_stock', 'reorder_level', 
            'status', 'image'
        )->with([
            'category:id,name', 
            'brand:id,name'
        ]);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->lowStock();
                    break;
                case 'out':
                    $query->outOfStock();
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15);
        
        // Cache dropdown data for 30 minutes
        $categories = cache()->remember('active_categories', 1800, function() {
            return Category::select('id', 'name')->active()->get();
        });
        
        $brands = cache()->remember('active_brands', 1800, function() {
            return Brand::select('id', 'name')->active()->get();
        });

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $suppliers = Supplier::active()->get();

        return view('admin.products.create', compact('categories', 'brands', 'suppliers'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'description' => ['nullable', 'string'],
            'unit' => ['required', 'string', 'max:255'],
            'quantity_in_stock' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'min_selling_price' => ['required', 'numeric', 'min:0', 'lte:max_selling_price'],
            'max_selling_price' => ['required', 'numeric', 'min:0', 'gte:min_selling_price'],
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:products'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'suppliers', 'stockMovements' => function ($query) {
            $query->latest()->limit(20);
        }]);

        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing a product
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        $suppliers = Supplier::active()->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands', 'suppliers'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'description' => ['nullable', 'string'],
            'unit' => ['required', 'string', 'max:255'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'min_selling_price' => ['required', 'numeric', 'min:0', 'lte:max_selling_price'],
            'max_selling_price' => ['required', 'numeric', 'min:0', 'gte:min_selling_price'],
            'wholesale_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'barcode' => ['nullable', 'string', 'max:255', 'unique:products,barcode,' . $product->id],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product)
    {
        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active',
        ]);

        $status = $product->status === 'active' ? 'activated' : 'deactivated';
        
        return back()->with('success', "Product {$status} successfully!");
    }
}
