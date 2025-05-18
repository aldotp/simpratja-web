<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Users',
                'url' => '/users',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Data User') }}
                </h2>
                <x-form.button class="!py-2 !px-2.5" onclick="window.location.href='{{ route('create') }}'">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </x-form.button>
            </div>
            <x-ui.table id="table-users">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">Budi Santoso</td>
                    <td class="px-6 py-4">budi@example.com</td>
                    <td class="px-6 py-4">
                        <span
                            class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Dokter</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <x-form.button class="!p-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </x-form.button>
                            <x-form.button
                            data-modal-target="resetPasswordModal"
                            variant="danger"
                            class="!p-2"
                            onclick="DialogManager.showModal('resetPasswordModal')">
                                <i class="fa-solid fa-refresh"></i>
                            </x-form.button>
                        </div>
                    </td>
                </tr>
            </x-ui.table>
        </x-ui.card>
    </div>
    <x-dialog.modal id="resetPasswordModal" title="Reset Password" size="md">
        Apakah anda yakin akan me-reset password?
        <x-slot name="footer">
            <x-form.button onclick="DialogManager.hideModal('resetPasswordModal')">Tidak, kembali</x-form.button>
            <x-form.button variant="danger" onclick="resetPassword()">Ya, me-reset!</x-form.button>
        </x-slot>
    </x-dialog.modal>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new simpleDatatables.DataTable('#table-users', {
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
        });

        function resetPassword() {
            // Implement password reset logic here
            console.log('Password reset to default');
            DialogManager.hideModal('resetPasswordModal');
        }
    </script>
</x-dashboard-layout>
