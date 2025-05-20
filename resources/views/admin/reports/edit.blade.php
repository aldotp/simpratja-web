<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Laporan',
                'url' => '/admin/reports',
            ],
            [
                'label' => 'Edit',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('admin.reports.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Edit Laporan') }}
                </h2>
            </div>

            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="space-y-4 mt-4">
                @csrf
                @method('PUT')

                <x-form.input name="title" id="title" label="Jenis Laporan" placeholder="Masukkan Jenis Laporan"
                    required :value="old('title', $report->report_type)" />

                <x-form.input name="period" id="period" label="Periode"
                    placeholder="Masukkan Periode (contoh: Januari 2023)" required :value="old('period', $report->period)" />

                <x-form.textarea label="Isi Laporan" name="content" placeholder="Masukkan isi konten"
                    :value="old('content', $report->report_content)" />

                <div class="flex justify-end mt-6">
                    <x-form.button type="submit" variant="primary">
                        Update Laporan
                    </x-form.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-dashboard-layout>
