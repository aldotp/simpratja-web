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

            <form action="{{ route('staff.history-visits') }}" method="GET" class="mb-6">
                <div class="flex flex-col md:flex-row justify-end gap-2">
                    <div>
                        <x-ui.daterangepicker id="visit-date-filter" name="visit_date" startLabel="Tanggal Mulai" endLabel="Tanggal Akhir"
                            startPlaceholder="Pilih tanggal mulai" endPlaceholder="Pilih tanggal akhir"
                            maxDate="{{ now()->format('Y-m-d') }}"
                            :startValue="request('visit_date_start', '')" :endValue="request('visit_date_end', '')" />
                    </div>
                    <div class="flex items-end">
                        <x-form.button type="submit" class="w-full md:w-auto">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </x-form.button>
                        @if (request('visit_date_start') || request('visit_date_end'))
                            <a href="{{ route('staff.history-visits') }}"
                                class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
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
                                <span x-data="{ status: '{{ $visit->visit_status }}' }"
                                    :class="{
                                        'bg-yellow-500 text-white': status === 'register',
                                        'bg-green-600 text-white': status !== 'register'
                                    }"
                                    class="inline-flex gap-2 items-center px-4 py-2 rounded-md font-medium shadow-sm hover:bg-opacity-90 transition duration-150 ease-in-out text-xs">
                                    @if ($visit->visit_status === 'register')
                                        <i class="fas fa-clipboard-check mr-1"></i>
                                    @else
                                        <i class="fas fa-check mr-1"></i>
                                    @endif
                                    <span
                                        x-text="status === 'register' ? 'Belum Registrasi' : 'Sudah Registrasi'"></span>
                                </span>
                                <x-form.button variant="info" class="!py-1 !px-2 checkupBtn"
                                    data-id="{{ $visit->id }}" data-modal-target="checkupModal"
                                    data-modal-toggle="checkupModal">
                                    <i class="fas fa-eye mr-1"></i> Detail
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
                <x-form.input label="Resep" id="medicine" type="text" readonly />
            </div>
        </div>
    </x-dialog.modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable with datetime sorting
                const dataTable = new simpleDatatables.DataTable('#table-history-visits', {
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

                // Check if date filters are applied and highlight them
                const startDateInput = document.getElementById('visit-date-filter-start');
                const endDateInput = document.getElementById('visit-date-filter-end');

                if (startDateInput && startDateInput.value) {
                    startDateInput.classList.add('border-primary-500');
                }

                if (endDateInput && endDateInput.value) {
                    endDateInput.classList.add('border-primary-500');
                }

                // Handle checkup button click
                const checkupBtns = document.querySelectorAll('.checkupBtn');
                checkupBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const visitId = this.getAttribute('data-id');
                        // Fetch visit details
                        fetch(`/staff/visits/${visitId}/details`)
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                document.getElementById('doctor_name').value = data.doctor_name;
                                document.getElementById('patient_name').value = data.patient_name;
                                document.getElementById('examination_date').value = data
                                    .examination_date;
                                document.getElementById('complaint').value = data.complaint || '-';
                                document.getElementById('diagnosis').value = data.diagnosis || '-';
                                document.getElementById('medicine').value = data.medicine ||
                                    '-';
                            })
                            .catch(error => console.error('Error:', error));
                    });
                });
            });
        </script>
    @endpush
</x-dashboard-layout>
