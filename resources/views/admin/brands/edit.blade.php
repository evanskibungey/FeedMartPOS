<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.brands.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                    {{ __('Edit Brand') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">{{ $brand->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                Brand Information
                            </h3>
                            <p class="text-sm text-white/90 mt-1">Update the details of this brand</p>
                        </div>
                        <div class="text-sm text-white/80">
                            <span>ID: #{{ $brand->id }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.brands.update', $brand) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Brand Name -->
                        <div>
                            <x-input-label for="name" :value="__('Brand Name')" class="required" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="name" 
                                    class="pl-12 block w-full" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name', $brand->name)" 
                                    required 
                                    autofocus 
                                    placeholder="e.g., Unga Farm Care, Pembe, Jubilee Feeds" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Enter the brand or manufacturer name</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <div class="mt-2">
                                <textarea 
                                    id="description" 
                                    name="description" 
                                    rows="4"
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none"
                                    placeholder="Provide information about this brand or manufacturer (optional)">{{ old('description', $brand->description) }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Optional: Add details about the brand</p>
                        </div>

                        <!-- Logo Upload -->
                        <div x-data="{ 
                            logoPreview: '{{ $brand->logo ? Storage::url($brand->logo) : '' }}',
                            fileName: '',
                            hasExistingLogo: {{ $brand->logo ? 'true' : 'false' }},
                            handleFileSelect(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    this.fileName = file.name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.logoPreview = e.target.result;
                                        this.hasExistingLogo = false;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            },
                            clearFile() {
                                this.logoPreview = '{{ $brand->logo ? Storage::url($brand->logo) : '' }}';
                                this.fileName = '';
                                this.hasExistingLogo = {{ $brand->logo ? 'true' : 'false' }};
                                document.getElementById('logo').value = '';
                            }
                        }">
                            <x-input-label for="logo" :value="__('Brand Logo')" />
                            
                            <div class="mt-2">
                                <!-- Upload Area -->
                                <div class="flex items-center space-x-4">
                                    <!-- Preview or Placeholder -->
                                    <div class="flex-shrink-0">
                                        <div class="h-24 w-24 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden">
                                            <template x-if="logoPreview">
                                                <img :src="logoPreview" alt="Logo preview" class="h-full w-full object-contain">
                                            </template>
                                            <template x-if="!logoPreview">
                                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Upload Button and Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <label for="logo" class="cursor-pointer inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <span x-text="hasExistingLogo ? 'Change Logo' : 'Choose File'"></span>
                                            </label>
                                            
                                            @if($brand->logo)
                                            <span class="text-xs text-agri-600 font-medium" x-show="hasExistingLogo">
                                                ✓ Logo uploaded
                                            </span>
                                            @endif
                                        </div>
                                        
                                        <input 
                                            type="file" 
                                            id="logo" 
                                            name="logo" 
                                            accept="image/*"
                                            class="hidden"
                                            @change="handleFileSelect">
                                        
                                        <p class="text-sm text-gray-500 mt-2" x-show="!fileName && !hasExistingLogo">
                                            PNG, JPG or JPEG (max 2MB)
                                        </p>
                                        
                                        <div x-show="fileName" class="flex items-center space-x-2 mt-2">
                                            <p class="text-sm text-gray-700 font-medium" x-text="fileName"></p>
                                            <button type="button" @click="clearFile" class="text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Optional: Upload a new logo to replace the existing one</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <x-input-label for="is_active" :value="__('Status')" class="required" />
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-agri-300 transition-all duration-200 w-full">
                                    <input 
                                        type="radio" 
                                        name="is_active" 
                                        value="1" 
                                        class="w-4 h-4 text-agri-600 border-gray-300 focus:ring-agri-500"
                                        {{ old('is_active', $brand->is_active) == '1' ? 'checked' : '' }}
                                        required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-agri-600 animate-pulse mr-2"></span>
                                            <span class="font-semibold text-gray-900">Active</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Brand is visible and products can be assigned to it</p>
                                    </div>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 w-full">
                                    <input 
                                        type="radio" 
                                        name="is_active" 
                                        value="0" 
                                        class="w-4 h-4 text-gray-600 border-gray-300 focus:ring-gray-500"
                                        {{ old('is_active', $brand->is_active) == '0' ? 'checked' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-gray-600 mr-2"></span>
                                            <span class="font-semibold text-gray-900">Inactive</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Brand is hidden and not available for new products</p>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>

                        <!-- Brand Stats -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Brand Statistics
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Total Products</span>
                                        <span class="text-2xl font-bold text-gray-800">{{ $brand->products()->count() }}</span>
                                    </div>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Created</span>
                                        <span class="text-sm font-semibold text-gray-800">{{ $brand->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.brands.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="btn-harvest inline-flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Update Brand</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Warning if has products -->
            @if($brand->products()->count() > 0)
            <div class="mt-6 bg-harvest-50 border-l-4 border-harvest-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-harvest-800">Brand Has Products</h3>
                        <div class="mt-2 text-sm text-harvest-700">
                            <p>This brand has {{ $brand->products()->count() }} {{ Str::plural('product', $brand->products()->count()) }} assigned to it. You cannot delete this brand, but you can deactivate it to hide it from new product assignments.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-app-layout>

<style>
.required::after {
    content: " *";
    color: #ef4444;
}
</style>
