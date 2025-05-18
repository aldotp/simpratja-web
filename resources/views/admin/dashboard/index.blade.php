<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Dashboard',
                'url' => '/dashboard',
            ],
        ]" />

        <div class="grid md:grid-cols-3 mt-4 gap-4">

            <!-- Total Pasien Card -->
            <x-ui.card title="Total Pasien" variant="primary" shadow="md">
                <div class="flex items-center">
                    <i class="fas fa-users text-primary-600 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-3xl font-bold">0</h3>
                        <p class="text-gray-600 dark:text-gray-400">Pasien terdaftar</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Pasien Aktif Card -->
            <x-ui.card title="Pasien Aktif Hari Ini" variant="success" shadow="md">
                <div class="flex items-center">
                    <i class="fas fa-user-check text-green-600 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-3xl font-bold">0</h3>
                        <p class="text-gray-600 dark:text-gray-400">Kunjungan hari ini</p>
                    </div>
                </div>
            </x-ui.card>

            <!-- Rekam Medis Card -->
            <x-ui.card title="Total Rekam Medis" variant="info" shadow="md">
                <div class="flex items-center">
                    <i class="fas fa-notes-medical text-blue-600 text-3xl mr-4"></i>
                    <div>
                        <h3 class="text-3xl font-bold">0</h3>
                        <p class="text-gray-600 dark:text-gray-400">Rekam medis tersimpan</p>
                    </div>
                </div>
            </x-ui.card>

        </div>

        <!-- Chart Pasien dan Visitasi -->
        <div class="grid md:grid-cols-2 mt-4 gap-4 mb-4">
            <!-- Chart Tren Kunjungan Pasien -->
            <x-ui.card title="Tren Kunjungan Pasien" subtitle="Data 6 bulan terakhir" class="h-full">
                <x-ui.chart type="line" :series="[
                    ['name' => 'Kunjungan Pasien', 'data' => [45, 52, 38, 65, 73, 80]],
                    ['name' => 'Pasien Baru', 'data' => [20, 25, 18, 30, 35, 40]],
                ]" :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']" title="Statistik Kunjungan Pasien"
                    xaxisTitle="Bulan" yaxisTitle="Jumlah" height="300" :colors="['#4F46E5', '#10B981']" enableAnimation="true"
                    enableDataLabels="false" enableLegend="true" />
            </x-ui.card>

            <!-- Chart Distribusi Pasien -->
            <x-ui.card title="Distribusi Pasien" subtitle="Berdasarkan kategori" class="h-full">
                <x-ui.chart type="pie" :series="[35, 25, 20, 15, 5]" :labels="['Umum', 'Anak', 'Lansia', 'Ibu Hamil', 'Lainnya']" title="Kategori Pasien" height="300"
                    :colors="['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']" enableDataLabels="true" enableLegend="true" />
            </x-ui.card>
        </div>

        <!-- Chart Rekam Medis -->
        <x-ui.card title="Distribusi Rekam Medis" subtitle="Berdasarkan jenis pemeriksaan" class="mt-4">
            <x-ui.chart type="bar" :series="[['name' => 'Jumlah Rekam Medis', 'data' => [65, 48, 42, 30, 25, 20]]]" :labels="[
                'Pemeriksaan Umum',
                'Pemeriksaan Gigi',
                'Pemeriksaan Mata',
                'Konsultasi Gizi',
                'Imunisasi',
                'Lainnya',
            ]"
                title="Rekam Medis Berdasarkan Jenis Pemeriksaan" xaxisTitle="Jenis Pemeriksaan" yaxisTitle="Jumlah"
                height="300" :colors="['#3B82F6']" enableAnimation="true" enableDataLabels="true" />
        </x-ui.card>
    </div>
</x-dashboard-layout>
