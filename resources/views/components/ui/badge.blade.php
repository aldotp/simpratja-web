@props([
    'variant' => 'primary',
    'size' => 'md',
    'pill' => false,
    'outline' => false,
])

@php
    // Define color variants based on Flowbite design
    $variants = [
        'primary' => 'bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300',
        'secondary' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
        'success' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'danger' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'warning' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'info' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'light' => 'bg-gray-50 text-gray-800 dark:bg-gray-600 dark:text-gray-300',
        'dark' => 'bg-gray-800 text-gray-50 dark:bg-gray-900 dark:text-gray-50',
    ];

    // Define outline variants
    $outlineVariants = [
        'primary' => 'bg-transparent border border-primary-400 text-primary-800 dark:border-primary-600 dark:text-primary-400',
        'secondary' => 'bg-transparent border border-gray-400 text-gray-800 dark:border-gray-600 dark:text-gray-400',
        'success' => 'bg-transparent border border-green-400 text-green-800 dark:border-green-600 dark:text-green-400',
        'danger' => 'bg-transparent border border-red-400 text-red-800 dark:border-red-600 dark:text-red-400',
        'warning' =>
            'bg-transparent border border-yellow-400 text-yellow-800 dark:border-yellow-600 dark:text-yellow-400',
        'info' => 'bg-transparent border border-blue-400 text-blue-800 dark:border-blue-600 dark:text-blue-400',
        'light' => 'bg-transparent border border-gray-200 text-gray-800 dark:border-gray-700 dark:text-gray-300',
        'dark' => 'bg-transparent border border-gray-800 text-gray-800 dark:border-gray-700 dark:text-gray-300',
    ];

    // Define sizes
    $sizes = [
        'sm' => 'text-xs px-2 py-0.5',
        'md' => 'text-xs px-2.5 py-0.5',
        'lg' => 'text-sm px-3 py-1',
    ];

    // Determine rounded style
    $rounded = $pill ? 'rounded-full' : 'rounded';

    // Determine color variant
    $colorClasses = $outline
        ? $outlineVariants[$variant] ?? $outlineVariants['primary']
        : $variants[$variant] ?? $variants['primary'];

    // Determine size
    $sizeClasses = $sizes[$size] ?? $sizes['md'];

    // Combine all classes
    $classes = $colorClasses . ' ' . $sizeClasses . ' ' . $rounded . ' font-medium';
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
