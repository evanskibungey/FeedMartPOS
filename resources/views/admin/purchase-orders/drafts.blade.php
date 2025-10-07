<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight flex items-center">
                    <svg class="w-8 h-8 mr-3 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Draft Purchase Orders') }}
                </h2>
                <p class="text-sm text-gray-600 mt-2">Review and approve draft purchase orders before sending to suppliers</p>
            </div>
            <a href="{{ route('admin.purchase-orders.create') }}" class="btn-agri inline-flex items-center justify-center space-x-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Create New PO</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-agri-50 border-l-4 border-agri-500 p-4 rounded-lg shadow-sm animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-agri-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-agri-800 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-red-800 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Stats Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-harvest-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Total Draft Orders</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $draftOrders->total() }}</p>
                            <p class="text-xs text-gray-500 mt-1">Awaiting approval</p>
                        </div>
                        <div class="h-16 w-16 bg-harvest-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Total Value</p>
                            <p class="text-3xl font-bold text-agri-600">KES {{ number_format($draftOrders->sum('total_amount'), 2) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Pending commitment</p>
                        </div>
                        <div class="h-16 w-16 bg-agri-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border-l-4 border-sky-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-1">Total Items</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $draftOrders->sum('items_count') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Products to order</p>
                        </div>
                        <div class="h-16 w-16 bg-sky-100 rounded-xl flex items-center justify-center">
                            <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Draft Purchase Orders List -->
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Draft Purchase Orders Queue
                            </h3>
                            <p class="text-sm text-white/90 mt-1">Review details and approve orders to send to suppliers</p>
                        </div>
                        <a href="{{ route('admin.purchase-orders.index') }}" class="text-sm text-white/90 hover:text-white underline">
                            View All Purchase Orders →
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($draftOrders as $po)
                        <div class="border-b border-gray-200 last:border-b-0 hover:bg-harvest-50/20 transition-colors duration-150">
                            <div class="p-6">
                                <!-- PO Header -->
                                <div class="flex flex-col md:flex-row md:items-start md:justify-between space-y-4 md:space-y-0 mb-4">
                                    <div class="flex items-start space-x-4">
                                        <div class="h-12 w-12 rounded-xl bg-gradient-harvest flex items-center justify-center shadow-md flex-shrink-0">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900">{{ $po->order_number }}</h4>
                                            <div class="flex items-center space-x-4 mt-1 text-sm text-gray-600">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                    {{ $po->supplier->name }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $po->order_date ? $po->order_date->format('M d, Y') : 'N/A' }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    By {{ $po->creator->name }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-agri-600">KES {{ number_format($po->total_amount, 2) }}</p>
                                        <p class="text-sm text-gray-500">{{ $po->items_count }} {{ Str::plural('item', $po->items_count) }}</p>
                                    </div>
                                </div>

                                <!-- Items Preview -->
                                <div class="mb-4 bg-gray-50 rounded-lg p-4">
                                    <p class="text-xs font-semibold text-gray-600 uppercase mb-3">Order Items:</p>
                                    <div class="space-y-2">
                                        @foreach($po->items->take(3) as $item)
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="flex items-center space-x-2">
                                                    @if($item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}" class="h-8 w-8 rounded object-cover" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-8 w-8 bg-harvest-200 rounded flex items-center justify-center">
                                                            <span class="text-harvest-700 text-xs font-bold">{{ substr($item->product->name, 0, 2) }}</span>
                                                        </div>
                                                    @endif
                                                    <span class="font-medium text-gray-900">{{ $item->product->name }}</span>
                                                </div>
                                                <div class="flex items-center space-x-4">
                                                    <span class="text-gray-600">{{ number_format($item->quantity_ordered) }} {{ $item->product->unit }}</span>
                                                    <span class="font-semibold text-gray-900">KES {{ number_format($item->subtotal, 2) }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                        @if($po->items->count() > 3)
                                            <p class="text-xs text-gray-500 italic">+ {{ $po->items->count() - 3 }} more items...</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Notes -->
                                @if($po->notes)
                                    <div class="mb-4 bg-sky-50 border-l-4 border-sky-400 p-3 rounded">
                                        <p class="text-xs font-semibold text-sky-800 uppercase mb-1">Notes:</p>
                                        <p class="text-sm text-sky-900">{{ $po->notes }}</p>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                    <div class="flex items-center space-x-2">
                                        <span class="badge bg-gray-100 text-gray-800">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Draft
                                        </span>
                                        @if($po->expected_date)
                                            <span class="text-xs text-gray-600">Expected: {{ $po->expected_date->format('M d') }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.purchase-orders.show', $po) }}" 
                                           class="px-4 py-2 bg-white text-gray-700 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 inline-flex items-center space-x-2 transition-colors duration-200">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>View Details</span>
                                        </a>
                                        <a href="{{ route('admin.purchase-orders.edit', $po) }}" 
                                           class="px-4 py-2 bg-white text-sky-600 border-2 border-sky-300 rounded-lg font-semibold hover:bg-sky-50 inline-flex items-center space-x-2 transition-colors duration-200">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                        <form action="{{ route('admin.purchase-orders.mark-ordered', $po) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn-agri"
                                                    onclick="return confirm('✅ Mark this Purchase Order as ORDERED?\n\n📋 Order: {{ $po->order_number }}\n🏢 Supplier: {{ $po->supplier->name }}\n💰 Total: KES {{ number_format($po->total_amount, 2) }}\n\nThis will:\n• Lock the order (no more edits)\n• Send it to the supplier\n• Move it to active purchase orders\n\nProceed?')">
                                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>Mark as Ordered</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-16 text-center">
                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Draft Purchase Orders</h3>
                            <p class="text-gray-600 mb-6 max-w-md mx-auto">
                                All purchase orders have been processed, or you haven't created any drafts yet.
                            </p>
                            <div class="flex items-center justify-center space-x-4">
                                <a href="{{ route('admin.purchase-orders.create') }}" class="btn-agri inline-flex items-center space-x-2">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    <span>Create Purchase Order</span>
                                </a>
                                <a href="{{ route('admin.purchase-orders.index') }}" class="px-6 py-3 bg-white text-gray-700 border-2 border-gray-300 rounded-lg font-semibold hover:bg-gray-50 inline-flex items-center space-x-2">
                                    <span>View All Orders</span>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if($draftOrders->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $draftOrders->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-gradient-to-r from-sky-50 to-agri-50 rounded-xl p-6 border border-sky-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center shadow-md">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold text-gray-900 mb-2">📋 How Draft Purchase Orders Work</h4>
                        <div class="space-y-2 text-sm text-gray-700">
                            <p><strong>1. Create:</strong> New purchase orders start as drafts - you can edit, modify, or delete them.</p>
                            <p><strong>2. Review:</strong> This page shows all drafts waiting for approval. Check items, quantities, and total amounts.</p>
                            <p><strong>3. Approve:</strong> Click "Mark as Ordered" to send the order to the supplier. Once ordered, you cannot edit it.</p>
                            <p><strong>4. Track:</strong> Ordered POs move to the main Purchase Orders list where you can track delivery and receive items.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
