<x-home-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">Contoh Penggunaan Komponen Chart
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <!-- Chart Line Basic -->
            <x-ui.card title="Line Chart" subtitle="Grafik garis dasar">
                <x-ui.chart type="line" :series="[
                    ['name' => 'Penjualan', 'data' => [30, 40, 35, 50, 49, 60, 70, 91, 125]],
                    ['name' => 'Pendapatan', 'data' => [20, 35, 40, 45, 55, 65, 75, 85, 100]],
                ]" :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep']" title="Penjualan dan Pendapatan Bulanan"
                    xaxisTitle="Bulan" yaxisTitle="Jumlah (dalam juta)" height="300" />
            </x-ui.card>

            <!-- Chart Area -->
            <x-ui.card title="Area Chart" subtitle="Grafik area dengan data stacked">
                <x-ui.chart type="area" :series="[
                    ['name' => 'Produk A', 'data' => [31, 40, 28, 51, 42, 109, 100]],
                    ['name' => 'Produk B', 'data' => [11, 32, 45, 32, 34, 52, 41]],
                ]" :labels="['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']" title="Penjualan Produk Mingguan"
                    stacked="true" height="300" />
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Grafik Batang dan Kolom</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <!-- Chart Bar -->
            <x-ui.card title="Bar Chart" subtitle="Grafik batang horizontal">
                <x-ui.chart type="bar" :series="[['name' => 'Pengunjung', 'data' => [420, 380, 510, 390, 600, 550, 340]]]" :labels="['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']" title="Jumlah Pengunjung Website"
                    horizontal="true" height="300" enableDataLabels="true" />
            </x-ui.card>

            <!-- Chart Column -->
            <x-ui.card title="Column Chart" subtitle="Grafik kolom dengan multiple series">
                <x-ui.chart type="bar" :series="[
                    ['name' => '2022', 'data' => [44, 55, 57, 56, 61, 58, 63, 60, 66]],
                    ['name' => '2023', 'data' => [76, 85, 101, 98, 87, 105, 91, 114, 94]],
                ]" :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep']" title="Perbandingan Penjualan Tahunan"
                    height="300" :colors="['#4F46E5', '#10B981']" />
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Grafik Lingkaran</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <!-- Chart Pie -->
            <x-ui.card title="Pie Chart" subtitle="Grafik lingkaran sederhana">
                <x-ui.chart type="pie" :series="[44, 55, 13, 43, 22]" :labels="['Produk A', 'Produk B', 'Produk C', 'Produk D', 'Produk E']" title="Distribusi Penjualan Produk"
                    height="300" enableDataLabels="true" />
            </x-ui.card>

            <!-- Chart Donut -->
            <x-ui.card title="Donut Chart" subtitle="Grafik donat dengan warna kustom">
                <x-ui.chart type="donut" :series="[44, 55, 41, 17, 15]" :labels="['Makanan', 'Minuman', 'Snack', 'Buah', 'Lainnya']" title="Kategori Produk Terjual"
                    height="300" :colors="['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']" />
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Grafik Khusus</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
            <!-- Chart Radar -->
            <x-ui.card title="Radar Chart" subtitle="Grafik radar untuk perbandingan multidimensi">
                <x-ui.chart type="radar" :series="[
                    ['name' => 'Produk A', 'data' => [80, 50, 30, 40, 100, 20]],
                    ['name' => 'Produk B', 'data' => [20, 30, 40, 80, 20, 80]],
                ]" :labels="['Kualitas', 'Harga', 'Fitur', 'Desain', 'Durabilitas', 'Layanan']" title="Perbandingan Produk"
                    height="300" />
            </x-ui.card>

            <!-- Chart Polar Area -->
            <x-ui.card title="Polar Area Chart" subtitle="Grafik area polar">
                <x-ui.chart type="polarArea" :series="[14, 23, 21, 17, 15, 10, 12, 17, 21]" :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep']" title="Distribusi Data Bulanan"
                    height="300" enableDataLabels="false" />
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Kustomisasi Lanjutan</h2>
        <div class="grid grid-cols-1 gap-6 mb-12">
            <!-- Chart dengan Zoom -->
            <x-ui.card title="Chart dengan Zoom" subtitle="Grafik dengan fitur zoom dan toolbar">
                <x-ui.chart type="line" :series="[
                    ['name' => 'AAPL', 'data' => [31, 40, 28, 51, 42, 109, 100, 120, 80, 95, 110, 85]],
                    ['name' => 'MSFT', 'data' => [11, 32, 45, 32, 34, 52, 41, 50, 60, 55, 70, 65]],
                    ['name' => 'GOOGL', 'data' => [15, 25, 35, 40, 45, 55, 65, 75, 85, 95, 90, 80]],
                ]" :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']" title="Pergerakan Harga Saham Tahunan"
                    subtitle="Klik dan seret untuk memperbesar area tertentu" xaxisTitle="Bulan"
                    yaxisTitle="Harga Saham ($)" height="400" enableZoom="true" :colors="['#4F46E5', '#10B981', '#F59E0B']" />
            </x-ui.card>
        </div>
    </div>
</x-home-layout>
