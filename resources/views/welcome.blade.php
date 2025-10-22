@php
$homeController = app(\App\Http\Controllers\HomeController::class);
$data = $homeController->index()->getData();
$featuredProducts = $data['featuredProducts'];
$categories = $data['categories'];
$cartCount = $data['cartCount'];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ \App\Models\Setting::systemName() }} - {{ \App\Models\Setting::tagline() }}</title>
    <meta name="description" content="Your trusted partner in agriculture. Premium quality animal feed, farm supplies, and agricultural products delivered with care.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        .gradient-text {
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-agri-50 via-white to-harvest-50">
    
    <!-- Navigation Bar -->
    <nav class="bg-white/80 backdrop-blur-lg shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-3">
                    <x-application-logo class="h-12 w-12" />
                    <div>
                        <h1 class="text-2xl font-bold gradient-text">{{ \App\Models\Setting::systemName() }}</h1>
                        <p class="text-xs text-gray-500">{{ \App\Models\Setting::tagline() }}</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link active">Home</a>
                    <a href="#products" class="nav-link">Products</a>
                    <a href="{{ route('shop.index') }}" class="nav-link">Shop</a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-agri-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-agri-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-agri-600 font-medium transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-agri">Get Started</a>
                    @else
                    <a href="{{ route('dashboard') }}" class="btn-agri">Dashboard</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden py-20 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center space-x-2 bg-agri-100 text-agri-700 px-4 py-2 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Trusted by 500+ Farmers</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Quality Feed for
                        <span class="gradient-text block mt-2">Healthy Livestock</span>
                    </h1>
                    
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Your trusted partner in agriculture. We provide premium quality animal feed, farm supplies, and agricultural products delivered with care to help your farm thrive.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('shop.index') }}" class="btn-agri inline-flex items-center justify-center text-lg group">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Shop Now
                        </a>
                        <a href="#products" class="btn-harvest inline-flex items-center justify-center text-lg">
                            Browse Products
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="relative lg:h-[600px]">
                    <div class="absolute inset-0 bg-gradient-agri opacity-10 rounded-3xl transform rotate-6"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 float-animation">
                        <x-application-logo class="h-64 w-64 mx-auto" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose <span class="gradient-text">{{ \App\Models\Setting::systemName() }}</span>?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">We're committed to providing the best products and services for your agricultural needs</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-gradient-to-br from-agri-50 to-agri-100 rounded-2xl p-8 border border-agri-200 hover:scale-105 transition-transform">
                    <div class="bg-white rounded-xl p-4 w-16 h-16 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-agri-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Premium Quality</h3>
                    <p class="text-gray-600">Carefully selected products that meet the highest quality standards</p>
                </div>

                <div class="bg-gradient-to-br from-harvest-50 to-harvest-100 rounded-2xl p-8 border border-harvest-200 hover:scale-105 transition-transform">
                    <div class="bg-white rounded-xl p-4 w-16 h-16 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-harvest-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Fast Delivery</h3>
                    <p class="text-gray-600">Quick and reliable delivery service to get products when you need them</p>
                </div>

                <div class="bg-gradient-to-br from-sky-50 to-sky-100 rounded-2xl p-8 border border-sky-200 hover:scale-105 transition-transform">
                    <div class="bg-white rounded-xl p-4 w-16 h-16 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-sky-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Support</h3>
                    <p class="text-gray-600">Our team of agricultural experts is here to help you</p>
                </div>

                <div class="bg-gradient-to-br from-earth-50 to-earth-100 rounded-2xl p-8 border border-earth-200 hover:scale-105 transition-transform">
                    <div class="bg-white rounded-xl p-4 w-16 h-16 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-earth-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Best Prices</h3>
                    <p class="text-gray-600">Competitive pricing without compromising on quality</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    @if($featuredProducts->count() > 0)
    <section id="products" class="py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
                <div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Featured <span class="gradient-text">Products</span></h2>
                    <p class="text-xl text-gray-600">Discover our top picks for your agricultural needs</p>
                </div>
                <a href="{{ route('shop.index') }}" class="btn-agri inline-flex items-center">
                    View All Products
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredProducts->take(8) as $product)
                <a href="{{ route('shop.show', $product->id) }}" class="group block">
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-transparent hover:border-agri-200 hover:-translate-y-2">
                        <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                            @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">{{ $product->name }}</h3>
                            @if($product->category)
                            <p class="text-sm text-gray-500 mb-3">{{ $product->category->name }}</p>
                            @endif
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-bold text-agri-600">{{ \App\Models\Setting::formatCurrency($product->price) }}</p>
                                <div class="bg-agri-100 text-agri-700 p-2 rounded-lg group-hover:bg-agri-600 group-hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-gray-300">
    <!-- Newsletter Section -->
    <div class="border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div>
                    <h3 class="text-2xl font-bold text-white mb-2">Stay Updated</h3>
                    <p class="text-gray-400">Subscribe to our newsletter for the latest products, tips, and exclusive offers.</p>
                </div>
                <div>
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-agri-500 focus:border-transparent transition-all">
                        <button type="submit" class="bg-agri-600 hover:bg-agri-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:shadow-lg hover:scale-105 whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Footer Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Company Info -->
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <x-application-logo class="h-12 w-12" />
                    <h3 class="text-2xl font-bold text-white">{{ \App\Models\Setting::systemName() }}</h3>
                </div>
                <p class="text-gray-400 leading-relaxed">{{ \App\Models\Setting::tagline() }}</p>
                <p class="text-sm text-gray-500">Your trusted partner in agriculture, providing premium quality products for healthy livestock and thriving farms.</p>
                
                <!-- Social Media -->
                <div class="flex space-x-4">
                    <a href="#" class="bg-gray-800 hover:bg-agri-600 text-gray-400 hover:text-white p-3 rounded-xl transition-all duration-300 transform hover:scale-110" title="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-sky-600 text-gray-400 hover:text-white p-3 rounded-xl transition-all duration-300 transform hover:scale-110" title="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-pink-600 text-gray-400 hover:text-white p-3 rounded-xl transition-all duration-300 transform hover:scale-110" title="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-blue-700 text-gray-400 hover:text-white p-3 rounded-xl transition-all duration-300 transform hover:scale-110" title="LinkedIn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-bold text-lg mb-6 flex items-center">
                    <span class="w-1 h-6 bg-agri-500 mr-3 rounded-full"></span>
                    Quick Links
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#home" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="#products" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shop.index') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Shop
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Cart
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div>
                <h4 class="text-white font-bold text-lg mb-6 flex items-center">
                    <span class="w-1 h-6 bg-harvest-500 mr-3 rounded-full"></span>
                    Categories
                </h4>
                <ul class="space-y-3">
                    @forelse($categories->take(5) as $category)
                    <li>
                        <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="text-gray-400 hover:text-harvest-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            {{ $category->name }}
                        </a>
                    </li>
                    @empty
                    <li class="text-gray-500 text-sm">No categories available</li>
                    @endforelse
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-white font-bold text-lg mb-6 flex items-center">
                    <span class="w-1 h-6 bg-sky-500 mr-3 rounded-full"></span>
                    Get In Touch
                </h4>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3 text-gray-400">
                        <svg class="w-5 h-5 text-agri-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm">123 Farm Road, Agricultural District</span>
                    </li>
                    <li class="flex items-start space-x-3 text-gray-400">
                        <svg class="w-5 h-5 text-agri-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:info@feedmart.com" class="text-sm hover:text-agri-400 transition-colors">info@feedmart.com</a>
                    </li>
                    <li class="flex items-start space-x-3 text-gray-400">
                        <svg class="w-5 h-5 text-agri-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:+1234567890" class="text-sm hover:text-agri-400 transition-colors">+123 456 7890</a>
                    </li>
                    <li class="flex items-start space-x-3 text-gray-400">
                        <svg class="w-5 h-5 text-agri-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm">Mon - Sat: 8:00 AM - 6:00 PM</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-gray-400 text-sm text-center md:text-left">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::systemName() }}. All rights reserved.
            </p>
            <div class="flex flex-wrap justify-center gap-6 text-sm">
                <a href="#" class="text-gray-400 hover:text-agri-400 transition-colors">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-agri-400 transition-colors">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-agri-400 transition-colors">Cookie Policy</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
