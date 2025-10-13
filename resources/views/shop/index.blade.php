<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Shop') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Browse our quality agricultural products</p>
            </div>
            <!-- Cart Button -->
            <a href="{{ route('cart.index') }}" class="btn-agri relative">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                View Cart
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 h-6 w-6 bg-harvest-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse">
                        {{ $cartCount }}
                    </span>
                @endif
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

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-24">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Filters
                            </h3>
                        </div>
                        <div class="card-body space-y-6">
                            <!-- Search -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Search Products</label>
                                <form method="GET" action="{{ route('shop.index') }}">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                    <div class="relative">
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                               placeholder="Search by name or SKU..." 
                                               class="input-field pr-10">
                                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-agri-600 hover:text-agri-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Categories -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <div class="space-y-2">
                                    <a href="{{ route('shop.index', ['search' => request('search'), 'brand' => request('brand'), 'sort' => request('sort')]) }}" 
                                       class="block px-3 py-2 rounded-lg text-sm {{ !request('category') ? 'bg-agri-100 text-agri-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                                        All Categories
                                    </a>
                                    @foreach($categories as $category)
                                        <a href="{{ route('shop.index', ['category' => $category->id, 'search' => request('search'), 'brand' => request('brand'), 'sort' => request('sort')]) }}" 
                                           class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request('category') == $category->id ? 'bg-agri-100 text-agri-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                                            <span>{{ $category->name }}</span>
                                            <span class="badge badge-sm">{{ $category->products_count }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Brands -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Brand</label>
                                <div class="space-y-2">
                                    <a href="{{ route('shop.index', ['search' => request('search'), 'category' => request('category'), 'sort' => request('sort')]) }}" 
                                       class="block px-3 py-2 rounded-lg text-sm {{ !request('brand') ? 'bg-harvest-100 text-harvest-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                                        All Brands
                                    </a>
                                    @foreach($brands as $brand)
                                        <a href="{{ route('shop.index', ['brand' => $brand->id, 'search' => request('search'), 'category' => request('category'), 'sort' => request('sort')]) }}" 
                                           class="block px-3 py-2 rounded-lg text-sm {{ request('brand') == $brand->id ? 'bg-harvest-100 text-harvest-700 font-semibold' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                                            {{ $brand->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Clear Filters -->
                            @if(request()->hasAny(['category', 'brand', 'search', 'sort']))
                                <a href="{{ route('shop.index') }}" class="btn-earth w-full text-center">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear All Filters
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:col-span-3">
                    <!-- Toolbar -->
                    <div class="card mb-6">
                        <div class="card-body">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <p class="text-gray-700">
                                        <span class="font-semibold text-lg">{{ $products->total() }}</span> 
                                        <span class="text-gray-600">products found</span>
                                    </p>
                                </div>
                                <!-- Sort -->
                                <form method="GET" action="{{ route('shop.index') }}" class="flex items-center space-x-2">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <label class="text-sm text-gray-700 font-medium">Sort by:</label>
                                    <select name="sort" onchange="this.form.submit()" class="input-field py-2 text-sm">
                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Products -->
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="card group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden rounded-t-xl bg-gradient-to-br from-gray-100 to-gray-200 aspect-square">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                        @endif
                                        <!-- Category Badge -->
                                        <div class="absolute top-3 left-3">
                                            <span class="badge badge-sm bg-white/90 backdrop-blur-sm text-agri-700 shadow-lg">
                                                {{ $product->category->name }}
                                            </span>
                                        </div>
                                        <!-- Stock Badge -->
                                        <div class="absolute top-3 right-3">
                                            @if($product->quantity_in_stock > 10)
                                                <span class="badge badge-sm badge-success shadow-lg">In Stock</span>
                                            @elseif($product->quantity_in_stock > 0)
                                                <span class="badge badge-sm badge-warning shadow-lg">Low Stock</span>
                                            @else
                                                <span class="badge badge-sm badge-error shadow-lg">Out of Stock</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-5">
                                        <!-- Brand -->
                                        <p class="text-xs text-gray-500 mb-1">{{ $product->brand->name }}</p>
                                        
                                        <!-- Product Name -->
                                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-agri-600 transition-colors line-clamp-2">
                                            <a href="{{ route('shop.show', $product->id) }}">{{ $product->name }}</a>
                                        </h3>
                                        
                                        <!-- SKU -->
                                        <p class="text-xs text-gray-500 mb-3">SKU: {{ $product->sku }}</p>
                                        
                                        <!-- Description -->
                                        @if($product->description)
                                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $product->description }}</p>
                                        @endif

                                        <!-- Price & Actions -->
                                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                            <div>
                                                <p class="text-2xl font-bold text-agri-600">
                                                    KES {{ number_format($product->price, 2) }}
                                                </p>
                                                @if($product->unit)
                                                    <p class="text-xs text-gray-500">per {{ $product->unit }}</p>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('shop.show', $product->id) }}" 
                                                   class="p-2 rounded-lg border-2 border-agri-200 text-agri-600 hover:bg-agri-50 transition-colors"
                                                   title="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                @if($product->quantity_in_stock > 0)
                                                    <form method="POST" action="{{ route('cart.add') }}">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" 
                                                                class="p-2 rounded-lg bg-gradient-agri text-white hover:shadow-lg transition-all"
                                                                title="Add to Cart">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button disabled class="p-2 rounded-lg bg-gray-300 text-gray-500 cursor-not-allowed" title="Out of Stock">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="card">
                            <div class="card-body text-center py-16">
                                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No Products Found</h3>
                                <p class="text-gray-600 mb-6">Try adjusting your filters or search criteria</p>
                                <a href="{{ route('shop.index') }}" class="btn-agri inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Clear Filters
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
