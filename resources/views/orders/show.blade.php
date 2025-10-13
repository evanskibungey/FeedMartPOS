<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('orders.index') }}" class="p-2 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                        Order {{ $order->order_number }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                </div>
            </div>
            <span class="badge badge-lg {{ $order->getStatusBadgeClass() }}">
                {{ $order->getStatusText() }}
            </span>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-xl font-bold">Order Items</h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                        <!-- Product Image -->
                                        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gradient-to-br from-gray-200 to-gray-300">
                                            @if($item->product && $item->product->image_url)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" 
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $item->product_name }}</h4>
                                            <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                                                <span>Unit Price: KES {{ number_format($item->unit_price, 2) }}</span>
                                                <span>Quantity: {{ $item->quantity }}</span>
                                                @if($item->tax_rate > 0)
                                                    <span>Tax: {{ $item->tax_rate }}%</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="text-sm text-gray-600">Subtotal</p>
                                            <p class="text-lg font-bold text-gray-900">KES {{ number_format($item->subtotal, 2) }}</p>
                                            @if($item->tax_amount > 0)
                                                <p class="text-xs text-gray-500">+ Tax: KES {{ number_format($item->tax_amount, 2) }}</p>
                                            @endif
                                            <p class="text-xl font-bold text-agri-600 mt-1">KES {{ number_format($item->total, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="card">
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
                            <div>
                                <label class="text-sm font-semibold text-gray-700">Phone Number</label>
                                <p class="text-gray-900 mt-1">{{ $order->phone }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-semibold text-gray-700">Delivery Address</label>
                                <p class="text-gray-900 mt-1">{{ $order->delivery_address }}</p>
                            </div>
                            @if($order->notes)
                                <div>
                                    <label class="text-sm font-semibold text-gray-700">Order Notes</label>
                                    <p class="text-gray-600 mt-1 italic">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-header">
                            <h3 class="text-xl font-bold">Order Summary</h3>
                        </div>
                        <div class="card-body space-y-4">
                            <!-- Order Info -->
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Order Number</span>
                                    <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Order Date</span>
                                    <span class="font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Status</span>
                                    <span class="badge {{ $order->getStatusBadgeClass() }}">{{ $order->getStatusText() }}</span>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4 space-y-3">
                                <div class="flex justify-between text-gray-700">
                                    <span>Subtotal</span>
                                    <span class="font-semibold">KES {{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                
                                @if($order->tax > 0)
                                    <div class="flex justify-between text-gray-700">
                                        <span>Tax</span>
                                        <span class="font-semibold">KES {{ number_format($order->tax, 2) }}</span>
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
                                    <span class="text-2xl font-bold text-agri-600">KES {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>

                            <!-- Status Timeline -->
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">Order Timeline</h4>
                                <div class="space-y-3">
                                    <!-- Placed -->
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Order Placed</p>
                                            <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Processing -->
                                    @if($order->isProcessing() || $order->isCompleted())
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Processing</p>
                                                <p class="text-xs text-gray-500">Order is being prepared</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-start space-x-3 opacity-50">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-600">Processing</p>
                                                <p class="text-xs text-gray-500">Pending</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Completed -->
                                    @if($order->isCompleted())
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">Completed</p>
                                                <p class="text-xs text-gray-500">{{ $order->completed_at ? $order->completed_at->format('M d, Y h:i A') : 'Delivered' }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-start space-x-3 opacity-50">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-600">Completed</p>
                                                <p class="text-xs text-gray-500">Pending</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Cancelled -->
                                    @if($order->isCancelled())
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-semibold text-red-900">Cancelled</p>
                                                <p class="text-xs text-red-600">{{ $order->cancelled_at ? $order->cancelled_at->format('M d, Y h:i A') : 'Order cancelled' }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="border-t border-gray-200 pt-4 space-y-3">
                                @if($order->isPending())
                                    <form method="POST" action="{{ route('orders.cancel', $order->id) }}" 
                                          onsubmit="return confirm('Are you sure you want to cancel this order? This action cannot be undone.')">
                                        @csrf
                                        <button type="submit" class="btn-earth w-full bg-red-600 hover:bg-red-700 border-red-700 text-white">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Cancel Order
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('orders.index') }}" class="btn-earth w-full text-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Back to Orders
                                </a>

                                <a href="{{ route('shop.index') }}" class="btn-agri w-full text-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    Continue Shopping
                                </a>
                            </div>

                            <!-- Help -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700 font-semibold mb-2">Need Help?</p>
                                <p class="text-xs text-gray-600 mb-3">Contact our support team for assistance with your order.</p>
                                <div class="space-y-1">
                                    <p class="text-xs text-agri-600 font-semibold">📞 +254 123 456 789</p>
                                    <p class="text-xs text-agri-600 font-semibold">📧 support@feedmart.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
