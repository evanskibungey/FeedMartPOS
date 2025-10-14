<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Financial Report
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
                <a href="{{ route('admin.reports.financial.export', request()->all()) }}" 
                   class="inline-flex items-center px-6 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 font-semibold shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export to Excel
                </a>
            </div>

            <!-- Date Range Filter -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <form method="GET" action="{{ route('admin.reports.financial') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="from_date" class="block text-sm font-semibold text-gray-700 mb-2">From Date</label>
                        <input type="date" 
                               name="from_date" 
                               id="from_date" 
                               value="{{ $fromDate }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                    </div>
                    <div>
                        <label for="to_date" class="block text-sm font-semibold text-gray-700 mb-2">To Date</label>
                        <input type="date" 
                               name="to_date" 
                               id="to_date" 
                               value="{{ $toDate }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full px-6 py-2.5 bg-gradient-harvest text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>

            <!-- Financial Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Total Revenue</p>
                                <p class="text-3xl font-bold text-green-600 mt-2">KES {{ number_format($totalRevenue, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-600">
                            <div>POS: KES {{ number_format($posRevenue, 2) }}</div>
                            <div>Orders: KES {{ number_format($orderRevenue, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Cost of Goods Sold -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">COGS</p>
                                <p class="text-3xl font-bold text-orange-600 mt-2">KES {{ number_format($totalCOGS, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-600">
                            Cost of Goods Sold
                        </div>
                    </div>
                </div>

                <!-- Gross Profit -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Gross Profit</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">KES {{ number_format($grossProfit, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-600">
                            Margin: {{ number_format($grossProfitMargin, 2) }}%
                        </div>
                    </div>
                </div>

                <!-- Tax Collected -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-100 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase">Tax Collected</p>
                                <p class="text-3xl font-bold text-purple-600 mt-2">KES {{ number_format($totalTax, 2) }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-3 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3 text-xs text-gray-600">
                            VAT & other taxes
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit & Loss Statement -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-harvest-50 to-agri-50 px-6 py-4 border-b-2 border-harvest-200">
                    <h3 class="text-lg font-bold text-gray-900">Profit & Loss Statement</h3>
                    <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($fromDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('M d, Y') }}</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Revenue Section -->
                        <div>
                            <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl">
                                <span class="font-bold text-gray-900">Revenue</span>
                                <span class="font-bold text-green-600">KES {{ number_format($totalRevenue, 2) }}</span>
                            </div>
                            <div class="ml-6 mt-2 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <span>POS Sales</span>
                                    <span>KES {{ number_format($posRevenue, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-700">
                                    <span>Customer Orders</span>
                                    <span>KES {{ number_format($orderRevenue, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-gray-200 pt-4">
                            <div class="flex justify-between items-center p-4 bg-orange-50 rounded-xl">
                                <span class="font-bold text-gray-900">Cost of Goods Sold</span>
                                <span class="font-bold text-orange-600">(KES {{ number_format($totalCOGS, 2) }})</span>
                            </div>
                        </div>

                        <div class="border-t-2 border-gray-200 pt-4">
                            <div class="flex justify-between items-center p-4 bg-blue-50 rounded-xl">
                                <span class="font-bold text-gray-900 text-lg">Gross Profit</span>
                                <span class="font-bold text-blue-600 text-lg">KES {{ number_format($grossProfit, 2) }}</span>
                            </div>
                            <div class="ml-6 mt-2">
                                <div class="flex justify-between text-gray-700">
                                    <span>Gross Profit Margin</span>
                                    <span class="font-semibold">{{ number_format($grossProfitMargin, 2) }}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-2 border-gray-200 pt-4">
                            <div class="flex justify-between items-center p-4 bg-purple-50 rounded-xl">
                                <span class="font-bold text-gray-900">Tax Collected</span>
                                <span class="font-bold text-purple-600">KES {{ number_format($totalTax, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown Chart -->
            <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Daily Revenue Trend</h3>
                <div class="space-y-2">
                    @php
                        $maxRevenue = collect($dailyRevenue)->max('amount');
                    @endphp
                    @foreach($dailyRevenue as $day)
                    <div class="flex items-center space-x-3">
                        <div class="w-16 text-sm text-gray-600 font-semibold">{{ $day['date'] }}</div>
                        <div class="flex-1 bg-gray-100 rounded-full h-8 relative overflow-hidden">
                            <div class="bg-gradient-harvest h-full rounded-full transition-all duration-500" 
                                 style="width: {{ $maxRevenue > 0 ? ($day['amount'] / $maxRevenue) * 100 : 0 }}%">
                            </div>
                            <div class="absolute inset-0 flex items-center justify-end pr-3">
                                <span class="text-xs font-bold text-gray-700">KES {{ number_format($day['amount'], 2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl shadow-lg border-2 border-green-200 p-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="bg-green-600 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Profit Performance</h4>
                    </div>
                    <p class="text-sm text-gray-700 mb-2">Gross profit margin indicates the percentage of revenue remaining after cost of goods sold.</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($grossProfitMargin, 2) }}%</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl shadow-lg border-2 border-blue-200 p-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Revenue Split</h4>
                    </div>
                    <p class="text-sm text-gray-700 mb-2">Distribution between POS and online orders.</p>
                    <div class="space-y-1">
                        <p class="text-sm"><span class="font-semibold">POS:</span> {{ $totalRevenue > 0 ? number_format(($posRevenue / $totalRevenue) * 100, 1) : 0 }}%</p>
                        <p class="text-sm"><span class="font-semibold">Online:</span> {{ $totalRevenue > 0 ? number_format(($orderRevenue / $totalRevenue) * 100, 1) : 0 }}%</p>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl shadow-lg border-2 border-purple-200 p-6">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="bg-purple-600 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Tax Rate</h4>
                    </div>
                    <p class="text-sm text-gray-700 mb-2">Effective tax rate on revenue.</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $totalRevenue > 0 ? number_format(($totalTax / $totalRevenue) * 100, 2) : 0 }}%</p>
                </div>
            </div>

        </div>
    </div>
</x-admin-app-layout>
