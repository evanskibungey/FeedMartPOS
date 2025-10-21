<x-admin-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Page Header with Action Button -->
            <x-page-header 
                title="Products" 
                :action="route('admin.products.create')" 
                actionLabel="Add New Product">
                <x-slot name="subtitle">
                    Manage your product inventory and pricing
                </x-slot>
            </x-page-header>
            @if(session('success'))
            <div class="bg-agri-50 border-l-4 border-agri-500 p-4 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-agri-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="text-agri-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="stat-card stat-card-harvest">
                    <p class="text-sm text-gray-600 mb-1">Total Products</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $products->total() }}</p>
                </div>
                <div class="stat-card stat-card-agri">
                    <p class="text-sm text-gray-600 mb-1">In Stock</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $products->where('quantity_in_stock', '>', 0)->count() }}</p>
                </div>
                <div class="stat-card stat-card-sky">
                    <p class="text-sm text-gray-600 mb-1">Low Stock</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $products->filter(fn($p) => $p->quantity_in_stock > 0 && $p->quantity_in_stock <= $p->reorder_level)->count() }}</p>
                </div>
                <div class="stat-card stat-card-earth">
                    <p class="text-sm text-gray-600 mb-1">Out of Stock</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $products->where('quantity_in_stock', '<=', 0)->count() }}</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                        <select name="category" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <select name="brand" class="px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-agri-500">
                            <option value="">All Brands</option>
                            @foreach($brands as $brd)
                            <option value="{{ $brd->id }}" {{ request('brand') == $brd->id ? 'selected' : '' }}>{{ $brd->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-harvest">Filter</button>
                    </form>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card">
                <div class="card-header"><h3 class="text-lg font-semibold">Product Inventory</h3></div>
                <div class="card-body p-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Product</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Category/Brand</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Price</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Stock</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($products as $product)
                                <tr class="hover:bg-agri-50/30">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" class="h-10 w-10 rounded-lg object-cover" alt="{{ $product->name }}">
                                            @else
                                            <div class="h-10 w-10 bg-gradient-harvest rounded-lg flex items-center justify-center">
                                                <span class="text-white text-xs font-bold">{{ substr($product->name, 0, 2) }}</span>
                                            </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                                                <div class="text-xs text-gray-500">SKU: {{ $product->sku }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div>{{ $product->category->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $product->brand->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold">KES {{ number_format($product->price, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold">{{ $product->quantity_in_stock }} {{ $product->unit }}</div>
                                        @if($product->quantity_in_stock <= 0)
                                            <span class="badge bg-red-100 text-red-800 text-xs">Out of Stock</span>
                                        @elseif($product->quantity_in_stock <= $product->reorder_level)
                                            <span class="badge badge-warning text-xs">Low Stock</span>
                                        @else
                                            <span class="badge badge-success text-xs">In Stock</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->status === 'active')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge bg-gray-100 text-gray-800">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.products.show', $product) }}" class="p-2 text-agri-600 hover:bg-agri-50 rounded-lg"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></a>
                                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="px-6 py-16 text-center">
                                    <div class="text-gray-400">No products found</div>
                                </td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($products->hasPages())
                    <div class="px-6 py-4 border-t bg-gray-50">{{ $products->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <x-fab-button :action="route('admin.products.create')" label="Add New Product" />
</x-admin-app-layout>
