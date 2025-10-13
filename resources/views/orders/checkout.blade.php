<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">Complete your order</p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Customer Information -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h3 class="text-xl font-bold flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Customer Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                                        <input type="text" value="{{ Auth::user()->name }}" disabled 
                                               class="input-field bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                        <input type="email" value="{{ Auth::user()->email }}" disabled 
                                               class="input-field bg-gray-50">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="card mb-6">
                            <div class="card-header">
                                <h3 class="text-xl font-bold flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Delivery Information
                                </h3>
                            </div>
                            <div class="card-body space-y-4">
                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Phone Number <span class="text-red-500">*</span>
                                    </label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', Auth::user()->phone) }}" 
                                           required
                                           placeholder="+254 712 345 678"
                                           class="input-field @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Delivery Address -->
                                <div>
                                    <label for="delivery_address" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Delivery Address <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="delivery_address" 
                                              name="delivery_address" 
                                              rows="3" 
                                              required
                                              placeholder="Enter your complete delivery address including street, building, city, and any landmarks..."
                                              class="input-field resize-none @error('delivery_address') border-red-500 @enderror">{{ old('delivery_address') }}</textarea>
                                    @error('delivery_address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">Please provide a complete address for accurate delivery</p>
                                </div>

                                <!-- Order Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                                        Order Notes (Optional)
                                    </label>
                                    <textarea id="notes" 
                                              name="notes" 
                                              rows="2" 
                                              placeholder="Any special instructions for your order..."
                                              class="input-field resize-none @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('cart.index') }}" class="btn-earth text-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back to Cart
                            </a>
                            <button type="submit" class="btn-agri flex-1 text-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-header">
                            <h3 class="text-xl font-bold">Order Summary</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <!-- Cart Items -->
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @foreach($cart as $item)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <div class="w-16 h-16 flex-shrink-0 rounded-lg overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300">
                                            @if($item['image'])
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item['name'] }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }} × KES {{ number_format($item['unit_price'], 2) }}</p>
                                            <p class="text-sm font-bold text-agri-600">KES {{ number_format($item['total'], 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal ({{ $cartCount }} items)</span>
                                    <span class="font-semibold">KES {{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                @if($tax > 0)
                                    <div class="flex justify-between text-gray-700">
                                        <span>Tax</span>
                                        <span class="font-semibold">KES {{ number_format($tax, 2) }}</span>
                                    </div>
                                @endif

                                <div class="flex justify-between text-gray-700">
                                    <span>Delivery</span>
                                    <span class="font-semibold text-green-600">Free</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-300 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-agri-600">KES {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Security Notice -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start space-x-2">
                                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-semibold text-blue-900">Secure Checkout</p>
                                        <p class="text-xs text-blue-700 mt-1">Your information is protected and secure</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
