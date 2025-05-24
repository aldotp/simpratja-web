<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Leader'],
            [
                'label' => 'Laporan',
                'url' => '/leader/reports',
            ],
            [
                'label' => 'Detail',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex justify-between">
                <div class="flex flex-row gap-4 items-center mb-6">
                    <x-form.button class="!p-3" variant="secondary"
                        onclick="window.location.href='{{ route('leader.reports.index') }}'">
                        <i class="fa-solid fa-angle-left"></i>
                    </x-form.button>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                        {{ __('Detail Laporan') }}
                    </h2>
                </div>
                <div>
                    <a href="{{ route('leader.reports.show', $report->id) }}" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        {{ __('Download') }}
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Jenis Laporan</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $report->report_type }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Periode</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">{{ $report->period }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tanggal Dibuat</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        {{ Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d F Y') }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Terakhir Diperbarui</h3>
                    <p class="mt-1 text-gray-600 dark:text-gray-400">
                        {{ Carbon\Carbon::parse($report->updated_at)->translatedFormat('l, d F Y') }}</td>
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Isi Laporan</h3>
                    <div
                        class="mt-2 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="prose dark:prose-invert max-w-none">
                            {!! $report->report_content !!}
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-dashboard-layout>