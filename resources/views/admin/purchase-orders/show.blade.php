<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.purchase-orders.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Purchase Order Details') }}
                </h2>
            </div>
            <div class="flex items-center space-x-2">
                @if($purchaseOrder->status === 'draft')
                    <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}" class="px-4 py-2 bg-white text-harvest-600 border-2 border-harvest-300 rounded-lg font-semibold hover:bg-harvest-50 inline-flex items-center space-x-2 transition-colors duration-200">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Order</span>
                    </a>
                    <form action="{{ route('admin.purchase-orders.mark-ordered', $purchaseOrder) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="btn-agri inline-flex items-center space-x-2" onclick="return confirm('Mark this purchase order as ORDERED?\n\nThis means you have sent the order to the supplier.\n\nYou will NOT be able to edit it after this.')">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Mark as Ordered</span>
                        </button>
                    </form>
                @endif
                @if($purchaseOrder->status === 'ordered')
                    <button type="button" onclick="document.getElementById('receiveModal').classList.remove('hidden')" class="btn-agri inline-flex items-center space-x-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Receive Items</span>
                    </button>
                @endif
            </div>
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

            <!-- PO Header Card -->
            <div class="bg-gradient-harvest text-white rounded-xl p-6 shadow-lg animate-fade-in-up">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-4 md:space-y-0">
                    <div>
                        <h3 class="text-3xl font-bold">{{ $purchaseOrder->order_number }}</h3>
                        <div class="flex items-center space-x-4 mt-2">
                            <span class="text-white/80">Order Date: {{ $purchaseOrder->order_date ? $purchaseOrder->order_date->format('M d, Y') : 'N/A' }}</span>
                            @if($purchaseOrder->expected_date)
                                <span class="text-white/80">• Expected: {{ $purchaseOrder->expected_date->format('M d, Y') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($purchaseOrder->status === 'draft')
                            <span class="badge bg-white/20 text-white border border-white/30 text-lg px-4 py-2">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Draft
                            </span>
                        @elseif($purchaseOrder->status === 'ordered')
                            <span class="badge bg-sky-100 text-sky-800 text-lg px-4 py-2">
                                <svg class="w-5 h-5 inline mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Ordered (Awaiting Delivery)
                            </span>
                        @elseif($purchaseOrder->status === 'received')
                            <span class="badge badge-success text-lg px-4 py-2">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Received
                            </span>
                        @else
                            <span class="badge bg-red-100 text-red-800 text-lg px-4 py-2">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelled
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Supplier Information -->
                <div class="card animate-fade-in-up">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Supplier Details
                        </h3>
                    </div>
                    <div class="card-body space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Company Name</p>
                            <p class="text-gray-900 font-semibold">{{ $purchaseOrder->supplier->name }}</p>
                        </div>

                        @if($purchaseOrder->supplier->contact_name)
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Contact Person</p>
                                <p class="text-gray-900">{{ $purchaseOrder->supplier->contact_name }}</p>
                            </div>
                        @endif

                        @if($purchaseOrder->supplier->phone)
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Phone</p>
                                <p class="text-gray-900 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $purchaseOrder->supplier->phone }}
                                </p>
                            </div>
                        @endif

                        @if($purchaseOrder->supplier->email)
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Email</p>
                                <p class="text-gray-900 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $purchaseOrder->supplier->email }}
                                </p>
                            </div>
                        @endif

                        @if($purchaseOrder->supplier->address || $purchaseOrder->supplier->city)
                            <div>
                                <p class="text-sm text-gray-600 font-medium">Address</p>
                                <p class="text-gray-900 text-sm">
                                    @if($purchaseOrder->supplier->address)
                                        {{ $purchaseOrder->supplier->address }}<br>
                                    @endif
                                    {{ $purchaseOrder->supplier->city }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="card animate-fade-in-up">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Order Items
                            </h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Quantity Ordered</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Unit Price</th>
                                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($purchaseOrder->items as $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        @if($item->product->image)
                                                            <img src="{{ Storage::url($item->product->image) }}" class="h-10 w-10 rounded-lg object-cover mr-3" alt="{{ $item->product->name }}">
                                                        @else
                                                            <div class="h-10 w-10 bg-gradient-harvest rounded-lg flex items-center justify-center mr-3">
                                                                <span class="text-white text-xs font-bold">{{ substr($item->product->name, 0, 2) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="text-sm font-semibold text-gray-900">{{ $item->product->name }}</div>
                                                            <div class="text-xs text-gray-500">SKU: {{ $item->product->sku }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($item->quantity_ordered) }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">{{ $item->product->unit }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    KES {{ number_format($item->purchase_price, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                    KES {{ number_format($item->subtotal, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-right font-bold text-gray-700 text-lg">Total Amount:</td>
                                            <td class="px-6 py-4 font-bold text-2xl text-agri-600">KES {{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($purchaseOrder->notes || $purchaseOrder->received_date)
                        <div class="card animate-fade-in-up">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Additional Information
                                </h3>
                            </div>
                            <div class="card-body space-y-4">
                                @if($purchaseOrder->notes)
                                    <div>
                                        <p class="text-sm text-gray-600 font-medium mb-2">Notes</p>
                                        <p class="text-gray-900 text-sm bg-gray-50 p-3 rounded-lg">{{ $purchaseOrder->notes }}</p>
                                    </div>
                                @endif

                                @if($purchaseOrder->received_date)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t">
                                        <div>
                                            <p class="text-sm text-gray-600 font-medium">Received Date</p>
                                            <p class="text-gray-900 font-semibold">{{ $purchaseOrder->received_date->format('M d, Y H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-medium">Received By</p>
                                            <p class="text-gray-900 font-semibold">{{ $purchaseOrder->creator->name }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="card animate-fade-in-up">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Record Information
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-gray-600">Created By:</span>
                                    <span class="font-medium text-gray-900">{{ $purchaseOrder->creator->name }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <span class="text-gray-600">Created:</span>
                                    <span class="font-medium text-gray-900">{{ $purchaseOrder->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="text-gray-600">Last Updated:</span>
                                    <span class="font-medium text-gray-900">{{ $purchaseOrder->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Receive Items Modal -->
    @if($purchaseOrder->status === 'ordered')
    <div id="receiveModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-2xl font-bold text-gray-900">Receive Purchase Order Items</h3>
                <button onclick="document.getElementById('receiveModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.purchase-orders.receive', $purchaseOrder) }}" method="POST" class="mt-4">
                @csrf
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @foreach($purchaseOrder->items as $item)
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    @if($item->product->image)
                                        <img src="{{ Storage::url($item->product->image) }}" class="h-12 w-12 rounded-lg object-cover" alt="{{ $item->product->name }}">
                                    @else
                                        <div class="h-12 w-12 bg-gradient-harvest rounded-lg flex items-center justify-center">
                                            <span class="text-white text-sm font-bold">{{ substr($item->product->name, 0, 2) }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-600">Ordered</p>
                                    <p class="font-bold text-gray-900">{{ number_format($item->quantity_ordered) }} {{ $item->product->unit }}</p>
                                </div>
                            </div>
                            
                            <input type="hidden" name="items[{{ $loop->index }}][item_id]" value="{{ $item->id }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantity Received <span class="text-red-500">*</span>
                                </label>
                                <input type="number" 
                                       name="items[{{ $loop->index }}][quantity_received]" 
                                       value="{{ $item->quantity_ordered }}"
                                       min="0" 
                                       max="{{ $item->quantity_ordered }}"
                                       required
                                       class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500 focus:ring-2 focus:ring-agri-200">
                                <p class="text-xs text-gray-500 mt-1">Enter 0 if this item was not delivered</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="document.getElementById('receiveModal').classList.add('hidden')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" class="btn-agri">
                        <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Confirm Receipt & Update Stock
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</x-admin-app-layout>
