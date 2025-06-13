<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[['label' => 'Profile']]" />

        @if (session('success'))
            <x-ui.alert type="success" class="mt-4" :message="session('success')" dismissible />
        @endif

        @if (session('error'))
            <x-ui.alert type="error" class="mt-4" :message="session('error')" dismissible />
        @endif

        <x-ui.card class="mt-4">
            <div class="flex flex-row gap-4 items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </div>

            <div class="flex flex-col md:flex-row gap-8">
                <!-- Profile Image and Basic Info -->
                <div class="w-full md:w-1/3 flex flex-col items-center justify-center">
                    <div
                        class="w-32 h-32 rounded-full overflow-hidden mb-4 bg-gray-200 flex items-center justify-center">
                        <img class="w-full h-full object-cover"
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->detail->name }}"
                            alt="Profile Image">
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ auth()->user()->detail->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                </div>

                <!-- Profile Form -->
                <div class="w-full md:w-2/3">
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <x-form.input name="name" id="name" label="Nama Lengkap"
                            placeholder="Masukkan Nama Lengkap" required :value="old('name', auth()->user()->detail->name)" />

                        <x-form.input name="nik" id="nik" label="NIK" placeholder="Masukkan NIK" required
                            :value="old('nik', auth()->user()->nik)" minLength="16" maxLength="16" />

                        <x-form.input name="phone_number" id="phone_number" label="No. Handphone"
                            placeholder="Masukkan No. Handphone" required :value="old('phone_number', auth()->user()->detail->phone_number)" />

                        <x-form.select name="gender" id="gender" label="Jenis Kelamin" required>
                            <option value="0"
                                {{ old('gender', auth()->user()->detail->gender) == '0' ? 'selected' : '' }}>Perempuan
                            </option>
                            <option value="1"
                                {{ old('gender', auth()->user()->detail->gender) == '1' ? 'selected' : '' }}>Laki-laki
                            </option>
                        </x-form.select>

                        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 flex flex-col gap-2">
                            <h4 class="text-md font-medium text-gray-800 dark:text-gray-300 mb-2">Ubah Password
                                (opsional)</h4>

                            <x-form.input type="password" name="password" id="password" label="Password Baru"
                                placeholder="Masukkan Password Baru" />

                            <x-form.input type="password" name="password_confirmation" id="password_confirmation"
                                label="Konfirmasi Password Baru" placeholder="Konfirmasi Password Baru" />
                        </div>

                        <div class="flex justify-end mt-6">
                            <x-form.button type="submit" variant="primary">
                                Update Profile
                            </x-form.button>
                        </div>
                    </form>
                </div>
            </div>
        </x-ui.card>
    </div>
</x-dashboard-layout>
