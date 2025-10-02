<x-admin-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ now()->format('l, F j, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-gradient-harvest rounded-2xl shadow-harvest p-8 text-white animate-fade-in-up">
                <div class="flex items-center justify-between">
                    <div class="space-y-2">
                        <h3 class="text-2xl font-bold">Welcome back, {{ auth()->user()->name }}! 👨‍💼</h3>
                        <p class="text-harvest-50 text-lg">Manage your FeedMart business from the admin portal</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-32 h-32 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-in-right">
                <!-- Total Users -->
                <div class="stat-card stat-card-harvest group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Total Users</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] ?? 156 }}</p>
                            <p class="text-harvest-600 text-sm font-medium mt-1">All system users</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-harvest rounded-xl flex items-center justify-center text-white shadow-harvest group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="stat-card stat-card-agri group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Customers</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_customers'] ?? 892 }}</p>
                            <p class="text-agri-600 text-sm font-medium mt-1 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                                Active customers
                            </p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center text-white shadow-agri group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Staff -->
                <div class="stat-card stat-card-sky group cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium mb-1">Staff Members</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $stats['total_staff'] ?? 24 }}</p>
                            <p class="text-sky-600 text-sm font-medium mt-1">Active employees</p>
                        </div>
                        <div class="h-16 w-16 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center text-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & System Info -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.index') }}" class="block w-full">
                                <button class="btn-harvest w-full text-left flex items-center justify-between group">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        Manage Users
                                    </span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </a>
                            
                            <a href="{{ route('admin.users.create') }}" class="block w-full">
                                <button class="btn-agri w-full text-left flex items-center justify-between group">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Add New User
                                    </span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </a>
                            
                            <a href="{{ route('pos.dashboard') }}" class="block w-full">
                                <button class="bg-gradient-to-br from-sky-400 to-sky-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 w-full text-left flex items-center justify-between group">
                                    <span class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Open POS Terminal
                                    </span>
                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Information -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            System Information
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-agri-50 hover:bg-agri-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-agri-500 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">System Status</p>
                                        <p class="text-xs text-gray-600">All systems operational</p>
                                    </div>
                                </div>
                                <span class="badge badge-success">Active</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-harvest-50 hover:bg-harvest-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-harvest-500 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Server Time</p>
                                        <p class="text-xs text-gray-600">{{ now()->format('H:i:s') }}</p>
                                    </div>
                                </div>
                                <span class="badge badge-warning">Live</span>
                            </div>

                            <div class="flex items-center justify-between p-3 rounded-lg bg-sky-50 hover:bg-sky-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="h-10 w-10 rounded-full bg-sky-500 flex items-center justify-center text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Last Backup</p>
                                        <p class="text-xs text-gray-600">{{ now()->subHours(2)->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <span class="badge badge-info">Recent</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-app-layout>
