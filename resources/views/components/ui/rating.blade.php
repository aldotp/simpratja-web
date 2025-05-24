@props([
    'value' => 0,
    'readonly' => false,
    'size' => 'md',
    'color' => 'warning',
])

@php
    $sizeClasses =
        [
            'sm' => 'w-4 h-4',
            'md' => 'w-5 h-5',
            'lg' => 'w-7 h-7',
        ][$size] ?? 'w-5 h-5';

    $colorClasses =
        [
            'warning' => 'text-yellow-300 dark:text-yellow-400',
            'primary' => 'text-primary-300 dark:text-primary-400',
            'success' => 'text-green-300 dark:text-green-400',
            'info' => 'text-blue-300 dark:text-blue-400',
            'danger' => 'text-red-300 dark:text-red-400',
        ][$color] ?? 'text-yellow-300';

    $value = min(max($value, 0), 5);
@endphp

<div class="flex items-center space-x-1">
    @for ($i = 1; $i <= 5; $i++)
        @if (!$readonly)
            <button type="button"
                class="{{ $sizeClasses }} {{ $i <= $value ? $colorClasses : 'text-gray-300 dark:text-gray-500' }}">
                <span class="sr-only">Star {{ $i }}</span>
                <svg class="{{ $sizeClasses }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 22 20">
                    <path
                        d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                </svg>
            </button>
        @else
            <svg class="{{ $sizeClasses }} {{ $i <= $value ? $colorClasses : 'text-gray-300 dark:text-gray-500' }}"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                <path
                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
            </svg>
        @endif
    @endfor
</div>
