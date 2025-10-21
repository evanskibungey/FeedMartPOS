<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of purchase orders
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::select(
            'id', 'supplier_id', 'order_number', 'order_date', 
            'expected_date', 'status', 'total_amount', 'created_by', 'created_at'
        )->with([
            'supplier:id,name,phone',
            'creator:id,name'
        ])->withCount('items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by supplier
        if ($request->filled('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }

        // Search by order number
        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $purchaseOrders = $query->latest()->paginate(15);
        
        // Cache suppliers dropdown
        $suppliers = cache()->remember('active_suppliers', 1800, function() {
            return Supplier::select('id', 'name')->active()->get();
        });

        return view('admin.purchase-orders.index', compact('purchaseOrders', 'suppliers'));
    }

    /**
     * Display draft purchase orders
     */
    public function drafts()
    {
        $draftOrders = PurchaseOrder::with(['supplier', 'creator', 'items.product'])
            ->withCount('items')
            ->where('status', 'draft')
            ->latest()
            ->paginate(15);

        return view('admin.purchase-orders.drafts', compact('draftOrders'));
    }

    /**
     * Show the form for creating a new purchase order
     */
    public function create()
    {
        $suppliers = Supplier::active()->get();
        $products = Product::active()->with(['category', 'brand'])->get();

        // Generate order number
        $orderNumber = 'PO-' . date('Y') . '-' . str_pad(PurchaseOrder::count() + 1, 4, '0', STR_PAD_LEFT);

        return view('admin.purchase-orders.create', compact('suppliers', 'products', 'orderNumber'));
    }

    /**
     * Store a newly created purchase order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'order_number' => ['required', 'string', 'unique:purchase_orders'],
            'order_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date', 'after_or_equal:order_date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity_ordered' => ['required', 'integer', 'min:1'],
            'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            // Create purchase order
            $purchaseOrder = PurchaseOrder::create([
                'supplier_id' => $validated['supplier_id'],
                'order_number' => $validated['order_number'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'status' => 'draft',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Create purchase order items
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity_ordered'] * $item['purchase_price'];
                $totalAmount += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'purchase_price' => $item['purchase_price'],
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total amount
            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()
                ->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified purchase order
     */
    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'items.product', 'creator']);

        return view('admin.purchase-orders.show', compact('purchaseOrder'));
    }

    /**
     * Show the form for editing a purchase order
     */
    public function edit(PurchaseOrder $purchaseOrder)
    {
        // Only allow editing draft purchase orders
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be edited!');
        }

        $suppliers = Supplier::active()->get();
        $products = Product::active()->with(['category', 'brand'])->get();
        $purchaseOrder->load('items.product');

        return view('admin.purchase-orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }

    /**
     * Update the specified purchase order
     */
    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Only allow updating draft purchase orders
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be updated!');
        }

        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'order_date' => ['required', 'date'],
            'expected_date' => ['nullable', 'date', 'after_or_equal:order_date'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity_ordered' => ['required', 'integer', 'min:1'],
            'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            // Update purchase order
            $purchaseOrder->update([
                'supplier_id' => $validated['supplier_id'],
                'order_date' => $validated['order_date'],
                'expected_date' => $validated['expected_date'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Delete existing items
            $purchaseOrder->items()->delete();

            // Create new items
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity_ordered'] * $item['purchase_price'];
                $totalAmount += $subtotal;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity_ordered' => $item['quantity_ordered'],
                    'purchase_price' => $item['purchase_price'],
                    'subtotal' => $subtotal,
                ]);
            }

            // Update total amount
            $purchaseOrder->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()
                ->route('admin.purchase-orders.show', $purchaseOrder)
                ->with('success', 'Purchase order updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update purchase order: ' . $e->getMessage());
        }
    }

    /**
     * Mark purchase order as ordered
     */
    public function markAsOrdered(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be marked as ordered!');
        }

        $purchaseOrder->update(['status' => 'ordered']);

        return back()->with('success', 'Purchase order marked as ordered!');
    }

    /**
     * Receive purchase order items
     */
    public function receive(Request $request, PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'This purchase order has already been received!');
        }

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.item_id' => ['required', 'exists:purchase_order_items,id'],
            'items.*.quantity_received' => ['required', 'integer', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            foreach ($validated['items'] as $itemData) {
                $item = PurchaseOrderItem::findOrFail($itemData['item_id']);
                $quantityToReceive = $itemData['quantity_received'];

                if ($quantityToReceive > 0) {
                    // Update quantity received
                    $item->increment('quantity_received', $quantityToReceive);

                    // Update product stock
                    $product = $item->product;
                    $product->increment('quantity_in_stock', $quantityToReceive);

                    // Record stock movement
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'in',
                        'quantity' => $quantityToReceive,
                        'reference' => $purchaseOrder->order_number,
                        'notes' => 'Received from PO: ' . $purchaseOrder->order_number,
                        'user_id' => auth()->id(),
                    ]);
                }
            }

            // Check if all items are fully received
            $allReceived = $purchaseOrder->items->every(function ($item) {
                return $item->quantity_received >= $item->quantity_ordered;
            });

            if ($allReceived) {
                $purchaseOrder->markAsReceived();
            }

            DB::commit();

            return back()->with('success', 'Items received successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to receive items: ' . $e->getMessage());
        }
    }

    /**
     * Cancel purchase order
     */
    public function cancel(PurchaseOrder $purchaseOrder)
    {
        if ($purchaseOrder->status === 'received') {
            return back()->with('error', 'Cannot cancel a received purchase order!');
        }

        $purchaseOrder->update(['status' => 'cancelled']);

        return back()->with('success', 'Purchase order cancelled!');
    }

    /**
     * Remove the specified purchase order
     */
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Only allow deleting draft purchase orders
        if ($purchaseOrder->status !== 'draft') {
            return back()->with('error', 'Only draft purchase orders can be deleted!');
        }

        $purchaseOrder->delete();

        return redirect()
            ->route('admin.purchase-orders.index')
            ->with('success', 'Purchase order deleted successfully!');
    }
}
