<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Feedbacks',
                'url' => '/staff/feedbacks',
            ],
            [
                'label' => 'Detail',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center mb-6">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('staff.feedbacks.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Detail Feedback') }}
                </h2>
            </div>

            <div class="space-y-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Nama
                        Pasien</label>
                    <p class="text-gray-900 dark:text-gray-300">{{ $feedback->patient->name }}</p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Rating</label>
                    <x-ui.rating :value="$feedback->rating" readonly />
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Tanggal</label>
                    <p class="text-gray-900 dark:text-gray-300">
                        {{ Carbon\Carbon::parse($feedback->created_at)->translatedFormat('l, d F Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Feedback</label>
                    <p class="text-gray-900 dark:text-gray-300">{{ $feedback->feedback_content }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-dashboard-layout>
