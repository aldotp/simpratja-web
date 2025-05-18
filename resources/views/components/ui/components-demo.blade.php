<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Komponen UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 p-8">
    <div class="max-w-6xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Demo Komponen UI</h1>

        <!-- Breadcrumb Demo -->
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Breadcrumb</h2>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Breadcrumb Default</h3>
                <x-ui.breadcrumb :items="[
                    ['label' => 'Beranda', 'url' => '#', 'icon' => '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>'],
                    ['label' => 'Proyek', 'url' => '#'],
                    ['label' => 'Detail Proyek'],
                ]" />
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Breadcrumb dengan Dot Separator</h3>
                <x-ui.breadcrumb
                    separator="dot"
                    variant="light"
                    rounded
                    :items="[
                        ['label' => 'Beranda', 'url' => '#'],
                        ['label' => 'Kategori', 'url' => '#'],
                        ['label' => 'Produk', 'url' => '#'],
                        ['label' => 'Detail Produk'],
                    ]"
                />
            </div>
        </div>

        <!-- Table Demo -->
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Tabel</h2>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Tabel dengan Slot Atas dan Pagination</h3>

                <x-ui.table striped hoverable>
                    <x-slot name="top">
                        <div class="flex items-center space-x-4 mb-4 md:mb-0">
                            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                Tambah Data
                            </button>
                            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                                Export
                            </button>
                        </div>

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
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Tabel Sederhana</h3>

                <x-ui.table variant="light" size="sm" bordered>
                    <x-slot name="thead">
                        <tr>
                            <th scope="col" class="px-4 py-2">Produk</th>
                            <th scope="col" class="px-4 py-2">Kategori</th>
                            <th scope="col" class="px-4 py-2">Harga</th>
                        </tr>
                    </x-slot>

                    <tr>
                        <td class="px-4 py-2">Laptop Asus</td>
                        <td class="px-4 py-2">Elektronik</td>
                        <td class="px-4 py-2">Rp 12.000.000</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Smartphone Samsung</td>
                        <td class="px-4 py-2">Elektronik</td>
                        <td class="px-4 py-2">Rp 8.500.000</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2">Headphone Sony</td>
                        <td class="px-4 py-2">Aksesoris</td>
                        <td class="px-4 py-2">Rp 2.300.000</td>
                    </tr>
                </x-ui.table>
            </div>
        </div>

        <!-- Pagination Demo -->
        <div class="space-y-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Pagination</h2>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Pagination Sederhana</h3>

                <!-- Contoh pagination statis untuk demo -->
                <div class="flex justify-center">
                    <nav class="flex items-center justify-center">
                        <ul class="flex items-center -space-x-px">
                            <li>
                                <span class="flex items-center px-3 py-2 text-sm text-gray-300 bg-gray-100 border border-gray-300 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:text-gray-400 rounded-l-lg">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </li>
                            <li>
                                <span aria-current="page" class="flex items-center px-3 py-2 text-sm text-white bg-primary-600 hover:bg-primary-700 rounded-lg">
                                    1
                                </span>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white rounded-lg">
                                    2
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white rounded-lg">
                                    3
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white rounded-r-lg">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-800 dark:text-white mb-4">Pagination Sederhana (Prev/Next)</h3>

                <!-- Contoh pagination statis untuk demo -->
                <div class="flex justify-center">
                    <nav class="flex items-center justify-center">
                        <ul class="flex items-center -space-x-px">
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white rounded-lg mr-2">
                                    <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                    </svg>
                                    Sebelumnya
                                </a>
                            </li>
                            <li>
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white rounded-lg">
                                    Selanjutnya
                                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
