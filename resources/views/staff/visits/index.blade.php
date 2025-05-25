<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Kunjungan',
                'url' => '/staff/visits',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Kunjungan') }}
                </h2>
                <span
                    class="text-primary-600 dark:text-gray-400 font-bold text-lg mr-2">{{ \Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }}</span>
            </div>
            <x-ui.table id="table-visits">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">No. REG</th>
                        <th scope="col" class="px-6 py-3">Tgl. Periksa</th>
                        <th scope="col" class="px-6 py-3">Nama Pasien</th>
                        <th scope="col" class="px-6 py-3">No. HP</th>
                        <th scope="col" class="px-6 py-3">Dokter</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>
                @forelse ($visits as $visit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $visit->registration_number }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y') }}</td>
                        <td class="px-6 py-4">{{ $visit->patient_name }}</td>
                        <td class="px-6 py-4">{{ $visit->patient_phone_number }}</td>
                        <td class="px-6 py-4">{{ $visit->doctor_name ?? 'Belum ditentukan' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button variant="info" class="!py-1 !px-2">
                                    <i class="fas fa-phone mr-1"></i> Panggil
                                </x-form.button>
                                <x-form.button variant="success" class="!py-1 !px-2 registrasiBtn"
                                    data-id="{{ $visit->id }}" data-modal-target="confirmationModal"
                                    data-modal-toggle="confirmationModal">
                                    <i class="fas fa-clipboard-check mr-1"></i> Konfirmasi
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada data kunjungan</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    <!-- Modal Konfirmasi Nomor Antrian -->
    <x-dialog.modal id="confirmationModal" title="Konfirmasi Nomor Antrian" size="md" :showCloseButton="true"
        :static="true">
        <p class="text-center text-gray-700 dark:text-gray-400 mb-4">Apakah Anda yakin ingin mendapatkan nomor antrian?
        </p>
        <div class="flex justify-center space-x-2">
            <x-form.button type="button" variant="secondary" data-modal-hide="confirmationModal">
                Batal
            </x-form.button>
            <x-form.button type="button" variant="primary" id="confirmQueueButton">
                Konfirmasi
            </x-form.button>
        </div>
    </x-dialog.modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable
                new simpleDatatables.DataTable('#table-visits', {
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

                const registrasiBtns = document.querySelectorAll('.registrasiBtn');

                registrasiBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const visitId = this.getAttribute('data-id');
                        document.getElementById('visit_id').value = visitId;

                        // Fetch visit details via AJAX
                        fetch(`/staff/visits/${visitId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('pasien').value = data.patient_name;
                                document.getElementById('no_hp').value = data.patient_phone ||
                                    'Tidak tersedia';
                                document.getElementById('examination_date').value = data
                                    .examination_date;
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
