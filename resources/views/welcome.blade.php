<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeedMart') }} - Your Trusted Agriculture & Animal Feed Partner</title>
        <meta name="description" content="Premium animal feed and agricultural supplies. Quality products for livestock, poultry, and crop farming. Shop online or visit our store.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-agri-50 via-white to-harvest-50">
        <!-- Navigation Bar -->
        <nav x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 20" 
             :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-lg' : 'bg-white/80 backdrop-blur-sm'"
             class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 border-b border-agri-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3 group">
                        <a href="/" class="flex items-center space-x-3 transition-transform duration-300 hover:scale-105">
                            <x-application-logo class="h-12 w-12 transition-transform duration-300 group-hover:rotate-12" />
                            <div>
                                <span class="text-2xl font-bold text-gradient-agri">FeedMart</span>
                                <p class="text-xs text-gray-600 -mt-1">Agriculture & Animal Feed</p>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="text-gray-700 hover:text-agri-600 font-medium transition-colors duration-200">Home</a>
                        <a href="#products" class="text-gray-700 hover:text-agri-600 font-medium transition-colors duration-200">Products</a>
                        <a href="#about" class="text-gray-700 hover:text-agri-600 font-medium transition-colors duration-200">About Us</a>
                        <a href="#contact" class="text-gray-700 hover:text-agri-600 font-medium transition-colors duration-200">Contact</a>
                    </div>

                    <!-- Auth Buttons (Desktop) -->
                    <div class="hidden md:flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 text-agri-600 border-2 border-agri-200 rounded-xl font-semibold hover:bg-agri-50 transition-all duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-agri-600 border-2 border-agri-200 rounded-xl font-semibold hover:bg-agri-50 transition-all duration-200">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-agri">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-gray-600 hover:bg-agri-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="md:hidden border-t border-agri-100 bg-white">
                <div class="px-4 py-4 space-y-3">
                    <a href="#home" class="block px-4 py-2 text-gray-700 hover:bg-agri-50 rounded-lg">Home</a>
                    <a href="#products" class="block px-4 py-2 text-gray-700 hover:bg-agri-50 rounded-lg">Products</a>
                    <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-agri-50 rounded-lg">About Us</a>
                    <a href="#contact" class="block px-4 py-2 text-gray-700 hover:bg-agri-50 rounded-lg">Contact</a>
                    <div class="pt-4 border-t border-agri-100 space-y-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block w-full px-4 py-2.5 text-center text-agri-600 border-2 border-agri-200 rounded-xl font-semibold hover:bg-agri-50">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block w-full px-4 py-2.5 text-center text-agri-600 border-2 border-agri-200 rounded-xl font-semibold hover:bg-agri-50">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block w-full btn-agri text-center">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-agri-200/30 rounded-full blur-3xl -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-harvest-200/30 rounded-full blur-3xl -ml-48 -mb-48"></div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-8 animate-fade-in-up">
                        <div class="inline-flex items-center space-x-2 px-4 py-2 bg-agri-100 rounded-full text-agri-700 font-semibold text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Trusted by 500+ Farmers</span>
                        </div>
                        
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Quality Feed for
                            <span class="text-gradient-agri">Healthy Livestock</span>
                        </h1>
                        
                        <p class="text-xl text-gray-600 leading-relaxed">
                            Premium agricultural supplies and animal feed solutions. From poultry to cattle, we provide everything your farm needs to thrive.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn-agri text-center text-lg px-8 py-4">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Go to Dashboard
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn-agri text-center text-lg px-8 py-4">
                                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Start Shopping
                                </a>
                                <a href="{{ route('login') }}" class="btn-earth text-center text-lg px-8 py-4">
                                    Sign In
                                </a>
                            @endauth
                        </div>

                        <!-- Trust Indicators -->
                        <div class="flex flex-wrap gap-8 pt-8">
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-agri-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-gray-700 font-semibold">4.9/5 Rating</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700 font-semibold">Quality Guaranteed</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-700 font-semibold">Fast Delivery</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Image/Visual -->
                    <div class="relative animate-slide-in-right">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                            <div class="aspect-square bg-gradient-to-br from-agri-400 to-agri-600 flex items-center justify-center">
                                <svg class="w-2/3 h-2/3 text-white opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6 text-white">
                                <p class="text-lg font-semibold">Premium Quality Products</p>
                                <p class="text-sm text-white/90">Trusted by farmers nationwide</p>
                            </div>
                        </div>
                        
                        <!-- Floating Stats -->
                        <div class="absolute -bottom-6 -left-6 bg-white rounded-xl shadow-xl p-4 animate-pulse">
                            <p class="text-3xl font-bold text-agri-600">10K+</p>
                            <p class="text-sm text-gray-600">Happy Customers</p>
                        </div>
                        
                        <div class="absolute -top-6 -right-6 bg-white rounded-xl shadow-xl p-4">
                            <p class="text-3xl font-bold text-harvest-600">500+</p>
                            <p class="text-sm text-gray-600">Products</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Product Categories Section -->
        <section id="products" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Product Categories</h2>
                    <p class="text-xl text-gray-600">Everything your farm needs in one place</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Category 1 -->
                    <div class="group card cursor-pointer hover:scale-105 transition-all duration-300">
                        <div class="aspect-square bg-gradient-agri rounded-xl mb-4 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Poultry Feed</h3>
                            <p class="text-gray-600 mb-4">Complete nutrition for chickens, ducks, and other poultry</p>
                            <span class="badge badge-success">100+ Products</span>
                        </div>
                    </div>

                    <!-- Category 2 -->
                    <div class="group card cursor-pointer hover:scale-105 transition-all duration-300">
                        <div class="aspect-square bg-gradient-harvest rounded-xl mb-4 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Cattle Feed</h3>
                            <p class="text-gray-600 mb-4">High-quality feed for dairy and beef cattle</p>
                            <span class="badge badge-warning">150+ Products</span>
                        </div>
                    </div>

                    <!-- Category 3 -->
                    <div class="group card cursor-pointer hover:scale-105 transition-all duration-300">
                        <div class="aspect-square bg-gradient-earth rounded-xl mb-4 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Farming Tools</h3>
                            <p class="text-gray-600 mb-4">Essential tools and equipment for modern farming</p>
                            <span class="badge badge-info">80+ Products</span>
                        </div>
                    </div>

                    <!-- Category 4 -->
                    <div class="group card cursor-pointer hover:scale-105 transition-all duration-300">
                        <div class="aspect-square bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl mb-4 flex items-center justify-center">
                            <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Health Supplements</h3>
                            <p class="text-gray-600 mb-4">Vitamins and supplements for animal health</p>
                            <span class="badge bg-sky-100 text-sky-800">60+ Products</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features/Benefits Section -->
        <section id="about" class="py-20 bg-gradient-to-br from-agri-50 to-harvest-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose FeedMart?</h2>
                    <p class="text-xl text-gray-600">Your trusted partner in agriculture</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="stat-card stat-card-agri">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center shadow-agri">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Quality Assured</h3>
                                <p class="text-gray-600">All products tested and certified for quality standards</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-harvest">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-harvest rounded-xl flex items-center justify-center shadow-harvest">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Fast Delivery</h3>
                                <p class="text-gray-600">Same-day delivery available in selected areas</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-earth">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-earth rounded-xl flex items-center justify-center shadow-earth">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Best Prices</h3>
                                <p class="text-gray-600">Competitive pricing with bulk discounts available</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-sky">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-to-br from-sky-400 to-sky-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Expert Support</h3>
                                <p class="text-gray-600">Agricultural experts available for consultation</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-agri">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-agri rounded-xl flex items-center justify-center shadow-agri">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Easy Ordering</h3>
                                <p class="text-gray-600">Simple online ordering with order tracking</p>
                            </div>
                        </div>
                    </div>

                    <div class="stat-card stat-card-harvest">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 h-16 w-16 bg-gradient-harvest rounded-xl flex items-center justify-center shadow-harvest">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Community</h3>
                                <p class="text-gray-600">Join our community of 10,000+ farmers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-20 bg-gradient-agri relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>
            
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                    Ready to Get Started?
                </h2>
                <p class="text-xl text-white/90 mb-10">
                    Join thousands of farmers who trust FeedMart for their agricultural needs
                </p>
                
                @guest
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-10 py-4 bg-white text-agri-600 rounded-xl font-bold text-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 shadow-xl">
                            Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="px-10 py-4 bg-agri-800 text-white rounded-xl font-bold text-lg hover:bg-agri-900 transform hover:-translate-y-1 transition-all duration-200 shadow-xl">
                            Sign In
                        </a>
                    </div>
                @else
                    <a href="{{ url('/dashboard') }}" class="inline-block px-10 py-4 bg-white text-agri-600 rounded-xl font-bold text-lg hover:bg-gray-50 transform hover:-translate-y-1 transition-all duration-200 shadow-xl">
                        Go to Dashboard
                    </a>
                @endguest
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div>
                        <h2 class="text-4xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                        <p class="text-lg text-gray-600 mb-8">
                            Have questions? Our team is here to help you find the right products for your farm.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Phone</h3>
                                    <p class="text-gray-600">+63 123 456 7890</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Email</h3>
                                    <p class="text-gray-600">support@feedmart.com</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 bg-agri-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-agri-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Address</h3>
                                    <p class="text-gray-600">123 Agriculture Street, Farm City, Philippines</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                        <form class="space-y-4">
                            <div>
                                <input type="text" placeholder="Your Name" class="input-field">
                            </div>
                            <div>
                                <input type="email" placeholder="Your Email" class="input-field">
                            </div>
                            <div>
                                <input type="tel" placeholder="Phone Number" class="input-field">
                            </div>
                            <div>
                                <textarea rows="4" placeholder="Your Message" class="input-field resize-none"></textarea>
                            </div>
                            <button type="submit" class="btn-agri w-full">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                    <!-- Company Info -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <x-application-logo class="h-10 w-10" />
                            <span class="text-xl font-bold">FeedMart</span>
                        </div>
                        <p class="text-gray-400 mb-4">
                            Your trusted partner for quality agricultural supplies and animal feed.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="font-bold text-lg mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="#home" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                            <li><a href="#products" class="text-gray-400 hover:text-white transition-colors">Products</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Portal Access -->
                    <div>
                        <h3 class="font-bold text-lg mb-4">Portal Access</h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('login') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center space-x-2">
                                    <span class="h-2 w-2 rounded-full bg-agri-500"></span>
                                    <span>Customer Portal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.login') }}" class="text-gray-400 hover:text-harvest-400 transition-colors flex items-center space-x-2">
                                    <span class="h-2 w-2 rounded-full bg-harvest-500"></span>
                                    <span>Admin Portal</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('pos.login') }}" class="text-gray-400 hover:text-sky-400 transition-colors flex items-center space-x-2">
                                    <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                                    <span>POS Portal</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Newsletter -->
                    <div>
                        <h3 class="font-bold text-lg mb-4">Newsletter</h3>
                        <p class="text-gray-400 mb-4">Subscribe for updates and special offers</p>
                        <form class="space-y-2">
                            <input type="email" placeholder="Your email" class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-700 text-white placeholder-gray-500 focus:border-agri-500 focus:ring-1 focus:ring-agri-500 transition-all">
                            <button type="submit" class="w-full btn-agri">Subscribe</button>
                        </form>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} FeedMart. All rights reserved.
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scroll to Top Button -->
        <button x-data="{ show: false }" 
                @scroll.window="show = window.pageYOffset > 300"
                x-show="show"
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="fixed bottom-8 right-8 h-14 w-14 bg-gradient-agri text-white rounded-full shadow-agri hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 z-40 flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </body>
</html>
