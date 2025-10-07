<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.purchase-orders.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Edit Purchase Order') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- PO Header Info -->
            <div class="bg-gradient-harvest text-white rounded-xl p-6 mb-6 shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $purchaseOrder->order_number }}</h3>
                        <p class="text-white/80 mt-1">{{ $purchaseOrder->supplier->name }}</p>
                    </div>
                    <span class="badge bg-white/20 text-white border border-white/30">
                        {{ ucfirst($purchaseOrder->status) }}
                    </span>
                </div>
            </div>

            @if($purchaseOrder->status !== 'draft')
                <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg mb-6">
                    <div class="flex">
                        <svg class="h-5 w-5 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-amber-800">Limited Editing</h3>
                            <p class="text-sm text-amber-700 mt-1">This purchase order is {{ $purchaseOrder->status }}. Only limited fields can be edited.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.purchase-orders.update', $purchaseOrder) }}" class="space-y-6" id="poForm">
                @csrf
                @method('PUT')
                
                <!-- PO Details Card -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Purchase Order Information
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="supplier_id" value="Supplier" class="required" />
                                <select id="supplier_id" name="supplier_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200" {{ $purchaseOrder->status !== 'draft' ? 'disabled' : '' }}>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchaseOrder->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($purchaseOrder->status !== 'draft')
                                    <input type="hidden" name="supplier_id" value="{{ $purchaseOrder->supplier_id }}">
                                @endif
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="order_date" value="Order Date" class="required" />
                                <x-text-input id="order_date" name="order_date" type="date" :value="old('order_date', $purchaseOrder->order_date?->format('Y-m-d'))" required class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('order_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="expected_date" value="Expected Delivery Date" />
                                <x-text-input id="expected_date" name="expected_date" type="date" :value="old('expected_date', $purchaseOrder->expected_date?->format('Y-m-d'))" class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('expected_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="status" value="Status" class="required" />
                                <select id="status" name="status" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                    <option value="draft" {{ old('status', $purchaseOrder->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="ordered" {{ old('status', $purchaseOrder->status) == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                    @if($purchaseOrder->status === 'received')
                                        <option value="received" selected>Received</option>
                                    @endif
                                    @if($purchaseOrder->status === 'cancelled')
                                        <option value="cancelled" selected>Cancelled</option>
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none" placeholder="Additional notes or special instructions">{{ old('notes', $purchaseOrder->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Order Items Card -->
                <div class="card animate-fade-in-up">
                    <div class="card-header flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Order Items
                            </h3>
                        </div>
                        @if($purchaseOrder->status === 'draft')
                            <button type="button" id="addItemBtn" class="btn-sm bg-white/20 hover:bg-white/30 text-white">
                                <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Item
                            </button>
                        @endif
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Unit Price</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Subtotal</th>
                                        @if($purchaseOrder->status === 'draft')
                                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody id="itemsTable" class="bg-white divide-y divide-gray-200">
                                    @foreach($purchaseOrder->items as $index => $item)
                                        <tr class="item-row hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                @if($purchaseOrder->status === 'draft')
                                                    <select name="items[{{ $index }}][product_id]" required class="product-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }} ({{ $product->sku }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                                @else
                                                    <div class="font-medium text-gray-900">{{ $item->product->name }}</div>
                                                    <div class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" name="items[{{ $index }}][quantity]" min="1" step="1" value="{{ $item->quantity }}" required class="quantity-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }}>
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="number" name="items[{{ $index }}][unit_price]" min="0" step="0.01" value="{{ $item->unit_price }}" required class="price-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" {{ $purchaseOrder->status !== 'draft' ? 'readonly' : '' }}>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="subtotal-display font-semibold text-gray-900">KES {{ number_format($item->subtotal, 2) }}</span>
                                            </td>
                                            @if($purchaseOrder->status === 'draft')
                                                <td class="px-6 py-4 text-center">
                                                    <button type="button" class="remove-item p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="hidden" name="items[{{ $index }}][_delete]" value="0" class="delete-flag">
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                    <tr>
                                        <td colspan="{{ $purchaseOrder->status === 'draft' ? '3' : '3' }}" class="px-6 py-4 text-right font-bold text-gray-700">Total Amount:</td>
                                        <td class="px-6 py-4 font-bold text-xl text-agri-600" id="totalAmount">KES {{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                        @if($purchaseOrder->status === 'draft')
                                            <td></td>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.purchase-orders.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="btn-agri inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Update Purchase Order</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($purchaseOrder->status === 'draft')
        <!-- Item Row Template -->
        <template id="itemRowTemplate">
            <tr class="item-row hover:bg-gray-50">
                <td class="px-6 py-4">
                    <select name="items[INDEX][product_id]" required class="product-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}">
                                {{ $product->name }} ({{ $product->sku }})
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="px-6 py-4">
                    <input type="number" name="items[INDEX][quantity]" min="1" step="1" required class="quantity-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" placeholder="0">
                </td>
                <td class="px-6 py-4">
                    <input type="number" name="items[INDEX][unit_price]" min="0" step="0.01" required class="price-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" placeholder="0.00">
                </td>
                <td class="px-6 py-4">
                    <span class="subtotal-display font-semibold text-gray-900">KES 0.00</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <button type="button" class="remove-item p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            </tr>
        </template>

        <script>
            let itemIndex = {{ $purchaseOrder->items->count() }};

            // Add event listeners to existing rows
            document.querySelectorAll('#itemsTable .item-row').forEach(row => {
                addRowEventListeners(row);
            });

            // Add item button
            const addBtn = document.getElementById('addItemBtn');
            if (addBtn) {
                addBtn.addEventListener('click', function() {
                    const template = document.getElementById('itemRowTemplate');
                    const clone = template.content.cloneNode(true);
                    
                    clone.querySelectorAll('[name*="INDEX"]').forEach(el => {
                        el.name = el.name.replace('INDEX', itemIndex);
                    });

                    const row = clone.querySelector('.item-row');
                    addRowEventListeners(row);

                    document.getElementById('itemsTable').appendChild(clone);
                    itemIndex++;
                });
            }

            function addRowEventListeners(row) {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const priceInput = row.querySelector('.price-input');
                const removeBtn = row.querySelector('.remove-item');

                if (productSelect) {
                    productSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        if (selectedOption.value && selectedOption.dataset.price) {
                            priceInput.value = selectedOption.dataset.price;
                            calculateSubtotal(row);
                        }
                    });
                }

                quantityInput.addEventListener('input', () => calculateSubtotal(row));
                priceInput.addEventListener('input', () => calculateSubtotal(row));

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        const deleteFlag = row.querySelector('.delete-flag');
                        if (deleteFlag) {
                            deleteFlag.value = '1';
                            row.style.display = 'none';
                        } else {
                            row.remove();
                        }
                        calculateTotal();
                    });
                }
            }

            function calculateSubtotal(row) {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                const subtotal = quantity * price;
                
                row.querySelector('.subtotal-display').textContent = `KES ${subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
                calculateTotal();
            }

            function calculateTotal() {
                let total = 0;
                document.querySelectorAll('#itemsTable .item-row').forEach(row => {
                    if (row.style.display !== 'none') {
                        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                        const price = parseFloat(row.querySelector('.price-input').value) || 0;
                        total += quantity * price;
                    }
                });
                
                document.getElementById('totalAmount').textContent = `KES ${total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
            }

            // Initial calculation
            calculateTotal();
        </script>
    @endif

    <style>
    .required::after {
        content: " *";
        color: #ef4444;
    }
    </style>
</x-admin-app-layout>
