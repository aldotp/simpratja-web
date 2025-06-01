<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Doctor'],
            [
                'label' => 'Medicines',
                'url' => '/doctor/medicines',
            ],
            [
                'label' => 'Detail',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center mb-6">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('doctor.medicines.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Detail Obat') }}
                </h2>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Obat</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $medicine->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Satuan</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $medicine->unit }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Harga (Rp)</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">Rp
                            {{ number_format($medicine->price, 2, ',', '.') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Stok</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $medicine->stock }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Kadaluarsa</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($medicine->expiry_date)->translatedFormat('l, d F Y') }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Dibuat</h3>
                        <p class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($medicine->created_at)->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <div class="flex justify-end mt-6 space-x-3">
                    <x-form.button variant="primary"
                        onclick="window.location.href='{{ route('doctor.medicines.edit', $medicine->id) }}'">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Obat
                    </x-form.button>
                    <x-form.button variant="danger" onclick="DialogManager.showModal('deleteModal')">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Obat
                    </x-form.button>
                </div>
            </div>
        </x-ui.card>
    </div>

    <x-dialog.modal id="deleteModal" title="Hapus Obat" size="md">
        Apakah anda yakin akan menghapus obat ini?
        <x-slot name="footer">
            <x-form.button onclick="DialogManager.closeModal('deleteModal')">Tidak, kembali</x-form.button>
            <form action="{{ route('doctor.medicines.destroy', $medicine->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-form.button variant="danger" type="submit">Ya, hapus!</x-form.button>
            </form>
        </x-slot>
    </x-dialog.modal>
</x-dashboard-layout>
