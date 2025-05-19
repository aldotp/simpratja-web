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
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data User') }}
                </h2>
                <x-form.button class="!py-2 !px-2.5" onclick="window.location.href='{{ route('admin.users.create') }}'">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </x-form.button>
            </div>
            <x-ui.table id="table-users">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">NIK</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>

                @forelse ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $user->id }}</td>
                        <td class="px-6 py-4">{{ $user->detail->name }}</td>
                        <td class="px-6 py-4">{{ $user->nik }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 capitalize">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <x-form.button variant="primary"
                                    onclick="window.location.href='{{ route('admin.users.edit', $user->id) }}'">
                                    <i class="fas fa-edit mr-2"></i>
                                    {{ __('Edit') }}
                                </x-form.button>
                                <x-form.button variant="danger" onclick="DialogManager.showModal('resetPasswordModal')"
                                    data-id="{{ $user->nik }}">
                                    <i class="fas fa-lock mr-2"></i>
                                    {{ __('Reset') }}
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
    <x-dialog.modal id="resetPasswordModal" title="Reset Password" size="md">
        Apakah anda yakin akan me-reset password?
        <x-slot name="footer">
            <x-form.button onclick="DialogManager.hideModal('resetPasswordModal')">Tidak, kembali</x-form.button>
            <form action="{{ route('admin.reset-password') }}" method="POST">
                @csrf
                <input type="hidden" name="nik" id="reset_nik" value="{{ $user->nik }}">
                <x-form.button variant="danger" type="submit">Ya, me-reset!</x-form.button>
            </form>
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
    </script>
</x-dashboard-layout>
