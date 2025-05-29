<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Rekam Medis',
                'url' => '/staff/medical-records',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Rekam Medis') }}
                </h2>
            </div>
            <x-ui.table id="table-medical-records" hoverable="true" striped="true">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">No. Rekam Medis</th>
                        <th scope="col" class="px-6 py-3">NIK Pasien</th>
                        <th scope="col" class="px-6 py-3">Nama Pasien</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($medicalRecords as $record)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $record->medical_record_number }}</td>
                        <td class="px-6 py-4">{{ $record->patient_nik }}</td>
                        <td class="px-6 py-4">{{ $record->patient_name }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($record->created_at)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button class="!py-2 !px-2.5" variant="info"
                                    data-modal-target="viewMedicalRecordModal"
                                    data-modal-toggle="viewMedicalRecordModal"
                                    data-record-id="{{ $record->patient_id }}">
                                    <i class="fas fa-eye"></i>
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data rekam medis</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    <!-- Modal View Medical Record -->
    <x-dialog.modal id="viewMedicalRecordModal" title="Catatan Rekam Medis" size="7xl">
        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-6 shadow">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Informasi Pasien</h3>
            <div class="patient-info flex flex-col gap-2 text-sm">
                <!-- Informasi pasien akan dimuat di sini melalui AJAX -->
            </div>
        </div>

        <div>
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-3">Riwayat Pemeriksaan</h3>
            <div class="overflow-x-auto">
                <x-ui.table id="medical-record-details-table" hoverable="true" striped="true" class="min-w-full">
                    <x-slot name="thead">
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                No</th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal Periksa</th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Keluhan</th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Diagnosis</th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Resep</th>
                        </tr>
                    </x-slot>
                    <tbody id="medical-record-details-body"
                        class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <!-- Data akan dimuat di sini melalui AJAX -->
                    </tbody>
                </x-ui.table>
            </div>
        </div>
    </x-dialog.modal>
    @push('scripts')
        @vite('resources/js/app.js')
        <script>
            // Pastikan Flowbite tersedia sebelum digunakan
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable
                new simpleDatatables.DataTable('#table-medical-records', {
                    paging: true,
                    perPage: 10,
                    perPageSelect: [5, 10, 15, 20, 25],
                    fixedHeight: false,
                    labels: {
                        placeholder: 'Cari...',
                        perPage: 'data per halaman',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} sampai {end} dari {rows} data'
                    }
                });

                const viewModalElement = document.getElementById('viewMedicalRecordModal');
                const viewModal = new Modal(viewModalElement);

                // Event listener untuk tombol yang membuka modal
                document.querySelectorAll('[data-modal-toggle="viewMedicalRecordModal"]').forEach(button => {
                    button.addEventListener('click', function() {
                        const recordId = this.getAttribute('data-record-id');
                        loadMedicalRecordDetails(recordId);
                    });
                });

                function loadMedicalRecordDetails(recordId) {
                    const patientInfoDiv = viewModalElement.querySelector('.patient-info');
                    const detailsTableBody = viewModalElement.querySelector('#medical-record-details-body');

                    // Tampilkan pesan loading
                    patientInfoDiv.innerHTML =
                        '<p class="text-center text-gray-500 dark:text-gray-400">Memuat informasi pasien...</p>';
                    detailsTableBody.innerHTML =
                        '<tr><td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">Memuat riwayat pemeriksaan...</td></tr>';

                    // Panggil API untuk mendapatkan detail
                    fetch(`/staff/medical-records/${recordId}/details`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                patientInfoDiv.innerHTML =
                                    `<p class="text-red-500 text-center">${data.error}</p>`;
                                detailsTableBody.innerHTML =
                                    `<tr><td colspan="8" class="px-4 py-3 text-center text-red-500">${data.error}</td></tr>`;
                                return;
                            }

                            // Tampilkan informasi pasien
                            if (data.data.details[0]) {
                                const mr = data.data.details[0];
                                patientInfoDiv.innerHTML = `
                                    <div><span class="font-semibold text-gray-700 dark:text-gray-300">No. Rekam Medis:</span> <span class="text-gray-600 dark:text-gray-400">${mr.medical_record_number || 'N/A'}</span></div>
                                    <div><span class="font-semibold text-gray-700 dark:text-gray-300">Nama Pasien:</span> <span class="text-gray-600 dark:text-gray-400">${mr.patient_name || 'N/A'}</span></div>
                                    <div><span class="font-semibold text-gray-700 dark:text-gray-300">Alamat Pasien:</span> <span class="text-gray-600 dark:text-gray-400">${mr.patient_address || 'N/A'}</span></div>
                                `;
                            } else {
                                patientInfoDiv.innerHTML =
                                    '<p class="text-center text-gray-500 dark:text-gray-400">Informasi pasien tidak ditemukan.</p>';
                            }

                            // Tampilkan riwayat pemeriksaan
                            if (data.data.details && data.data.details.length > 0) {
                                let detailsHtml = '';
                                data.data.details.forEach((detail, index) => {
                                    detailsHtml += `
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">${index + 1}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">${detail.examination_date || 'N/A'}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">${detail.complaint || 'N/A'}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">${detail.diagnosis || 'N/A'}</td>
                                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">${detail.medicines || 'N/A'}</td>
                                        </tr>
                                    `;
                                });
                                detailsTableBody.innerHTML = detailsHtml;
                            } else {
                                detailsTableBody.innerHTML =
                                    '<tr><td colspan="8" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">Tidak ada riwayat pemeriksaan.</td></tr>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching medical record details:', error);
                            patientInfoDiv.innerHTML =
                                '<p class="text-red-500 text-center">Gagal memuat informasi pasien.</p>';
                            detailsTableBody.innerHTML =
                                '<tr><td colspan="8" class="px-4 py-3 text-center text-red-500">Terjadi kesalahan saat memuat data. Silakan coba lagi.</td></tr>';
                        });
                }
            });

        </script>
    @endpush
</x-dashboard-layout>
