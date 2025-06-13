<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Doctors',
                'url' => '/admin/doctors',
            ],
            [
                'label' => 'Create',
                'url' => '/admin/doctors/create',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('admin.doctors.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Create Dokter') }}
                </h2>
            </div>

            <form action="{{ route('admin.doctors.store') }}" method="POST" class="space-y-4 mt-4">
                @csrf

                <x-form.input name="name" id="name" label="Nama Lengkap" placeholder="Masukkan Nama Lengkap"
                    required :value="old('name')" />
                <x-form.input name="nik" id="nik" label="NIK" placeholder="Masukkan NIK" required
                    :value="old('nik')" minLength="16" maxLength="16" />

                <x-form.input name="phone_number" id="phone_number" label="No. Handphone" type="number"
                    placeholder="Masukkan No. Handphone" required :value="old('phone_number')" />

                <x-form.select name="gender" id="gender" label="Jenis Kelamin" required>
                    <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Perempuan</option>
                    <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Laki-laki</option>
                </x-form.select>

                <x-form.input name="quota" id="quota" label="Kuota" type="number"
                    placeholder="Masukkan Kuota Pasien" required :value="old('quota')" />

                <div class="flex justify-end mt-6">
                    <x-form.button type="submit" variant="primary">
                        Tambah Dokter
                    </x-form.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-dashboard-layout>
