<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    /**
     * Process a new sale
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,mpesa,card,bank_transfer',
            'payment_reference' => 'nullable|string|max:255',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ], [
            'items.*.price.min' => 'Price must be greater than or equal to the minimum selling price.',
        ]);

        DB::beginTransaction();

        try {
            // Calculate totals with product-specific tax rates
            $subtotal = 0;
            $totalTaxAmount = 0;
            $itemsData = [];

            // Validate stock and prepare items
            foreach ($validated['items'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                // Check if product is active
                if ($product->status !== 'active') {
                    throw ValidationException::withMessages([
                        'items' => "Product '{$product->name}' is not available for sale."
                    ]);
                }

                // Check stock availability
                if ($product->quantity_in_stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient stock for '{$product->name}'. Available: {$product->quantity_in_stock}, Requested: {$item['quantity']}"
                    ]);
                }

                // Validate price is within allowed range
                $minPrice = $product->min_selling_price ?? $product->cost_price;
                $maxPrice = $product->max_selling_price ?? $product->price;

                if ($item['price'] < $minPrice) {
                    throw ValidationException::withMessages([
                        'items' => "Price for '{$product->name}' cannot be lower than the minimum selling price of KES " . number_format($minPrice, 2)
                    ]);
                }

                if ($item['price'] > $maxPrice) {
                    throw ValidationException::withMessages([
                        'items' => "Price for '{$product->name}' cannot be higher than the maximum selling price of KES " . number_format($maxPrice, 2)
                    ]);
                }

                $itemSubtotal = $item['quantity'] * $item['price'];
                $subtotal += $itemSubtotal;
                
                // Calculate tax for this item based on product's tax rate
                $itemTaxRate = $product->tax_rate ?? 0;
                $itemTaxAmount = round($itemSubtotal * ($itemTaxRate / 100), 2);
                $totalTaxAmount += $itemTaxAmount;

                $itemsData[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal' => $itemSubtotal,
                    'tax_rate' => $itemTaxRate,
                    'tax_amount' => $itemTaxAmount,
                ];
            }

            // Calculate overall tax rate (weighted average)
            $overallTaxRate = $subtotal > 0 ? round(($totalTaxAmount / $subtotal) * 100, 2) : 0;
            $totalAmount = $subtotal + $totalTaxAmount;

            // Generate receipt number
            $receiptNumber = Sale::generateReceiptNumber();

            // Create the sale record
            $sale = Sale::create([
                'receipt_number' => $receiptNumber,
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'] ?? null,
                'customer_phone' => $validated['customer_phone'] ?? null,
                'subtotal' => $subtotal,
                'tax_amount' => $totalTaxAmount,
                'tax_rate' => $overallTaxRate,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?? null,
                'status' => 'completed',
                'notes' => $validated['notes'] ?? null,
                'sale_date' => now(),
            ]);

            // Create sale items and update stock
            foreach ($itemsData as $itemData) {
                $product = $itemData['product'];

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                // Update product stock
                $product->decrement('quantity_in_stock', $itemData['quantity']);

                // Record stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $itemData['quantity'],
                    'reference' => $receiptNumber,
                    'notes' => 'Sale - ' . $receiptNumber,
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            // Load relationships for response
            $sale->load('saleItems.product');

            return response()->json([
                'success' => true,
                'message' => 'Sale completed successfully',
                'sale' => [
                    'id' => $sale->id,
                    'receipt_number' => $sale->receipt_number,
                    'subtotal' => number_format($sale->subtotal, 2),
                    'tax_amount' => number_format($sale->tax_amount, 2),
                    'total_amount' => number_format($sale->total_amount, 2),
                    'payment_method' => strtoupper($sale->payment_method),
                    'sale_date' => $sale->sale_date->format('l, F j, Y g:i A'),
                    'items' => $sale->saleItems->map(function ($item) {
                        return [
                            'product_name' => $item->product_name,
                            'quantity' => $item->quantity,
                            'unit_price' => number_format($item->unit_price, 2),
                            'subtotal' => number_format($item->subtotal, 2),
                        ];
                    }),
                ],
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sale processing failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process sale. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get sales history
     */
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'saleItems'])
            ->orderBy('sale_date', 'desc');

        // Filter by date range if provided
        if ($request->has('from_date')) {
            $query->whereDate('sale_date', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->whereDate('sale_date', '<=', $request->to_date);
        }

        // Filter by cashier
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by payment method
        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $sales = $query->paginate(50);

        return response()->json($sales);
    }

    /**
     * Get a specific sale
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'saleItems.product']);

        return response()->json([
            'success' => true,
            'sale' => $sale,
        ]);
    }

    /**
     * Get today's sales statistics
     */
    public function todayStats()
    {
        $todaySales = Sale::today()->completed()->get();

        $stats = [
            'sales' => $todaySales->sum('total_amount'),
            'transactions' => $todaySales->count(),
            'items_sold' => $todaySales->sum(function ($sale) {
                return $sale->saleItems->sum('quantity');
            }),
            'sales_formatted' => number_format($todaySales->sum('total_amount'), 2),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
}
