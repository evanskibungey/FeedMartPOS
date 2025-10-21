<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            
            <!-- Welcome Message -->
            <div class="bg-gradient-harvest rounded-2xl shadow-harvest p-4 sm:p-6 lg:p-8 text-white animate-fade-in-up">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="space-y-3 w-full md:w-auto">
                        <h3 class="text-xl sm:text-2xl font-bold">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-harvest-50 text-sm sm:text-base">Here's what's happening with your business today</p>
                        <div class="flex flex-col sm:flex-row gap-3 mt-4">
                            <div class="bg-white/20 px-3 sm:px-4 py-2 rounded-lg flex-1 sm:flex-none">
                                <span class="text-xs sm:text-sm font-semibold">Today's Revenue</span>
                                <p class="text-lg sm:text-2xl font-bold">KES {{ number_format($revenueStats['today_revenue'], 2) }}</p>
                            </div>
                            <div class="bg-white/20 px-3 sm:px-4 py-2 rounded-lg flex-1 sm:flex-none">
                                <span class="text-xs sm:text-sm font-semibold">Today's Transactions</span>
                                <p class="text-lg sm:text-2xl font-bold">{{ $revenueStats['today_transactions'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block flex-shrink-0">
                        <svg class="w-24 sm:w-32 h-24 sm:h-32 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Primary Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 animate-slide-in-right">
                
                <!-- Total Revenue -->
                <div class="stat-card stat-card-harvest group cursor-pointer hover:scale-105 transition-transform duration-300 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                        <div class="min-w-0 flex-1">
                            <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Total Revenue</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800 truncate">KES {{ number_format($revenueStats['total_revenue'], 0) }}</p>
                            <p class="text-xs sm:text-sm font-medium mt-1 flex items-center {{ $monthComparison['growth_percentage'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $monthComparison['growth_percentage'] >= 0 ? 'M5 10l7-7m0 0l7 7m-7-7v18' : 'M19 14l-7 7m0 0l-7-7m7 7V3' }}" />
                                </svg>
                                <span class="truncate">{{ number_format(abs($monthComparison['growth_percentage']), 1) }}% vs last month</span>
                            </p>
                        </div>
                        <div class="h-12 w-12 sm:h-16 sm:w-16 bg-gradient-harvest rounded-xl flex items-center justify-center text-white shadow-harvest group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Transactions -->
                <div class="stat-card stat-card-agri group cursor-pointer hover:scale-105 transition-transform duration-300 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                        <div class="min-w-0 flex-1">
                            <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Total Transactions</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800 truncate">{{ number_format($revenueStats['total_transactions']) }}</p>
                            <p class="text-agri-600 text-xs sm:text-sm font-medium mt-1 truncate">
                                Orders: {{ $orderStats['total_orders'] }} | Sales: {{ $salesStats['total_sales'] }}
                            </p>
                        </div>
                        <div class="h-12 w-12 sm:h-16 sm:w-16 bg-gradient-agri rounded-xl flex items-center justify-center text-white shadow-agri group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="stat-card stat-card-sky group cursor-pointer hover:scale-105 transition-transform duration-300 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                        <div class="min-w-0 flex-1">
                            <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Total Products</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800 truncate">{{ $productStats['total_products'] }}</p>
                            <p class="text-sky-600 text-xs sm:text-sm font-medium mt-1 truncate">
                                Active: {{ $productStats['active_products'] }}
                            </p>
                        </div>
                        <div class="h-12 w-12 sm:h-16 sm:w-16 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="stat-card group cursor-pointer hover:scale-105 transition-transform duration-300 p-4 sm:p-6 {{ $orderStats['pending_orders'] > 0 ? 'border-l-4 border-yellow-500' : '' }}">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                        <div class="min-w-0 flex-1">
                            <p class="text-gray-600 text-xs sm:text-sm font-medium mb-1">Pending Orders</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800 truncate">{{ $orderStats['pending_orders'] }}</p>
                            <p class="text-yellow-600 text-xs sm:text-sm font-medium mt-1">
                                Needs attention
                            </p>
                        </div>
                        <div class="h-12 w-12 sm:h-16 sm:w-16 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                            <svg class="w-6 sm:w-8 h-6 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6">
                <a href="{{ route('admin.users.index') }}" class="block w-full">
                    <button class="btn-harvest w-full text-left flex items-center justify-between group py-2.5 sm:py-3 px-3 sm:px-6 text-sm sm:text-base">
                        <span class="flex items-center min-w-0">
                            <svg class="w-5 h-5 mr-2 sm:mr-3 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="truncate">Manage Users</span>
                        </span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>

                <a href="{{ route('admin.products.index') }}" class="block w-full">
                    <button class="btn-agri w-full text-left flex items-center justify-between group py-2.5 sm:py-3 px-3 sm:px-6 text-sm sm:text-base">
                        <span class="flex items-center min-w-0">
                            <svg class="w-5 h-5 mr-2 sm:mr-3 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="truncate">Manage Products</span>
                        </span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>

                <a href="{{ route('pos.dashboard') }}" class="block w-full">
                    <button class="bg-gradient-to-br from-sky-400 to-sky-600 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 w-full text-left flex items-center justify-between group py-2.5 sm:py-3 px-3 sm:px-6 text-sm sm:text-base">
                        <span class="flex items-center min-w-0">
                            <svg class="w-5 h-5 mr-2 sm:mr-3 flex-shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="truncate">Open POS Terminal</span>
                        </span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </a>
            </div>

        </div>
    </div>
</x-admin-app-layout>
