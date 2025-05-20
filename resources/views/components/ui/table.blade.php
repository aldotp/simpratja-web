@props([
    'striped' => false,
    'hoverable' => true,
    'bordered' => false,
    'size' => 'md' /* sm, md, lg */,
    'variant' => 'default' /* default, light, dark */,
    'rounded' => 'lg' /* none, sm, md, lg, xl */,
    'shadow' => 'md' /* none, sm, md, lg, xl */,
    'responsive' => false,
    'class' => '',
])

@php
    // Base classes
    $baseClasses = 'w-full text-left text-gray-500 dark:text-gray-400 min-h-[200px]';

    // Variant classes
    $variantClasses = [
        'default' => 'bg-white dark:bg-gray-800',
        'light' => 'bg-gray-50 dark:bg-gray-700',
        'dark' => 'bg-gray-100 dark:bg-gray-900',
    ];

    // Size classes
    $sizeClasses = [
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base',
    ];

    // Shadow classes
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
    ];

    // Striped, hoverable, and bordered classes
    $stripedClass = $striped ? 'table-striped' : '';
    $hoverableClass = $hoverable ? 'table-hover' : '';
    $borderedClass = $bordered ? 'table-bordered' : '';

    // Combine all classes
    $tableClasses =
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
        $stripedClass .
        ' ' .
        $hoverableClass .
        ' ' .
        $borderedClass .
        ' ' .
        $class;

    // Responsive wrapper class
    $responsiveClass = $responsive ? 'overflow-x-auto' : '';
@endphp

<div>
    {{-- Top slot for buttons, search, filters --}}
    @if (isset($top))
        <div
            class="flex flex-col md:flex-row place-content-end items-start md:items-center py-4 bg-white dark:bg-gray-800">
            {{ $top }}
        </div>
    @endif

    <table {{ $attributes->merge(['class' => $tableClasses, $responsiveClass]) }}>
        @if (isset($thead))
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                {{ $thead }}
            </thead>
        @endif

        <tbody>
            {{ $slot }}
        </tbody>

        @if (isset($tfoot))
            <tfoot class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                {{ $tfoot }}
            </tfoot>
        @endif
    </table>
</div>

{{-- Add custom styles for striped, hoverable, and bordered tables --}}
<style>
    .table-striped tbody tr:nth-child(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .dark .table-striped tbody tr:nth-child(odd) {
        background-color: rgba(255, 255, 255, 0.02);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .dark .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table-bordered {
        border: 1px solid #e5e7eb;
    }

    .dark .table-bordered {
        border: 1px solid #374151;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #e5e7eb;
    }

    .dark .table-bordered th,
    .dark .table-bordered td {
        border: 1px solid #374151;
    }
</style>
