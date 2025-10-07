<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.inventory.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Adjust Stock') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Warning Notice -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-amber-800">Important: Manual Stock Adjustment</h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>This feature is for corrections and physical inventory counts</li>
                                <li>All adjustments are logged with your user account</li>
                                <li>Use purchase orders for normal stock receipts</li>
                                <li>Provide a clear reason for audit purposes</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.inventory.adjust.store') }}" class="space-y-6">
                @csrf
                
                <!-- Product Selection -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Select Product
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div>
                            <x-input-label for="product_id" value="Product" class="required" />
                            <select id="product_id" name="product_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                <option value="">Select a product to adjust</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            data-stock="{{ $product->quantity_in_stock }}" 
                                            data-unit="{{ $product->unit }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} (SKU: {{ $product->sku }}) - Current: {{ $product->quantity_in_stock }} {{ $product->unit }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                        </div>

                        <!-- Current Stock Display -->
                        <div id="currentStockDisplay" class="hidden bg-sky-50 border-l-4 border-sky-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-sky-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-sky-800">Current Stock Level</p>
                                    <p class="text-2xl font-bold text-sky-900 mt-1"><span id="currentStock">0</span> <span id="currentUnit" class="text-lg">units</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adjustment Details -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Adjustment Details
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="adjustment_type" value="Adjustment Type" class="required" />
                                <select id="adjustment_type" name="adjustment_type" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                    <option value="">Select adjustment type</option>
                                    <option value="increase" {{ old('adjustment_type') == 'increase' ? 'selected' : '' }}>Increase Stock (+)</option>
                                    <option value="decrease" {{ old('adjustment_type') == 'decrease' ? 'selected' : '' }}>Decrease Stock (-)</option>
                                </select>
                                <x-input-error :messages="$errors->get('adjustment_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="quantity" value="Quantity to Adjust" class="required" />
                                <x-text-input id="quantity" name="quantity" type="number" min="1" step="1" :value="old('quantity')" required class="mt-2 w-full" placeholder="Enter adjustment quantity" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>
                        </div>

                        <!-- New Stock Preview -->
                        <div id="newStockPreview" class="hidden p-4 bg-gradient-agri rounded-lg text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-white/80">New Stock Level After Adjustment</p>
                                    <p class="text-3xl font-bold mt-1"><span id="newStock">0</span> <span id="newUnit" class="text-xl">units</span></p>
                                </div>
                                <div class="h-12 w-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="reason" value="Reason for Adjustment" class="required" />
                            <textarea id="reason" name="reason" rows="4" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none" placeholder="Explain why you're adjusting this stock level (e.g., Physical count correction, Damaged goods, System error correction)">{{ old('reason') }}</textarea>
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">This will be recorded in the audit trail</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.inventory.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="btn-agri inline-flex items-center space-x-2" id="submitBtn" disabled>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Apply Adjustment</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const productSelect = document.getElementById('product_id');
        const adjustmentType = document.getElementById('adjustment_type');
        const quantityInput = document.getElementById('quantity');
        const currentStockDisplay = document.getElementById('currentStockDisplay');
        const newStockPreview = document.getElementById('newStockPreview');
        const submitBtn = document.getElementById('submitBtn');

        let currentStock = 0;
        let currentUnit = '';

        // Update current stock display when product changes
        productSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            
            if (selectedOption.value) {
                currentStock = parseFloat(selectedOption.dataset.stock);
                currentUnit = selectedOption.dataset.unit;
                
                document.getElementById('currentStock').textContent = currentStock.toLocaleString();
                document.getElementById('currentUnit').textContent = currentUnit;
                currentStockDisplay.classList.remove('hidden');
                
                calculateNewStock();
            } else {
                currentStockDisplay.classList.add('hidden');
                newStockPreview.classList.add('hidden');
                submitBtn.disabled = true;
            }
        });

        // Calculate new stock when adjustment type or quantity changes
        adjustmentType.addEventListener('change', calculateNewStock);
        quantityInput.addEventListener('input', calculateNewStock);

        function calculateNewStock() {
            const type = adjustmentType.value;
            const quantity = parseFloat(quantityInput.value) || 0;
            
            if (productSelect.value && type && quantity > 0) {
                let newStock;
                
                if (type === 'increase') {
                    newStock = currentStock + quantity;
                } else if (type === 'decrease') {
                    newStock = currentStock - quantity;
                }
                
                // Prevent negative stock
                if (newStock < 0) {
                    newStockPreview.classList.add('hidden');
                    submitBtn.disabled = true;
                    alert('Adjustment would result in negative stock. Please adjust the quantity.');
                    return;
                }
                
                document.getElementById('newStock').textContent = newStock.toLocaleString();
                document.getElementById('newUnit').textContent = currentUnit;
                newStockPreview.classList.remove('hidden');
                submitBtn.disabled = false;
            } else {
                newStockPreview.classList.add('hidden');
                submitBtn.disabled = true;
            }
        }

        // Form submission confirmation
        document.querySelector('form').addEventListener('submit', function(e) {
            const type = adjustmentType.value;
            const quantity = quantityInput.value;
            const newStock = document.getElementById('newStock').textContent;
            
            const message = `Are you sure you want to ${type} stock by ${quantity} ${currentUnit}?\n\nNew stock level will be: ${newStock} ${currentUnit}`;
            
            if (!confirm(message)) {
                e.preventDefault();
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
