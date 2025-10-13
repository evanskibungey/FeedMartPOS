<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display customer's orders
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show single order details
     */
    public function show($id)
    {
        $order = auth()->user()->orders()
            ->with(['orderItems.product'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartCount = array_sum(array_column($cart, 'quantity'));
        $subtotal = 0;
        $tax = 0;
        $total = 0;

        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
            $tax += $item['tax_amount'];
            $total += $item['total'];
        }

        return view('orders.checkout', compact('cart', 'cartCount', 'subtotal', 'tax', 'total'));
    }

    /**
     * Process order
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        DB::beginTransaction();

        try {
            // Calculate totals
            $subtotal = 0;
            $tax = 0;

            foreach ($cart as $item) {
                $subtotal += $item['subtotal'];
                $tax += $item['tax_amount'];
            }

            $totalAmount = $subtotal + $tax;

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total_amount' => $totalAmount,
                'delivery_address' => $request->delivery_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            // Create order items and update stock
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock availability
                if ($product->quantity_in_stock < $item['quantity']) {
                    throw new \Exception('Insufficient stock for ' . $product->name);
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'tax_rate' => $item['tax_rate'],
                    'tax_amount' => $item['tax_amount'],
                    'subtotal' => $item['subtotal'],
                    'total' => $item['total'],
                ]);

                // Update product stock
                $product->decrement('quantity_in_stock', $item['quantity']);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully! Order number: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    /**
     * Cancel order
     */
    public function cancel($id)
    {
        $order = auth()->user()->orders()->findOrFail($id);

        if (!$order->isPending()) {
            return back()->with('error', 'Only pending orders can be cancelled');
        }

        DB::beginTransaction();

        try {
            // Restore product stock
            foreach ($order->orderItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity_in_stock', $item->quantity);
                }
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Order cancelled successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }
}
