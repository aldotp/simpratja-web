<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Riwayat Kunjungan',
                'url' => '/staff/history-visits',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Riwayat Kunjungan') }}
                </h2>
            </div>
            <x-ui.table id="table-history-visits">
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
                        <td class="px-6 py-4">{{ $visit->patient->phone_number }}</td>
                        <td class="px-6 py-4">{{ $visit->doctor_name ?? 'Belum ditentukan' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-row gap-4">
                                <span
                                    :class="$visit->>visit_status == 'register' ? 'bg-yellow-600 text-white' :
                                        'bg-green-600 text-white'"
                                    class="inline-flex items-center px-4 py-2 rounded-md font-medium text-sm shadow-sm hover:bg-opacity-90 transition duration-150 ease-in-out">
                                    {{ $visit->visit_status == 'register' ? 'Belum Registrasi' : 'Sudah Registrasi' }}
                                </span>
                                <x-form.button variant="primary" class="!py-1 !px-2 checkupBtn"
                                    data-id="{{ $visit->id }}" data-modal-target="checkupModal"
                                    data-modal-toggle="checkupModal">
                                    <i class="fas fa-stethoscope mr-1"></i> Check Up
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada riwayat kunjungan</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    <!-- Modal Detail Pemeriksaan -->
    <x-dialog.modal id="checkupModal" title="Detail Pemeriksaan" size="lg" :showCloseButton="true" :static="true">
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form.input type="text" label="Dokter" id="doctor_name" readonly />
                <x-form.input type="text" id="patient_name" label="Pasien" readonly />
            </div>
            <div>
                <x-form.input label="Tanggal Periksa" id="examination_date" type="text" readonly />
            </div>
            <div>
                <x-form.textarea label="Keluhan" id="complaint" readonly rows="3" />
            </div>
            <div>
                <x-form.textarea label="Diagnosis" id="diagnosis" readonly rows="3" />
            </div>
            <div>
                <x-form.input label="Resep" id="prescription" type="text" readonly />
            </div>
        </div>
    </x-dialog.modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable with datetime sorting
                new simpleDatatables.DataTable('#table-history-visits', {
                    paging: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 15, 20],
                    fixedHeight: false,
                    sortable: true,
                    columns: [{
                        select: 2,
                        type: 'date',
                        format: 'YYYY-MM-DD'
                    }],
                    labels: {
                        placeholder: 'Cari...',
                        perPage: 'data per halaman',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} sampai {end} dari {rows} data'
                    }
                });

                // Handle checkup button click
                const checkupBtns = document.querySelectorAll('.checkupBtn');
                checkupBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const visitId = this.getAttribute('data-id');
                        // Fetch visit details
                        fetch(`/staff/visits/${visitId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('doctor_name').value = data.doctor_name;
                                document.getElementById('patient_name').value = data.patient_name;
                                document.getElementById('examination_date').value = data
                                    .examination_date;
                                document.getElementById('complaint').value = data.complaint || '-';
                                document.getElementById('diagnosis').value = data.diagnosis || '-';
                                document.getElementById('prescription').value = data.prescription ||
                                    '-';
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
