<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Inventory Report
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Back Button and Export -->
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.reports.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Reports
                </a>
                <a href="{{ route('admin.reports.inventory.export', request()->all()) }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export to Excel
                </a>
            </div>

            <!-- Filter -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.reports.inventory') }}" class="flex items-end space-x-4">
                    <div class="flex-1">
                        <label for="filter" class="block text-sm font-semibold text-gray-700 mb-2">Filter</label>
                        <select name="filter" 
                                id="filter" 
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                            <option value="all" {{ $filter == 'all' ? 'selected' : '' }}>All Products</option>
                            <option value="low_stock" {{ $filter == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ $filter == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="overstocked" {{ $filter == 'overstocked' ? 'selected' : '' }}>Overstocked</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-harvest text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                        Apply Filter
                    </button>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Total Products</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalProducts) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Inventory Value</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($totalValue, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-2 border-yellow-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Low Stock</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($lowStockCount) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg border-2 border-red-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Out of Stock</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($outOfStockCount) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-red-400 to-red-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products by Category -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Inventory by Category</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($productsByCategory as $cat)
                    <div class="p-4 bg-gradient-to-r from-harvest-50 to-agri-50 rounded-xl border border-harvest-200">
                        <p class="font-semibold text-gray-900">{{ $cat->category->name ?? 'Uncategorized' }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $cat->count }} products • {{ number_format($cat->total_stock) }} units</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b-2 border-blue-200">
                    <h3 class="text-lg font-bold text-gray-900">Product Inventory</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Category</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Stock</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Reorder Level</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Cost Price</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Value</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $product->sku }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $product->category->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($product->quantity_in_stock) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm text-gray-600">{{ number_format($product->reorder_level) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm text-gray-900">KES {{ number_format($product->cost_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">KES {{ number_format($product->quantity_in_stock * $product->cost_price, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->quantity_in_stock == 0)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                    @elseif($product->quantity_in_stock <= $product->reorder_level)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                                    @elseif($product->quantity_in_stock > ($product->reorder_level * 3))
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-800">Overstocked</span>
                                    @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">Good</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Stock Movements -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b-2 border-purple-200">
                    <h3 class="text-lg font-bold text-gray-900">Recent Stock Movements (Last 30 Days)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Type</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Quantity</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Reference</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">User</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($stockMovements as $movement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $movement->created_at->format('M d, Y') }}</span>
                                    <div class="text-xs text-gray-500">{{ $movement->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $movement->product->name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($movement->type === 'in')
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">IN</span>
                                    @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">OUT</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($movement->quantity) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $movement->reference }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $movement->user->name ?? 'System' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-app-layout>
