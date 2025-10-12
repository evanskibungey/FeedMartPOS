<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('System Settings') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Configure your system</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-fade-in-up">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="text-red-700 font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Tabs/Navigation -->
                <div class="lg:col-span-1">
                    <div class="card sticky top-4">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold">Settings Menu</h3>
                        </div>
                        <div class="card-body p-0">
                            <nav class="space-y-1 p-3">
                                <button onclick="showTab('system')" id="tab-system" class="settings-tab-btn settings-tab-active w-full text-left px-4 py-3 rounded-lg font-semibold flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span>System Settings</span>
                                </button>
                                <button onclick="showTab('profile')" id="tab-profile" class="settings-tab-btn w-full text-left px-4 py-3 rounded-lg font-semibold flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Profile Settings</span>
                                </button>
                                <button onclick="showTab('security')" id="tab-security" class="settings-tab-btn w-full text-left px-4 py-3 rounded-lg font-semibold flex items-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>Security</span>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- System Settings Tab -->
                    <div id="content-system" class="settings-content">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    System Configuration
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Configure system-wide settings like name, logo, and currency</p>
                            </div>
                            <div class="card-body">
                                <form id="systemSettingsForm" method="POST" action="{{ route('admin.settings.update-system') }}" enctype="multipart/form-data" class="space-y-6">
                                    @csrf

                                    <!-- System Name -->
                                    <div>
                                        <x-input-label for="system_name" value="System Name" />
                                        <x-text-input id="system_name" name="system_name" type="text" class="mt-1 block w-full" :value="old('system_name', $settings['system_name'])" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('system_name')" />
                                        <p class="text-sm text-gray-500 mt-1">This name will appear across the entire system</p>
                                    </div>

                                    <!-- System Currency -->
                                    <div>
                                        <x-input-label for="system_currency" value="Default Currency" />
                                        <select id="system_currency" name="system_currency" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-harvest-500 focus:ring-harvest-500" required>
                                            @foreach($currencies as $code => $name)
                                                <option value="{{ $code }}" {{ old('system_currency', $settings['system_currency']) == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('system_currency')" />
                                        <p class="text-sm text-gray-500 mt-1">Currency used throughout the system</p>
                                    </div>

                                    <!-- System Logo -->
                                    <div>
                                        <x-input-label for="system_logo" value="System Logo" />

                                        @if($settings['system_logo'])
                                            <div class="mt-2 p-4 bg-gray-50 rounded-lg border-2 border-gray-200">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-4">
                                                        <img src="{{ $settings['system_logo'] }}" alt="Current Logo" class="h-16 w-16 object-contain rounded">
                                                        <div>
                                                            <p class="text-sm font-semibold text-gray-700">Current Logo</p>
                                                            <p class="text-xs text-gray-500">Upload a new logo below to replace</p>
                                                        </div>
                                                    </div>
                                                    <button type="button" onclick="removeLogoConfirm()" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 rounded-lg font-semibold text-sm transition-colors duration-200 border border-red-200">
                                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Remove Logo
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <input type="file" id="system_logo" name="system_logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-harvest-50 file:text-harvest-700 hover:file:bg-harvest-100" />
                                        <x-input-error class="mt-2" :messages="$errors->get('system_logo')" />
                                        <p class="text-sm text-gray-500 mt-1">Upload PNG, JPG, JPEG, or SVG (max 2MB)</p>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center justify-end">
                                        <button type="submit" class="btn-harvest">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Save System Settings
                                        </button>
                                    </div>
                                </form>

                                <!-- Separate Remove Logo Form (Hidden) -->
                                <form id="removeLogoForm" method="POST" action="{{ route('admin.settings.remove-logo') }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Settings Tab -->
                    <div id="content-profile" class="settings-content hidden">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile Information
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Update your personal information and login credentials</p>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('admin.settings.update-profile') }}" class="space-y-6">
                                    @csrf

                                    <!-- Name -->
                                    <div>
                                        <x-input-label for="name" value="Full Name" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', Auth::user()->name)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <x-input-label for="email" value="Email Address" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', Auth::user()->email)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                        <p class="text-sm text-gray-500 mt-1">Used for system login</p>
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <x-input-label for="phone" value="Phone Number" />
                                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', Auth::user()->phone)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                        <p class="text-sm text-gray-500 mt-1">Can also be used for login</p>
                                    </div>

                                    <!-- Current Role Display -->
                                    <div class="p-4 bg-harvest-50 rounded-lg border border-harvest-200">
                                        <div class="flex items-center space-x-3">
                                            <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-700">Current Role</p>
                                                <p class="text-lg font-bold text-harvest-700 uppercase">{{ Auth::user()->role }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center justify-end">
                                        <button type="submit" class="btn-harvest">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div id="content-security" class="settings-content hidden">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="text-lg font-semibold flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Change Password
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Update your password for enhanced security</p>
                            </div>
                            <div class="card-body">
                                <!-- Security Warning -->
                                <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded-lg">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-yellow-800">Password Requirements:</p>
                                            <ul class="text-xs text-yellow-700 mt-1 space-y-1">
                                                <li>• Minimum 8 characters</li>
                                                <li>• Must contain uppercase and lowercase letters</li>
                                                <li>• Must contain at least one number</li>
                                                <li>• Must contain at least one symbol</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('admin.settings.update-password') }}" class="space-y-6">
                                    @csrf

                                    <!-- Current Password -->
                                    <div>
                                        <x-input-label for="current_password" value="Current Password" />
                                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" required autocomplete="current-password" />
                                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                                    </div>

                                    <!-- New Password -->
                                    <div>
                                        <x-input-label for="password" value="New Password" />
                                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                    </div>

                                    <!-- Confirm New Password -->
                                    <div>
                                        <x-input-label for="password_confirmation" value="Confirm New Password" />
                                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                                        <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex items-center justify-end">
                                        <button type="submit" class="btn-harvest">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        .settings-tab-btn {
            @apply text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700 transition-all duration-200;
        }
        .settings-tab-active {
            @apply bg-gradient-harvest text-white shadow-harvest;
        }
    </style>

    <script>
        function showTab(tabName) {
            // Hide all content
            document.querySelectorAll('.settings-content').forEach(el => {
                el.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.settings-tab-btn').forEach(el => {
                el.classList.remove('settings-tab-active');
            });

            // Show selected content
            document.getElementById('content-' + tabName).classList.remove('hidden');

            // Add active class to selected tab
            document.getElementById('tab-' + tabName).classList.add('settings-tab-active');
        }

        // Handle logo removal
        function removeLogoConfirm() {
            if (confirm('Are you sure you want to remove the logo?')) {
                document.getElementById('removeLogoForm').submit();
            }
        }

        // Show system tab by default on page load
        document.addEventListener('DOMContentLoaded', function() {
            showTab('system');
        });
    </script>
</x-admin-app-layout>
