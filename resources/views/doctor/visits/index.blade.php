<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Breadcrumb -->
        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Doctor'],
            ['label' => 'Kunjungan', 'url' => '/doctor/visits'],
        ]" />

        <!-- Card -->
        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Kunjungan') }}
                </h2>
                <span class="text-primary-600 dark:text-gray-400 font-bold text-lg mr-2">
                    {{ \Carbon\Carbon::parse(now())->translatedFormat('l, d F Y') }}
                </span>
            </div>

            <!-- Table -->
            <x-ui.table id="table-visits">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">No. REG</th>
                        <th scope="col" class="px-6 py-3">Antrian</th>
                        <th scope="col" class="px-6 py-3">Tgl. Periksa</th>
                        <th scope="col" class="px-6 py-3">Nama Pasien</th>
                        <th scope="col" class="px-6 py-3">No. HP</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($visits as $visit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $visit->registration_number }}</td>
                        <td class="px-6 py-4">{{ $visit->queue_number }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y') }}
                        </td>
                        <td class="px-6 py-4">{{ $visit->patient_name }}</td>
                        <td class="px-6 py-4">{{ $visit->patient_phone_number }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @switch($visit->visit_status)
                                    @case('queue')
                                        <x-ui.badge class="px-2 py-1.5 text-nowrap" variant="warning">
                                            <i class="fas fa-clipboard-check mr-1"></i> Dalam Antrian
                                        </x-ui.badge>
                                    @break

                                    @case('check')
                                        <x-form.button variant="primary" class="!py-1 !px-2 periksaBtn"
                                            data-id="{{ $visit->id }}"
                                            data-modal-target="medicalRecordModal-{{ $visit->id }}"
                                            data-modal-toggle="medicalRecordModal-{{ $visit->id }}">
                                            <i class="fas fa-stethoscope mr-1"></i> Periksa
                                        </x-form.button>
                                    @break

                                    @case('done')
                                        <x-ui.badge class="px-2 py-1.5 text-nowrap" variant="success">
                                            <i class="fas fa-check mr-1"></i> Selesai
                                        </x-ui.badge>
                                    @break

                                    @default
                                        <x-ui.badge class="px-2 py-1.5 text-nowrap" variant="secondary">
                                            <i class="fas fa-info mr-1"></i> Dalam Pendaftaran
                                        </x-ui.badge>
                                    @break
                                @endswitch
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Detail Rekam Medis -->
                    <x-dialog.modal id="medicalRecordModal-{{ $visit->id }}" title="Detail Rekam Medis"
                        size="xl" :showCloseButton="true" :static="true">
                        <form id="medicalRecordForm" action="{{ route('doctor.medical-records.store', $visit->id) }}"
                            method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <x-form.input id="dokter" name="dokter" label="Dokter" :disabled="true" />
                                </div>
                                <div>
                                    <x-form.input id="pasien" name="pasien" label="Pasien" :disabled="true" />
                                </div>
                            </div>
                            <div class="mb-4">
                                <div>
                                    <x-form.datepicker id="examination_date" name="examination_date"
                                        label="Tanggal Periksa" :required="true" disabled />
                                </div>
                            </div>
                            <div class="mb-4">
                                <x-form.input id="keluhan" name="complaint" label="Keluhan" :required="true" />
                            </div>
                            <div class="mb-4">
                                <x-form.textarea id="diagnosis" name="diagnosis" label="Diagnosis" rows="3"
                                    :required="true" />
                            </div>
                            <div class="mb-4">
                                <x-form.select id="medicine_id" name="medicine_id" label="Resep" :required="true"
                                    placeholder="Pilih Obat">
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok:
                                            {{ $medicine->stock }})</option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <input type="hidden" name="visit_id" id="visit_id">
                            <div class="flex justify-end space-x-2">
                                <x-form.button type="button" variant="secondary"
                                    data-modal-hide="medicalRecordModal-{{ $visit->id }}">Batal</x-form.button>
                                <x-form.button type="submit" variant="primary">Simpan</x-form.button>
                            </div>
                        </form>
                    </x-dialog.modal>

                    <!-- Modal Panggil Pasien -->
                    <x-dialog.modal id="callPatientModal-{{ $visit->id }}" title="Panggil Pasien" size="md"
                        :showCloseButton="true" :static="true">
                        <p class="text-gray-700 dark:text-gray-400 mb-4">Anda akan memanggil pasien <span
                                class="font-semibold">{{ $visit->patient_name }}</span>.</p>
                        <p class="text-blue-500 mb-4">Sistem akan mengubah status kunjungan pasien menjadi "check".</p>
                        <div class="flex justify-center space-x-2">
                            <x-form.button type="button" class="grow" variant="secondary"
                                data-modal-hide="callPatientModal-{{ $visit->id }}">Batal</x-form.button>
                            <form action="{{ route('doctor.visits.call-patient', $visit->id) }}" method="post">
                                @csrf
                                <x-form.button type="submit" class="grow" variant="info">
                                    <i class="fas fa-phone mr-1"></i> Panggil Pasien
                                </x-form.button>
                            </form>
                        </div>
                    </x-dialog.modal>

                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada data kunjungan</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

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

                const periksaBtns = document.querySelectorAll('.periksaBtn');

                periksaBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const visitId = this.getAttribute('data-id');
                        document.getElementById('visit_id').value = visitId;

                        // Fetch visit details via AJAX
                        fetch(`/doctor/visits/${visitId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('dokter').value = data.doctor_name;
                                document.getElementById('pasien').value = data.patient_name;
                                document.getElementById('examination_date').value = data.examination_date;
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
