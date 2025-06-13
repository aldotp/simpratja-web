<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Admin'],
            [
                'label' => 'Users',
                'url' => '/admin/users',
            ],
            [
                'label' => 'Edit',
            ],
        ]" />
        <x-ui.card class="mt-2">
            <div class="flex flex-row gap-4 items-center">
                <x-form.button class="!p-3" variant="secondary"
                    onclick="window.location.href='{{ route('admin.users.index') }}'">
                    <i class="fa-solid fa-angle-left"></i>
                </x-form.button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    {{ __('Edit User') }}
                </h2>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4 mt-4">
                @csrf
                @method('PUT')

                <x-form.input name="name" id="name" label="Nama Lengkap" placeholder="Masukkan Nama Lengkap"
                    required :value="old('name', $user->name)" />
                <x-form.input name="nik" id="nik" label="NIK" placeholder="Masukkan NIK" required
                    :value="old('nik', $user->nik)" minLength="16" maxLength="16" />

                <x-form.input name="phone_number" id="phone_number" label="No. Handphone"
                    placeholder="Masukkan No. Handphone" required :value="old('phone_number', $user->phone_number)" />

                <x-form.select name="gender" id="gender" label="Jenis Kelamin" required>
                    <option value="0" {{ old('gender', $user->gender) == '0' ? 'selected' : '' }}>Perempuan
                    </option>
                    <option value="1" {{ old('gender', $user->gender) == '1' ? 'selected' : '' }}>Laki-laki
                    </option>
                </x-form.select>

                <x-form.select name="role" id="role" label="Role" required>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="leader" {{ old('role', $user->role) == 'leader' ? 'selected' : '' }}>Leader</option>
                </x-form.select>

                <div class="flex justify-end mt-6">
                    <x-form.button type="submit" variant="primary">
                        Edit User
                    </x-form.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-dashboard-layout>
