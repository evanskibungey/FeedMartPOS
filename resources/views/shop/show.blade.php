<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('shop.index') }}" class="p-2 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                        {{ $product->name }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $product->category->name }} • {{ $product->brand->name }}</p>
                </div>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Product Image -->
                <div class="card">
                    <div class="card-body p-0">
                        <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 aspect-square">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-48 h-48 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="space-y-6">
                    <!-- Info Card -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Category & Brand -->
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="badge badge-agri">{{ $product->category->name }}</span>
                                <span class="badge badge-harvest">{{ $product->brand->name }}</span>
                            </div>

                            <!-- Product Name -->
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                            
                            <!-- SKU -->
                            <p class="text-sm text-gray-500 mb-4">SKU: {{ $product->sku }}</p>

                            <!-- Stock Status -->
                            <div class="mb-6">
                                @if($product->quantity_in_stock > 10)
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="font-semibold">In Stock ({{ $product->quantity_in_stock }} available)</span>
                                    </div>
                                @elseif($product->quantity_in_stock > 0)
                                    <div class="flex items-center text-yellow-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <span class="font-semibold">Low Stock (Only {{ $product->quantity_in_stock }} left)</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-red-600">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="font-semibold">Out of Stock</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Price -->
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <div class="flex items-baseline space-x-3">
                                    <span class="text-4xl font-bold text-agri-600">KES {{ number_format($product->price, 2) }}</span>
                                    @if($product->unit)
                                        <span class="text-gray-500">per {{ $product->unit }}</span>
                                    @endif
                                </div>
                                @if($product->tax_rate > 0)
                                    <p class="text-sm text-gray-500 mt-2">Tax: {{ $product->tax_rate }}% included</p>
                                @endif
                            </div>

                            <!-- Add to Cart Form -->
                            @if($product->quantity_in_stock > 0)
                                <form method="POST" action="{{ route('cart.add') }}" x-data="{ quantity: 1 }">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="mb-6">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                                        <div class="flex items-center space-x-4">
                                            <button type="button" 
                                                    @click="quantity = Math.max(1, quantity - 1)"
                                                    class="p-3 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            
                                            <input type="number" 
                                                   name="quantity" 
                                                   x-model="quantity"
                                                   min="1" 
                                                   max="{{ $product->quantity_in_stock }}"
                                                   class="input-field text-center text-2xl font-bold w-24">
                                            
                                            <button type="button" 
                                                    @click="quantity = Math.min({{ $product->quantity_in_stock }}, quantity + 1)"
                                                    class="p-3 rounded-lg border-2 border-gray-300 hover:border-agri-500 hover:bg-agri-50 transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-2">Maximum: {{ $product->quantity_in_stock }} units</p>
                                    </div>

                                    <button type="submit" class="btn-agri w-full text-lg py-4">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 text-center">
                                    <svg class="w-16 h-16 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <p class="text-red-700 font-semibold text-lg">This product is currently out of stock</p>
                                    <p class="text-red-600 text-sm mt-1">Check back later or browse similar products</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold">Product Information</h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Category</span>
                                    <span class="font-semibold text-gray-900">{{ $product->category->name }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Brand</span>
                                    <span class="font-semibold text-gray-900">{{ $product->brand->name }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-200">
                                    <span class="text-gray-600">SKU</span>
                                    <span class="font-mono text-gray-900">{{ $product->sku }}</span>
                                </div>
                                @if($product->unit)
                                    <div class="flex justify-between py-2 border-b border-gray-200">
                                        <span class="text-gray-600">Unit</span>
                                        <span class="font-semibold text-gray-900">{{ $product->unit }}</span>
                                    </div>
                                @endif
                                @if($product->barcode)
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-600">Barcode</span>
                                        <span class="font-mono text-gray-900">{{ $product->barcode }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($product->description)
                <div class="card mb-12">
                    <div class="card-header">
                        <h3 class="text-xl font-bold">Product Description</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Related Products</h2>
                        <a href="{{ route('shop.index', ['category' => $product->category_id]) }}" class="text-agri-600 hover:text-agri-700 font-semibold flex items-center">
                            View all in {{ $product->category->name }}
                            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="card group hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                                <!-- Product Image -->
                                <div class="relative overflow-hidden rounded-t-xl bg-gradient-to-br from-gray-100 to-gray-200 aspect-square">
                                    @if($relatedProduct->image_url)
                                        <img src="{{ $relatedProduct->image_url }}" alt="{{ $relatedProduct->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <!-- Stock Badge -->
                                    <div class="absolute top-3 right-3">
                                        @if($relatedProduct->quantity_in_stock > 10)
                                            <span class="badge badge-sm badge-success shadow-lg">In Stock</span>
                                        @elseif($relatedProduct->quantity_in_stock > 0)
                                            <span class="badge badge-sm badge-warning shadow-lg">Low Stock</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4">
                                    <!-- Brand -->
                                    <p class="text-xs text-gray-500 mb-1">{{ $relatedProduct->brand->name }}</p>
                                    
                                    <!-- Product Name -->
                                    <h3 class="text-sm font-bold text-gray-900 mb-2 group-hover:text-agri-600 transition-colors line-clamp-2">
                                        <a href="{{ route('shop.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                                    </h3>

                                    <!-- Price & Action -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                        <p class="text-lg font-bold text-agri-600">
                                            KES {{ number_format($relatedProduct->price, 2) }}
                                        </p>
                                        <a href="{{ route('shop.show', $relatedProduct->id) }}" 
                                           class="p-2 rounded-lg border-2 border-agri-200 text-agri-600 hover:bg-agri-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
