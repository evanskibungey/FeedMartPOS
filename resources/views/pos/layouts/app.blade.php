<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FeedMart') }} - Point of Sale</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-harvest-50 via-white to-agri-50">
            @include('pos.layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm shadow-lg border-b-4 border-harvest-500">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-3">
                            <div class="h-1 w-12 bg-gradient-harvest rounded-full"></div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="animate-fade-in-up">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white/50 backdrop-blur-sm border-t border-gray-200 mt-12">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="flex items-center space-x-3">
                            <x-application-logo class="h-10 w-10" />
                            <div>
                                <p class="text-sm font-semibold text-gray-700">{{ config('app.name', 'FeedMart') }} POS</p>
                                <p class="text-xs text-gray-500">Point of Sale Terminal</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p>&copy; {{ date('Y') }} FeedMart. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
