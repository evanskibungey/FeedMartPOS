<x-admin-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Page Header with Action Button -->
            <x-page-header 
                title="Purchase Orders" 
                :action="route('admin.purchase-orders.create')" 
                actionLabel="Create Purchase Order">
                <x-slot name="subtitle">
                    Manage your purchase orders and inventory procurement
                </x-slot>
            </x-page-header>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-harvest-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $purchaseOrders->total() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-harvest-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-sky-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Draft Orders</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $purchaseOrders->where('status', 'draft')->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Ordered</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $purchaseOrders->where('status', 'ordered')->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-earth-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Received</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $purchaseOrders->where('status', 'received')->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-earth-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-earth-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card animate-fade-in-up">
                <div class="card-body">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <input type="text" name="search" placeholder="Search by PO number..." value="{{ request('search') }}" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                        
                        <select name="supplier" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                            <option value="">All Suppliers</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                            <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From Date" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200">

                        <button type="submit" class="btn-harvest">
                            <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filter
                        </button>
                    </form>
                </div>
            </div>

            <!-- Purchase Orders Table -->
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Purchase Orders
                    </h3>
                    <p class="text-sm text-white/90 mt-1">Manage your purchase orders and inventory procurement</p>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        PO Number
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Supplier
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Order Date
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Expected
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Total Amount
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($purchaseOrders as $po)
                                    <tr class="hover:bg-agri-50/30 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-lg bg-gradient-harvest flex items-center justify-center shadow-md">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $po->order_number }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ $po->items_count }} {{ Str::plural('item', $po->items_count) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $po->supplier->name }}
                                            </div>
                                            @if($po->supplier->phone)
                                                <div class="text-xs text-gray-500">
                                                    {{ $po->supplier->phone }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $po->order_date ? $po->order_date->format('M d, Y') : '—' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $po->expected_date ? $po->expected_date->format('M d, Y') : '—' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">
                                                KES {{ number_format($po->total_amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($po->status === 'draft')
                                                <span class="badge bg-gray-100 text-gray-800">
                                                    <span class="h-2 w-2 rounded-full bg-gray-600 mr-1"></span>
                                                    Draft
                                                </span>
                                            @elseif($po->status === 'ordered')
                                                <span class="badge bg-sky-100 text-sky-800">
                                                    <span class="h-2 w-2 rounded-full bg-sky-600 animate-pulse mr-1"></span>
                                                    Ordered
                                                </span>
                                            @elseif($po->status === 'received')
                                                <span class="badge badge-success">
                                                    <span class="h-2 w-2 rounded-full bg-agri-600 mr-1"></span>
                                                    Received
                                                </span>
                                            @else
                                                <span class="badge bg-red-100 text-red-800">
                                                    <span class="h-2 w-2 rounded-full bg-red-600 mr-1"></span>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <!-- View Button -->
                                                <a href="{{ route('admin.purchase-orders.show', $po) }}" 
                                                   class="p-2 text-agri-600 hover:text-agri-800 hover:bg-agri-50 rounded-lg transition-colors duration-200" 
                                                   title="View Details">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                @if($po->status === 'draft')
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.purchase-orders.edit', $po) }}" 
                                                       class="p-2 text-sky-600 hover:text-sky-800 hover:bg-sky-50 rounded-lg transition-colors duration-200" 
                                                       title="Edit">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <!-- Mark as Ordered Button -->
                                                    <form action="{{ route('admin.purchase-orders.mark-ordered', $po) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="p-2 text-agri-600 hover:text-agri-800 hover:bg-agri-50 rounded-lg transition-colors duration-200"
                                                                title="Mark as Ordered"
                                                                onclick="return confirm('Mark this PO as ORDERED?\nYou will not be able to edit it after this.')">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($po->status === 'ordered')
                                                    <!-- View to Receive -->
                                                    <span class="text-xs text-sky-600 font-semibold">Click "View" to receive items</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-16">
                                            <div class="text-center">
                                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No purchase orders found</h3>
                                                <p class="text-gray-600 mb-6">Create your first purchase order to start managing inventory.</p>
                                                <a href="{{ route('admin.purchase-orders.create') }}" class="btn-agri inline-flex items-center space-x-2">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                    <span>Create Purchase Order</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($purchaseOrders->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                            {{ $purchaseOrders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <x-fab-button :action="route('admin.purchase-orders.create')" label="Create Purchase Order" />
</x-admin-app-layout>
