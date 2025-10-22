@php
$categories = \App\Models\Category::withCount('products')->get();
@endphp

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
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Home
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
                    @guest
                    <li>
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-agri-400 transition-colors flex items-center group">
                            <svg class="w-4 h-4 mr-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            Sign In
                        </a>
                    </li>
                    @endguest
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
