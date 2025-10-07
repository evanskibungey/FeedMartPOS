<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.suppliers.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                </a>
                <div>
                    <h2 class="font-bold text-3xl text-gray-800">{{ $supplier->name }}</h2>
                    <p class="text-sm text-gray-600">Supplier Details</p>
                </div>
            </div>
            <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn-harvest inline-flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Supplier</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="stat-card stat-card-harvest">
                    <p class="text-sm text-gray-600 mb-1">Products</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $supplier->products->count() }}</p>
                </div>
                <div class="stat-card stat-card-agri">
                    <p class="text-sm text-gray-600 mb-1">Purchase Orders</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $supplier->purchaseOrders->count() }}</p>
                </div>
                <div class="stat-card stat-card-sky">
                    <p class="text-sm text-gray-600 mb-1">Status</p>
                    @if($supplier->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge bg-gray-100 text-gray-800">Inactive</span>
                    @endif
                </div>
                <div class="stat-card stat-card-earth">
                    <p class="text-sm text-gray-600 mb-1">Member Since</p>
                    <p class="text-lg font-bold text-gray-800">{{ $supplier->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Contact Information -->
                <div class="lg:col-span-1">
                    <div class="card">
                        <div class="card-header"><h3 class="text-lg font-semibold">Contact Information</h3></div>
                        <div class="card-body space-y-4">
                            @if($supplier->contact_name)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Contact Person</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $supplier->contact_name }}</p>
                            </div>
                            @endif
                            @if($supplier->phone)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Phone</p>
                                <p class="text-sm text-gray-900">{{ $supplier->phone }}</p>
                            </div>
                            @endif
                            @if($supplier->email)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Email</p>
                                <p class="text-sm text-gray-900">{{ $supplier->email }}</p>
                            </div>
                            @endif
                            @if($supplier->address)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Address</p>
                                <p class="text-sm text-gray-900">{{ $supplier->address }}</p>
                            </div>
                            @endif
                            @if($supplier->city)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">City</p>
                                <p class="text-sm text-gray-900">{{ $supplier->city }}</p>
                            </div>
                            @endif
                            @if($supplier->payment_terms)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Payment Terms</p>
                                <p class="text-sm text-gray-900">{{ $supplier->payment_terms }}</p>
                            </div>
                            @endif
                            @if($supplier->notes)
                            <div>
                                <p class="text-xs text-gray-500 uppercase">Notes</p>
                                <p class="text-sm text-gray-900">{{ $supplier->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Purchase Orders -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="card-header"><h3 class="text-lg font-semibold">Recent Purchase Orders</h3></div>
                        <div class="card-body p-0">
                            @if($supplier->purchaseOrders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Order#</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($supplier->purchaseOrders as $po)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm"><a href="{{ route('admin.purchase-orders.show', $po) }}" class="text-sky-600 hover:text-sky-800 font-semibold">{{ $po->order_number }}</a></td>
                                            <td class="px-6 py-4 text-sm text-gray-600">{{ $po->order_date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">KES {{ number_format($po->total_amount, 2) }}</td>
                                            <td class="px-6 py-4">
                                                @if($po->status === 'received')
                                                    <span class="badge badge-success">Received</span>
                                                @elseif($po->status === 'ordered')
                                                    <span class="badge badge-warning">Ordered</span>
                                                @elseif($po->status === 'draft')
                                                    <span class="badge bg-gray-100 text-gray-800">Draft</span>
                                                @else
                                                    <span class="badge bg-red-100 text-red-800">Cancelled</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-12">
                                <p class="text-gray-500">No purchase orders yet</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            @if($supplier->products->count() > 0)
            <div class="card">
                <div class="card-header"><h3 class="text-lg font-semibold">Supplied Products ({{ $supplier->products->count() }})</h3></div>
                <div class="card-body">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($supplier->products as $product)
                        <div class="p-4 border border-gray-200 rounded-lg hover:border-agri-300 transition">
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $product->sku }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-app-layout>
