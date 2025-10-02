<x-pos-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <span class="text-red-800 font-medium text-sm">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('pos.login') }}" class="space-y-6">
        @csrf

        <!-- Email or Phone -->
        <div>
            <x-input-label for="email" :value="__('Email or Phone Number')" />
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="email" class="pl-12" type="text" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="cashier@feedmart.com or phone number" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="relative mt-2">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="pl-12" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-sky-600 shadow-sm focus:ring-sky-500 focus:border-sky-500 transition duration-200" name="remember">
                <span class="ms-2 text-sm text-gray-700 font-medium">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-br from-sky-400 to-sky-600 border border-transparent rounded-xl font-semibold text-base text-white uppercase tracking-wider hover:shadow-lg focus:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                {{ __('Sign In to POS') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Terminal Access</span>
            </div>
        </div>

        <!-- Help Text -->
        <div class="bg-sky-50 border border-sky-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-sky-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-sky-700">
                        <strong>For Cashiers Only:</strong> Use your assigned credentials to access the POS terminal
                    </p>
                </div>
            </div>
        </div>
    </form>

    <!-- Back to Home -->
    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-semibold text-sky-600 hover:text-sky-700 transition duration-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Home
        </a>
    </div>
</x-pos-guest-layout>
