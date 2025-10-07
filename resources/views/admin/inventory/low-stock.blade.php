<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.inventory.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Low Stock Report') }}
                </h2>
            </div>
            <a href="{{ route('admin.purchase-orders.create') }}" class="btn-agri inline-flex items-center space-x-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Create Purchase Order</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Alert Banner -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-lg shadow-sm animate-fade-in-up">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold text-amber-800">Stock Alert</h3>
                        <div class="mt-2 text-sm text-amber-700">
                            <p><strong>{{ $lowStockProducts->count() }}</strong> products are currently at or below their reorder level and need restocking.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Low Stock Items</p>
                            <p class="text-3xl font-bold text-amber-600">{{ $lowStockProducts->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Critical (< 50% Reorder)</p>
                            <p class="text-3xl font-bold text-red-600">
                                {{ $lowStockProducts->filter(function($p) { 
                                    return $p->quantity_in_stock < ($p->reorder_level * 0.5); 
                                })->count() }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Estimated Restock Value</p>
                            <p class="text-3xl font-bold text-gray-800">
                                KES {{ number_format($lowStockProducts->sum(function($p) {
                                    return ($p->reorder_level - $p->quantity_in_stock) * $p->cost_price;
                                }), 0) }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products Table -->
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        Products Below Reorder Level
                    </h3>
                    <p class="text-sm text-white/90 mt-1">Products that need immediate attention</p>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Product
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Category/Brand
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Current Stock
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Reorder Level
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Shortage
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Priority
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Restock Cost
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($lowStockProducts as $product)
                                    @php
                                        $shortage = $product->reorder_level - $product->quantity_in_stock;
                                        $percentOfReorder = ($product->quantity_in_stock / $product->reorder_level) * 100;
                                        $isCritical = $percentOfReorder < 50;
                                    @endphp
                                    <tr class="hover:bg-amber-50/30 transition-colors duration-150 {{ $isCritical ? 'bg-red-50' : '' }}">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                @if($product->image)
                                                    <img src="{{ Storage::url($product->image) }}" class="h-10 w-10 rounded-lg object-cover mr-3" alt="{{ $product->name }}">
                                                @else
                                                    <div class="h-10 w-10 bg-gradient-harvest rounded-lg flex items-center justify-center mr-3">
                                                        <span class="text-white text-xs font-bold">{{ substr($product->name, 0, 2) }}</span>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                                    <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $product->category->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->brand->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-sm font-bold {{ $product->quantity_in_stock <= 0 ? 'text-red-600' : 'text-amber-600' }}">
                                                    {{ number_format($product->quantity_in_stock) }}
                                                </span>
                                                <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                                <div class="bg-amber-600 h-1.5 rounded-full" style="width: {{ min($percentOfReorder, 100) }}%"></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm text-gray-900 font-medium">{{ number_format($product->reorder_level) }}</span>
                                            <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-red-600">
                                                {{ number_format($shortage) }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isCritical)
                                                <span class="badge bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1 inline" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Critical
                                                </span>
                                            @elseif($percentOfReorder < 75)
                                                <span class="badge badge-warning">
                                                    <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                    High
                                                </span>
                                            @else
                                                <span class="badge bg-amber-100 text-amber-800">
                                                    Medium
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">
                                                KES {{ number_format($shortage * $product->cost_price, 2) }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @ KES {{ number_format($product->cost_price, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('admin.products.show', $product) }}" 
                                                   class="p-2 text-sky-600 hover:text-sky-800 hover:bg-sky-50 rounded-lg transition-colors duration-200" 
                                                   title="View Product">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-16">
                                            <div class="text-center">
                                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-agri-100 mb-4">
                                                    <svg class="w-8 h-8 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">All Stock Levels Are Good!</h3>
                                                <p class="text-gray-600">No products are currently below their reorder level.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($lowStockProducts->count() > 0)
                <!-- Quick Actions -->
                <div class="bg-sky-50 border-l-4 border-sky-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-sky-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-sky-800">Recommended Actions</h3>
                            <ul class="mt-2 text-sm text-sky-700 list-disc list-inside space-y-1">
                                <li>Review and create purchase orders for critical items immediately</li>
                                <li>Contact suppliers to confirm availability and delivery times</li>
                                <li>Consider adjusting reorder levels if items frequently go low</li>
                                <li>Check if alternative suppliers can provide faster delivery</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-app-layout>
