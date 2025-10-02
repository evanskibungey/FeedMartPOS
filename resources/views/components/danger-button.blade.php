<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 border border-transparent rounded-xl font-semibold text-sm text-white uppercase tracking-wider hover:from-red-700 hover:to-red-800 hover:shadow-lg active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
