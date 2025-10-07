<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Create New Category') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card animate-fade-in-up">
                <div class="card-header">
                    <h3 class="text-lg font-semibold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Category Information
                    </h3>
                    <p class="text-sm text-white/90 mt-1">Fill in the details below to create a new product category</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
                        @csrf

                        <!-- Category Name -->
                        <div>
                            <x-input-label for="name" :value="__('Category Name')" class="required" />
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                                <x-text-input 
                                    id="name" 
                                    class="pl-12 block w-full" 
                                    type="text" 
                                    name="name" 
                                    :value="old('name')" 
                                    required 
                                    autofocus 
                                    placeholder="e.g., Dairy Feed, Poultry Feed, Supplements" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Enter a unique name for this category</p>
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
                                    placeholder="Provide a brief description of this category (optional)">{{ old('description') }}</textarea>
                            </div>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">Optional: Describe what products belong in this category</p>
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
                                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                        required>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-agri-600 animate-pulse mr-2"></span>
                                            <span class="font-semibold text-gray-900">Active</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Category is visible and products can be assigned to it</p>
                                    </div>
                                </label>

                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 w-full">
                                    <input 
                                        type="radio" 
                                        name="is_active" 
                                        value="0" 
                                        class="w-4 h-4 text-gray-600 border-gray-300 focus:ring-gray-500"
                                        {{ old('is_active') == '0' ? 'checked' : '' }}>
                                    <div class="ml-3 flex-1">
                                        <div class="flex items-center">
                                            <span class="h-2 w-2 rounded-full bg-gray-600 mr-2"></span>
                                            <span class="font-semibold text-gray-900">Inactive</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">Category is hidden and not available for new products</p>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="btn-agri inline-flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Create Category</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="mt-6 bg-sky-50 border-l-4 border-sky-500 p-4 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-sky-800">Category Tips</h3>
                        <div class="mt-2 text-sm text-sky-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Use clear, descriptive names that customers will understand</li>
                                <li>Categories help organize your products and make them easier to find</li>
                                <li>You can change the status later if you need to hide a category temporarily</li>
                                <li>Categories with products cannot be deleted, only deactivated</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>

<style>
.required::after {
    content: " *";
    color: #ef4444;
}
</style>
