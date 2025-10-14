<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order {{ $order->order_number }} - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #f59e0b;
        }
        
        .header p {
            font-size: 14px;
            color: #666;
        }
        
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .order-info .section {
            flex: 1;
        }
        
        .order-info h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #f59e0b;
            text-transform: uppercase;
        }
        
        .order-info p {
            margin-bottom: 5px;
        }
        
        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-processing { background: #dbeafe; color: #1e40af; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        table thead {
            background: #f3f4f6;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #333;
        }
        
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }
        
        .totals table {
            margin-bottom: 0;
        }
        
        .totals table td {
            padding: 8px 12px;
        }
        
        .totals .total-row {
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #333;
        }
        
        .footer {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #333;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
        }
        
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #f59e0b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .print-button:hover {
            background: #d97706;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">Print Order</button>
    
    <div class="container">
        <div class="header">
            <h1>{{ \App\Models\Setting::systemName() }}</h1>
            <p>Order Invoice</p>
        </div>
        
        <div class="order-number">
            Order Number: {{ $order->order_number }}
            <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </div>
        
        <div class="order-info">
            <div class="section">
                <h3>Customer Information</h3>
                <p><strong>Name:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                @if($order->phone)
                <p><strong>Phone:</strong> {{ $order->phone }}</p>
                @endif
            </div>
            
            <div class="section">
                <h3>Order Details</h3>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                @if($order->completed_at)
                <p><strong>Completed:</strong> {{ $order->completed_at->format('M d, Y h:i A') }}</p>
                @endif
                @if($order->cancelled_at)
                <p><strong>Cancelled:</strong> {{ $order->cancelled_at->format('M d, Y h:i A') }}</p>
                @endif
            </div>
        </div>
        
        @if($order->delivery_address)
        <div class="order-info">
            <div class="section">
                <h3>Delivery Address</h3>
                <p>{{ $order->delivery_address }}</p>
            </div>
        </div>
        @endif
        
        <h3 style="margin-bottom: 15px; color: #f59e0b;">Order Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Tax</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->product_sku }}</td>
                    <td class="text-right">KES {{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">KES {{ number_format($item->tax_amount, 2) }}</td>
                    <td class="text-right">KES {{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right"><strong>KES {{ number_format($order->subtotal, 2) }}</strong></td>
                </tr>
                @if($order->tax > 0)
                <tr>
                    <td>Tax:</td>
                    <td class="text-right"><strong>KES {{ number_format($order->tax, 2) }}</strong></td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total:</td>
                    <td class="text-right">KES {{ number_format($order->total_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        
        @if($order->notes)
        <div style="clear: both; margin-top: 30px;">
            <h3 style="margin-bottom: 10px; color: #f59e0b;">Order Notes</h3>
            <p>{{ $order->notes }}</p>
        </div>
        @endif
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>{{ \App\Models\Setting::systemName() }} - Printed on {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
