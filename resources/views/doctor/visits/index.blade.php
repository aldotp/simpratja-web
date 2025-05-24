<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Doctor'],
            [
                'label' => 'Kunjungan',
                'url' => '/doctor/visits',
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
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>
                @forelse ($visits as $visit)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $visit->registration_number }}</td>
                        <td class="px-6 py-4">{{ date('Y-m-d', strtotime($visit->examination_date)) }}</td>
                        <td class="px-6 py-4">{{ $visit->patient->name }}</td>
                        <td class="px-6 py-4">{{ $visit->patient->phone_number }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button variant="info" class="!py-1 !px-2">
                                    <i class="fas fa-phone mr-1"></i> Panggil
                                </x-form.button>
                                <x-form.button variant="primary" class="!py-1 !px-2 panggilBtn"
                                    data-id="{{ $visit->id }}" data-modal-target="medicalRecordModal"
                                    data-modal-toggle="medicalRecordModal">
                                    <i class="fas fa-stethoscope mr-1"></i> Periksa
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data kunjungan</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    <!-- Modal Detail Rekam Medis -->
    <x-dialog.modal id="medicalRecordModal" title="Detail Rekam Medis" size="xl" :showCloseButton="true"
        :static="true">
        <form id="medicalRecordForm" action="{{ route('doctor.medical-records.store') }}" method="POST">
            @csrf
            <input type="hidden" name="visit_id" id="visit_id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-form.input id="dokter" name="dokter" label="Dokter" :disabled="true" />
                </div>
                <div>
                    <x-form.input id="pasien" name="pasien" label="Pasien" :disabled="true" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-form.datepicker id="examination_date" name="examination_date" label="Tanggal Periksa"
                        :required="true" />
                </div>
                <div>
                    <x-form.input id="keluhan" name="complaint" label="Keluhan" :required="true" />
                </div>
            </div>
            <div class="mb-4">
                <x-form.textarea id="diagnosis" name="diagnosis" label="Diagnosis" rows="3" :required="true" />
            </div>
            <div class="mb-4">
                <x-form.select id="medicine_id" name="medicine_id" label="Resep" :required="true">
                    <option value="">Pilih Obat</option>
                    @foreach ($medicines as $medicine)
                        <option value="{{ $medicine->id }}">{{ $medicine->name }} (Stok: {{ $medicine->stock }})
                        </option>
                    @endforeach
                </x-form.select>
            </div>
            <div class="flex justify-end space-x-2">
                <x-form.button type="button" variant="secondary" data-modal-hide="medicalRecordModal">
                    Batal
                </x-form.button>
                <x-form.button type="submit" variant="primary">
                    Simpan
                </x-form.button>
            </div>
        </form>
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

                const panggilBtns = document.querySelectorAll('.panggilBtn');

                panggilBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const visitId = this.getAttribute('data-id');
                        document.getElementById('visit_id').value = visitId;

                        // Fetch visit details via AJAX
                        fetch(`/doctor/visits/${visitId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('dokter').value = data.doctor_name;
                                document.getElementById('pasien').value = data.patient_name;
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
