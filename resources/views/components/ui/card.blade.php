@props([
    'title' => '',
    'subtitle' => '',
    'variant' => 'default',
    'size' => 'md',
    'imgSrc' => '',
    'imgAlt' => '',
    'imgPosition' => 'top',
    'footer' => false,
    'hover' => false,
    'shadow' => 'md',
    'rounded' => 'lg',
    'border' => false,
    'horizontal' => false,
    'class' => '',
])

@php
    // Base classes
    $baseClasses = 'bg-white dark:bg-gray-800 overflow-hidden';

    // Variant classes
    $variantClasses = [
        'default' => 'bg-white dark:bg-gray-800',
        'primary' => 'bg-primary-50 dark:bg-primary-900',
        'secondary' => 'bg-gray-50 dark:bg-gray-900',
        'success' => 'bg-green-50 dark:bg-green-900',
        'danger' => 'bg-red-50 dark:bg-red-900',
        'warning' => 'bg-yellow-50 dark:bg-yellow-900',
        'info' => 'bg-blue-50 dark:bg-blue-900',
    ];

    // Size classes
    $sizeClasses = [
        'sm' => 'p-3',
        'md' => 'p-5',
        'lg' => 'p-6',
        'xl' => 'p-8',
    ];

    // S♦adow classes
    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
    ];

    // Rounded classes
    $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        'full' => 'rounded-full',
    ];

    // Border classes
    $borderClass = $border ? 'border border-gray-200 dark:border-gray-700' : '';

    // Hover effect
    $hoverClass = $hover ? 'transition-transform duration-300 hover:scale-105 hover:shadow-lg' : '';

    // Horizontal layout
    $layoutClass = $horizontal ? 'flex flex-col md:flex-row' : 'flex flex-col';

    // Combine all classes
    $cardClasses =
        $baseClasses .
        ' ' .
        ($variantClasses[$variant] ?? $variantClasses['default']) .
        ' ' .
        ($sizeClasses[$size] ?? $sizeClasses['md']) .
        ' ' .
        ($shadowClasses[$shadow] ?? $shadowClasses['md']) .
        ' ' .
        ($roundedClasses[$rounded] ?? $roundedClasses['lg']) .
        ' ' .
        $borderClass .
        ' ' .
        $hoverClass .
        ' ' .
        $class;

    // Image position classes
    $imgContainerClass = $horizontal ? 'md:w-1/3' : 'w-full';
    $contentContainerClass = $horizontal ? 'md:w-2/3' : 'w-full';
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    <div class="{{ $layoutClass }}">
        @if ($imgSrc)
            <div class="{{ $imgContainerClass }} {{ $imgPosition === 'top' ? 'order-1' : 'order-2' }}">
                <img src="{{ $imgSrc }}" alt="{{ $imgAlt }}"
                    class="w-full h-auto object-cover {{ $roundedClasses[$rounded] ?? $roundedClasses['lg'] }}">
            </div>
        @endif

        <div class="{{ $contentContainerClass }} {{ $imgPosition === 'top' ? 'order-2' : 'order-1' }}">
            @if ($title || $subtitle)
                <div class="mb-4">
                    @if ($title)
                        <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}
                        </h5>
                    @endif

                    @if ($subtitle)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif

            <div class="text-gray-700 dark:text-gray-300">
                {{ $slot }}
            </div>

            @if ($footer)
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
