@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-gray-300 rounded-xl shadow-sm focus:border-agri-500 focus:ring-2 focus:ring-agri-200 disabled:bg-gray-100 disabled:cursor-not-allowed transition-all duration-200 placeholder:text-gray-400']) }}>
