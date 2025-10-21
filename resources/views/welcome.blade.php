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
    <title>{{ config('app.name', '  TJ&J FEEDS') }} - Quality Agriculture & Animal Feed Solutions</title>
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
                        <h1 class="text-2xl font-bold gradient-text">TJ&J FEEDS</h1>
                        <p class="text-xs text-gray-500">Agriculture Excellence</p>
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
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose <span class="gradient-text">TJ&J FEEDS</span>?</h2>
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
                                <p class="text-2xl font-bold text-agri-600">KES {{ number_format($product->price, 2) }}</p>
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
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-3 mb-4">
                    <x-application-logo class="h-10 w-10" />
                    <h3 class="text-xl font-bold text-white">TJ&J FEEDS</h3>
                </div>
                <p class="text-gray-400 mb-8">Your trusted partner for quality agricultural products and animal feed.</p>
                <div class="border-t border-gray-800 pt-8">
                    <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} TJ&J FEEDS. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
