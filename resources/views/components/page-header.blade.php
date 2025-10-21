@props(['title', 'action' => null, 'actionLabel' => null, 'actionIcon' => true])

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 animate-fade-in-up">
    <!-- Page Title Section -->
    <div class="flex items-center space-x-3">
        <div class="h-10 w-1 bg-gradient-harvest rounded-full"></div>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 leading-tight">{{ $title }}</h1>
            @isset($subtitle)
                <p class="text-sm text-gray-600 mt-1">{{ $subtitle }}</p>
            @endisset
        </div>
    </div>

    <!-- Action Buttons Section - Right Aligned -->
    @if($action)
        <div class="flex items-center gap-2 sm:gap-3">
            {{ $slot }}
            <a href="{{ $action }}" 
               class="btn-agri inline-flex items-center justify-center space-x-2 whitespace-nowrap group shadow-lg hover:shadow-xl transition-all duration-300">
                @if($actionIcon)
                    <svg class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                @endif
                <span class="font-semibold">{{ $actionLabel ?? 'Add New' }}</span>
            </a>
        </div>
    @endif
</div>
