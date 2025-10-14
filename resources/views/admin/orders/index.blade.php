<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Order Management
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Revenue</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['total_revenue'], 2) }}</p>
                                <p class="text-xs text-gray-500 mt-1">All time</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-50 to-green-100 px-6 py-2">
                        <p class="text-xs text-green-700 font-semibold">Today: KES {{ number_format($stats['today_revenue'], 2) }}</p>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Orders</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_orders']) }}</p>
                                <p class="text-xs text-gray-500 mt-1">All orders</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-2">
                        <p class="text-xs text-blue-700 font-semibold">{{ $stats['pos_sales_count'] }} Walk-in + {{ $stats['customer_orders_count'] }} Online</p>
                    </div>
                </div>

                <!-- POS Sales -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">POS Sales</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['pos_sales_count']) }}</p>
                                <p class="text-xs text-gray-500 mt-1">KES {{ number_format($stats['pos_sales_total'], 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-6 py-2">
                        <p class="text-xs text-orange-700 font-semibold">Walk-in customers</p>
                    </div>
                </div>

                <!-- Customer Orders -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Customer Orders</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['customer_orders_count']) }}</p>
                                <p class="text-xs text-gray-500 mt-1">KES {{ number_format($stats['customer_orders_total'], 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-2 flex justify-between text-xs">
                        <span class="text-yellow-700 font-semibold">Pending: {{ $stats['customer_orders_pending'] }}</span>
                        <span class="text-blue-700 font-semibold">Processing: {{ $stats['customer_orders_processing'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                            <input type="text" 
                                   name="search" 
                                   id="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Order number, customer name, phone..." 
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select name="status" 
                                    id="status" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                                <option value="">All Orders</option>
                                <option value="walk_in" {{ request('status') == 'walk_in' ? 'selected' : '' }}>Walk-in (POS)</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <!-- From Date -->
                        <div>
                            <label for="from_date" class="block text-sm font-semibold text-gray-700 mb-2">From Date</label>
                            <input type="date" 
                                   name="from_date" 
                                   id="from_date" 
                                   value="{{ request('from_date') }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- To Date -->
                        <div>
                            <label for="to_date" class="block text-sm font-semibold text-gray-700 mb-2">To Date</label>
                            <input type="date" 
                                   name="to_date" 
                                   id="to_date" 
                                   value="{{ request('to_date') }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                        </div>

                        <!-- Buttons -->
                        <div class="md:col-span-3 flex items-end space-x-3">
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-gradient-harvest text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span>Filter</span>
                                </span>
                            </button>
                            <a href="{{ route('admin.orders.index') }}" 
                               class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors duration-200 font-semibold">
                                Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- POS Sales Table (NOW FIRST!) -->
            @if(!request()->filled('status') || request('status') === 'walk_in')
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-6 py-4 border-b-2 border-orange-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>POS Sales (Walk-in)</span>
                        </h3>
                        <span class="px-3 py-1 bg-orange-600 text-white text-sm font-bold rounded-full">
                            {{ $sales->total() }} sales
                        </span>
                    </div>
                </div>

                @if($sales->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-gray-500 text-lg font-semibold">No POS sales found</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Receipt #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Cashier</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sales as $sale)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $sale->receipt_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        @if($sale->customer_name)
                                        <div class="font-semibold text-gray-900">{{ $sale->customer_name }}</div>
                                        @if($sale->customer_phone)
                                        <div class="text-gray-500">{{ $sale->customer_phone }}</div>
                                        @endif
                                        @else
                                        <span class="text-gray-400 italic">Walk-in customer</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-900">{{ $sale->user->name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $sale->saleItems->count() }} item(s)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">KES {{ number_format($sale->total_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($sale->payment_method === 'cash')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        Cash
                                    </span>
                                    @elseif($sale->payment_method === 'mpesa')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        M-Pesa
                                    </span>
                                    @elseif($sale->payment_method === 'card')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                        Card
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-purple-100 text-purple-800">
                                        Bank Transfer
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $sale->sale_date->format('M d, Y') }}</span>
                                    <div class="text-xs text-gray-500">{{ $sale->sale_date->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.orders.show-sale', $sale->id) }}" 
                                       class="text-harvest-600 hover:text-harvest-900 font-semibold">
                                        View
                                    </a>
                                    <a href="{{ route('admin.orders.print-sale', $sale->id) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900 font-semibold">
                                        Print
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50">
                    {{ $sales->links() }}
                </div>
                @endif
            </div>
            @endif

            <!-- Customer Orders Table (NOW SECOND!) -->
            @if(!request()->filled('status') || request('status') !== 'walk_in')
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b-2 border-purple-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Customer Orders (Online Shop)</span>
                        </h3>
                        <span class="px-3 py-1 bg-purple-600 text-white text-sm font-bold rounded-full">
                            {{ $orders->total() }} orders
                        </span>
                    </div>
                </div>

                @if($orders->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-gray-500 text-lg font-semibold">No customer orders found</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $order->order_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm">
                                        <div class="font-semibold text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-gray-500">{{ $order->user->email }}</div>
                                        @if($order->phone)
                                        <div class="text-gray-500">{{ $order->phone }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $order->orderItems->count() }} item(s)</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">KES {{ number_format($order->total_amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($order->status === 'pending')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @elseif($order->status === 'processing')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                        Processing
                                    </span>
                                    @elseif($order->status === 'completed')
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                    @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.orders.show-order', $order->id) }}" 
                                       class="text-harvest-600 hover:text-harvest-900 font-semibold">
                                        View
                                    </a>
                                    <a href="{{ route('admin.orders.print-order', $order->id) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900 font-semibold">
                                        Print
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50">
                    {{ $orders->links() }}
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-xl shadow-lg z-50">
        {{ session('error') }}
    </div>
    @endif
</x-admin-app-layout>
