<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-gradient-agri rounded-2xl shadow-agri p-8 text-white animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}! 🌾</h3>
                        <p class="text-agri-50 text-lg">Here's what's happening with your store today.</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-32 h-32 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 4h14v-2H7v2zm0 4h14v-2H7v2zM7 7v2h14V7H7z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-in-right">
                <!-- Stat Card 1: Sales Today -->
                <div class="stat-card stat-card-agri group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Sales Today</p>
                            <p class="text-3xl font-bold text-gray-800">₱12,450</p>
                            <p class="text-agri-600 text-sm font-medium mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +12.5% from yesterday
                            </p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center text-white shadow-agri group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2: Orders -->
                <div class="stat-card stat-card-harvest group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-800">156</p>
                            <p class="text-harvest-600 text-sm font-medium mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +8.2% from last week
                            </p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-harvest rounded-xl flex items-center justify-center text-white shadow-harvest group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3: Products -->
                <div class="stat-card stat-card-earth group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Products</p>
                            <p class="text-3xl font-bold text-gray-800">1,248</p>
                            <p class="text-earth-600 text-sm font-medium mt-1">In stock</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-earth rounded-xl flex items-center justify-center text-white shadow-earth group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4: Customers -->
                <div class="stat-card stat-card-sky group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Active Customers</p>
                            <p class="text-3xl font-bold text-gray-800">892</p>
                            <p class="text-sky-600 text-sm font-medium mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                +15.3% this month
                            </p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4">
                            <button class="btn-agri text-left flex items-center justify-center space-x-2 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <span>New Sale</span>
                            </button>
                            <button class="btn-harvest text-left flex items-center justify-center space-x-2 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>Add Product</span>
                            </button>
                            <button class="btn-earth text-left flex items-center justify-center space-x-2 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>Add Customer</span>
                            </button>
                            <button class="bg-gradient-to-br from-sky-400 to-sky-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-left flex items-center justify-center space-x-2 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <span>View Reports</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Recent Activity
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-agri-50 transition-colors duration-200">
                                <div class="h-10 w-10 rounded-full bg-agri-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">New sale completed</p>
                                    <p class="text-xs text-gray-600">Order #1234 - ₱2,450</p>
                                    <p class="text-xs text-gray-500 mt-1">2 minutes ago</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-harvest-50 transition-colors duration-200">
                                <div class="h-10 w-10 rounded-full bg-harvest-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">New product added</p>
                                    <p class="text-xs text-gray-600">Premium Animal Feed - 50kg</p>
                                    <p class="text-xs text-gray-500 mt-1">15 minutes ago</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-sky-50 transition-colors duration-200">
                                <div class="h-10 w-10 rounded-full bg-sky-100 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-800">New customer registered</p>
                                    <p class="text-xs text-gray-600">Juan Dela Cruz</p>
                                    <p class="text-xs text-gray-500 mt-1">1 hour ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
