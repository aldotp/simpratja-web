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
                            x-on:click="activeTab = 'new-patient'; document.getElementById('section-detail-patient').classList.add('hidden')"
                            :class="activeTab === 'new-patient' ?
                                'flex-1 py-4 px-6 text-center font-medium text-primary-600 border-b-2 border-primary-500 bg-primary-50' :
                                'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-primary-600'">Pasien
                            Baru</button>
                        <button
                            x-on:click="activeTab = 'existing-patient'; document.getElementById('section-detail-patient').classList.add('hidden')"
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

                                    <x-form.input name="first_name" id="first_name" label="Nama Lengkap"
                                        placeholder="Masukkan Nama Lengkap" required />
                                    <x-form.datepicker name="birth" id="birth" label="Tanggal Lahir"
                                        placeholder="Pilih tanggal lahir" x-init="$nextTick(() => {
                                            new Datepicker($el, { format: 'dd-mm-yyyy' });
                                        })" />
                                    <x-form.select name="gender" id="gender" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin">
                                        <option value="0">Perempuan</option>
                                        <option value="1">Laki Laki</option>
                                    </x-form.select>
                                    <x-form.select name="blood-type" id="blood-type" label="Gol. Darah"
                                        placeholder="Pilih Golongan Darah">
                                        <option value="1">A</option>
                                        <option value="2">B</option>
                                        <option value="3">AB</option>
                                        <option value="4">O</option>
                                    </x-form.select>
                                    <x-form.input name="religion" id="religion" label="Agama"
                                        placeholder="Masukkan Agama" />
                                    <x-form.select name="marital-status" id="marital-status" label="Status"
                                        placeholder="Pilih Status">
                                        <option value="false">Belum Menikah</option>
                                        <option value="true">Sudah Menikah</option>
                                    </x-form.select>
                                    <x-form.input type="tel" name="phone" id="phone" label="No. HP"
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
                                    <x-form.datepicker name="tgl-periksa" id="tgl-periksa" label="Tanggal Periksa"
                                        placeholder="Pilih tanggal periksa" x-init="$nextTick(() => {
                                            new Datepicker($el, { format: 'dd-mm-yyyy' });
                                        })" />
                                    <x-form.select name="dokter" id="dokter" label="Dokter"
                                        placeholder="Pilih dokter">
                                        <option value="x">Contoh 1</option>
                                        <option value="y">Contoh 2</option>
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
                                <div class="grid grid-cols-2 gap-4">
                                    <x-form.input name="no_rm" id="no_rm" label="Rekam Medis"
                                        placeholder="Masukkan Rekam Medis" required />

                                    <x-form.datepicker name="tgl-lahir" id="tgl-lahir" label="Tanggal Lahir" required
                                        placeholder="Pilih tanggal lahir" x-init="$nextTick(() => {
                                            new Datepicker($el, { format: 'dd-mm-yyyy' });
                                        })" />
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
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Medical Check Up</h3>
                            <!-- Informasi Medis -->
                            <div class="space-y-4">
                                <x-form.datepicker name="tgl-periksa" datepicker-min-date="{{ now() }}"
                                    id="tgl-periksa-existing" label="Tanggal Periksa"
                                    placeholder="Pilih tanggal periksa" x-init="$nextTick(() => {
                                        new Datepicker($el, { format: 'dd-mm-yyyy' });
                                    })" />
                                <x-form.select name="dokter" id="dokter" label="Dokter"
                                    placeholder="Pilih dokter">
                                    <option value="x">Contoh 1</option>
                                    <option value="y">Contoh 2</option>
                                </x-form.select>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </div>
        </div>
    </main>
    <script>
        async function getDetailExistingPatient() {
            const no_rm = document.getElementById('no_rm').value;
            const tgl_lahir = document.getElementById('tgl-lahir').value;

            const response = await fetch('/api/v1/get-patient', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        no_rm: no_rm,
                        tgl_lahir: tgl_lahir,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'success') {
                        document.getElementById('section-detail-patient').classList.remove('hidden');
                        document.getElementById('btn-search-patient').classList.add('hidden');

                        // Update the detail section with patient data
                        document.getElementById('patient-name').innerText = data.patient.name;
                        document.getElementById('patient-nik').innerText = data.patient.nik;
                        document.getElementById('patient-gender').innerText = data.patient.gender;
                        document.getElementById('patient-phone').innerText = data.patient.phone_number;
                        document.getElementById('patient-address').innerText = data.patient.address;
                        document.getElementById('tgl-periksa').value = '';
                        document.getElementById('dokter').value = '';
                    } else {
                        alert(data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                })
        }
    </script>
</x-home-layout>
