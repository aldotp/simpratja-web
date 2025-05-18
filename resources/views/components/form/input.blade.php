@props([
    'name' => '',
    'id' => '',
    'type' => 'text',
    'label' => '',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'helpText' => '',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'form-group ' . $class]) }}>
    @if ($label)
        <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        @if ($disabled) disabled @endif
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

    @if ($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror

    {{ $slot }}
</div>
