<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Doctors',
                'url' => '/admin/doctors',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Dokter') }}
                </h2>
                <x-form.button class="!py-2 !px-2.5" onclick="window.location.href='{{ route('admin.doctors.create') }}'">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </x-form.button>
            </div>

            <form action="{{ route('admin.doctors.index') }}" method="GET" class="mb-6">
                <div class="flex flex-col md:flex-row justify-end gap-2">
                    <div>
                        <x-ui.daterangepicker id="doctor-date-filter" name="doctor_date" startLabel="Tanggal Mulai"
                            endLabel="Tanggal Akhir" startPlaceholder="Pilih tanggal mulai"
                            endPlaceholder="Pilih tanggal akhir" maxDate="{{ now()->format('Y-m-d') }}"
                            :startValue="request('doctor_date_start', '')" :endValue="request('doctor_date_end', '')" />
                    </div>
                    <div class="flex items-end">
                        <x-form.button type="submit" class="w-full md:w-auto">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </x-form.button>
                        @if (request('doctor_date_start') || request('doctor_date_end'))
                            <a href="{{ route('admin.doctors.index') }}"
                                class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            <x-ui.table id="table-doctors">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">NIK</th>
                        <th scope="col" class="px-6 py-3">Kuota</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($doctors as $doctor)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $doctor->name }}</td>
                        <td class="px-6 py-4">{{ $doctor->nik }}</td>
                        <td class="px-6 py-4">{{ $doctor->quota }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button class="!py-2 !px-2.5" variant="primary"
                                    onclick="window.location.href='{{ route('admin.doctors.edit', $doctor->id) }}'">
                                    <i class="fas fa-edit mr-2"></i>
                                    {{ __('Edit') }}
                                </x-form.button>
                                <x-form.button class="!py-2 !px-2.5" variant="danger"
                                    data-modal-toggle="deleteModal-{{ $doctor->id }}"
                                    data-modal-target="deleteModal-{{ $doctor->id }}" data-id="{{ $doctor->id }}">
                                    <i class="fas fa-trash mr-2"></i>
                                    {{ __('Delete') }}
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                    <x-dialog.modal id="deleteModal-{{ $doctor->id }}" title="Hapus Dokter" size="md">
                        Apakah anda yakin akan menghapus dokter ini?
                        <x-slot name="footer">
                            <x-form.button data-modal-hide="deleteModal">Tidak, kembali</x-form.button>
                            <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" method="POST"
                                id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <x-form.button variant="danger" type="submit">Ya, hapus!</x-form.button>
                            </form>
                        </x-slot>
                    </x-dialog.modal>
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
                // Initialize DataTable with datetime sorting
                const dataTable = new simpleDatatables.DataTable('#table-doctors', {
                    paging: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 15, 20],
                    fixedHeight: false,
                    sortable: true,
                    labels: {
                        placeholder: 'Cari...',
                        perPage: 'data per halaman',
                        noRows: 'Data tidak ditemukan',
                        info: 'Menampilkan {start} sampai {end} dari {rows} data'
                    }
                });

                // Check if date filters are applied and highlight them
                const startDateInput = document.getElementById('doctor-date-filter-start');
                const endDateInput = document.getElementById('doctor-date-filter-end');

                if (startDateInput && startDateInput.value) {
                    startDateInput.classList.add('border-primary-500');
                }

                if (endDateInput && endDateInput.value) {
                    endDateInput.classList.add('border-primary-500');
                }
            });
        </script>
    @endpush
</x-dashboard-layout>
