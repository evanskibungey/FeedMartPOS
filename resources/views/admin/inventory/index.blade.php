<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Inventory Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.inventory.adjust') }}" class="btn-harvest inline-flex items-center space-x-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Adjust Stock</span>
                </a>
                <a href="{{ route('admin.purchase-orders.create') }}" class="btn-agri inline-flex items-center space-x-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>New Purchase Order</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-agri-50 border-l-4 border-agri-500 p-4 rounded-lg shadow-sm animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-agri-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-agri-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-agri-500 animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Products</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</p>
                            <p class="text-xs text-gray-500 mt-1">Active inventory items</p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-amber-500 animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Low Stock Items</p>
                            <p class="text-3xl font-bold text-amber-600 mt-1">{{ $lowStockCount }}</p>
                            <a href="{{ route('admin.inventory.low-stock') }}" class="text-xs text-amber-600 hover:text-amber-800 mt-1 inline-flex items-center">
                                View items
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="h-12 w-12 bg-amber-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-red-500 animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Out of Stock</p>
                            <p class="text-3xl font-bold text-red-600 mt-1">{{ $outOfStockCount }}</p>
                            <p class="text-xs text-gray-500 mt-1">Needs restocking</p>
                        </div>
                        <div class="h-12 w-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-harvest-500 animate-fade-in-up">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Value</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">KES {{ number_format($totalInventoryValue, 0) }}</p>
                            <p class="text-xs text-gray-500 mt-1">At cost price</p>
                        </div>
                        <div class="h-12 w-12 bg-harvest-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.inventory.movements') }}" class="card hover:shadow-lg transition-shadow duration-200 animate-fade-in-up">
                    <div class="card-body flex items-center space-x-4">
                        <div class="h-12 w-12 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Stock Movements</h3>
                            <p class="text-sm text-gray-600">View transaction history</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.inventory.low-stock') }}" class="card hover:shadow-lg transition-shadow duration-200 animate-fade-in-up">
                    <div class="card-body flex items-center space-x-4">
                        <div class="h-12 w-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Low Stock Report</h3>
                            <p class="text-sm text-gray-600">{{ $lowStockCount }} items need attention</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.inventory.reorder') }}" class="card hover:shadow-lg transition-shadow duration-200 animate-fade-in-up">
                    <div class="card-body flex items-center space-x-4">
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Reorder Report</h3>
                            <p class="text-sm text-gray-600">Items at reorder level</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Stock Status by Category -->
            @if($stockByCategory->count() > 0)
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Stock Status by Category
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Total Products</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">In Stock</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Low Stock</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Out of Stock</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Total Value</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($stockByCategory as $category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-semibold text-gray-900">{{ $category->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $category->products_count }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="badge badge-success">
                                                    {{ $category->in_stock_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="badge badge-warning">
                                                    {{ $category->low_stock_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="badge bg-red-100 text-red-800">
                                                    {{ $category->out_of_stock_count ?? 0 }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                KES {{ number_format($category->total_value ?? 0, 0) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Stock Movements -->
            @if($recentMovements && $recentMovements->count() > 0)
                <div class="card animate-fade-in-up">
                    <div class="card-header flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Recent Stock Movements
                            </h3>
                            <p class="text-sm text-white/90 mt-1">Latest inventory transactions</p>
                        </div>
                        <a href="{{ route('admin.inventory.movements') }}" class="text-white/90 hover:text-white text-sm font-medium">
                            View All →
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Date/Time</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Reference</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">User</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentMovements as $movement)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $movement->created_at->format('M d, H:i') }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $movement->product->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $movement->product->sku }}</div>
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
        </div>
    </div>
</x-admin-app-layout>
