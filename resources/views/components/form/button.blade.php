@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'fullWidth' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'font-medium rounded-md transition duration-300';

    $variantClasses = [
        'primary' => 'bg-primary-600 hover:bg-primary-700 text-white',
        'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800',
        'outline' => 'bg-transparent border border-primary-600 text-primary-600 hover:bg-primary-50',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
    ];

    $sizeClasses = [
        'sm' => 'px-4 py-2 text-sm',
        'md' => 'px-6 py-3',
        'lg' => 'px-8 py-4 text-lg',
    ];

    $widthClass = $fullWidth ? 'w-full' : '';

    $classes =
        $baseClasses .
        ' ' .
        ($variantClasses[$variant] ?? $variantClasses['primary']) .
        ' ' .
        ($sizeClasses[$size] ?? $sizeClasses['md']) .
        ' ' .
        $widthClass;
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}
    @if ($disabled) disabled @endif>
    {{ $slot }}
</button>
