<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl font-semibold text-sm text-gray-700 uppercase tracking-wider shadow-sm hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-agri-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200']) }}>
    {{ $slot }}
</button>
