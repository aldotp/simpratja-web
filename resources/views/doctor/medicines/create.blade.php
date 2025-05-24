<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Doctor'],
            [
                'label' => 'Medicines',
                'url' => '/doctor/medicines',
            ],
            [
                'label' => 'Create',
                'url' => '/doctor/medicines/create',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('doctor.medicines.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Tambah Obat') }}
                </h2>
            </div>

            <form action="{{ route('doctor.medicines.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf

                <x-form.input name="name" id="name" label="Nama Obat" placeholder="Masukkan Nama Obat" required
                    :value="old('name')" />

                <x-form.input name="unit" id="unit" label="Satuan"
                    placeholder="Masukkan Satuan (contoh: Tablet, Botol)" required :value="old('unit')" />

                <x-form.input name="price" id="price" label="Harga" type="number" step="0.01"
                    placeholder="Masukkan Harga" required :value="old('price')" />

                <x-form.input name="stock" id="stock" label="Stok" type="number"
                    placeholder="Masukkan Jumlah Stok" required :value="old('stock')" />

                <x-form.input name="expiry_date" id="expiry_date" label="Tanggal Kadaluarsa" type="date"
                    placeholder="Pilih Tanggal Kadaluarsa" required :value="old('expiry_date')" />

                <div class="flex justify-end space-x-2">
                    <x-form.button variant="secondary"
                        onclick="window.location.href='{{ route('doctor.medicines.index') }}'; return false;">
                        Batal
                    </x-form.button>
                    <x-form.button variant="primary" type="submit">
                        Simpan
                    </x-form.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-dashboard-layout>
