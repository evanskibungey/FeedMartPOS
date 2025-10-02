<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FeedMart') }} - Admin Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col lg:flex-row">
            <!-- Left Side - Branding & Info -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-harvest p-12 flex-col justify-between relative overflow-hidden">
                <!-- Decorative Background Elements -->
                <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/10 rounded-full -ml-48 -mb-48"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-8">
                        <x-application-logo class="w-16 h-16" />
                        <div>
                            <h1 class="text-3xl font-bold text-white">FeedMart</h1>
                            <p class="text-harvest-100 text-sm">Administrative Portal</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6 text-white">
                        <h2 class="text-4xl font-bold leading-tight">
                            Manage Your<br/>Agricultural Business
                        </h2>
                        <p class="text-lg text-harvest-100">
                            Secure administrative access to manage users, inventory, sales reports, and business operations for your feed mart.
                        </p>
                    </div>
                </div>

                <!-- Feature List -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <span class="font-semibold">User Management</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <span class="font-semibold">Sales Analytics & Reports</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <span class="font-semibold">Secure Access Control</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gradient-to-br from-harvest-50 via-white to-agri-50">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8">
                    <div class="flex flex-col items-center space-y-2">
                        <x-application-logo class="w-20 h-20" />
                        <div class="text-center">
                            <h1 class="text-2xl font-bold text-gradient-harvest">FeedMart</h1>
                            <p class="text-sm text-gray-600">Admin Portal</p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border-t-4 border-harvest-500 animate-fade-in-up">
                        <div class="p-8 sm:p-10">
                            <div class="mb-8 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-harvest text-white mb-4 shadow-harvest">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">Admin Portal</h2>
                                <p class="text-gray-600 mt-2">Sign in to manage FeedMart</p>
                            </div>
                            
                            {{ $slot }}
                        </div>
                    </div>

                    <!-- Footer Text -->
                    <div class="mt-6 text-center text-sm text-gray-600">
                        <p>&copy; {{ date('Y') }} FeedMart. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
