<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FeedMart') }} - POS Terminal</title>

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
                            <p class="text-harvest-100 text-sm">Point of Sale Terminal</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6 text-white">
                        <h2 class="text-4xl font-bold leading-tight">
                            Fast & Efficient<br/>Sales Processing
                        </h2>
                        <p class="text-lg text-harvest-100">
                            Process customer transactions quickly and efficiently with our intuitive point of sale system designed for agricultural feed stores.
                        </p>
                    </div>
                </div>

                <!-- Feature List -->
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="font-semibold">Quick Checkout Process</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="font-semibold">Real-time Transaction Tracking</span>
                    </div>
                    <div class="flex items-center space-x-3 text-white">
                        <div class="h-10 w-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="font-semibold">Cash & Payment Management</span>
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
                            <h1 class="text-2xl font-bold bg-gradient-harvest bg-clip-text text-transparent">FeedMart</h1>
                            <p class="text-sm text-gray-600">POS Terminal</p>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="w-full max-w-md">
                    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden border-t-4 border-harvest-500 animate-fade-in-up">
                        <div class="p-8 sm:p-10">
                            <div class="mb-8 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-harvest text-white mb-4 shadow-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">POS Terminal</h2>
                                <p class="text-gray-600 mt-2">Sign in to start selling</p>
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
