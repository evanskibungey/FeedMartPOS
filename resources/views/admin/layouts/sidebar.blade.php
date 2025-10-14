<!-- Enhanced Modern Sidebar -->
<aside 
    x-show="sidebarOpen"
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    class="fixed inset-y-0 left-0 z-50 lg:z-30 bg-white border-r border-gray-200 shadow-2xl transition-all duration-300 ease-in-out overflow-hidden">
    
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200 bg-gradient-to-r from-harvest-50 to-agri-50">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group overflow-hidden">
                <div class="flex-shrink-0">
                    <x-application-logo class="h-10 w-10 transition-transform duration-300 group-hover:scale-110" />
                </div>
                <div x-show="!sidebarCollapsed"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-x-2"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="flex flex-col">
                    <span class="text-xl font-bold bg-gradient-harvest bg-clip-text text-transparent whitespace-nowrap">{{ \App\Models\Setting::systemName() }}</span>
                    <span class="text-xs text-harvest-600 font-semibold -mt-0.5 whitespace-nowrap">Admin Portal</span>
                </div>
            </a>
            
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" 
                    class="lg:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0 relative">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    @if(request()->routeIs('admin.dashboard'))
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                    </span>
                    @endif
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Users Management -->
            <a href="{{ route('admin.users.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.users.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0 relative">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    @if(request()->routeIs('admin.users.*'))
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                    </span>
                    @endif
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap flex-1">Users</span>
            </a>

            <!-- Section Divider -->
            <div class="flex items-center space-x-2 px-3 py-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Inventory</span>
                <div x-show="!sidebarCollapsed" 
                     x-transition
                     class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Products -->
            <a href="{{ route('admin.products.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.products.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Products</span>
            </a>

            <!-- Categories -->
            <a href="{{ route('admin.categories.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.categories.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Categories</span>
            </a>

            <!-- Brands -->
            <a href="{{ route('admin.brands.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.brands.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Brands</span>
            </a>

            <!-- Inventory Management -->
            <a href="{{ route('admin.inventory.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.inventory.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Inventory</span>
            </a>

            <!-- Section Divider -->
            <div class="flex items-center space-x-2 px-3 py-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Procurement</span>
                <div x-show="!sidebarCollapsed" 
                     x-transition
                     class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Purchase Orders -->
            <a href="{{ route('admin.purchase-orders.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.purchase-orders.index', 'admin.purchase-orders.show', 'admin.purchase-orders.edit', 'admin.purchase-orders.create') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Purchase Orders</span>
            </a>

            <!-- Draft Purchase Orders -->
            <a href="{{ route('admin.purchase-orders.drafts') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.purchase-orders.drafts') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap flex-1">Draft Orders</span>
                @php
                    $draftCount = \App\Models\PurchaseOrder::where('status', 'draft')->count();
                @endphp
                @if($draftCount > 0)
                    <span x-show="!sidebarCollapsed" 
                          x-transition
                          class="ml-auto px-2 py-0.5 text-xs font-bold bg-red-500 text-white rounded-full animate-pulse">{{ $draftCount }}</span>
                @endif
            </a>

            <!-- Suppliers -->
            <a href="{{ route('admin.suppliers.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.suppliers.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Suppliers</span>
            </a>

            <!-- Section Divider -->
            <div class="flex items-center space-x-2 px-3 py-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">Sales</span>
                <div x-show="!sidebarCollapsed" 
                     x-transition
                     class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Orders -->
            <a href="#" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Orders</span>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="ml-auto px-1.5 py-0.5 text-xs font-bold bg-sky-100 text-sky-700 rounded">Soon</span>
            </a>

            <!-- Customers -->
            <a href="{{ route('admin.customers.index') }}" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.customers.*') 
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105' 
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Customers</span>
            </a>

            <!-- Reports -->
            <a href="#" 
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200 text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="font-semibold whitespace-nowrap">Reports</span>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="ml-auto px-1.5 py-0.5 text-xs font-bold bg-sky-100 text-sky-700 rounded">Soon</span>
            </a>

            <!-- Section Divider -->
            <div class="flex items-center space-x-2 px-3 py-3">
                <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <span x-show="!sidebarCollapsed" 
                      x-transition
                      class="text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap">System</span>
                <div x-show="!sidebarCollapsed" 
                     x-transition
                     class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
            </div>

            <!-- Settings -->
            <a href="{{ route('admin.settings.index') }}"
               class="group flex items-center space-x-3 px-3 py-3 rounded-xl transition-all duration-200
                      {{ request()->routeIs('admin.settings.*')
                          ? 'bg-gradient-harvest text-white shadow-harvest scale-105'
                          : 'text-gray-700 hover:bg-gradient-to-r hover:from-harvest-50 hover:to-agri-50 hover:text-harvest-700' }}">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 transition-transform duration-200 group-hover:scale-110 group-hover:rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed"
                      x-transition
                      class="font-semibold whitespace-nowrap">Settings</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="border-t border-gray-200 bg-gradient-to-r from-gray-50 to-harvest-50">
            <!-- User Info Card (when expanded) -->
            <div x-show="!sidebarCollapsed" 
                 x-transition
                 class="p-3 m-3 bg-white rounded-xl border border-harvest-100 shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="h-10 w-10 rounded-full bg-gradient-harvest flex items-center justify-center text-white font-bold text-sm shadow-harvest">
                        {{ substr(Auth::user()->name, 0, 2) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">Admin Access</p>
                    </div>
                </div>
            </div>

            <!-- Collapse Toggle Button -->
            <div class="p-3">
                <button @click="sidebarCollapsed = !sidebarCollapsed" 
                        class="w-full flex items-center justify-center space-x-2 px-3 py-2.5 rounded-xl bg-white border-2 border-harvest-200 hover:border-harvest-400 hover:bg-harvest-50 text-harvest-700 transition-all duration-200 shadow-sm hover:shadow-md group">
                    <svg x-show="!sidebarCollapsed" 
                         class="w-5 h-5 transition-transform duration-200 group-hover:-translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                    <svg x-show="sidebarCollapsed" 
                         class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                    <span x-show="!sidebarCollapsed" 
                          x-transition
                          class="font-semibold text-sm">Collapse Menu</span>
                </button>
            </div>
        </div>
    </div>
</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #f59e0b 0%, #fbbf24 100%);
        border-radius: 10px;
    }
    
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #d97706 0%, #f59e0b 100%);
    }
</style>
