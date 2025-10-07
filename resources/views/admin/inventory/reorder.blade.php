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
                    {{ __('Reorder Report') }}
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
            <!-- Info Banner -->
            <div class="bg-sky-50 border-l-4 border-sky-500 p-4 rounded-lg shadow-sm animate-fade-in-up">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-semibold text-sky-800">Reorder Report Information</h3>
                        <div class="mt-2 text-sm text-sky-700">
                            <p>This report shows all products that have reached or fallen below their reorder level. Use this to plan your purchasing and maintain optimal stock levels.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Items to Reorder</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $reorderProducts->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-harvest-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Units Needed</p>
                            <p class="text-3xl font-bold text-gray-800">
                                {{ number_format($reorderProducts->sum(function($p) {
                                    return max(0, $p->reorder_level - $p->quantity_in_stock);
                                })) }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-harvest-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-sky-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Estimated Cost</p>
                            <p class="text-3xl font-bold text-gray-800">
                                KES {{ number_format($reorderProducts->sum(function($p) {
                                    $shortage = max(0, $p->reorder_level - $p->quantity_in_stock);
                                    return $shortage * $p->cost_price;
                                }), 0) }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-earth-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Categories Affected</p>
                            <p class="text-3xl font-bold text-gray-800">
                                {{ $reorderProducts->pluck('category_id')->unique()->count() }}
                            </p>
                        </div>
                        <div class="h-12 w-12 bg-earth-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reorder by Supplier -->
            @if($reorderBySupplier->count() > 0)
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Reorder by Supplier
                        </h3>
                        <p class="text-sm text-white/90 mt-1">Organize your purchase orders by supplier</p>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @foreach($reorderBySupplier as $supplierData)
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-agri-300 transition-all duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-10 w-10 bg-gradient-earth rounded-lg flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">{{ substr($supplierData['supplier']->name, 0, 2) }}</span>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $supplierData['supplier']->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $supplierData['products']->count() }} products to reorder</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Estimated Cost</p>
                                            <p class="text-xl font-bold text-agri-600">
                                                KES {{ number_format($supplierData['total_cost'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="border-t pt-3">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                            @foreach($supplierData['products'] as $product)
                                                <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                                                    <div class="flex items-center space-x-2">
                                                        @if($product->image)
                                                            <img src="{{ Storage::url($product->image) }}" class="h-8 w-8 rounded object-cover" alt="{{ $product->name }}">
                                                        @else
                                                            <div class="h-8 w-8 bg-gradient-harvest rounded flex items-center justify-center">
                                                                <span class="text-white text-xs font-bold">{{ substr($product->name, 0, 2) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                                            <p class="text-xs text-gray-500">{{ $product->sku }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <p class="text-sm font-semibold text-red-600">
                                                            {{ number_format(max(0, $product->reorder_level - $product->quantity_in_stock)) }} {{ $product->unit }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Detailed Reorder List -->
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Detailed Reorder List
                    </h3>
                    <p class="text-sm text-white/90 mt-1">Complete list of all products at reorder level</p>
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
                                        Supplier
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Current / Reorder
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Suggested Order
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Unit Cost
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Total Cost
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reorderProducts as $product)
                                    @php
                                        $shortage = max(0, $product->reorder_level - $product->quantity_in_stock);
                                        $suggestedOrder = ceil($shortage / 10) * 10; // Round up to nearest 10
                                    @endphp
                                    <tr class="hover:bg-agri-50/30 transition-colors duration-150">
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
                                            @if($product->suppliers && $product->suppliers->count() > 0)
                                                <div class="text-sm font-medium text-gray-900">{{ $product->suppliers->first()->name }}</div>
                                                @if($product->suppliers->count() > 1)
                                                    <div class="text-xs text-gray-500">+{{ $product->suppliers->count() - 1 }} more</div>
                                                @endif
                                            @else
                                                <span class="text-sm text-gray-400">No supplier</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm">
                                                <span class="font-bold {{ $product->quantity_in_stock <= 0 ? 'text-red-600' : 'text-amber-600' }}">
                                                    {{ number_format($product->quantity_in_stock) }}
                                                </span>
                                                <span class="text-gray-500 mx-1">/</span>
                                                <span class="font-semibold text-gray-900">{{ number_format($product->reorder_level) }}</span>
                                                <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-agri-600">
                                                {{ number_format($suggestedOrder) }}
                                            </span>
                                            <span class="text-xs text-gray-500 ml-1">{{ $product->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            KES {{ number_format($product->cost_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">
                                                KES {{ number_format($suggestedOrder * $product->cost_price, 2) }}
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
                                        <td colspan="7" class="px-6 py-16">
                                            <div class="text-center">
                                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-agri-100 mb-4">
                                                    <svg class="w-8 h-8 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Products Need Reordering</h3>
                                                <p class="text-gray-600">All products are above their reorder levels. Your inventory is well stocked!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($reorderProducts->count() > 0)
                <!-- Action Tips -->
                <div class="bg-agri-50 border-l-4 border-agri-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-agri-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-agri-800">Tips for Efficient Reordering</h3>
                            <ul class="mt-2 text-sm text-agri-700 list-disc list-inside space-y-1">
                                <li>Group orders by supplier to save on shipping costs</li>
                                <li>Check supplier lead times before placing orders</li>
                                <li>Consider ordering slightly above reorder level to account for lead time</li>
                                <li>Review and adjust reorder levels based on sales patterns</li>
                                <li>Maintain good relationships with multiple suppliers for each product</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-app-layout>
