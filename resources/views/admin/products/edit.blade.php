<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Edit Product') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Info Card -->
            <div class="bg-gradient-agri text-white rounded-xl p-6 mb-6 shadow-lg">
                <div class="flex items-center space-x-4">
                    @if($product->image)
                        <img src="{{ Storage::url($product->image) }}" class="h-20 w-20 rounded-lg object-cover shadow-md" alt="{{ $product->name }}">
                    @else
                        <div class="h-20 w-20 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                        <p class="text-white/80">SKU: {{ $product->sku }}</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Basic Information
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" value="Product Name" class="required" />
                                <x-text-input id="name" name="name" :value="old('name', $product->name)" required class="mt-2 w-full" placeholder="Enter product name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sku" value="SKU" class="required" />
                                <x-text-input id="sku" name="sku" :value="old('sku', $product->sku)" required class="mt-2 w-full" placeholder="Stock Keeping Unit" />
                                <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="category_id" value="Category" class="required" />
                                <select id="category_id" name="category_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="brand_id" value="Brand" class="required" />
                                <select id="brand_id" name="brand_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brd)
                                        <option value="{{ $brd->id }}" {{ old('brand_id', $product->brand_id) == $brd->id ? 'selected' : '' }}>
                                            {{ $brd->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none" placeholder="Provide product description">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="unit" value="Unit" class="required" />
                                <x-text-input id="unit" name="unit" :value="old('unit', $product->unit)" required class="mt-2 w-full" placeholder="e.g., 50kg bag, 10kg, 1 liter" />
                                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="barcode" value="Barcode" />
                                <x-text-input id="barcode" name="barcode" :value="old('barcode', $product->barcode)" class="mt-2 w-full" placeholder="Product barcode" />
                                <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pricing Information
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cost_price" value="Cost Price (KES)" class="required" />
                                <div class="relative mt-2">
                                    <span class="absolute left-3 top-3 text-gray-500">KES</span>
                                    <x-text-input id="cost_price" name="cost_price" type="number" step="0.01" :value="old('cost_price', $product->cost_price)" required class="pl-14 w-full" />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Your purchase/cost price</p>
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="wholesale_price" value="Wholesale Price (KES)" />
                                <div class="relative mt-2">
                                    <span class="absolute left-3 top-3 text-gray-500">KES</span>
                                    <x-text-input id="wholesale_price" name="wholesale_price" type="number" step="0.01" :value="old('wholesale_price', $product->wholesale_price)" class="pl-14 w-full" />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Optional bulk pricing</p>
                                <x-input-error :messages="$errors->get('wholesale_price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="price" value="Retail Price (KES)" class="required" />
                                <div class="relative mt-2">
                                    <span class="absolute left-3 top-3 text-gray-500">KES</span>
                                    <x-text-input id="price" name="price" type="number" step="0.01" :value="old('price', $product->price)" required class="pl-14 w-full" />
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Standard retail price</p>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                        </div>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-3">Dynamic Pricing (POS Price Range)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="min_selling_price" value="Minimum Selling Price (KES)" class="required" />
                                    <div class="relative mt-2">
                                        <span class="absolute left-3 top-3 text-gray-500">KES</span>
                                        <x-text-input id="min_selling_price" name="min_selling_price" type="number" step="0.01" :value="old('min_selling_price', $product->min_selling_price)" required class="pl-14 w-full" />
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Lowest price allowed during sales</p>
                                    <x-input-error :messages="$errors->get('min_selling_price')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="max_selling_price" value="Maximum Selling Price (KES)" class="required" />
                                    <div class="relative mt-2">
                                        <span class="absolute left-3 top-3 text-gray-500">KES</span>
                                        <x-text-input id="max_selling_price" name="max_selling_price" type="number" step="0.01" :value="old('max_selling_price', $product->max_selling_price)" required class="pl-14 w-full" />
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1">Standard/highest price (default POS price)</p>
                                    <x-input-error :messages="$errors->get('max_selling_price')" class="mt-2" />
                                </div>
                            </div>
                            <p class="text-xs text-blue-700 mt-3"><strong>Note:</strong> POS users can adjust prices within this range when making sales.</p>
                        </div>
                        
                        <div>
                            <x-input-label for="tax_rate" value="Tax Rate (%)" />
                            <x-text-input id="tax_rate" name="tax_rate" type="number" step="0.01" :value="old('tax_rate', $product->tax_rate)" class="mt-2 w-full" placeholder="e.g., 16" />
                            <p class="text-xs text-gray-500 mt-1">Enter 0 for no tax, or the applicable percentage (e.g., 16 for 16% VAT)</p>
                            <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Stock Information -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Stock Information
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="bg-sky-50 border-l-4 border-sky-500 p-4 rounded-lg">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-sky-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-sky-800">Current Stock: {{ $product->quantity_in_stock }} {{ $product->unit }}</p>
                                    <p class="text-xs text-sky-700 mt-1">Stock quantity is managed through purchase orders and sales. Modify reorder level only.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="quantity_in_stock" value="Stock Quantity" class="required" />
                                <x-text-input id="quantity_in_stock" name="quantity_in_stock" type="number" :value="old('quantity_in_stock', $product->quantity_in_stock)" required class="mt-2 w-full" readonly />
                                <p class="mt-1 text-xs text-gray-500">Read-only: Updated via purchase orders</p>
                            </div>
                            <div>
                                <x-input-label for="reorder_level" value="Reorder Level" class="required" />
                                <x-text-input id="reorder_level" name="reorder_level" type="number" :value="old('reorder_level', $product->reorder_level)" required class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('reorder_level')" class="mt-2" />
                                <p class="mt-1 text-xs text-gray-500">Alert when stock reaches this level</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Image & Status -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Product Image & Status
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        @if($product->image)
                            <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-lg">
                                <img src="{{ Storage::url($product->image) }}" class="h-20 w-20 rounded-lg object-cover shadow-md" alt="{{ $product->name }}">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Current Image</p>
                                    <p class="text-xs text-gray-500">Upload a new image to replace</p>
                                </div>
                            </div>
                        @endif

                        <div>
                            <x-input-label for="image" value="Product Image" />
                            <input type="file" id="image" name="image" accept="image/*" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-agri-100 file:text-agri-800 hover:file:bg-agri-200 transition-all duration-200">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-xs text-gray-500">Recommended: Square image, at least 500x500px</p>
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" class="required" />
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-agri-300 transition-all duration-200 w-full">
                                    <input type="radio" name="status" value="active" class="w-4 h-4 text-agri-600 border-gray-300 focus:ring-agri-500" {{ old('status', $product->status) == 'active' ? 'checked' : '' }} required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-agri-600 animate-pulse mr-2"></span>
                                            <span class="font-semibold text-gray-900">Active</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Product is visible and available for sale</p>
                                    </div>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 w-full">
                                    <input type="radio" name="status" value="inactive" class="w-4 h-4 text-gray-600 border-gray-300 focus:ring-gray-500" {{ old('status', $product->status) == 'inactive' ? 'checked' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-gray-600 mr-2"></span>
                                            <span class="font-semibold text-gray-900">Inactive</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Product is hidden and not available for sale</p>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="btn-agri inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Update Product</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-app-layout>

<style>
.required::after {
    content: " *";
    color: #ef4444;
}
</style>
