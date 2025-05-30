@props([
    'name' => '',
    'id' => '',
    'label' => '',
    'startLabel' => 'Tanggal Mulai',
    'endLabel' => 'Tanggal Akhir',
    'startPlaceholder' => 'Pilih tanggal mulai',
    'endPlaceholder' => 'Pilih tanggal akhir',
    'startValue' => '',
    'endValue' => '',
    'required' => false,
    'disabled' => false,
    'helpText' => '',
    'class' => '',
    'maxDate' => '',
    'minDate' => '',
])

<div {{ $attributes->merge(['class' => 'form-group ' . $class]) }}>
    @if ($label)
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div id="{{ $id }}" date-rangepicker datepicker-max-date="{{ $maxDate }}"
        datepicker-min-date="{{ $minDate }}" datepicker-format="yyyy-mm-dd" class="flex flex-col md:flex-row gap-4">
        <div class="relative w-full">
            @if ($startLabel)
                <label for="{{ $id }}-start"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ $startLabel }}
                    @if ($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
            @endif
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input type="text" id="{{ $id }}-start" name="{{ $name }}_start"
                    value="{{ $startValue }}" @if ($required) required @endif
                    @if ($disabled) disabled @endif
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="{{ $startPlaceholder }}">
            </div>
        </div>
        <div class="relative w-full">
            @if ($endLabel)
                <label for="{{ $id }}-end"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    {{ $endLabel }}
                    @if ($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
            @endif
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
                <input type="text" id="{{ $id }}-end" name="{{ $name }}_end"
                    value="{{ $endValue }}" @if ($required) required @endif
                    @if ($disabled) disabled @endif
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="{{ $endPlaceholder }}">
            </div>
        </div>
    </div>

    @if ($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif

    @error($name . '_start')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror

    @error($name . '_end')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
    @enderror

    {{ $slot }}
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateRangePicker = document.getElementById('{{ $id }}');
            if (dateRangePicker) {
                const startInput = document.getElementById('{{ $id }}-start');
                const endInput = document.getElementById('{{ $id }}-end');

                if (startInput && endInput) {
                    const options = {
                        format: 'yyyy-mm-dd',
                    };

                    new Datepicker(startInput, options);
                    new Datepicker(endInput, options);

                    // Ensure end date is not before start date
                    startInput.addEventListener('changeDate', function(e) {
                        const startDate = new Date(e.target.value);
                        const endDate = new Date(endInput.value);

                        if (endDate < startDate) {
                            endInput.value = e.target.value;
                        }
                    });
                }
            }
        });
    </script>
@endpush
