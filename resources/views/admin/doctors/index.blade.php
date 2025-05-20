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
                                    onclick="DialogManager.showModal('deleteModal')" data-id="{{ $doctor->id }}">
                                    <i class="fas fa-trash mr-2"></i>
                                    {{ __('Delete') }}
                                </x-form.button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse

            </x-ui.table>
        </x-ui.card>
    </div>
    <x-dialog.modal id="deleteModal" title="Hapus Dokter" size="md">
        Apakah anda yakin akan menghapus dokter ini?
        <x-slot name="footer">
            <x-form.button onclick="DialogManager.closeModal('deleteModal')">Tidak, kembali</x-form.button>
            <form action="{{ route('admin.doctors.destroy', '') }}" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <x-form.button variant="danger" type="submit">Ya, hapus!</x-form.button>
            </form>
        </x-slot>
    </x-dialog.modal>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            new simpleDatatables.DataTable('#table-doctors', {
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

            // Setup delete modal
            const deleteButtons = document.querySelectorAll('[data-id]');
            const deleteForm = document.getElementById('deleteForm');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const doctorId = this.getAttribute('data-id');
                    const action = deleteForm.getAttribute('action');
                    deleteForm.setAttribute('action', action.replace('', doctorId));
                });
            });
        });
    </script>
</x-dashboard-layout>
