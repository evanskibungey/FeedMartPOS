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
    <body class="font-sans antialiased bg-gradient-to-br from-agri-50 via-white to-harvest-50">
        <div x-data="{ 
            sidebarOpen: false, 
            sidebarCollapsed: false,
            isMobile() {
                return window.innerWidth < 1024;
            },
            init() {
                // Set initial state based on screen size
                this.sidebarOpen = window.innerWidth >= 1024;
                
                // Handle responsive behavior
                const handleResize = () => {
                    if (window.innerWidth >= 1024) {
                        this.sidebarOpen = true;
                    } else {
                        this.sidebarOpen = false;
                    }
                };
                
                window.addEventListener('resize', handleResize);
                
                // Cleanup
                this.$el.addEventListener('alpine:destroy', () => {
                    window.removeEventListener('resize', handleResize);
                });
            }
        }" class="min-h-screen">
            
            <!-- Sidebar -->
            @include('admin.layouts.sidebar')

            <!-- Main Content Area -->
            <div class="flex flex-col min-h-screen transition-all duration-300" 
                 :class="{ 
                     'lg:ml-64': !sidebarCollapsed, 
                     'lg:ml-20': sidebarCollapsed 
                 }">
                
                <!-- Top Navigation Bar -->
                @include('admin.layouts.topbar')

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto animate-fade-in-up">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="bg-white/50 backdrop-blur-sm border-t border-gray-200 mt-auto">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                            <div class="flex items-center space-x-3">
                                <x-application-logo class="h-8 w-8" />
                                <div>
                                    <p class="text-xs font-semibold text-gray-700">{{ config('app.name', 'FeedMart') }} Admin</p>
                                    <p class="text-xs text-gray-500">Administrative Dashboard</p>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 flex items-center space-x-4">
                                <span>&copy; {{ date('Y') }} FeedMart. All rights reserved.</span>
                                <span class="hidden md:inline-flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-green-600 font-semibold">System Online</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen && isMobile()" 
             x-cloak
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             style="z-index: 45;"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm lg:hidden">
        </div>
    </body>
</html>