<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Dashboard',
                'url' => '/dashboard/admin',
            ],
            [
                'label' => 'Users',
                'url' => '/users',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <x-form.button>
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </x-form.button>
            </div>
            <x-ui.table>
                <x-slot name="top">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Cari data...">
                    </div>
                </x-slot>

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
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Aktif</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="px-2 py-1 text-xs text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                            <button class="px-2 py-1 text-xs text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">Siti Rahayu</td>
                    <td class="px-6 py-4">siti@example.com</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Aktif</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="px-2 py-1 text-xs text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                            <button class="px-2 py-1 text-xs text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                        </div>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">3</td>
                    <td class="px-6 py-4">Ahmad Hidayat</td>
                    <td class="px-6 py-4">ahmad@example.com</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <button class="px-2 py-1 text-xs text-blue-700 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Edit</button>
                            <button class="px-2 py-1 text-xs text-red-700 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Hapus</button>
                        </div>
                    </td>
                </tr>
            </x-ui.table>
        </x-ui.card>
    </div>
</x-dashboard-layout>
