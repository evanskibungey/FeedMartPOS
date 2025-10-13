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
    <title>{{ config('app.name', 'FeedMart') }} - Agriculture & Animal Feed</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-agri-50 via-white to-harvest-50">
    <!-- This file has been simplified due to size constraints -->
    <!-- Please use the shop.index route for the full e-commerce experience -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-4xl w-full">
            <div class="text-center mb-8">
                <x-application-logo class="h-20 w-20 mx-auto mb-4" />
                <h1 class="text-5xl font-bold text-gray-900 mb-4">Welcome to <span class="text-gradient-agri">FeedMart</span></h1>
                <p class="text-xl text-gray-600 mb-8">Your Trusted Agriculture & Animal Feed Partner</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <a href="{{ route('shop.index') }}" class="btn-agri text-center py-6 text-lg">
                    <svg class="w-6 h-6 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Shop Now
                </a>
                @guest
                <a href="{{ route('register') }}" class="btn-harvest text-center py-6 text-lg">
                    Create Account
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="btn-harvest text-center py-6 text-lg">
                    Go to Dashboard
                </a>
                @endguest
            </div>

            @if($featuredProducts->count() > 0)
            <div class="card mb-8">
                <div class="card-header">
                    <h2 class="text-2xl font-bold">Featured Products</h2>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($featuredProducts->take(4) as $product)
                        <a href="{{ route('shop.show', $product->id) }}" class="group">
                            <div class="aspect-square bg-gray-100 rounded-lg mb-2 overflow-hidden">
                                @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <h3 class="font-bold text-sm line-clamp-2 mb-1">{{ $product->name }}</h3>
                            <p class="text-agri-600 font-bold">KES {{ number_format($product->price, 2) }}</p>
                        </a>
                        @endforeach
                    </div>
                    <div class="text-center mt-6">
                        <a href="{{ route('shop.index') }}" class="text-agri-600 hover:text-agri-700 font-semibold">
                            View All Products →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center text-gray-600">
                <p>Quality Feed for Healthy Livestock | Trusted by 500+ Farmers</p>
            </div>
        </div>
    </div>
</body>
</html>
