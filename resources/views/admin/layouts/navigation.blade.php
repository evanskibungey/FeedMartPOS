<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-md border-b-2 border-harvest-100 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center space-x-3 group">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 transition-transform duration-300 hover:scale-105">
                        <x-application-logo class="block h-12 w-12 transition-transform duration-300 group-hover:rotate-12" />
                        <div class="hidden md:block">
                            <span class="text-2xl font-bold text-gradient-harvest">FeedMart</span>
                            <p class="text-xs text-harvest-600 -mt-1 font-semibold">Admin Portal</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="nav-link border-harvest-500 text-harvest-700 hover:text-harvest-600 hover:border-harvest-300 hover:bg-harvest-50/50">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>{{ __('Dashboard') }}</span>
                        </div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="nav-link border-harvest-500 text-harvest-700 hover:text-harvest-600 hover:border-harvest-300 hover:bg-harvest-50/50">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>{{ __('Users') }}</span>
                        </div>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Side: Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Admin Badge -->
                <div class="mr-4 px-3 py-1 bg-harvest-100 text-harvest-700 rounded-full text-xs font-bold uppercase tracking-wider">
                    Administrator
                </div>

                <!-- Notification Bell -->
                <button class="relative p-2 text-gray-600 hover:text-harvest-600 transition-colors duration-200 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                </button>

                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border-2 border-harvest-200 text-sm leading-4 font-medium rounded-xl text-gray-700 bg-white hover:bg-harvest-50 hover:border-harvest-400 focus:outline-none focus:ring-2 focus:ring-harvest-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center space-x-3">
                                <div class="h-8 w-8 rounded-full bg-gradient-harvest flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="text-left">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">Admin</div>
                                </div>
                                <svg class="fill-current h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 bg-gradient-harvest text-white">
                            <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-xs opacity-90">{{ Auth::user()->email ?? Auth::user()->phone }}</p>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ __('Profile') }}</span>
                        </x-dropdown-link>

                        <div class="border-t border-gray-200"></div>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('admin.logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-red-600 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-harvest-600 hover:bg-harvest-50 focus:outline-none focus:ring-2 focus:ring-harvest-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-harvest-100">
        <div class="pt-2 pb-3 space-y-1 bg-white">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="border-harvest-500 text-harvest-700 hover:bg-harvest-50">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>{{ __('Dashboard') }}</span>
                </div>
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="border-harvest-500 text-harvest-700 hover:bg-harvest-50">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>{{ __('Users') }}</span>
                </div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-harvest-200 bg-harvest-50">
            <div class="px-4 flex items-center space-x-3">
                <div class="h-10 w-10 rounded-full bg-gradient-harvest flex items-center justify-center text-white font-semibold text-lg">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-600">{{ Auth::user()->email ?? Auth::user()->phone }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('admin.logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
