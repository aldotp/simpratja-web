<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Pasien',
                'url' => '/staff/patients',
            ],
            [
                'label' => 'Edit',
            ],
        ]" />

        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center mb-6">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('staff.patients.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Edit Data Pasien') }}
                </h2>
            </div>

            <form action="{{ route('staff.patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Data Pribadi -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-user-circle text-primary-600 mr-2"></i>
                            Data Pribadi
                        </h3>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-form.input id="nik" name="nik" label="NIK" :value="old('nik', $patient->nik)"
                                        required />
                                </div>
                                <div>
                                    <x-form.input id="name" name="name" label="Nama Lengkap" :value="old('name', $patient->name)"
                                        required />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-form.datepicker id="birth_date" name="birth_date" label="Tanggal Lahir"
                                        :value="old(
                                            'birth_date',
                                            $patient->birth_date
                                        )" required />
                                </div>
                                <div>
                                    <x-form.select id="gender" name="gender" label="Jenis Kelamin" required>
                                        @foreach ([['value' => 0, 'label' => 'Perempuan'], ['value' => 1, 'label' => 'Laki-laki']] as $option)
                                            <option value="{{ $option['value'] }}"
                                                {{ old('gender', $patient->gender) == $option['value'] ? 'selected' : '' }}>
                                                {{ $option['label'] }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->

                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-info-circle text-primary-600 mr-2"></i>
                            Informasi Tambahan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-form.select id="blood_type" name="blood_type" label="Golongan Darah" required>
                                    @foreach ([['value' => 'A', 'label' => 'A'], ['value' => 'B', 'label' => 'B'], ['value' => 'AB', 'label' => 'AB'], ['value' => 'O', 'label' => 'O']] as $option)
                                        <option value="{{ $option['value'] }}"
                                            {{ old('blood_type', $patient->blood_type) == $option['value'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div>
                                <x-form.select id="religion" name="religion" label="Agama" required>
                                    @foreach ([['value' => 'Islam', 'label' => 'Islam'], ['value' => 'Kristen', 'label' => 'Kristen'], ['value' => 'Katolik', 'label' => 'Katolik'], ['value' => 'Hindu', 'label' => 'Hindu'], ['value' => 'Buddha', 'label' => 'Buddha'], ['value' => 'Konghucu', 'label' => 'Konghucu']] as $option)
                                        <option value="{{ $option['value'] }}"
                                            {{ old('religion', $patient->religion) == $option['value'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-form.select id="status" name="status" label="Status" required>
                                    @foreach ([['value' => 0, 'label' => 'Belum Menikah'], ['value' => 1, 'label' => 'Menikah']] as $option)
                                        <option value="{{ $option['value'] }}"
                                            {{ old('status', $patient->status) == $option['value'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </x-form.select>
                            </div>
                            <div>
                                <x-form.input id="phone_number" name="phone_number" label="No. Telepon"
                                    :value="old('phone_number', $patient->phone_number)" required />
                            </div>
                        </div>

                        <div>
                            <x-form.textarea id="address" name="address" label="Alamat" :value="old('address', $patient->address)" required />
                        </div>
                    </div>
                </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 flex justify-end space-x-3">
        <x-form.button variant="secondary" class="!py-2 !px-4"
            onclick="window.location.href='{{ route('staff.patients.index') }}'">
            <i class="fas fa-times mr-2"></i>
            Batal
        </x-form.button>
        <x-form.button variant="primary" class="!py-2 !px-4" type="submit">
            <i class="fas fa-save mr-2"></i>
            Simpan Perubahan
        </x-form.button>
    </div>
    </form>
    </x-ui.card>
    </div>
</x-dashboard-layout>
