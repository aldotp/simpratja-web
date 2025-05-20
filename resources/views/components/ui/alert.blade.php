@props([
    'type' => 'info',
    'dismissible' => false,
    'messages' => [],
    'message' => '',
])

@php
    // Define alert colors based on type
    $alertClasses = [
        'success' =>
            'text-green-800 bg-green-50 dark:bg-gray-800 dark:text-green-400 border-green-300 dark:border-green-800',
        'error' => 'text-red-800 bg-red-50 dark:bg-gray-800 dark:text-red-400 border-red-300 dark:border-red-800',
        'warning' =>
            'text-yellow-800 bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300 border-yellow-300 dark:border-yellow-800',
        'info' => 'text-blue-800 bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border-blue-300 dark:border-blue-800',
    ];

    // Get the appropriate class based on type
    $alertClass = $alertClasses[$type] ?? $alertClasses['info'];

    // Define icon based on type
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-times-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle',
    ];

    $icon = $icons[$type] ?? $icons['info'];

    // Convert single message to array if provided
    if (!empty($message) && empty($messages)) {
        $messages = [$message];
    }
@endphp

@if (!empty($messages))
    <div id="alert-{{ Str::random(10) }}" class="flex p-4 mb-4 border rounded-lg {{ $alertClass }}" role="alert">
        <div class="flex items-center">
            <i class="fas {{ $icon }} mr-2 text-lg"></i>
            <div>
                @if (count($messages) === 1)
                    <span class="font-medium">{{ $messages[0] }}</span>
                @else
                    <span class="font-medium">Perhatian:</span>
                    <ul class="mt-1.5 ml-4 list-disc list-inside">
                        @foreach ($messages as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        @if ($dismissible)
            <button type="button"
                class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 inline-flex h-8 w-8 {{ $alertClass }}"
                data-dismiss-target="#alert-{{ Str::random(10) }}" aria-label="Close">
                <span class="sr-only">Tutup</span>
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
@endif
