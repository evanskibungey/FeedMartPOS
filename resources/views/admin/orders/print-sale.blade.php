<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $sale->receipt_number }} - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #333;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        .header p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .receipt-number {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .info-section {
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .info-section .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .divider {
            border-top: 1px dashed #666;
            margin: 15px 0;
        }
        
        .items-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .items-table .item {
            margin-bottom: 10px;
        }
        
        .items-table .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .items-table .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }
        
        .totals {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #333;
        }
        
        .totals .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .totals .total-row {
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        
        .payment-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #666;
            font-size: 11px;
        }
        
        .payment-info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .footer {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #333;
            text-align: center;
            font-size: 10px;
        }
        
        .footer p {
            margin: 3px 0;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
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
            font-family: Arial, sans-serif;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .print-button:hover {
            background: #d97706;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">Print Receipt</button>
    
    <div class="container">
        <div class="header">
            <h1>{{ \App\Models\Setting::systemName() }}</h1>
            <p>SALES RECEIPT</p>
            <p>================================</p>
        </div>
        
        <div class="receipt-number">
            {{ $sale->receipt_number }}
        </div>
        
        <div class="info-section">
            <div class="row">
                <span>Date:</span>
                <span>{{ $sale->sale_date->format('M d, Y h:i A') }}</span>
            </div>
            <div class="row">
                <span>Cashier:</span>
                <span>{{ $sale->user->name }}</span>
            </div>
            @if($sale->customer_name)
            <div class="row">
                <span>Customer:</span>
                <span>{{ $sale->customer_name }}</span>
            </div>
            @endif
            @if($sale->customer_phone)
            <div class="row">
                <span>Phone:</span>
                <span>{{ $sale->customer_phone }}</span>
            </div>
            @endif
        </div>
        
        <div class="divider"></div>
        
        <div class="items-table">
            @foreach($sale->saleItems as $item)
            <div class="item">
                <div class="item-name">{{ $item->product_name }}</div>
                <div class="item-details">
                    <span>{{ $item->quantity }} x KES {{ number_format($item->unit_price, 2) }}</span>
                    <span>KES {{ number_format($item->subtotal, 2) }}</span>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="totals">
            <div class="row">
                <span>Subtotal:</span>
                <span>KES {{ number_format($sale->subtotal, 2) }}</span>
            </div>
            @if($sale->tax_amount > 0)
            <div class="row">
                <span>Tax ({{ number_format($sale->tax_rate, 2) }}%):</span>
                <span>KES {{ number_format($sale->tax_amount, 2) }}</span>
            </div>
            @endif
            <div class="row total-row">
                <span>TOTAL:</span>
                <span>KES {{ number_format($sale->total_amount, 2) }}</span>
            </div>
        </div>
        
        <div class="payment-info">
            <div class="row">
                <span>Payment Method:</span>
                <span>
                    @if($sale->payment_method === 'cash')
                        CASH
                    @elseif($sale->payment_method === 'mpesa')
                        M-PESA
                    @elseif($sale->payment_method === 'card')
                        CARD
                    @else
                        BANK TRANSFER
                    @endif
                </span>
            </div>
            @if($sale->payment_reference)
            <div class="row">
                <span>Reference:</span>
                <span>{{ $sale->payment_reference }}</span>
            </div>
            @endif
        </div>
        
        @if($sale->notes)
        <div class="divider"></div>
        <div class="info-section">
            <div style="margin-bottom: 5px; font-weight: bold;">Notes:</div>
            <div>{{ $sale->notes }}</div>
        </div>
        @endif
        
        <div class="footer">
            <p>================================</p>
            <p>Thank you for your business!</p>
            <p>Visit us again soon</p>
            <p>================================</p>
            <p>{{ \App\Models\Setting::systemName() }}</p>
            <p>Printed: {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
