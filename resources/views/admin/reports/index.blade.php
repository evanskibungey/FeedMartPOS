<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Reports Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Today's Sales -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Today's Sales</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['today_sales'] + $stats['today_orders'], 2) }}</p>
                                <p class="text-xs text-gray-500 mt-1">POS + Online Orders</p>
                            </div>
                            <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Sales -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">This Month</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">KES {{ number_format($stats['month_sales'] + $stats['month_orders'], 2) }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->format('F Y') }}</p>
                            </div>
                            <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory Status -->
                <div class="bg-white rounded-2xl shadow-lg border-2 border-orange-100 hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Inventory</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_products']) }}</p>
                                <p class="text-xs text-gray-500 mt-1">Total Products</p>
                            </div>
                            <div class="bg-gradient-to-br from-orange-400 to-orange-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                        @if($stats['low_stock_products'] > 0)
                        <div class="mt-3 px-3 py-2 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-xs text-red-700 font-semibold">⚠️ {{ $stats['low_stock_products'] }} products low on stock</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Report Types -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Sales Reports -->
                <a href="{{ route('admin.reports.sales') }}" class="block group">
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-purple-100 hover:border-purple-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-br from-purple-400 to-purple-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">Sales Report</h3>
                                    <p class="text-sm text-gray-600 mt-1">Comprehensive sales analysis</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        POS & Online Sales
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Payment Methods
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Top Products
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Cashier Performance
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-4 py-2 bg-purple-50 text-purple-700 rounded-xl font-semibold group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                    View Report
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Inventory Reports -->
                <a href="{{ route('admin.reports.inventory') }}" class="block group">
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-br from-blue-400 to-blue-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">Inventory Report</h3>
                                    <p class="text-sm text-gray-600 mt-1">Stock levels & movements</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Stock Levels
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Low Stock Alerts
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Stock Movements
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Inventory Value
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-xl font-semibold group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                    View Report
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Financial Reports -->
                <a href="{{ route('admin.reports.financial') }}" class="block group">
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-green-100 hover:border-green-300 hover:shadow-xl transition-all duration-300 overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-br from-green-400 to-green-600 p-4 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">Financial Report</h3>
                                    <p class="text-sm text-gray-600 mt-1">Revenue & profitability</p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Revenue Analysis
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Cost of Goods Sold
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Gross Profit
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Tax Collected
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <span class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-xl font-semibold group-hover:bg-green-600 group-hover:text-white transition-colors">
                                    View Report
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Help Section -->
            <div class="bg-gradient-to-r from-harvest-50 to-agri-50 rounded-2xl shadow-lg border-2 border-harvest-200 p-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <svg class="w-8 h-8 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">About Reports</h3>
                        <p class="text-gray-700">
                            Access comprehensive business insights through our reporting system. Each report provides detailed analytics to help you make informed decisions about your business operations, inventory management, and financial performance.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-app-layout>
