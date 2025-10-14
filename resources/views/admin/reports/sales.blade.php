<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Sales Report
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
                <a href="{{ route('admin.reports.sales.export', request()->all()) }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export to Excel
                </a>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.reports.sales') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Period Selection -->
                        <div>
                            <label for="period" class="block text-sm font-semibold text-gray-700 mb-2">Period</label>
                            <select name="period" 
                                    id="period" 
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500"
                                    onchange="toggleCustomDates(this.value)">
                                <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="week" {{ $period == 'week' ? 'selected' : '' }}>This Week</option>
                                <option value="month" {{ $period == 'month' ? 'selected' : '' }}>This Month</option>
                                <option value="year" {{ $period == 'year' ? 'selected' : '' }}>This Year</option>
                                <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom Range</option>
                            </select>
                        </div>

                        <!-- From Date -->
                        <div id="from-date-div" style="{{ $period != 'custom' ? 'display:none' : '' }}">
                            <label for="from_date" class="block text-sm font-semibold text-gray-700 mb-2">From Date</label>
                            <input type="date" 
                                   name="from_date" 
                                   id="from_date" 
                                   value="{{ $fromDate }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                        </div>

                        <!-- To Date -->
                        <div id="to-date-div" style="{{ $period != 'custom' ? 'display:none' : '' }}">
                            <label for="to_date" class="block text-sm font-semibold text-gray-700 mb-2">To Date</label>
                            <input type="date" 
                                   name="to_date" 
                                   id="to_date" 
                                   value="{{ $toDate }}"
                                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                        </div>

                        <!-- Filter Button -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full px-6 py-2.5 bg-gradient-harvest text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Total Revenue</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($totalRevenue, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Transactions</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalTransactions) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Transaction -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Avg Transaction</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($averageTransaction, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Items -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Items Sold</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalItems) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- POS vs Online -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Revenue by Source</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-orange-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="bg-orange-600 p-2 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">POS Sales</p>
                                    <p class="text-sm text-gray-600">Walk-in customers</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">KES {{ number_format($posTotalRevenue, 2) }}</p>
                                <p class="text-sm text-gray-600">{{ $totalRevenue > 0 ? number_format(($posTotalRevenue / $totalRevenue) * 100, 1) : 0 }}%</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-purple-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <div class="bg-purple-600 p-2 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Online Orders</p>
                                    <p class="text-sm text-gray-600">Customer orders</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-gray-900">KES {{ number_format($ordersTotalRevenue, 2) }}</p>
                                <p class="text-sm text-gray-600">{{ $totalRevenue > 0 ? number_format(($ordersTotalRevenue / $totalRevenue) * 100, 1) : 0 }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Payment Methods (POS)</h3>
                    <div class="space-y-3">
                        @foreach($salesByPayment as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center space-x-3">
                                @if($payment->payment_method === 'cash')
                                <div class="bg-green-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                @elseif($payment->payment_method === 'mpesa')
                                <div class="bg-green-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                @elseif($payment->payment_method === 'card')
                                <div class="bg-blue-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                @else
                                <div class="bg-purple-600 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                    </svg>
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ ucfirst($payment->payment_method === 'mpesa' ? 'M-Pesa' : $payment->payment_method) }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment->count }} transactions</p>
                                </div>
                            </div>
                            <p class="font-bold text-gray-900">KES {{ number_format($payment->total, 2) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Selling Products -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-harvest-50 to-agri-50 px-6 py-4 border-b-2 border-harvest-200">
                    <h3 class="text-lg font-bold text-gray-900">Top Selling Products</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">#</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Quantity Sold</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($topProducts as $index => $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $index + 1 }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $product->product_name }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($product->total_quantity) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">KES {{ number_format($product->total_revenue, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cashier Performance -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b-2 border-blue-200">
                    <h3 class="text-lg font-bold text-gray-900">Cashier Performance (POS Sales)</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Cashier</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Transactions</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Total Sales</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Avg Transaction</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($salesByCashier as $cashier)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-gray-900">{{ $cashier->user->name }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">{{ number_format($cashier->transactions) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-green-600">KES {{ number_format($cashier->total, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-sm font-bold text-gray-900">KES {{ number_format($cashier->total / $cashier->transactions, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleCustomDates(period) {
            const fromDiv = document.getElementById('from-date-div');
            const toDiv = document.getElementById('to-date-div');
            
            if (period === 'custom') {
                fromDiv.style.display = 'block';
                toDiv.style.display = 'block';
            } else {
                fromDiv.style.display = 'none';
                toDiv.style.display = 'none';
            }
        }
    </script>
</x-admin-app-layout>
