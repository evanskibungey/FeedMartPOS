<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            POS Sale Details
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
                
                <!-- Main Sale Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Sale Header -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-50 to-orange-100 px-6 py-4 border-b-2 border-orange-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $sale->receipt_number }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Sale Date: {{ $sale->sale_date->format('F d, Y h:i A') }}</p>
                                </div>
                                <div>
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Sale Items -->
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Sale Items</h4>
                            <div class="space-y-4">
                                @foreach($sale->saleItems as $item)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex-1">
                                        <h5 class="font-bold text-gray-900">{{ $item->product_name }}</h5>
                                        <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            KES {{ number_format($item->unit_price, 2) }} × {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900">KES {{ number_format($item->subtotal, 2) }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Sale Totals -->
                            <div class="mt-6 pt-6 border-t-2 border-gray-200 space-y-2">
                                <div class="flex justify-between text-gray-700">
                                    <span class="font-semibold">Subtotal:</span>
                                    <span class="font-bold">KES {{ number_format($sale->subtotal, 2) }}</span>
                                </div>
                                @if($sale->tax_amount > 0)
                                <div class="flex justify-between text-gray-700">
                                    <span class="font-semibold">Tax ({{ number_format($sale->tax_rate, 2) }}%):</span>
                                    <span class="font-bold">KES {{ number_format($sale->tax_amount, 2) }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t border-gray-300">
                                    <span>Total:</span>
                                    <span>KES {{ number_format($sale->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($sale->notes)
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <span>Sale Notes</span>
                        </h4>
                        <p class="text-gray-900">{{ $sale->notes }}</p>
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
                        @if($sale->customer_name || $sale->customer_phone)
                        <div class="space-y-3">
                            @if($sale->customer_name)
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Name</p>
                                <p class="text-gray-900 font-semibold">{{ $sale->customer_name }}</p>
                            </div>
                            @endif
                            @if($sale->customer_phone)
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Phone</p>
                                <p class="text-gray-900">{{ $sale->customer_phone }}</p>
                            </div>
                            @endif
                        </div>
                        @else
                        <p class="text-gray-500 italic">Walk-in customer (no details provided)</p>
                        @endif
                    </div>

                    <!-- Cashier Information -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Cashier Information</span>
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Cashier</p>
                                <p class="text-gray-900 font-semibold">{{ $sale->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Email</p>
                                <p class="text-gray-900">{{ $sale->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <span>Payment Information</span>
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Payment Method</p>
                                <p class="text-gray-900 font-semibold">
                                    @if($sale->payment_method === 'cash')
                                        Cash
                                    @elseif($sale->payment_method === 'mpesa')
                                        M-Pesa
                                    @elseif($sale->payment_method === 'card')
                                        Card
                                    @else
                                        Bank Transfer
                                    @endif
                                </p>
                            </div>
                            @if($sale->payment_reference)
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Reference</p>
                                <p class="text-gray-900">{{ $sale->payment_reference }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sale Statistics -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Sale Statistics</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-semibold text-gray-600">Total Items:</span>
                                <span class="text-gray-900 font-bold">{{ $sale->saleItems->sum('quantity') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm font-semibold text-gray-600">Unique Products:</span>
                                <span class="text-gray-900 font-bold">{{ $sale->saleItems->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-2xl shadow-lg border-2 border-gray-100 p-6">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Actions</h4>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders.print-sale', $sale->id) }}" 
                               target="_blank"
                               class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors duration-200 font-semibold">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Print Receipt
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-admin-app-layout>
