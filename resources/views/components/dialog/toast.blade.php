@props([
    'id' => 'toast-' . uniqid(),
    'type' => 'default' /* default, success, error, warning, info */,
    'message' => '',
    'title' => '',
    'dismissible' => true,
    'position' => 'bottom-right' /* top-right, top-left, bottom-right, bottom-left */,
    'duration' => 5000 /* in milliseconds, 0 for persistent */,
    'show' => false,
])

@php
    $typeClasses =
        [
            'default' => 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800',
            'success' => 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
            'error' => 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
            'warning' => 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200',
            'info' => 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200',
        ][$type] ?? 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800';

    $positionClasses =
        [
            'top-right' => 'top-5 right-5',
            'top-left' => 'top-5 left-5',
            'bottom-right' => 'bottom-5 right-5',
            'bottom-left' => 'bottom-5 left-5',
        ][$position] ?? 'bottom-5 right-5';

    $icons =
        [
            'default' =>
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
            'success' =>
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>',
            'error' =>
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.5 11.5a1 1 0 0 1-2 0v-4a1 1 0 0 1 2 0v4Zm0 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/></svg>',
            'warning' =>
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
            'info' =>
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
        ][$type] ??
        '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>';

    $displayClass = $show ? '' : 'hidden';
@endphp

<!-- Toast -->
<div id="{{ $id }}"
    {{ $attributes->merge(['class' => "fixed z-50 flex items-center w-full max-w-xs p-4 rounded-lg shadow {$typeClasses} {$positionClasses} {$displayClass}"]) }}
    role="alert" @if ($duration > 0) data-toast-duration="{{ $duration }}" @endif>
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8">
        {!! $icons !!}
    </div>
    <div class="ml-3 text-sm font-normal">
        @if ($title)
            <span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">{{ $title }}</span>
        @endif
        <div class="text-sm font-normal">{{ $message }}</div>
        {{ $slot }}
    </div>
    @if ($dismissible)
        <button type="button"
            class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
            data-dismiss-target="#{{ $id }}" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
        </button>
    @endif
</div>

@if ($duration > 0)
    <script>
        // Auto-hide toast after duration
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('{{ $id }}');
            if (toast && !toast.classList.contains('hidden')) {
                const duration = toast.getAttribute('data-toast-duration');
                if (duration) {
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, parseInt(duration));
                }
            }
        });
    </script>
@endif
