<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
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
            <!-- Welcome Banner -->
            <div class="bg-gradient-agri rounded-2xl shadow-agri p-8 text-white animate-fade-in-up">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="space-y-2 mb-4 md:mb-0">
                        <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}! 🌾</h3>
                        <p class="text-agri-50 text-lg">Thank you for choosing FeedMart for your agricultural needs.</p>
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn-earth bg-white text-agri-600 hover:bg-agri-50 border-white inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Start Shopping
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-in-right">
                <!-- Total Orders -->
                <div class="stat-card stat-card-agri group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Orders</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_orders'] }}</p>
                            <p class="text-agri-600 text-sm font-medium mt-1">All time</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center text-white shadow-agri group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="stat-card stat-card-harvest group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Pending Orders</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['pending_orders'] }}</p>
                            <p class="text-harvest-600 text-sm font-medium mt-1">Awaiting processing</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-harvest rounded-xl flex items-center justify-center text-white shadow-harvest group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="stat-card stat-card-sky group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Processing</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['processing_orders'] }}</p>
                            <p class="text-sky-600 text-sm font-medium mt-1">In preparation</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="stat-card stat-card-earth group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Spent</p>
                            <p class="text-3xl font-bold text-gray-800">KES {{ number_format($stats['total_spent'], 0) }}</p>
                            <p class="text-earth-600 text-sm font-medium mt-1">All completed orders</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-earth rounded-xl flex items-center justify-center text-white shadow-earth group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Orders -->
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
                            <a href="{{ route('shop.index') }}" class="btn-agri text-center flex flex-col items-center justify-center py-6 group">
                                <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                <span>Browse Products</span>
                            </a>
                            
                            <a href="{{ route('cart.index') }}" class="btn-harvest text-center flex flex-col items-center justify-center py-6 group">
                                <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>View Cart</span>
                            </a>
                            
                            <a href="{{ route('orders.index') }}" class="btn-earth text-center flex flex-col items-center justify-center py-6 group">
                                <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>My Orders</span>
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-sky-400 to-sky-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center flex flex-col items-center justify-center py-6 group">
                                <svg class="w-8 h-8 mb-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>My Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="card">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Recent Orders
                            </h3>
                            <a href="{{ route('orders.index') }}" class="text-sm text-agri-600 hover:text-agri-700 font-semibold">
                                View All →
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($recentOrders->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentOrders as $order)
                                    <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-agri-50 transition-colors duration-200">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full {{ $order->isPending() ? 'bg-yellow-100' : ($order->isProcessing() ? 'bg-blue-100' : ($order->isCompleted() ? 'bg-green-100' : 'bg-red-100')) }} flex items-center justify-center">
                                            @if($order->isPending())
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif($order->isProcessing())
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                                </svg>
                                            @elseif($order->isCompleted())
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-1">
                                                <p class="text-sm font-semibold text-gray-800">{{ $order->order_number }}</p>
                                                <span class="badge badge-sm {{ $order->getStatusBadgeClass() }}">{{ $order->getStatusText() }}</span>
                                            </div>
                                            <p class="text-xs text-gray-600">{{ $order->orderItems->count() }} {{ $order->orderItems->count() == 1 ? 'item' : 'items' }} • KES {{ number_format($order->total_amount, 2) }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->diffForHumans() }}</p>
                                        </div>
                                        <a href="{{ route('orders.show', $order->id) }}" class="flex-shrink-0 p-2 text-agri-600 hover:bg-agri-100 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-gray-600 text-sm mb-3">No orders yet</p>
                                <a href="{{ route('shop.index') }}" class="text-agri-600 hover:text-agri-700 text-sm font-semibold">
                                    Start Shopping →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Support Card -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h-12 w-12 bg-agri-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Customer Support</h4>
                        <p class="text-sm text-gray-600 mb-3">Need help? Our team is here for you</p>
                        <p class="text-xs text-agri-600 font-semibold">📞 +254 123 456 789</p>
                    </div>
                </div>

                <!-- Quality Card -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h-12 w-12 bg-harvest-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Quality Guaranteed</h4>
                        <p class="text-sm text-gray-600 mb-3">All products tested & certified</p>
                        <p class="text-xs text-harvest-600 font-semibold">100% Quality Assured</p>
                    </div>
                </div>

                <!-- Delivery Card -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="h-12 w-12 bg-earth-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Fast Delivery</h4>
                        <p class="text-sm text-gray-600 mb-3">Quick delivery to your doorstep</p>
                        <p class="text-xs text-earth-600 font-semibold">Free Shipping Available</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
