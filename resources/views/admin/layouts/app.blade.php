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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-agri-50 via-white to-harvest-50">
            @include('admin.layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm shadow-lg border-b-4 border-harvest-500">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-3">
                            <div class="h-1 w-12 bg-gradient-harvest rounded-full"></div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-harvest-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
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
                                <p class="text-sm font-semibold text-gray-700">{{ config('app.name', 'FeedMart') }} Admin</p>
                                <p class="text-xs text-gray-500">Administrative Dashboard</p>
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
