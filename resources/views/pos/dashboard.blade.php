<x-pos-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">{{ __('POS Terminal') }}</h2>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span>{{ now()->format('l, F j, Y') }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-harvest-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Today's Sales</p>
                            <p id="todaySales" class="text-2xl font-bold text-gray-800">KES {{ number_format($todayStats['sales'], 2) }}</p>
                        </div>
                        <div class="h-12 w-12 bg-harvest-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Transactions</p>
                            <p id="todayTransactions" class="text-2xl font-bold text-gray-800">{{ $todayStats['transactions'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Items Sold</p>
                            <p id="todayItemsSold" class="text-2xl font-bold text-gray-800">{{ $todayStats['items_sold'] }}</p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Products Section -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Search Form -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <form method="GET" action="{{ route('pos.dashboard') }}">
                            <div class="flex flex-col md:flex-row gap-3">
                                <div class="flex-1">
                                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-harvest-500">
                                </div>
                                <div class="w-full md:w-64">
                                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="px-6 py-2 bg-harvest-600 text-white rounded-lg hover:bg-harvest-700">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="text-lg font-semibold mb-4">Products</h3>
                        @if($products->isEmpty())
                            <p class="text-center py-12 text-gray-500">No products found</p>
                        @else
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-h-[600px] overflow-y-auto">
                                @foreach($products as $product)
                                    <div class="bg-gray-50 rounded-lg p-3 border hover:border-harvest-500 cursor-pointer" onclick="addToCart({{ $product->id }})">
                                        <div class="aspect-square bg-white rounded mb-2 flex items-center justify-center">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                            @endif
                                        </div>
                                        <h4 class="font-semibold text-sm mb-1 truncate">{{ $product->name }}</h4>
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-harvest-600">KES {{ number_format($product->selling_price, 2) }}</span>
                                            <span class="text-xs text-gray-500">Stock: {{ $product->quantity_in_stock }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Cart Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-4 sticky top-4">
                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg font-semibold">Cart (<span id="itemCount">0</span>)</h3>
                            <button onclick="clearCart()" class="text-red-500 text-sm hover:text-red-700">Clear</button>
                        </div>

                        <div id="emptyCart" class="text-center py-8">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="text-gray-500">Cart is empty</p>
                        </div>

                        <div id="cartItemsList" class="space-y-3 mb-4 max-h-64 overflow-y-auto hidden"></div>

                        <div id="paymentMethodSection" class="mb-4 opacity-50 pointer-events-none">
                            <h4 class="text-sm font-semibold mb-2">Payment Method</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <button id="cashBtn" onclick="selectPaymentMethod('cash')" class="payment-method-btn payment-method-active">Cash</button>
                                <button id="mpesaBtn" onclick="selectPaymentMethod('mpesa')" class="payment-method-btn">M-Pesa</button>
                            </div>
                            <p id="paymentNote" class="text-xs text-gray-500 mt-2">Cash selected</p>
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal:</span>
                                <span id="subtotal">KES 0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Tax (16%):</span>
                                <span id="tax">KES 0.00</span>
                            </div>
                            <div class="flex justify-between text-lg font-bold border-t pt-2">
                                <span>Total:</span>
                                <span id="total" class="text-harvest-600">KES 0.00</span>
                            </div>
                        </div>

                        <button id="checkoutBtn" onclick="proceedToCheckout()" disabled class="w-full mt-4 bg-harvest-600 text-white py-3 rounded-lg hover:bg-harvest-700 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors">
                            Complete Sale (F9)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    <div id="receiptModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold mb-2 text-harvest-700">{{ \App\Models\Setting::systemName() }}</h2>
                <p class="text-sm text-gray-600">Sales Receipt</p>
                <div class="mt-4 border-t border-b py-2 text-left">
                    <p class="text-sm"><strong>Receipt #:</strong> <span id="receiptNumber"></span></p>
                    <p class="text-sm"><strong>Date:</strong> <span id="receiptDate"></span></p>
                    <p class="text-sm"><strong>Cashier:</strong> {{ auth()->user()->name }}</p>
                    <p class="text-sm"><strong>Payment:</strong> <span id="receiptPaymentMethod"></span></p>
                </div>
            </div>

            <div class="max-h-64 overflow-y-auto mb-4">
                <table class="w-full">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left py-2 px-2 text-sm">Item</th>
                            <th class="text-center py-2 px-2 text-sm">Qty</th>
                            <th class="text-right py-2 px-2 text-sm">Price</th>
                            <th class="text-right py-2 px-2 text-sm">Total</th>
                        </tr>
                    </thead>
                    <tbody id="receiptItems"></tbody>
                </table>
            </div>

            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between text-sm">
                    <span>Subtotal:</span>
                    <span id="receiptSubtotal"></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span>Tax (16%):</span>
                    <span id="receiptTax"></span>
                </div>
                <div class="flex justify-between text-lg font-bold border-t pt-2">
                    <span>Total:</span>
                    <span id="receiptTotal" class="text-harvest-600"></span>
                </div>
            </div>

            <div class="mt-6 space-y-3">
                <button onclick="printReceipt()" class="w-full bg-harvest-600 text-white py-2 rounded-lg hover:bg-harvest-700 transition-colors">
                    Print Receipt
                </button>
                <button onclick="newSale()" class="w-full bg-agri-600 text-white py-2 rounded-lg hover:bg-agri-700 transition-colors">
                    New Sale
                </button>
            </div>
        </div>
    </div>

    <style>
        .payment-method-btn { 
            padding: 0.75rem; 
            border: 2px solid #e5e7eb; 
            border-radius: 0.5rem; 
            font-weight: 600; 
            cursor: pointer; 
            transition: all 0.2s;
        }
        .payment-method-btn:hover { 
            border-color: #059669; 
            background-color: #f0fdf4; 
        }
        .payment-method-active { 
            border-color: #059669; 
            background-color: #d1fae5; 
            color: #065f46; 
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #receiptModal, #receiptModal * {
                visibility: visible;
            }
            #receiptModal {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>

    <script>
        let cart = [];
        let selectedPaymentMethod = 'cash';
        let isProcessingSale = false;

        async function addToCart(productId) {
            try {
                // Fetch product details with price range
                const response = await fetch(`/pos/products/${productId}`);
                
                // Check if response is ok
                if (!response.ok) {
                    console.error('Response not OK:', response.status, response.statusText);
                    const errorText = await response.text();
                    console.error('Error details:', errorText);
                    showAlert('Failed to fetch product details. Status: ' + response.status, 'error');
                    return;
                }
                
                const data = await response.json();
                console.log('Product data received:', data);
                
                if (!data.success) {
                    console.error('API returned success=false:', data);
                    showAlert('Failed to fetch product details', 'error');
                    return;
                }
                
                const product = data.product;
                
                // Check if product already in cart
                const existingItem = cart.find(item => item.id === productId);
                
                if (existingItem) {
                    if (existingItem.quantity < product.quantity_in_stock) {
                        existingItem.quantity++;
                    } else {
                        showAlert('Cannot exceed maximum stock of ' + product.quantity_in_stock + '!', 'warning');
                        return;
                    }
                } else {
                    // Add new item with price range info
                    cart.push({ 
                        id: product.id, 
                        name: product.name,
                        sku: product.sku,
                        price: parseFloat(product.default_selling_price),
                        min_price: parseFloat(product.min_selling_price),
                        max_price: parseFloat(product.max_selling_price),
                        quantity: 1,
                        maxStock: product.quantity_in_stock
                    });
                }
                
                updateCart();
                
            } catch (error) {
                console.error('Error adding to cart:', error);
                console.error('Error stack:', error.stack);
                showAlert('Failed to add product to cart: ' + error.message, 'error');
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCart();
        }

        function updatePrice(productId, newPrice) {
            const item = cart.find(item => item.id === productId);
            if (!item) return;
            
            const price = parseFloat(newPrice);
            
            // Validate price range
            if (price < item.min_price) {
                showAlert(`Price cannot be lower than KES ${item.min_price.toFixed(2)}`, 'warning');
                updateCart(); // Reset display
                return;
            }
            
            if (price > item.max_price) {
                showAlert(`Price cannot be higher than KES ${item.max_price.toFixed(2)}`, 'warning');
                updateCart(); // Reset display
                return;
            }
            
            // Valid price - update
            item.price = price;
            updateCart();
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                const newQuantity = item.quantity + change;
                if (newQuantity > 0 && newQuantity <= item.maxStock) {
                    item.quantity = newQuantity;
                    updateCart();
                } else if (newQuantity > item.maxStock) {
                    showAlert('Cannot exceed maximum stock!', 'warning');
                } else if (newQuantity === 0) {
                    removeFromCart(productId);
                }
            }
        }

        function updateCart() {
            const cartItemsList = document.getElementById('cartItemsList');
            const emptyCart = document.getElementById('emptyCart');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const paymentMethodSection = document.getElementById('paymentMethodSection');
            
            if (cart.length === 0) {
                cartItemsList.classList.add('hidden');
                emptyCart.classList.remove('hidden');
                checkoutBtn.disabled = true;
                paymentMethodSection.classList.add('opacity-50', 'pointer-events-none');
            } else {
                emptyCart.classList.add('hidden');
                cartItemsList.classList.remove('hidden');
                checkoutBtn.disabled = false;
                paymentMethodSection.classList.remove('opacity-50', 'pointer-events-none');
                
                cartItemsList.innerHTML = cart.map((item, index) => `
                    <div class="bg-gray-50 rounded-lg p-3 border">
                        <div class="flex justify-between mb-2">
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm truncate">${item.name}</h4>
                                <p class="text-xs text-gray-500">SKU: ${item.sku}</p>
                            </div>
                            <button onclick="removeFromCart(${item.id})" class="text-red-500 hover:text-red-700 font-bold text-lg ml-2">×</button>
                        </div>
                        <div class="mb-2">
                            <label class="text-xs text-gray-600 block mb-1">Price (KES)</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                value="${item.price}" 
                                min="${item.min_price}" 
                                max="${item.max_price}"
                                onchange="updatePrice(${item.id}, this.value)"
                                class="w-full px-3 py-1 border rounded text-sm"
                            />
                            <p class="text-xs text-gray-500 mt-1">Range: KES ${item.min_price.toFixed(2)} - ${item.max_price.toFixed(2)}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2 bg-white rounded border">
                                <button onclick="updateQuantity(${item.id}, -1)" class="px-3 py-1 hover:bg-gray-100">-</button>
                                <span class="px-3 font-semibold">${item.quantity}</span>
                                <button onclick="updateQuantity(${item.id}, 1)" class="px-3 py-1 hover:bg-gray-100">+</button>
                            </div>
                            <span class="font-bold text-harvest-600">KES ${(item.quantity * item.price).toFixed(2)}</span>
                        </div>
                    </div>
                `).join('');
            }
            
            const subtotal = cart.reduce((sum, item) => sum + (item.quantity * item.price), 0);
            const tax = subtotal * 0.16;
            const total = subtotal + tax;
            const itemCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            
            document.getElementById('itemCount').textContent = itemCount;
            document.getElementById('subtotal').textContent = `KES ${subtotal.toFixed(2)}`;
            document.getElementById('tax').textContent = `KES ${tax.toFixed(2)}`;
            document.getElementById('total').textContent = `KES ${total.toFixed(2)}`;
        }

        function clearCart() {
            if (cart.length === 0) return;
            if (confirm('Clear cart? This will remove all items.')) {
                cart = [];
                updateCart();
            }
        }

        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;
            document.getElementById('cashBtn').classList.remove('payment-method-active');
            document.getElementById('mpesaBtn').classList.remove('payment-method-active');
            document.getElementById(method + 'Btn').classList.add('payment-method-active');
            document.getElementById('paymentNote').textContent = method === 'cash' ? 'Cash payment selected' : 'M-Pesa payment selected';
        }

        async function proceedToCheckout() {
            if (cart.length === 0 || isProcessingSale) return;
            
            isProcessingSale = true;
            const checkoutBtn = document.getElementById('checkoutBtn');
            const originalText = checkoutBtn.textContent;
            checkoutBtn.textContent = 'Processing Sale...';
            checkoutBtn.disabled = true;
            
            try {
                // Prepare sale data
                const saleData = {
                    items: cart.map(item => ({
                        product_id: item.id,
                        quantity: item.quantity,
                        price: item.price
                    })),
                    payment_method: selectedPaymentMethod
                };
                
                // Send to server
                const response = await fetch('{{ route("pos.sales.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(saleData)
                });
                
                const result = await response.json();
                
                if (response.ok && result.success) {
                    // Display receipt
                    displayReceipt(result.sale);
                    
                    // Update today's stats
                    await updateTodayStats();
                } else {
                    showAlert(result.message || 'Failed to process sale. Please try again.', 'error');
                    console.error('Sale error:', result);
                }
                
            } catch (error) {
                console.error('Sale processing error:', error);
                showAlert('An error occurred while processing the sale. Please check your connection and try again.', 'error');
            } finally {
                isProcessingSale = false;
                checkoutBtn.textContent = originalText;
                checkoutBtn.disabled = cart.length === 0;
            }
        }
        
        function displayReceipt(sale) {
            document.getElementById('receiptNumber').textContent = sale.receipt_number;
            document.getElementById('receiptDate').textContent = sale.sale_date;
            document.getElementById('receiptPaymentMethod').textContent = sale.payment_method;
            
            document.getElementById('receiptItems').innerHTML = sale.items.map(item => `
                <tr class="border-b">
                    <td class="py-2 px-2 text-sm">${item.product_name}</td>
                    <td class="py-2 px-2 text-center text-sm">${item.quantity}</td>
                    <td class="py-2 px-2 text-right text-sm">KES ${item.unit_price}</td>
                    <td class="py-2 px-2 text-right font-semibold text-sm">KES ${item.subtotal}</td>
                </tr>
            `).join('');
            
            document.getElementById('receiptSubtotal').textContent = `KES ${sale.subtotal}`;
            document.getElementById('receiptTax').textContent = `KES ${sale.tax_amount}`;
            document.getElementById('receiptTotal').textContent = `KES ${sale.total_amount}`;
            
            document.getElementById('receiptModal').classList.remove('hidden');
            document.getElementById('receiptModal').classList.add('flex');
        }

        function printReceipt() {
            window.print();
        }

        function newSale() {
            cart = [];
            updateCart();
            document.getElementById('receiptModal').classList.add('hidden');
            document.getElementById('receiptModal').classList.remove('flex');
            selectPaymentMethod('cash');
            
            // Reload page to refresh stats and product stock
            window.location.reload();
        }
        
        async function updateTodayStats() {
            try {
                const response = await fetch('{{ route("pos.sales.today-stats") }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    if (data.success && data.stats) {
                        document.getElementById('todaySales').textContent = `KES ${data.stats.sales_formatted}`;
                        document.getElementById('todayTransactions').textContent = data.stats.transactions;
                        document.getElementById('todayItemsSold').textContent = data.stats.items_sold;
                    }
                }
            } catch (error) {
                console.error('Error updating stats:', error);
            }
        }

        function showAlert(message, type = 'info') {
            alert(message);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCart();
            selectPaymentMethod('cash');
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'F9' && cart.length > 0 && !isProcessingSale) {
                e.preventDefault();
                proceedToCheckout();
            }
            if (e.key === 'Escape') {
                const modal = document.getElementById('receiptModal');
                if (modal.classList.contains('flex')) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            }
        });
    </script>
</x-pos-app-layout>
