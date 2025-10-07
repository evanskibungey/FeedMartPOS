<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.products.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Product Details') }}
                </h2>
            </div>
            <a href="{{ route('admin.products.edit', $product) }}" class="btn-agri inline-flex items-center space-x-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>Edit Product</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Product Header Card -->
            <div class="bg-gradient-agri text-white rounded-xl p-6 shadow-lg animate-fade-in-up">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" class="h-24 w-24 rounded-lg object-cover shadow-md" alt="{{ $product->name }}">
                        @else
                            <div class="h-24 w-24 bg-white/20 rounded-lg flex items-center justify-center">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-3xl font-bold">{{ $product->name }}</h3>
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="text-white/80">SKU: {{ $product->sku }}</span>
                                @if($product->barcode)
                                    <span class="text-white/80">• Barcode: {{ $product->barcode }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($product->status === 'active')
                            <span class="badge bg-white/20 text-white border border-white/30">
                                <span class="h-2 w-2 rounded-full bg-white animate-pulse mr-1"></span>
                                Active
                            </span>
                        @else
                            <span class="badge bg-red-100 text-red-800">
                                <span class="h-2 w-2 rounded-full bg-red-600 mr-1"></span>
                                Inactive
                            </span>
                        @endif

                        @php
                            $stockStatus = $product->getStockStatus();
                        @endphp
                        @if($stockStatus === 'ok')
                            <span class="badge badge-success">In Stock</span>
                        @elseif($stockStatus === 'low')
                            <span class="badge badge-warning">Low Stock</span>
                        @else
                            <span class="badge bg-red-100 text-red-800">Out of Stock</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-agri-500 animate-fade-in-up">
                    <p class="text-sm text-gray-600 font-medium">Current Stock</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($product->quantity_in_stock) }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $product->unit }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-harvest-500 animate-fade-in-up">
                    <p class="text-sm text-gray-600 font-medium">Retail Price</p>
                    <p class="text-2xl font-bold text-gray-800">KES {{ number_format($product->price, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">per {{ $product->unit }}</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-sky-500 animate-fade-in-up">
                    <p class="text-sm text-gray-600 font-medium">Total Value</p>
                    <p class="text-2xl font-bold text-gray-800">KES {{ number_format($product->quantity_in_stock * $product->price, 2) }}</p>
                    <p class="text-xs text-gray-500 mt-1">at retail price</p>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-earth-500 animate-fade-in-up">
                    <p class="text-sm text-gray-600 font-medium">Reorder Level</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($product->reorder_level) }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $product->unit }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Information -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Product Information
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Category</p>
                                <p class="text-gray-900 font-semibold">{{ $product->category->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Brand</p>
                                <p class="text-gray-900 font-semibold">{{ $product->brand->name }}</p>
                            </div>
                        </div>

                        @if($product->description)
                            <div>
                                <p class="text-sm text-gray-600 font-medium mb-2">Description</p>
                                <p class="text-gray-800 text-sm leading-relaxed">{{ $product->description }}</p>
                            </div>
                        @endif

                        <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Unit of Measure</p>
                                <p class="text-gray-900 font-semibold">{{ $product->unit }}</p>
                            </div>
                            @if($product->tax_rate)
                                <div>
                                    <p class="text-sm text-gray-600 font-medium">Tax Rate</p>
                                    <p class="text-gray-900 font-semibold">{{ $product->tax_rate }}%</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pricing Details
                        </h3>
                    </div>
                    <div class="card-body space-y-4">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Cost Price</span>
                                <span class="text-gray-900 font-bold">KES {{ number_format($product->cost_price, 2) }}</span>
                            </div>

                            @if($product->wholesale_price)
                                <div class="flex items-center justify-between p-3 bg-sky-50 rounded-lg">
                                    <span class="text-sm text-gray-600 font-medium">Wholesale Price</span>
                                    <span class="text-gray-900 font-bold">KES {{ number_format($product->wholesale_price, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between p-3 bg-agri-50 rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Retail Price</span>
                                <span class="text-agri-800 font-bold text-lg">KES {{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">Markup</span>
                                @php
                                    $markup = $product->cost_price > 0 ? (($product->price - $product->cost_price) / $product->cost_price) * 100 : 0;
                                @endphp
                                <span class="font-semibold {{ $markup > 0 ? 'text-agri-600' : 'text-red-600' }}">
                                    {{ number_format($markup, 1) }}%
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Profit per Unit</span>
                                <span class="font-semibold text-harvest-600">
                                    KES {{ number_format($product->price - $product->cost_price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock History (if available) -->
            @if($product->stockMovements && $product->stockMovements->count() > 0)
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Recent Stock Movements
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Reference</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">User</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($product->stockMovements->take(10) as $movement)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $movement->created_at->format('M d, Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($movement->type === 'IN')
                                                    <span class="badge badge-success">Stock In</span>
                                                @elseif($movement->type === 'OUT')
                                                    <span class="badge bg-red-100 text-red-800">Stock Out</span>
                                                @else
                                                    <span class="badge bg-sky-100 text-sky-800">Adjustment</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="font-semibold {{ $movement->type === 'IN' ? 'text-agri-600' : 'text-red-600' }}">
                                                    {{ $movement->type === 'IN' ? '+' : '-' }}{{ number_format($movement->quantity) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $movement->reference ?? '—' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600">
                                                {{ $movement->user->name ?? 'System' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Suppliers -->
            @if($product->suppliers && $product->suppliers->count() > 0)
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Suppliers
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($product->suppliers as $supplier)
                                <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-agri-300 transition-all duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $supplier->name }}</h4>
                                            @if($supplier->pivot->supplier_sku)
                                                <p class="text-xs text-gray-500">SKU: {{ $supplier->pivot->supplier_sku }}</p>
                                            @endif
                                        </div>
                                        @if($supplier->pivot->unit_price)
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-agri-600">
                                                    KES {{ number_format($supplier->pivot->unit_price, 2) }}
                                                </p>
                                                <p class="text-xs text-gray-500">Supplier Price</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Record Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium text-gray-900">{{ $product->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span class="text-gray-600">Last Updated:</span>
                            <span class="font-medium text-gray-900">{{ $product->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
