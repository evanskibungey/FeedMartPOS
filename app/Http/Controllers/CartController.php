<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        $total = 0;
        $subtotal = 0;
        $tax = 0;

        foreach ($cart as $item) {
            $subtotal += $item['subtotal'];
            $tax += $item['tax_amount'];
            $total += $item['total'];
        }

        return view('cart.index', compact('cart', 'cartCount', 'subtotal', 'tax', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->quantity_in_stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock for ' . $product->name);
        }

        $cart = session()->get('cart', []);

        // Calculate prices
        $quantity = $request->quantity;
        $unitPrice = $product->price;
        $taxRate = $product->tax_rate ?? 0;
        $subtotal = $unitPrice * $quantity;
        $taxAmount = $subtotal * ($taxRate / 100);
        $total = $subtotal + $taxAmount;

        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;

            if ($product->quantity_in_stock < $newQuantity) {
                return back()->with('error', 'Cannot add more. Insufficient stock for ' . $product->name);
            }

            $cart[$product->id]['quantity'] = $newQuantity;
            $cart[$product->id]['subtotal'] = $unitPrice * $newQuantity;
            $cart[$product->id]['tax_amount'] = $cart[$product->id]['subtotal'] * ($taxRate / 100);
            $cart[$product->id]['total'] = $cart[$product->id]['subtotal'] + $cart[$product->id]['tax_amount'];
        } else {
            // Add new product to cart
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'unit_price' => $unitPrice,
                'quantity' => $quantity,
                'tax_rate' => $taxRate,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'image' => $product->image_url,
                'max_stock' => $product->quantity_in_stock,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', $product->name . ' added to cart!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return back()->with('error', 'Product not found in cart');
        }

        if ($product->quantity_in_stock < $request->quantity) {
            return back()->with('error', 'Insufficient stock. Only ' . $product->quantity_in_stock . ' available.');
        }

        $quantity = $request->quantity;
        $unitPrice = $cart[$product->id]['unit_price'];
        $taxRate = $cart[$product->id]['tax_rate'];
        $subtotal = $unitPrice * $quantity;
        $taxAmount = $subtotal * ($taxRate / 100);
        $total = $subtotal + $taxAmount;

        $cart[$product->id]['quantity'] = $quantity;
        $cart[$product->id]['subtotal'] = $subtotal;
        $cart[$product->id]['tax_amount'] = $taxAmount;
        $cart[$product->id]['total'] = $total;

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove product from cart
     */
    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Product removed from cart');
        }

        return back()->with('error', 'Product not found in cart');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count (AJAX)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }
}
