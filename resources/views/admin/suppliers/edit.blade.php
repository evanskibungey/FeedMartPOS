<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.suppliers.index') }}" class="p-2 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-3xl text-gray-800 leading-tight">Edit Supplier</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $supplier->name }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.suppliers.update', $supplier) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="card animate-fade-in-up">
                    <div class="card-header flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">Basic Information</h3>
                        </div>
                        <span class="text-sm text-white/80">ID: #{{ $supplier->id }}</span>
                    </div>
                    <div class="card-body space-y-6">
                        <div>
                            <x-input-label for="name" value="Supplier Name" class="required" />
                            <x-text-input id="name" class="block w-full mt-2" type="text" name="name" :value="old('name', $supplier->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contact_name" value="Contact Person" />
                            <x-text-input id="contact_name" class="block w-full mt-2" type="text" name="contact_name" :value="old('contact_name', $supplier->contact_name)" />
                            <x-input-error :messages="$errors->get('contact_name')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="phone" value="Phone Number" />
                                <x-text-input id="phone" class="block w-full mt-2" type="text" name="phone" :value="old('phone', $supplier->phone)" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" value="Email Address" />
                                <x-text-input id="email" class="block w-full mt-2" type="email" name="email" :value="old('email', $supplier->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3 class="text-lg font-semibold">Location Details</h3></div>
                    <div class="card-body space-y-6">
                        <div>
                            <x-input-label for="address" value="Address" />
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none mt-2">{{ old('address', $supplier->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="city" value="City/Town" />
                            <x-text-input id="city" class="block w-full mt-2" type="text" name="city" :value="old('city', $supplier->city)" />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h3 class="text-lg font-semibold">Business Details</h3></div>
                    <div class="card-body space-y-6">
                        <div>
                            <x-input-label for="payment_terms" value="Payment Terms" />
                            <x-text-input id="payment_terms" class="block w-full mt-2" type="text" name="payment_terms" :value="old('payment_terms', $supplier->payment_terms)" />
                            <x-input-error :messages="$errors->get('payment_terms')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="notes" value="Additional Notes" />
                            <textarea id="notes" name="notes" rows="4" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-agri-500 focus:ring-2 focus:ring-agri-200 transition-all duration-200 resize-none mt-2">{{ old('notes', $supplier->notes) }}</textarea>
                            <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="is_active" value="Status" class="required" />
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-agri-300 transition-all duration-200 w-full">
                                    <input type="radio" name="is_active" value="1" class="w-4 h-4 text-agri-600" {{ old('is_active', $supplier->is_active) == '1' ? 'checked' : '' }} required>
                                    <div class="ml-3"><span class="font-semibold text-gray-900">Active</span></div>
                                </label>
                                <label class="inline-flex items-center cursor-pointer p-4 border-2 border-gray-200 rounded-xl hover:border-gray-300 transition-all duration-200 w-full">
                                    <input type="radio" name="is_active" value="0" class="w-4 h-4 text-gray-600" {{ old('is_active', $supplier->is_active) == '0' ? 'checked' : '' }}>
                                    <div class="ml-3"><span class="font-semibold text-gray-900">Inactive</span></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <h4 class="text-sm font-semibold text-gray-700 mb-4">Supplier Statistics</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <span class="text-sm text-gray-600">Products</span>
                            <p class="text-2xl font-bold text-gray-800">{{ $supplier->products()->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <span class="text-sm text-gray-600">Orders</span>
                            <p class="text-2xl font-bold text-gray-800">{{ $supplier->purchaseOrders()->count() }}</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <span class="text-sm text-gray-600">Since</span>
                            <p class="text-sm font-semibold text-gray-800">{{ $supplier->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.suppliers.index') }}" class="px-6 py-3 bg-white border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition-all duration-200">Cancel</a>
                    <button type="submit" class="btn-harvest inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <span>Update Supplier</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-app-layout>

<style>
.required::after { content: " *"; color: #ef4444; }
</style>
