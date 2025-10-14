<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            Customer Order Details
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Orders
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Order Header -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 px-6 py-4 border-b-2 border-purple-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Order Date: {{ $order->created_at->format('F d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    @if($order->status === 'pending')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @elseif($order->status === 'processing')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                        Processing
                                    </span>
                                    @elseif($order->status === 'completed')
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                    @else
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Order Items</h4>
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex-1">
                                        <h5 class="font-bold text-gray-900">{{ $item->product_name }}</h5>
                                        <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            KES {{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">KES {{ number_format($item->total, 2) }}</p>
                                        @if($item->tax_amount > 0)
                                        <p class="text-xs text-gray-500">Tax: KES {{ number_format($item->tax_amount, 2) }}</p>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Order Totals -->
                            <div class="mt-6 pt-6 border-t-2 border-gray-200 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <span class="font-semibold">Subtotal:</span>
                                    <span class="font-bold">KES {{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if($order->tax > 0)
                                <div class="flex justify-between text-gray-700">
                                    <span class="font-semibold">Tax:</span>
                                    <span class="font-bold">KES {{ number_format($order->tax, 2) }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t border-gray-300">
                                    <span>Total:</span>
                                    <span>KES {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    @if($order->delivery_address || $order->notes)
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Delivery Information</span>
                        </h4>
                        @if($order->delivery_address)
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-600 mb-1">Delivery Address</p>
                            <p class="text-gray-900">{{ $order->delivery_address }}</p>
                        </div>
                        @endif
                        @if($order->notes)
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Order Notes</p>
                            <p class="text-gray-900">{{ $order->notes }}</p>
                        </div>
                        @endif
                    </div>
                    @endif

                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Customer Information</span>
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Name</p>
                                <p class="text-gray-900 font-semibold">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Email</p>
                                <p class="text-gray-900">{{ $order->user->email }}</p>
                            </div>
                            @if($order->phone)
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Phone</p>
                                <p class="text-gray-900">{{ $order->phone }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Update Order Status -->
                    @if(!$order->isCancelled())
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Update Status</h4>
                        <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Change Status</label>
                                    <select name="status" 
                                            id="status" 
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-harvest-500 focus:ring-harvest-500">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <button type="submit" 
                                        class="w-full px-4 py-2.5 bg-gradient-harvest text-white rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-semibold">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Order Timeline -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Order Timeline</h4>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Order Created</p>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            
                            @if($order->completed_at)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Order Completed</p>
                                    <p class="text-sm text-gray-600">{{ $order->completed_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endif

                            @if($order->cancelled_at)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Order Cancelled</p>
                                    <p class="text-sm text-gray-600">{{ $order->cancelled_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Actions</h4>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders.print-order', $order->id) }}" 
                               target="_blank"
                               class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-200 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Order
                            </a>
                        </div>
                    </div>

                </div>

            </div>
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
