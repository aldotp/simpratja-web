<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Pasien',
                'url' => '/staff/patients',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Pasien') }}
                </h2>
                <div class="flex space-x-2">
                    <x-form.input type="search" id="searchInput" placeholder="Cari pasien..." class="w-64" />
                </div>
            </div>
            <x-ui.table id="table-patients" hoverable="true" striped="true">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">No. Rekam Medis</th>
                        <th scope="col" class="px-6 py-3">NIK</th>
                        <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                        <th scope="col" class="px-6 py-3">Tgl. Lahir</th>
                        <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                        <th scope="col" class="px-6 py-3">Alamat</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($patients as $patient)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            @if ($patient->medicalRecord)
                                {{ $patient->medicalRecord->medical_record_number }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $patient->nik }}</td>
                        <td class="px-6 py-4">{{ $patient->name }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($patient->birth_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-4">{{ $patient->gender ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-6 py-4">{{ $patient->address }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                @if (!$patient->medicalRecord)
                                    <x-form.button class="!py-2 !px-2.5" variant="success"
                                        data-modal-target="generateMRNModal" data-modal-toggle="generateMRNModal"
                                        data-id="{{ $patient->id }}" data-name="{{ $patient->name }}">
                                        <i class="fas fa-file-medical"></i>
                                    </x-form.button>
                                @endif
                                <x-form.button class="!py-2 !px-2.5" variant="primary"
                                    onclick="window.location.href='{{ route('staff.patients.edit', $patient->id) }}'">
                                    <i class="fas fa-edit"></i>
                                </x-form.button>
                                <x-form.button class="!py-2 !px-2.5" variant="danger"
                                    data-modal-target="deletePatientModal" data-modal-toggle="deletePatientModal"
                                    data-id="{{ $patient->id }}" data-name="{{ $patient->name }}">
                                    <i class="fas fa-trash"></i>
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Tidak ada data pasien</td>
                    </tr>
                @endforelse

            </x-ui.table>
        </x-ui.card>
    </div>

    <!-- Modal Delete Confirm -->
    <x-dialog.modal id="deletePatientModal" title="Hapus Data Pasien" size="md">
        <p class="text-gray-600">Apakah anda yakin akan menghapus data pasien <span id="patientNameToDelete"
                class="font-semibold"></span>?</p>
        <p class="text-red-500 mt-2">Note: Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data
            terkait pasien ini.</p>
        <x-slot name="footer">
            <x-form.button data-modal-hide="deletePatientModal">Batal</x-form.button>
            <form id="deletePatientForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <x-form.button variant="danger" type="submit">Ya, Hapus!</x-form.button>
            </form>
        </x-slot>
    </x-dialog.modal>

    <!-- Modal Generate MRN -->
    <x-dialog.modal id="generateMRNModal" title="Generate Nomor Rekam Medis" size="md">
        <p class="text-gray-600">Anda akan membuat nomor rekam medis untuk pasien <span id="patientNameForMRN"
                class="font-semibold"></span>.</p>
        <p class="text-blue-500 mt-2">Nomor rekam medis akan dibuat secara otomatis oleh sistem.</p>
        <x-slot name="footer">
            <x-form.button data-modal-hide="generateMRNModal">Batal</x-form.button>
            <form id="generateMRNForm" action="" method="POST">
                @csrf
                <x-form.button variant="success" type="submit">Generate MRN</x-form.button>
            </form>
        </x-slot>
    </x-dialog.modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inisialisasi DataTable
                new simpleDatatables.DataTable('#table-patients', {
                    paging: true,
                    perPage: 10,
                    perPageSelect: [5, 10, 15, 20],
                    fixedHeight: false,
                    labels: {
                        placeholder: 'Cari...',
                        perPage: 'data per halaman',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} sampai {end} dari {rows} data'
                    }
                });

                // Setup modal hapus pasien
                const deleteModal = document.getElementById('deletePatientModal');
                if (deleteModal) {
                    deleteModal.addEventListener('show.tw.modal', function(event) {
                        const button = event.relatedTarget;
                        const patientId = button.getAttribute('data-id');
                        const patientName = button.getAttribute('data-name');

                        document.getElementById('patientNameToDelete').textContent = patientName;
                        document.getElementById('deletePatientForm').action = `/staff/patient/${patientId}`;
                    });
                }

                // Setup modal generate MRN
                const generateMRNModal = document.getElementById('generateMRNModal');
                if (generateMRNModal) {
                    generateMRNModal.addEventListener('show.tw.modal', function(event) {
                        const button = event.relatedTarget;
                        const patientId = button.getAttribute('data-id');
                        const patientName = button.getAttribute('data-name');

                        document.getElementById('patientNameForMRN').textContent = patientName;
                        document.getElementById('generateMRNForm').action =
                            `api/v1/patients/generate-medical-records/${patientId}`;
                    });
                }
            });
        </script>
    @endpush
</x-dashboard-layout>
