<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="h-16 w-1 bg-gradient-agri rounded-full"></div>
                <div>
                    <h2 class="font-bold text-4xl text-gray-900 leading-tight bg-gradient-to-r from-agri-600 to-harvest-600 bg-clip-text text-transparent">
                        {{ __('Shopping Cart') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1.5 text-agri-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Review your items before checkout
                    </p>
                </div>
            </div>
            <!-- Continue Shopping Button - Far Right -->
            <a href="{{ route('shop.index') }}" class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-earth-500 to-earth-600 text-white font-bold rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-earth-400 to-earth-500 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center space-x-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-lg">Continue Shopping</span>
                </div>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cart as $productId => $item)
                            <div class="card animate-fade-in-up">
                                <div class="card-body">
                                    <div class="flex flex-col md:flex-row gap-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <div class="w-32 h-32 rounded-lg overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                                                @if($item['image'])
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900">{{ $item['name'] }}</h3>
                                                    <p class="text-sm text-gray-500">SKU: {{ $item['sku'] }}</p>
                                                </div>
                                                <!-- Remove Button -->
                                                <form method="POST" action="{{ route('cart.remove') }}">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                                    <button type="submit" 
                                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                            title="Remove from cart">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mt-4">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center space-x-3">
                                                    <span class="text-sm text-gray-600 font-medium">Quantity:</span>
                                                    <form method="POST" action="{{ route('cart.update') }}" class="flex items-center space-x-2">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                                        <input type="hidden" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">
                                                        <button type="submit" 
                                                                class="p-2 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all"
                                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    
                                                    <span class="text-lg font-bold text-gray-900 w-12 text-center">{{ $item['quantity'] }}</span>
                                                    
                                                    <form method="POST" action="{{ route('cart.update') }}" class="flex items-center space-x-2">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                                        <input type="hidden" name="quantity" value="{{ min($item['max_stock'], $item['quantity'] + 1) }}">
                                                        <button type="submit" 
                                                                class="p-2 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all"
                                                                {{ $item['quantity'] >= $item['max_stock'] ? 'disabled' : '' }}>
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>

                                                <!-- Price Info -->
                                                <div class="text-right">
                                                    <p class="text-sm text-gray-600">Unit Price: {{ \App\Models\Setting::formatCurrency($item['unit_price']) }}</p>
                                                    <p class="text-xl font-bold text-agri-600">{{ \App\Models\Setting::formatCurrency($item['total']) }}</p>
                                                    @if($item['tax_rate'] > 0)
                                                        <p class="text-xs text-gray-500">Incl. Tax ({{ $item['tax_rate'] }}%)</p>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($item['quantity'] >= $item['max_stock'])
                                                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-lg p-2">
                                                    <p class="text-xs text-yellow-800 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                        </svg>
                                                        Maximum available quantity reached
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart Button -->
                        <div class="flex justify-between items-center">
                            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                                @csrf
                                <button type="submit" class="btn-earth">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="card sticky top-24">
                            <div class="card-header">
                                <h3 class="text-xl font-bold">Order Summary</h3>
                            </div>
                            <div class="card-body space-y-4">
                                <!-- Summary Details -->
                                <div class="space-y-3">
                                    <div class="flex justify-between text-gray-700">
                                        <span>Items ({{ $cartCount }})</span>
                                        <span class="font-semibold">{{ \App\Models\Setting::formatCurrency($subtotal) }}</span>
                                    </div>
                                    
                                    @if($tax > 0)
                                        <div class="flex justify-between text-gray-700">
                                            <span>Tax</span>
                                            <span class="font-semibold">{{ \App\Models\Setting::formatCurrency($tax) }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="border-t border-gray-300 pt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-gray-900">Total</span>
                                            <span class="text-2xl font-bold text-agri-600">{{ \App\Models\Setting::formatCurrency($total) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkout Button -->
                                @auth
                                    <a href="{{ route('checkout') }}" class="btn-agri w-full text-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Proceed to Checkout
                                    </a>
                                @else
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                                        <p class="text-blue-800 text-sm mb-3">Please login to checkout</p>
                                        <a href="{{ route('login') }}" class="btn-agri w-full text-center">
                                            Login to Continue
                                        </a>
                                        <p class="text-xs text-gray-600 mt-2">
                                            Don't have an account? 
                                            <a href="{{ route('register') }}" class="text-agri-600 hover:underline font-semibold">Register</a>
                                        </p>
                                    </div>
                                @endauth

                                <!-- Features -->
                                <div class="space-y-3 pt-4 border-t border-gray-200">
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <p class="text-sm text-gray-600">Quality guaranteed products</p>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <p class="text-sm text-gray-600">Fast delivery to your location</p>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <p class="text-sm text-gray-600">Secure checkout process</p>
                                    </div>
                                </div>

                                <!-- Help -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-700 font-semibold mb-2">Need Help?</p>
                                    <p class="text-xs text-gray-600">Contact our support team for assistance with your order.</p>
                                    <p class="text-xs text-agri-600 font-semibold mt-2">📞 +254 123 456 789</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="card">
                    <div class="card-body text-center py-16">
                        <svg class="w-32 h-32 mx-auto text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Your cart is empty</h3>
                        <p class="text-gray-600 mb-6">Looks like you haven't added any products to your cart yet.</p>
                        <a href="{{ route('shop.index') }}" class="btn-agri inline-flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Start Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
