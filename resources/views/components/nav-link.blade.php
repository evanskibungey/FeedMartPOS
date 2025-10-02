@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 border-b-4 border-agri-500 text-sm font-semibold leading-5 text-agri-700 bg-agri-50 rounded-t-lg focus:outline-none focus:border-agri-700 transition-all duration-200'
            : 'inline-flex items-center px-4 py-2 border-b-4 border-transparent text-sm font-medium leading-5 text-gray-600 hover:text-agri-600 hover:border-agri-300 hover:bg-agri-50/50 rounded-t-lg focus:outline-none focus:text-agri-700 focus:border-agri-300 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
