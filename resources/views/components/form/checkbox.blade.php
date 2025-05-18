@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'value' => '',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'helpText' => '',
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'flex items-start ' . $class]) }}>
    <div class="flex items-center h-5">
        <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            @if ($checked) checked @endif @if ($required) required @endif
            @if ($disabled) disabled @endif
            class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
    </div>
    <div class="ml-3 text-sm">
        @if ($label)
            <label for="{{ $id }}" class="font-medium text-gray-700">
                {!! $label !!}
            </label>
        @endif

        @if ($helpText)
            <p class="text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
        @endif

        @error($name)
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
        @enderror

        {{ $slot }}
    </div>
</div>
