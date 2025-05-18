@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'placeholder' => 'Pilih tanggal',
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

    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
        </div>
        <input datepicker type="text" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
            @if ($required) required @endif @if ($disabled) disabled @endif
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="{{ $placeholder }}">
    </div>

    @if ($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror

    {{ $slot }}
</div>
