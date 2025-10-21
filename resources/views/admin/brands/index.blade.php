<x-admin-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Page Header with Action Button -->
            <x-page-header 
                title="Product Brands" 
                :action="route('admin.brands.create')" 
                actionLabel="Add New Brand">
                <x-slot name="subtitle">
                    Manage your product brands and manufacturers
                </x-slot>
            </x-page-header>
            <!-- Success Message -->
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-harvest-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Brands</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $brands->total() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-harvest-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-agri-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Active Brands</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $brands->where('is_active', true)->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 shadow-sm border-l-4 border-sky-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">With Products</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $brands->where('products_count', '>', 0)->count() }}</p>
                        </div>
                        <div class="h-12 w-12 bg-sky-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brands Grid -->
            <div class="card animate-fade-in-up">
                <div class="card-header flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                            Product Brands
                        </h3>
                        <p class="text-sm text-white/90 mt-1">Manage your product brands and manufacturers</p>
                    </div>
                </div>
                <div class="card-body">
                    @if($brands->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($brands as $brand)
                                <div class="bg-white border-2 border-gray-200 rounded-xl p-6 hover:border-harvest-300 hover:shadow-lg transition-all duration-200 group">
                                    <!-- Brand Logo/Icon -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-shrink-0">
                                            @if($brand->logo)
                                                <img src="{{ Storage::url($brand->logo) }}" alt="{{ $brand->name }}" class="h-16 w-16 object-contain rounded-lg border border-gray-200">
                                            @else
                                                <div class="h-16 w-16 bg-gradient-harvest rounded-lg flex items-center justify-center shadow-md">
                                                    <span class="text-white font-bold text-xl">{{ substr($brand->name, 0, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            @if($brand->is_active)
                                                <span class="badge badge-success text-xs">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-gray-100 text-gray-800 text-xs">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Brand Info -->
                                    <div class="mb-4">
                                        <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $brand->name }}</h4>
                                        @if($brand->description)
                                            <p class="text-sm text-gray-600 line-clamp-2">{{ $brand->description }}</p>
                                        @else
                                            <p class="text-sm text-gray-400 italic">No description</p>
                                        @endif
                                    </div>

                                    <!-- Brand Stats -->
                                    <div class="flex items-center justify-between py-3 border-t border-gray-200 mb-4">
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Products</p>
                                            <p class="text-lg font-bold text-gray-900">{{ $brand->products_count }}</p>
                                        </div>
                                        <div class="h-8 w-px bg-gray-200"></div>
                                        <div class="text-center">
                                            <p class="text-xs text-gray-500">Since</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $brand->created_at->format('M Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.brands.edit', $brand) }}" class="flex-1 px-4 py-2 bg-sky-50 text-sky-700 rounded-lg font-semibold hover:bg-sky-100 transition-colors duration-200 text-center text-sm">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.brands.toggle-status', $brand) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 {{ $brand->is_active ? 'bg-harvest-50 text-harvest-700 hover:bg-harvest-100' : 'bg-agri-50 text-agri-700 hover:bg-agri-100' }} rounded-lg font-semibold transition-colors duration-200 text-sm" onclick="return confirm('Toggle status?')">
                                                {{ $brand->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Delete" onclick="return confirm('Are you sure you want to delete this brand?')">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($brands->hasPages())
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                {{ $brands->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No brands found</h3>
                            <p class="text-gray-600 mb-6">Get started by creating your first product brand.</p>
                            <a href="{{ route('admin.brands.create') }}" class="btn-agri inline-flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Create First Brand</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <x-fab-button :action="route('admin.brands.create')" label="Add New Brand" />
</x-admin-app-layout>
