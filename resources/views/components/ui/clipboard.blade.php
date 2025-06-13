@props([
    'target' => '',
    'label' => 'Copy',
    'showIcon' => true,
    'showTooltip' => true,
    'contentType' => 'value', /* value, innerHTML, textContent */
    'decodeHtmlEntities' => false,
    'position' => 'inside' /* inside, outside */
])

@php
    $buttonClasses = match($position) {
        'inside' => 'absolute end-2.5 top-1/2 -translate-y-1/2 inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-2.5 py-2 text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700',
        default => 'inline-flex items-center justify-center rounded-lg border border-gray-200 bg-white px-2.5 py-2 text-gray-900 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700'
    };

    $iconClasses = 'me-1.5 h-3.5 w-3.5';
    $labelClasses = 'text-xs font-semibold';

    $attributes = $attributes->merge([
        'data-copy-to-clipboard-target' => $target,
        'type' => 'button',
        'class' => $buttonClasses
    ]);

    if ($contentType !== 'value') {
        $attributes = $attributes->merge([
            'data-copy-to-clipboard-content-type' => $contentType
        ]);
    }

    if ($decodeHtmlEntities) {
        $attributes = $attributes->merge([
            'data-copy-to-clipboard-html-entities' => 'true'
        ]);
    }
@endphp

<button {{ $attributes }}>
    @if($showIcon)
        <svg class="{{ $iconClasses }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
            <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Z"/>
        </svg>
        <svg class="{{ $iconClasses }} hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
        </svg>
    @endif
    <span class="{{ $labelClasses }}">{{ $label }}</span>
</button>

@if($showTooltip)
<div data-tooltip-target="{{ $target }}-tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    Copied!
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
@endif