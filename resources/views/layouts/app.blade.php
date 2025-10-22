<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::systemName() }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gradient-to-br from-agri-50 via-white to-harvest-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm shadow-lg border-b-4 border-agri-500">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center space-x-3">
                            <div class="h-1 w-12 bg-gradient-agri rounded-full"></div>
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="animate-fade-in-up">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <x-customer-footer />
        </div>
    </body>
</html>
