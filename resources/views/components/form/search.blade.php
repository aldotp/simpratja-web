@props([
    'name' => '',
    'id' => '',
    'placeholder' => 'Search',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'helpText' => '',
    'class' => '',
    'buttonText' => '',
    'buttonClass' => '',
    'iconPosition' => 'left',
    'showButton' => false,
])

<div {{ $attributes->merge(['class' => 'form-group ' . $class]) }}>
    <div class="relative">
        @if ($iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                {{ $slot }}
            </div>
        @endif

        <input type="search" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            placeholder="{{ $placeholder }}" @if ($required) required @endif
            @if ($disabled) disabled @endif
            class="block w-full p-2.5 {{ $iconPosition === 'left' ? 'pl-10' : 'pr-10' }} text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

        @if ($iconPosition === 'right' && !$showButton)
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                {{ $slot }}
            </div>
        @endif

        @if ($showButton)
            <button type="submit"
                class="absolute right-0 top-0 h-full px-4 text-sm font-medium text-white bg-primary-600 rounded-r-lg border border-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 {{ $buttonClass }}">
                @if ($buttonText)
                    {{ $buttonText }}
                @else
                    <i class="fa-solid fa-magnifying-glass"></i>
                @endif
            </button>
        @endif
    </div>

    @if ($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror
</div>
