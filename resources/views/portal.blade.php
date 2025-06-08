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

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Pasien Baru</h2>
                            <p class="text-gray-600">Silakan isi formulir di bawah ini untuk mendaftar sebagai pasien
                                baru. Semua informasi dijaga kerahasiaan dan keamanannya.</p>
                        </div>

                        <form id="registration-form" class="space-y-6" action="{{ route('patient.register') }}"
                            method="POST">
                            @csrf
                            <div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-form.input name="nik" id="nik" label="NIK"
                                        placeholder="Masukkan NIK" required />

                                    <x-form.input name="name" id="name" label="Nama Lengkap"
                                        placeholder="Masukkan Nama Lengkap" required />
                                    <x-form.datepicker name="birth_date" id="birth_date" label="Tanggal Lahir"
                                        maxDate="{{ now()->format('Y-m-d') }}" placeholder="Pilih tanggal lahir" />
                                    <x-form.select name="gender" id="gender" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin">
                                        <option value="0">Perempuan</option>
                                        <option value="1">Laki Laki</option>
                                    </x-form.select>
                                    <x-form.select name="blood_type" id="blood_type" label="Gol. Darah"
                                        placeholder="Pilih Golongan Darah">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">AB</option>
                                        <option value="4">O</option>
                                    </x-form.select>
                                    <x-form.select name="religion" id="religion" label="Agama"
                                        placeholder="Pilih Kepercayaan">
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="katolik">Katolik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="budha">Budha</option>
                                        <option value="konghucu">Konghucu</option>
                                    </x-form.select>
                                    <x-form.select name="status" id="status" label="Status"
                                        placeholder="Pilih Status">
                                        <option value="0">Belum Menikah</option>
                                        <option value="1">Sudah Menikah</option>
                                    </x-form.select>
                                    <x-form.input type="tel" name="phone_number" id="phone_number" label="No. HP"
                                        placeholder="Masukkan Nomor HP" required />
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
                                        placeholder="Pilih tanggal periksa" />
                                    <x-form.select name="docter_id" id="docter_id" label="Dokter"
                                        placeholder="Pilih dokter">
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
                        <div class="mb-6  text-center">
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
                                        id="visit_date" label="Tanggal Periksa"
                                        placeholder="Pilih tanggal periksa" />
                                    <x-form.select name="docter_id" id="docter_id" label="Dokter"
                                        placeholder="Pilih dokter">
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
                    window.flasher.error('Terjadi kesalahan saat memproses data');
                    console.error('Error:', error);
                }
            }
        </script>
    @endpush
</x-home-layout>
