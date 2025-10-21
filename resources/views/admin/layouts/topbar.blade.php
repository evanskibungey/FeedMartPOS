<!-- Top Navigation Bar -->
<header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-40">
    <div class="px-3 sm:px-4 lg:px-8">
        <div class="flex items-center justify-between h-14 sm:h-16">
            <!-- Left Section: Menu Toggle & Breadcrumb -->
            <div class="flex items-center space-x-4">
                <!-- Mobile Menu Toggle -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-harvest-50 hover:text-harvest-600 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Desktop Sidebar Toggle -->
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="hidden lg:block p-2 rounded-lg text-gray-600 hover:bg-harvest-50 hover:text-harvest-600 transition-colors duration-200">
                    <svg x-show="!sidebarCollapsed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="sidebarCollapsed" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <!-- Breadcrumb -->
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-medium text-gray-800">Admin</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span>Dashboard</span>
                </div>
            </div>

            <!-- Right Section: Actions & Profile -->
            <div class="flex items-center space-x-3">
                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:block relative">
                    <input type="search" 
                           placeholder="Search..." 
                           class="w-64 pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-harvest-500 focus:border-transparent transition-all duration-200">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <!-- Quick Actions -->
                <a href="{{ route('pos.dashboard') }}" 
                   class="hidden sm:flex items-center space-x-2 px-4 py-2 bg-gradient-harvest text-white rounded-lg hover:shadow-harvest transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-sm font-semibold">POS</span>
                </a>

                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-harvest-600 hover:bg-harvest-50 rounded-lg transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                </button>

                <!-- Profile Dropdown -->
                <div x-data="{ open: false }" @click.away="open = false" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center space-x-3 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <div class="h-9 w-9 rounded-full bg-gradient-harvest flex items-center justify-center text-white font-semibold shadow-harvest">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-600 transition-transform duration-200" 
                             :class="{ 'rotate-180': open }" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50">
                        
                        <!-- User Info -->
                        <div class="px-4 py-3 bg-gradient-harvest text-white">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs opacity-90">{{ Auth::user()->email ?? Auth::user()->phone }}</p>
                        </div>

                        <!-- Menu Items -->
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}" 
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-harvest-50 hover:text-harvest-700 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>My Profile</span>
                            </a>

                            <a href="#" 
                               class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-harvest-50 hover:text-harvest-700 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Settings</span>
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200"></div>

                        <!-- Logout -->
                        <div class="py-2">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center space-x-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
