@props([
    'paginator' => null,
    'simple' => false,
    'size' => 'md' /* sm, md, lg */,
    'align' => 'center' /* left, center, right */,
    'rounded' => true,
    'class' => '',
])

@php
    // Size classes
    $sizeClasses = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base',
    ];

    // Alignment classes
    $alignClasses = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ];

    // Rounded classes
    $roundedClass = $rounded ? 'rounded-lg' : '';

    // Button base classes
    $buttonBaseClass = 'flex items-center ' . ($sizeClasses[$size] ?? $sizeClasses['md']);

    // Active button classes
    $activeButtonClass = $buttonBaseClass . ' text-white bg-primary-600 hover:bg-primary-700 ' . $roundedClass;

    // Inactive button classes
    $inactiveButtonClass =
        $buttonBaseClass .
        ' text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ' .
        $roundedClass;

    // Disabled button classes
    $disabledButtonClass =
        $buttonBaseClass .
        ' text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 ' .
        $roundedClass;

    // Container classes
    $containerClass = 'flex items-center ' . ($alignClasses[$align] ?? $alignClasses['center']) . ' ' . $class;
@endphp

@if ($paginator)
    <nav {{ $attributes->merge(['class' => $containerClass]) }} aria-label="Pagination">
        @if ($simple)
            {{-- Simple Pagination (Previous / Next only) --}}
            <ul class="flex items-center -space-x-px">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="{{ $disabledButtonClass }} mr-2">
                            <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                            </svg>
                            Sebelumnya
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" class="{{ $inactiveButtonClass }} mr-2">
                            <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                            </svg>
                            Sebelumnya
                        </a>
                    </li>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="{{ $inactiveButtonClass }}">
                            Selanjutnya
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="{{ $disabledButtonClass }}">
                            Selanjutnya
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>
        @else
            {{-- Full Pagination --}}
            <ul class="flex items-center -space-x-px">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="{{ $disabledButtonClass }} rounded-l-lg">
                            <span class="sr-only">Sebelumnya</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" class="{{ $inactiveButtonClass }} rounded-l-lg">
                            <span class="sr-only">Sebelumnya</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <span aria-current="page" class="{{ $activeButtonClass }}">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" class="{{ $inactiveButtonClass }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" class="{{ $inactiveButtonClass }} rounded-r-lg">
                            <span class="sr-only">Selanjutnya</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="{{ $disabledButtonClass }} rounded-r-lg">
                            <span class="sr-only">Selanjutnya</span>
                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>
        @endif
    </nav>
@endif
