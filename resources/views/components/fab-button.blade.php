@props(['action', 'label' => 'Add', 'icon' => true])

<!-- Floating Action Button (Mobile Only) -->
<div class="fixed bottom-6 right-6 z-40 lg:hidden">
    <a href="{{ $action }}" 
       class="flex items-center justify-center h-14 w-14 bg-gradient-harvest text-white rounded-full shadow-2xl hover:shadow-harvest transition-all duration-300 transform hover:scale-110 group"
       title="{{ $label }}">
        @if($icon)
            <svg class="h-6 w-6 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
        @else
            {{ $slot }}
        @endif
        
        <!-- Ripple Effect -->
        <span class="absolute inset-0 rounded-full bg-white opacity-0 group-hover:opacity-20 group-hover:animate-ping"></span>
    </a>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
    }
    
    .fixed.bottom-6.right-6 a {
        animation: float 3s ease-in-out infinite;
    }
</style>
