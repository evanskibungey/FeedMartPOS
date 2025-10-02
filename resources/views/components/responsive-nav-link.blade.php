@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-4 pe-4 py-3 border-l-4 border-agri-500 text-start text-base font-semibold text-agri-700 bg-agri-50 focus:outline-none focus:text-agri-800 focus:bg-agri-100 focus:border-agri-700 transition-all duration-200'
            : 'block w-full ps-4 pe-4 py-3 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-agri-700 hover:bg-agri-50 hover:border-agri-300 focus:outline-none focus:text-agri-800 focus:bg-agri-50 focus:border-agri-300 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
