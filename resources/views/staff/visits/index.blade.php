<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[['label' => 'Staff'], ['label' => 'Kunjungan', 'url' => '/staff/visits']]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Kunjungan') }}
                </h2>
                <span class="text-primary-600 dark:text-gray-400 font-bold text-lg mr-2">
                    {{ \Carbon\Carbon::parse(request('visit_date_start') ? request('visit_date_start') : now())->translatedFormat('l, d F Y') }}
                </span>
            </div>

            <form action="{{ route('staff.visits.index') }}" method="GET" class="mb-6">
                <div class="flex flex-col md:flex-row justify-end gap-2">
                    <div>
                        <x-ui.daterangepicker id="visit-date-filter" name="visit_date" startLabel="Tanggal Mulai"
                            endLabel="Tanggal Akhir" startPlaceholder="Pilih tanggal mulai"
                            endPlaceholder="Pilih tanggal akhir" minDate="{{ now()->format('Y-m-d') }}"
                            :startValue="request('visit_date_start', '')" :endValue="request('visit_date_end', '')" />
                    </div>
                    <div class="flex items-end">
                        <x-form.button type="submit" class="w-full md:w-auto">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </x-form.button>
                        @if (request('visit_date_start') || request('visit_date_end'))
                            <a href="{{ route('staff.visits.index') }}"
                                class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>

            <x-ui.table id="table-visits">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">No. REG</th>
                        <th scope="col" class="px-6 py-3">Antrian</th>
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
                        <td class="px-6 py-4">{{ $visit->queue_number }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($visit->examination_date)->translatedFormat('l, d F Y') }}</td>
                        <td class="px-6 py-4">{{ $visit->patient_name }}</td>
                        <td class="px-6 py-4">{{ $visit->patient_phone_number }}</td>
                        <td class="px-6 py-4">{{ $visit->doctor_name ?? 'Belum ditentukan' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @switch($visit->visit_status)
                                    @case('queue')
                                        <x-form.button variant="info" class="!py-1 !px-2"
                                            data-modal-target="callPatientModal-{{ $visit->id }}"
                                            data-modal-toggle="callPatientModal-{{ $visit->id }}"
                                            data-id="{{ $visit->id }}">
                                            <i class="fas fa-phone mr-1"></i> Panggil
                                        </x-form.button>
                                    @break

                                    @case('check')
                                        <x-ui.badge class="px-2 py-1.5 text-nowrap" variant="info">
                                            <span>
                                                <i class="fas fa-stethoscope mr-1"></i> Sedang Diperiksa
                                            </span>
                                        </x-ui.badge>
                                    @break

                                    @case('done')
                                        <x-ui.badge class="px-2 py-1.5 text-nowrap" variant="success">
                                            <span>
                                                <i class="fas fa-check-circle mr-1"></i> Selesai
                                            </span>
                                        </x-ui.badge>
                                    @break
                                @endswitch
                                @if (!$visit->queue_number)
                                    <x-form.button variant="secondary" class="!py-1 !px-2 registrasiBtn"
                                        data-id="{{ $visit->id }}"
                                        data-modal-target="confirmationModal-{{ $visit->id }}"
                                        data-modal-toggle="confirmationModal-{{ $visit->id }}">
                                        <i class="fas fa-clipboard-check mr-1"></i> Konfirmasi
                                    </x-form.button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Modal Konfirmasi Nomor Antrian -->
                    <x-dialog.modal id="confirmationModal-{{ $visit->id }}" title="Konfirmasi Nomor Antrian"
                        size="md" :showCloseButton="true" :static="true">
                        <p class="text-gray-700 dark:text-gray-400 mb-4">Apakah Anda yakin memberikan nomor antrian?</p>
                        <div class="flex justify-center space-x-2">
                            <x-form.button type="button" class="grow" variant="secondary"
                                data-modal-hide="confirmationModal-{{ $visit->id }}">
                                Batal
                            </x-form.button>
                            <form action="{{ route('staff.visits.queue-number', $visit->id) }}" method="post">
                                @csrf
                                <x-form.button type="submit" class="grow" variant="primary" id="confirmQueueButton">
                                    Konfirmasi
                                </x-form.button>
                            </form>
                        </div>
                    </x-dialog.modal>

                    <!-- Modal Panggil Pasien -->
                    <x-dialog.modal id="callPatientModal-{{ $visit->id }}" title="Panggil Pasien" size="md"
                        :showCloseButton="true" :static="true">
                        <p class="text-gray-700 dark:text-gray-400 mb-4">Anda akan memanggil pasien <span
                                class="font-semibold">{{ $visit->patient_name }}</span>.</p>
                        <p class="text-blue-500 mb-4">Sistem akan mengubah status kunjungan pasien menjadi "check".</p>
                        <div class="flex justify-center space-x-2">
                            <x-form.button type="button" class="grow" variant="secondary"
                                data-modal-hide="callPatientModal-{{ $visit->id }}">
                                Batal
                            </x-form.button>
                            <form action="{{ route('staff.visits.call-patient', $visit->id) }}" method="post">
                                @csrf
                                <x-form.button type="submit" class="grow" variant="info">
                                    <i class="fas fa-phone mr-1"></i> Panggil Pasien
                                </x-form.button>
                            </form>
                        </div>
                    </x-dialog.modal>

                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="8" class="px-6 py-4 text-center">Tidak ada data kunjungan</td>
                        </tr>
                    @endforelse
                </x-ui.table>
            </x-ui.card>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const dataTable = new simpleDatatables.DataTable('#table-visits', {
                        paging: true,
                        perPage: 5,
                        perPageSelect: [5, 10, 15, 20],
                        fixedHeight: false,
                        sortable: true,
                        columns: [{
                            select: 3,
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

                    const registrasiBtns = document.querySelectorAll('.registrasiBtn');
                    registrasiBtns.forEach(btn => {
                        btn.addEventListener('click', function() {
                            const visitId = this.getAttribute('data-id');
                            document.getElementById('visit_id').value = visitId;

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
