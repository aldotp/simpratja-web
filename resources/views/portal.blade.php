<x-home-layout>
    <main class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <!-- Portal Header -->
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Portal Pasien</h1>
                    <p class="text-gray-600 max-w-2xl mx-auto">Akses informasi kesehatan Anda dan kelola janji temu
                        dengan portal pasien yang aman.</p>
                </div>

                <!-- Registration Success Card -->
                <x-ui.card class="mb-4" x-data="{ show: false }" x-init="setTimeout(() => show = true, 2000)"
                    x-show.transition.duration.1000ms="show" id="card-registration-number">
                    <div class="w-full">
                        <div class="mb-2 flex justify-between items-center">
                            <label for="website-url" class="text-sm font-medium text-gray-900 dark:text-white">Nomor
                                Registrasi Terdaftar:</label>
                        </div>
                        <div class="flex items-center">
                            <div class="relative w-full">
                                <input id="input-registration-number" type="text"
                                    aria-describedby="helper-text-explanation"
                                    class="border border-e-0 border-gray-300 text-gray-500 dark:text-gray-400 text-sm focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500 rounded-s-lg"
                                    value="" readonly disabled />
                            </div>
                            <button id="copy-button" data-tooltip-target="tooltip-copy"
                                data-copy-target="input-registration-number"
                                class="shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-primary-700 rounded-e-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 border border-primary-700 dark:border-primary-600 hover:border-primary-800 dark:hover:border-primary-700"
                                type="button">
                                <span id="default-icon" class="inline-flex">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 18 20">
                                        <path
                                            d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z" />
                                    </svg>
                                </span>
                                <span id="success-icon" class="hidden">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 16 12">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                    </svg>
                                </span>
                            </button>
                            <div id="tooltip-copy" role="tooltip"
                                class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                <span id="default-tooltip-message">Salin nomor registrasi</span>
                                <span id="success-tooltip-message" class="hidden">Berhasil disalin!</span>
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>

                <!-- Tab Navigation -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8" x-data="{ activeTab: 'new-patient' }">
                    <div class="flex border-b border-gray-200">
                        <button
                            x-on:click="activeTab = 'new-patient'; if(window.patientFound) document.getElementById('section-detail-patient').classList.add('hidden')"
                            :class="activeTab === 'new-patient' ?
                                'flex-1 py-4 px-6 text-center font-medium text-primary-600 border-b-2 border-primary-500 bg-primary-50' :
                                'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-primary-600'">Pasien
                            Baru</button>
                        <button
                            x-on:click="activeTab = 'existing-patient'; if(window.patientFound) document.getElementById('section-detail-patient').classList.remove('hidden')"
                            :class="activeTab === 'existing-patient' ?
                                'flex-1 py-4 px-6 text-center font-medium text-primary-600 border-b-2 border-primary-500 bg-primary-50' :
                                'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-primary-600'">Pasien
                            Terdaftar</button>
                    </div>

                    <!-- New Patient Registration Form -->
                    <div x-show="activeTab === 'new-patient'" class="p-6 md:p-8">

                        <div class="mb-6 text-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Pasien Baru</h2>
                            <p class="text-gray-600">Silakan isi formulir di bawah ini untuk mendaftar sebagai pasien
                                baru. Semua informasi dijaga kerahasiaan dan keamanannya.</p>
                        </div>

                        <form id="registration-form" class="space-y-6" action="{{ route('patient.register') }}"
                            method="POST">
                            @csrf
                            <div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-form.input name="nik" id="nik" label="NIK" type="text"
                                        placeholder="Masukkan NIK" required
                                        helpText="NIK harus terdiri dari 16 digit angka" minLength="16" maxLength="16" />

                                    <x-form.input name="name" id="name" label="Nama Lengkap"
                                        placeholder="Masukkan Nama Lengkap" required />
                                    <x-form.datepicker name="birth_date" id="birth_date" label="Tanggal Lahir"
                                        maxDate="{{ now()->format('Y-m-d') }}" placeholder="Pilih tanggal lahir"
                                        required />
                                    <x-form.select name="gender" id="gender" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin" required>
                                        <option value="0">Perempuan</option>
                                        <option value="1">Laki Laki</option>
                                    </x-form.select>
                                    <x-form.select name="blood_type" id="blood_type" label="Gol. Darah"
                                        placeholder="Pilih Golongan Darah" required>
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">AB</option>
                                        <option value="4">O</option>
                                    </x-form.select>
                                    <x-form.select name="religion" id="religion" label="Agama"
                                        placeholder="Pilih Kepercayaan" required>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="konghucu">Konghucu</option>
                                    </x-form.select>
                                    <x-form.select name="status" id="status" label="Status"
                                        placeholder="Pilih Status" required>
                                        <option value="0">Belum Menikah</option>
                                        <option value="1">Sudah Menikah</option>
                                    </x-form.select>
                                    <x-form.input type="number" name="phone_number" id="phone_number"
                                        label="No. HP" placeholder="Masukkan Nomor HP" required />
                                    <x-form.textarea name="address" id="address" label="Alamat"
                                        placeholder="Masukkan Alamat Lengkap" rows="3" required
                                        class="md:col-span-2" />
                                </div>
                            </div>

                            <!-- Informasi Medis -->
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Medical Check Up</h3>
                                <!-- Informasi Medis -->
                                <div class="space-y-4">
                                    <x-form.datepicker minDate="{{ now()->format('Y-m-d') }}" name="examination_date"
                                        id="examination_date" label="Tanggal Periksa"
                                        placeholder="Pilih tanggal periksa" required />
                                    <x-form.select name="docter_id" id="docter_id" label="Dokter"
                                        placeholder="Pilih dokter" required>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            </div>

                            <!-- Persetujuan -->
                            <div class="space-y-4">
                                <x-form.checkbox name="terms" id="terms" required
                                    label='Saya menyetujui <a href="#" class="text-primary-600 hover:underline">Syarat dan Ketentuan</a> dan <a href="#" class="text-primary-600 hover:underline">Kebijakan Privasi</a>' />
                                <x-form.checkbox name="hipaa" id="hipaa" required
                                    label='Saya mengakui bahwa saya telah menerima salinan <a href="#" class="text-primary-600 hover:underline">Pemberitahuan Praktik Privasi</a>' />
                            </div>

                            <div class="pt-6">
                                <button type="submit"
                                    class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-md font-medium transition duration-300">
                                    Daftar Sekarang
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Existing Patient Login -->
                    <div x-show="activeTab === 'existing-patient'" class="p-6 md:p-8">
                        <div class="mb-6 text-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pasien Lama</h2>
                            <p class="text-gray-600">Silakan isi formulir di bawah ini untuk mencari informasi pasien.
                                Semua informasi dijaga kerahasiaan dan keamanannya.</p>
                        </div>

                        <form id="existing-patient-form" @submit.prevent="getDetailExistingPatient()">

                            <div class="space-y-4">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <x-form.input name="medical_record_number" id="medical_record_number"
                                        label="Rekam Medis" placeholder="Masukkan Rekam Medis" required />

                                    <x-form.datepicker name="birth_date" id="birth_date_existing"
                                        maxDate="{{ now()->format('Y-m-d') }}" label="Tanggal Lahir" required
                                        placeholder="Pilih tanggal lahir" />
                                </div>
                            </div>

                            <div class="mt-6">
                                <x-form.button id="btn-search-patient" type="submit"
                                    class="w-full transition duration-300">
                                    Cari Pasien
                                </x-form.button>
                            </div>
                        </form>
                    </div>
                </div>

                <x-ui.card id="section-detail-patient" class="hidden bg-white rounded-lg shadow-md overflow-hidden">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Detail Pasien</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Nama Pasien</h3>
                            <p id="patient-name" class="text-gray-600"></p>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">NIK</h3>
                            <p id="patient-nik" class="text-gray-600"></p>
                        </div>
                        <!-- Informasi Medis -->
                        <form action="{{ route('patient.register.existing') }}" method="POST">
                            @csrf
                            <input type="hidden" name="patient_id" id="patient_id">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Medical Check Up</h3>
                                <!-- Informasi Medis -->
                                <div class="space-y-4">
                                    <x-form.datepicker minDate="{{ now()->format('Y-m-d') }}" name="visit_date"
                                        id="visit_date" label="Tanggal Periksa" placeholder="Pilih tanggal periksa"
                                        required />
                                    <x-form.select name="docter_id" id="docter_id" label="Dokter"
                                        placeholder="Pilih dokter" required>
                                        @foreach ($doctors as $doctor)
                                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                        @endforeach
                                    </x-form.select>
                                </div>
                            </div>
                            <div class="pt-6">
                                <button type="submit"
                                    class="w-full bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-md font-medium transition duration-300">
                                    Daftar Kunjungan
                                </button>
                            </div>
                        </form>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </main>
    @push('scripts')
        <script type="module">
            import {
                getPatientExisting
            } from '{{ Vite::asset('resources/js/api.js') }}';

            // Global variable to track if patient was found
            window.patientFound = false;

            // Make the function available globally
            window.getDetailExistingPatient = async function() {
                const medical_record_number = document.getElementById('medical_record_number').value;
                const birth_date = document.getElementById('birth_date_existing').value;

                try {
                    const data = await getPatientExisting(medical_record_number, birth_date);

                    if (data.status === 'success' && data.data) {
                        // Set global flag that patient was found
                        window.patientFound = true;

                        document.getElementById('section-detail-patient').classList.remove('hidden');
                        document.getElementById('existing-patient-form').classList.add('hidden');

                        // Update the detail section with patient data
                        document.getElementById('patient-name').innerText = data.data.name;
                        document.getElementById('patient-nik').innerText = data.data.nik;

                        // Store patient ID for registration
                        document.getElementById('patient_id').value = data.data.id;
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            }

            // Fungsi untuk menampilkan data registrasi dari sessionStorage
            function displayRegistrationData() {
                const storedData = JSON.parse(sessionStorage.getItem('registrationData'));
                if (storedData) {
                    const cardRegistrationNumber = document.getElementById('card-registration-number');
                    const inputRegistrationNumber = document.getElementById('input-registration-number');

                    cardRegistrationNumber.classList.remove('hidden');
                    inputRegistrationNumber.value = storedData.registration_number;

                    if (storedData.success_message) {
                        window.flasher.success(storedData.success_message);
                    }
                }
            }

            // Tampilkan data saat halaman dimuat
            document.addEventListener('DOMContentLoaded', () => {
                displayRegistrationData();

                // Inisialisasi clipboard
                const copyButton = document.getElementById('copy-button');
                const defaultIcon = document.getElementById('default-icon');
                const successIcon = document.getElementById('success-icon');
                const defaultTooltip = document.getElementById('default-tooltip-message');
                const successTooltip = document.getElementById('success-tooltip-message');

                if (copyButton) {
                    copyButton.addEventListener('click', async () => {
                        const targetId = copyButton.getAttribute('data-copy-target');
                        const targetElement = document.getElementById(targetId);

                        try {
                            await navigator.clipboard.writeText(targetElement.value);

                            // Update UI untuk menunjukkan berhasil
                            defaultIcon.classList.add('!hidden');
                            successIcon.classList.remove('hidden');
                            defaultTooltip.classList.add('hidden');
                            successTooltip.classList.remove('hidden');

                            // Reset UI setelah 2 detik
                            setTimeout(() => {
                                defaultIcon.classList.remove('!hidden');
                                successIcon.classList.add('hidden');
                                defaultTooltip.classList.remove('hidden');
                                successTooltip.classList.add('hidden');
                            }, 2000);
                        } catch (err) {
                            console.error('Gagal menyalin teks: ', err);
                            window.flasher.error('Gagal menyalin nomor registrasi');
                        }
                    });
                }
            });

            @if (session('registration_number'))
                // Simpan data registrasi ke sessionStorage
                const registrationData = {
                    registration_number: '{{ session('registration_number') }}',
                };
                sessionStorage.setItem('registrationData', JSON.stringify(registrationData));
                displayRegistrationData();
            @endif
        </script>
    @endpush
</x-home-layout>
