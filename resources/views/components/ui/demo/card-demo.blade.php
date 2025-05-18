<x-home-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800 dark:text-white">Contoh Penggunaan Komponen Card
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Card Default -->
            <x-ui.card title="Card Default" subtitle="Contoh card dengan pengaturan default">
                <p>Ini adalah contoh card dengan pengaturan default. Card ini dapat digunakan untuk menampilkan berbagai
                    jenis konten.</p>
            </x-ui.card>

            <!-- Card dengan Gambar -->
            <x-ui.card title="Card dengan Gambar" subtitle="Menampilkan gambar di bagian atas"
                imgSrc="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                imgAlt="Contoh Gambar" hover="true">
                <p>Card ini menampilkan gambar di bagian atas dan memiliki efek hover saat kursor diarahkan ke card.</p>
            </x-ui.card>

            <!-- Card dengan Footer -->
            <x-ui.card title="Card dengan Footer" subtitle="Menampilkan bagian footer" variant="primary" shadow="lg">
                <p>Card ini memiliki bagian footer yang dapat digunakan untuk menampilkan tombol atau informasi
                    tambahan.</p>

                <x-slot name="footer">
                    <div class="flex justify-end">
                        <x-form.button type="button" size="sm">Tombol Aksi</x-form.button>
                    </div>
                </x-slot>
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Variasi Warna</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <!-- Card Variant Primary -->
            <x-ui.card title="Primary Card" variant="primary">
                <p>Card dengan variasi warna primary.</p>
            </x-ui.card>

            <!-- Card Variant Secondary -->
            <x-ui.card title="Secondary Card" variant="secondary">
                <p>Card dengan variasi warna secondary.</p>
            </x-ui.card>

            <!-- Card Variant Success -->
            <x-ui.card title="Success Card" variant="success">
                <p>Card dengan variasi warna success.</p>
            </x-ui.card>

            <!-- Card Variant Danger -->
            <x-ui.card title="Danger Card" variant="danger">
                <p>Card dengan variasi warna danger.</p>
            </x-ui.card>

            <!-- Card Variant Warning -->
            <x-ui.card title="Warning Card" variant="warning">
                <p>Card dengan variasi warna warning.</p>
            </x-ui.card>

            <!-- Card Variant Info -->
            <x-ui.card title="Info Card" variant="info">
                <p>Card dengan variasi warna info.</p>
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Variasi Ukuran dan Bayangan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Card Size Small -->
            <x-ui.card title="Small Card" size="sm" shadow="sm">
                <p>Card dengan ukuran kecil dan bayangan kecil.</p>
            </x-ui.card>

            <!-- Card Size Medium -->
            <x-ui.card title="Medium Card" size="md" shadow="md">
                <p>Card dengan ukuran sedang dan bayangan sedang.</p>
            </x-ui.card>

            <!-- Card Size Large -->
            <x-ui.card title="Large Card" size="lg" shadow="xl">
                <p>Card dengan ukuran besar dan bayangan besar.</p>
            </x-ui.card>
        </div>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Layout Horizontal</h2>
        <div class="grid grid-cols-1 gap-6 mb-12">
            <!-- Card Horizontal dengan Gambar -->
            <x-ui.card title="Card Horizontal" subtitle="Layout horizontal dengan gambar di samping"
                imgSrc="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                imgAlt="Contoh Gambar" horizontal="true" border="true" rounded="lg">
                <p>Card ini menggunakan layout horizontal dengan gambar di samping kiri dan konten di samping kanan.
                    Layout ini sangat cocok untuk menampilkan daftar item dengan gambar.</p>
                <p class="mt-3">Anda dapat menambahkan lebih banyak konten di sini sesuai kebutuhan.</p>

                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Terakhir diperbarui: 1 jam yang lalu</span>
                        <x-form.button type="button" variant="outline" size="sm">Lihat Detail</x-form.button>
                    </div>
                </x-slot>
            </x-ui.card>
        </div>
    </div>
</x-home-layout>
