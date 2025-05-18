@props([
    'id' => 'modal',
    'title' => '',
    'size' => 'md' /* xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl */,
    'showCloseButton' => true,
    'static' => false,
    'centered' => false,
])

@php
    $sizeClasses =
        [
            'xs' => 'max-w-xs',
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
        ][$size] ?? 'max-w-md';

    $modalAttributes = $static ? ['data-modal-backdrop' => 'static'] : [];
    $positionClass = $centered ? 'items-center' : 'items-start';
@endphp

<!-- Modal -->
<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    {{ $attributes->merge(['class' => 'fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full']) }}
    @foreach ($modalAttributes as $attribute => $value)
        {{ $attribute }}="{{ $value }}" @endforeach>
    <div class="relative w-full {{ $positionClass }} {{ $sizeClasses }} max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            @if ($title || $showCloseButton)
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    @if ($title)
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $title }}
                        </h3>
                    @endif
                    @if ($showCloseButton)
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            onclick="DialogManager.hideModal('{{ $id }}')">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    @endif
                </div>
            @endif

            <!-- Modal body -->
            <div class="p-6 space-y-6">
                {{ $slot }}
            </div>

            <!-- Modal footer -->
            @if (isset($footer))
                <div
                    class="flex items-center justify-end p-4 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
