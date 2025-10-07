<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.purchase-orders.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Create Purchase Order') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.purchase-orders.store') }}" class="space-y-6" id="poForm">
                @csrf
                
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
                                <select id="supplier_id" name="supplier_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="order_date" value="Order Date" class="required" />
                                <x-text-input id="order_date" name="order_date" type="date" :value="old('order_date', date('Y-m-d'))" required class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('order_date')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="expected_date" value="Expected Delivery Date" />
                                <x-text-input id="expected_date" name="expected_date" type="date" :value="old('expected_date')" class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('expected_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="order_number" value="Order Number" />
                                <x-text-input id="order_number" name="order_number" type="text" :value="old('order_number', $orderNumber)" readonly class="mt-2 w-full bg-gray-100" />
                                <p class="text-xs text-gray-500 mt-1">Auto-generated reference number</p>
                                <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="notes" value="Notes" />
                            <textarea id="notes" name="notes" rows="3" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none" placeholder="Additional notes or special instructions">{{ old('notes') }}</textarea>
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
                            <p class="text-sm text-white/90 mt-1">Add products to this purchase order</p>
                        </div>
                        <button type="button" id="addItemBtn" class="btn-sm bg-white/20 hover:bg-white/30 text-white">
                            <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Item
                        </button>
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
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTable" class="bg-white divide-y divide-gray-200">
                                    <tr class="text-center">
                                        <td colspan="5" class="px-6 py-8 text-gray-500">
                                            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                            <p>No items added yet. Click "Add Item" to start.</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-700">Total Amount:</td>
                                        <td class="px-6 py-4 font-bold text-xl text-agri-600" id="totalAmount">KES 0.00</td>
                                        <td></td>
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
                        <span>Create Purchase Order</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Item Row Template (Hidden) -->
    <template id="itemRowTemplate">
        <tr class="item-row hover:bg-gray-50">
            <td class="px-6 py-4">
                <select name="items[INDEX][product_id]" required class="product-select w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->cost_price }}" data-unit="{{ $product->unit }}">
                            {{ $product->name }} ({{ $product->sku }})
                        </option>
                    @endforeach
                </select>
            </td>
            <td class="px-6 py-4">
                <input type="number" name="items[INDEX][quantity_ordered]" min="1" step="1" required class="quantity-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" placeholder="0">
            </td>
            <td class="px-6 py-4">
                <input type="number" name="items[INDEX][purchase_price]" min="0" step="0.01" required class="price-input w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500" placeholder="0.00">
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
        let itemIndex = 0;

        // Add item button click
        document.getElementById('addItemBtn').addEventListener('click', function() {
            const template = document.getElementById('itemRowTemplate');
            const clone = template.content.cloneNode(true);
            
            // Replace INDEX with actual index
            clone.querySelectorAll('[name*="INDEX"]').forEach(el => {
                el.name = el.name.replace('INDEX', itemIndex);
            });

            // Add event listeners
            const row = clone.querySelector('.item-row');
            addRowEventListeners(row);

            // Remove empty message if exists
            const emptyRow = document.querySelector('#itemsTable tr td[colspan="5"]');
            if (emptyRow) {
                emptyRow.parentElement.remove();
            }

            document.getElementById('itemsTable').appendChild(clone);
            itemIndex++;
        });

        // Add event listeners to row
        function addRowEventListeners(row) {
            const productSelect = row.querySelector('.product-select');
            const quantityInput = row.querySelector('.quantity-input');
            const priceInput = row.querySelector('.price-input');
            const removeBtn = row.querySelector('.remove-item');

            // Auto-fill price when product selected
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const price = selectedOption.dataset.price;
                    priceInput.value = price;
                    calculateSubtotal(row);
                }
            });

            // Calculate subtotal on quantity/price change
            quantityInput.addEventListener('input', () => calculateSubtotal(row));
            priceInput.addEventListener('input', () => calculateSubtotal(row));

            // Remove item
            removeBtn.addEventListener('click', function() {
                row.remove();
                calculateTotal();
                // Show empty message if no items
                if (document.querySelectorAll('#itemsTable .item-row').length === 0) {
                    document.getElementById('itemsTable').innerHTML = `
                        <tr class="text-center">
                            <td colspan="5" class="px-6 py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p>No items added yet. Click "Add Item" to start.</p>
                            </td>
                        </tr>
                    `;
                }
            });
        }

        // Calculate subtotal for a row
        function calculateSubtotal(row) {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const subtotal = quantity * price;
            
            row.querySelector('.subtotal-display').textContent = `KES ${subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
            calculateTotal();
        }

        // Calculate total amount
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('#itemsTable .item-row').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(row.querySelector('.price-input').value) || 0;
                total += quantity * price;
            });
            
            document.getElementById('totalAmount').textContent = `KES ${total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
        }

        // Form validation
        document.getElementById('poForm').addEventListener('submit', function(e) {
            const items = document.querySelectorAll('#itemsTable .item-row');
            if (items.length === 0) {
                e.preventDefault();
                alert('Please add at least one item to the purchase order.');
                return false;
            }
        });
    </script>

    <style>
    .required::after {
        content: " *";
        color: #ef4444;
    }
    </style>
</x-admin-app-layout>
