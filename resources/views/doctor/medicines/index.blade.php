<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Doctor'],
            [
                'label' => 'Medicines',
                'url' => '/doctor/medicines',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Data Obat') }}
                </h2>
                <x-form.button class="!py-2 !px-2.5"
                    onclick="window.location.href='{{ route('doctor.medicines.create') }}'">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Create') }}
                </x-form.button>
            </div>
            <x-ui.table id="table-medicines">
                <x-slot name="thead">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Unit</th>
                        <th scope="col" class="px-6 py-3">Harga</th>
                        <th scope="col" class="px-6 py-3">Stok</th>
                        <th scope="col" class="px-6 py-3">Tanggal Kadaluarsa</th>
                        <th scope="col" class="px-6 py-3">Aksi</th>
                    </tr>
                </x-slot>
                @forelse ($medicines as $medicine)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $medicine->name }}</td>
                        <td class="px-6 py-4">{{ $medicine->unit }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($medicine->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $medicine->stock }}</td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->translatedFormat('l, d F Y') }}</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <x-form.button variant="secondary" class="!py-1 !px-2"
                                onclick="window.location.href='{{ route('doctor.medicines.edit', $medicine->id) }}'">
                                <i class="fas fa-edit"></i>
                            </x-form.button>
                            <x-form.button variant="info" class="!py-1 !px-2"
                                onclick="window.location.href='{{ route('doctor.medicines.show', $medicine->id) }}'">
                                <i class="fas fa-eye"></i>
                            </x-form.button>
                            <x-form.button variant="danger" class="!py-1 !px-2"
                                onclick="confirmDelete('{{ $medicine->id }}')">
                                <i class="fas fa-trash"></i>
                            </x-form.button>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td colspan="7" class="px-6 py-4 text-center">Tidak ada data obat</td>
                    </tr>
                @endforelse
            </x-ui.table>
        </x-ui.card>
    </div>

    <form action="{{ route('doctor.medicines.destroy', '') }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Apakah anda yakin ingin menghapus obat ini?')) {
                    var form = document.getElementById('deleteForm');
                    form.action = form.action + id;
                    form.submit();
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize DataTable
                new simpleDatatables.DataTable('#table-medicines', {
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
    @endpush
</x-dashboard-layout>
