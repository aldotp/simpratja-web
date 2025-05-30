<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Leader'],
            [
                'label' => 'Laporan',
                'url' => '/leader/reports',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Laporan') }}
                </h2>
            </div>
            <x-ui.table id="table-reports">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Jenis Laporan</th>
                        <th scope="col" class="px-6 py-3">Periode</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($reports as $report)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $report->report_type }}</td>
                        <td class="px-6 py-4">{{ $report->period }}</td>
                        <td class="px-6 py-4">
                            {{ Carbon\Carbon::parse($report->created_at)->translatedFormat('l, d F Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button class="!py-2 !px-2.5" variant="info"
                                    onclick="window.location.href='{{ route('leader.reports.show', $report->id) }}'">
                                    <i class="fas fa-eye mr-2"></i>
                                    {{ __('View') }}
                                </x-form.button>
                                <x-form.button class="!py-2 !px-2.5" variant="primary"
                                    onclick="window.location.href='{{ route('leader.reports.pdf', $report->id) }}'">
                                    <i class="fas fa-download mr-2"></i>
                                    {{ __('Download') }}
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse

            </x-ui.table>
        </x-ui.card>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable
                new simpleDatatables.DataTable('#table-reports', {
                    paging: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 15, 20],
                    fixedHeight: false,
                    labels: {
                        placeholder: 'Cari...',
                        perPage: 'data per halaman',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} sampai {end} dari {rows} data'
                    }
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
