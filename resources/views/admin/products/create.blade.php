<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.products.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg></a>
            <h2 class="font-bold text-3xl text-gray-800">Add New Product</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if($categories->isEmpty() || $brands->isEmpty())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-bold mb-2">Cannot Create Product</h3>
                        <div class="text-red-700 text-sm space-y-1">
                            @if($categories->isEmpty())
                            <p>• No categories found. Please <a href="{{ route('admin.categories.create') }}" class="underline font-semibold hover:text-red-900">create at least one category</a> first.</p>
                            @endif
                            @if($brands->isEmpty())
                            <p>• No brands found. Please <a href="{{ route('admin.brands.create') }}" class="underline font-semibold hover:text-red-900">create at least one brand</a> first.</p>
                            @endif
                            <p class="mt-2 font-semibold">Alternative: Run <code class="bg-red-100 px-2 py-1 rounded">php artisan db:seed</code> to populate sample data.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-red-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-red-800 font-bold mb-2">Validation Errors</h3>
                        <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="card">
                    <div class="card-header"><h3>Basic Information</h3></div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="name" value="Product Name *" />
                                <x-text-input id="name" name="name" :value="old('name')" required class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="sku" value="SKU *" />
                                <x-text-input id="sku" name="sku" :value="old('sku')" required class="mt-2 w-full" />
                                <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="category_id" value="Category *" />
                                <select id="category_id" name="category_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="brand_id" value="Brand *" />
                                <select id="brand_id" name="brand_id" required class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl">
                                    <option value="">Select Brand</option>
                                    @foreach($brands as $brd)
                                    <option value="{{ $brd->id }}" {{ old('brand_id') == $brd->id ? 'selected' : '' }}>{{ $brd->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('brand_id')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="description" value="Description" />
                            <textarea id="description" name="description" rows="3" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="unit" value="Unit *" />
                                <x-text-input id="unit" name="unit" :value="old('unit', '50kg bag')" required class="mt-2 w-full" placeholder="e.g., 50kg bag, 10kg, 1 liter" />
                            </div>
                            <div>
                                <x-input-label for="barcode" value="Barcode" />
                                <x-text-input id="barcode" name="barcode" :value="old('barcode')" class="mt-2 w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3>Pricing</h3></div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="cost_price" value="Cost Price (KES) *" />
                                <x-text-input id="cost_price" name="cost_price" type="number" step="0.01" :value="old('cost_price')" required class="mt-2 w-full" />
                            </div>
                            <div>
                                <x-input-label for="wholesale_price" value="Wholesale Price (KES)" />
                                <x-text-input id="wholesale_price" name="wholesale_price" type="number" step="0.01" :value="old('wholesale_price')" class="mt-2 w-full" />
                            </div>
                            <div>
                                <x-input-label for="price" value="Retail Price (KES) *" />
                                <x-text-input id="price" name="price" type="number" step="0.01" :value="old('price')" required class="mt-2 w-full" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="tax_rate" value="Tax Rate (%) *" />
                            <x-text-input id="tax_rate" name="tax_rate" type="number" step="0.01" :value="old('tax_rate', '16')" required class="mt-2 w-full" />
                            <x-input-error :messages="$errors->get('tax_rate')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3>Stock Information</h3></div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="quantity_in_stock" value="Initial Stock Quantity *" />
                                <x-text-input id="quantity_in_stock" name="quantity_in_stock" type="number" :value="old('quantity_in_stock', '0')" required class="mt-2 w-full" />
                            </div>
                            <div>
                                <x-input-label for="reorder_level" value="Reorder Level *" />
                                <x-text-input id="reorder_level" name="reorder_level" type="number" :value="old('reorder_level', '10')" required class="mt-2 w-full" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3>Product Image & Status</h3></div>
                    <div class="card-body space-y-4">
                        <div>
                            <x-input-label for="image" value="Product Image" />
                            <input type="file" id="image" name="image" accept="image/*" class="mt-2 w-full px-4 py-3 border-2 border-gray-300 rounded-xl">
                        </div>
                        <div>
                            <x-input-label value="Status *" />
                            <div class="mt-2 space-y-2">
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer">
                                    <input type="radio" name="status" value="active" checked class="w-4 h-4 text-agri-600">
                                    <span class="ml-3 font-semibold">Active</span>
                                </label>
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer">
                                    <input type="radio" name="status" value="inactive" class="w-4 h-4">
                                    <span class="ml-3 font-semibold">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="btn-agri">Create Product</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-app-layout>
