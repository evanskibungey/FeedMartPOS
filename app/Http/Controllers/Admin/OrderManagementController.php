<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderManagementController extends Controller
{
    /**
     * Display all orders (customer orders + POS sales)
     */
    public function index(Request $request)
    {
        // Build query for customer orders
        $ordersQuery = Order::with(['user', 'orderItems'])
            ->orderBy('created_at', 'desc');

        // Build query for POS sales
        $salesQuery = Sale::with(['user', 'saleItems'])
            ->orderBy('sale_date', 'desc');

        // Apply filters if provided
        if ($request->filled('status')) {
            if ($request->status === 'walk_in') {
                // Only show POS sales
                $orders = collect();
            } else {
                // Filter customer orders by status
                $ordersQuery->where('status', $request->status);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $ordersQuery->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });

            $salesQuery->where(function($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_date')) {
            $ordersQuery->whereDate('created_at', '>=', $request->from_date);
            $salesQuery->whereDate('sale_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $ordersQuery->whereDate('created_at', '<=', $request->to_date);
            $salesQuery->whereDate('sale_date', '<=', $request->to_date);
        }

        // Get results
        $orders = (!$request->filled('status') || $request->status !== 'walk_in') 
            ? $ordersQuery->paginate(20) 
            : collect()->paginate(20);
        
        $sales = (!$request->filled('status') || $request->status === 'walk_in')
            ? $salesQuery->paginate(20)
            : collect()->paginate(20);

        // Calculate statistics
        $stats = $this->calculateStats();

        return view('admin.orders.index', compact('orders', 'sales', 'stats'));
    }

    /**
     * Show single customer order details
     */
    public function showOrder($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show-order', compact('order'));
    }

    /**
     * Show single POS sale details
     */
    public function showSale($id)
    {
        $sale = Sale::with(['user', 'saleItems.product'])->findOrFail($id);
        return view('admin.orders.show-sale', compact('sale'));
    }

    /**
     * Update order status (customer orders only)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);

        // Prevent status changes for cancelled orders
        if ($order->status === 'cancelled' && $request->status !== 'cancelled') {
            return back()->with('error', 'Cannot change status of a cancelled order');
        }

        DB::beginTransaction();

        try {
            $oldStatus = $order->status;
            $order->status = $request->status;

            // Set timestamp for completed/cancelled orders
            if ($request->status === 'completed') {
                $order->completed_at = now();
            } elseif ($request->status === 'cancelled') {
                $order->cancelled_at = now();
                
                // Restore stock for cancelled orders
                foreach ($order->orderItems as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->increment('quantity_in_stock', $item->quantity);
                    }
                }
            }

            $order->save();

            DB::commit();

            return back()->with('success', "Order status updated from {$oldStatus} to {$request->status}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }

    /**
     * Calculate order statistics
     */
    private function calculateStats()
    {
        // Customer Orders Stats
        $customerOrders = Order::all();
        $customerOrdersTotal = $customerOrders->sum('total_amount');
        $customerOrdersPending = Order::where('status', 'pending')->count();
        $customerOrdersProcessing = Order::where('status', 'processing')->count();
        $customerOrdersCompleted = Order::where('status', 'completed')->count();

        // POS Sales Stats
        $posSales = Sale::where('status', 'completed')->get();
        $posSalesTotal = $posSales->sum('total_amount');
        $posSalesCount = $posSales->count();

        // Combined Stats
        $totalRevenue = $customerOrdersTotal + $posSalesTotal;
        $totalOrders = $customerOrders->count() + $posSalesCount;

        // Today's Stats
        $todayCustomerOrders = Order::whereDate('created_at', today())->sum('total_amount');
        $todayPosSales = Sale::whereDate('sale_date', today())->sum('total_amount');
        $todayRevenue = $todayCustomerOrders + $todayPosSales;

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'customer_orders_count' => $customerOrders->count(),
            'customer_orders_total' => $customerOrdersTotal,
            'customer_orders_pending' => $customerOrdersPending,
            'customer_orders_processing' => $customerOrdersProcessing,
            'customer_orders_completed' => $customerOrdersCompleted,
            'pos_sales_count' => $posSalesCount,
            'pos_sales_total' => $posSalesTotal,
            'today_revenue' => $todayRevenue,
        ];
    }

    /**
     * Print order receipt
     */
    public function printOrder($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.print-order', compact('order'));
    }

    /**
     * Print sale receipt
     */
    public function printSale($id)
    {
        $sale = Sale::with(['user', 'saleItems.product'])->findOrFail($id);
        return view('admin.orders.print-sale', compact('sale'));
    }
}
