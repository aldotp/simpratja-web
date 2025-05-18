@props([
    'items' => [],
    'separator' => 'slash' /* slash, chevron, dot */,
    'variant' => 'default' /* default, light, dark */,
    'size' => 'md' /* sm, md, lg */,
    'rounded' => false,
    'class' => '',
])

@php
    // Separator classes
    $separatorClasses = [
        'slash' =>
            '<svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>',
        'chevron' =>
            '<svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>',
        'dot' => '<span class="mx-2 text-gray-400">&bull;</span>',
    ];

    // Variant classes
    $variantClasses = [
        'default' => 'bg-transparent dark:bg-gray-800',
        'light' => 'bg-gray-50 dark:bg-gray-700',
        'dark' => 'bg-gray-100 dark:bg-gray-900',
    ];

    // Size classes
    $sizeClasses = [
        'sm' => 'py-2 px-3 text-xs',
        'md' => 'py-3 px-5 text-sm',
        'lg' => 'py-4 px-6',
    ];

    // Rounded classes
    $roundedClass = $rounded ? 'rounded-lg' : '';

    // Combine all classes
    $breadcrumbClasses =
        ($variantClasses[$variant] ?? $variantClasses['default']) .
        ' ' .
        ($sizeClasses[$size] ?? $sizeClasses['md']) .
        ' ' .
        $roundedClass .
        ' ' .
        $class;

    // Get separator HTML
    $separatorHtml = $separatorClasses[$separator] ?? $separatorClasses['slash'];
@endphp

<nav {{ $attributes->merge(['class' => $breadcrumbClasses]) }} aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        @foreach ($items as $index => $item)
            <li class="inline-flex items-center">
                @if ($index > 0)
                    <div class="flex items-center">
                        {!! $separatorHtml !!}
                    </div>
                @endif

                @if (isset($item['url']) && $index < count($items) - 1)
                    <a href="{{ $item['url'] }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                        @if (isset($item['icon']))
                            <span class="mr-2">{!! $item['icon'] !!}</span>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                        @if (isset($item['icon']))
                            <span class="mr-2">{!! $item['icon'] !!}</span>
                        @endif
                        {{ $item['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
