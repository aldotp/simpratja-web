<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Leader'],
            [
                'label' => 'Feedbacks',
                'url' => '/leader/feedbacks',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Daftar Feedback Pasien</h2>
            </div>

            <x-ui.table id="table-feedbacks" hoverable>
                <x-slot name="thead">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Pasien</th>
                        <th class="px-4 py-3">Feedback</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Rating</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($feedbacks as $feedback)
                    <tr>
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $feedback->name }}</td>
                        <td class="px-4 py-3">{{ Str::limit($feedback->feedback_content, 30) }}</td>
                        <td class="px-4 py-3">{{ Carbon\Carbon::parse($feedback->created_at)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <x-ui.rating :value="$feedback->rating" readonly />
                        </td>
                        <td class="px-4 py-3">
                            <x-form.button variant="info" class="!py-2 !px-2.5"
                                data-modal-target="feedbackModal-{{ $feedback->id }}"
                                data-modal-toggle="feedbackModal-{{ $feedback->id }}" data-id="{{ $feedback->id }}">
                                <i class="fas fa-eye"></i>
                            </x-form.button>
                        </td>
                    </tr>

                    <x-dialog.modal id="feedbackModal-{{ $feedback->id }}" title="Detail Feedback" size="2xl">
                        <div class="space-y-6">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Nama
                                    Pasien</label>
                                <p class="text-gray-900 dark:text-gray-300">{{ $feedback->name }}</p>
                            </div>
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Rating</label>
                                <x-ui.rating :value="$feedback->rating" readonly />
                            </div>
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Tanggal</label>
                                <p class="text-gray-900 dark:text-gray-300">
                                    {{ Carbon\Carbon::parse($feedback->created_at)->translatedFormat('l, d F Y') }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Feedback</label>
                                <p class="text-gray-900 dark:text-gray-300">{{ $feedback->feedback_content }}</p>
                            </div>
                        </div>
                    </x-dialog.modal>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new simpleDatatables.DataTable('#table-feedbacks', {
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
