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
                            x-on:click="activeTab = 'new-patient'; document.getElementById('queue-status-section').classList.add('hidden')"
                            :class="activeTab === 'new-patient' ?
                                'flex-1 py-4 px-6 text-center font-medium text-primary-600 border-b-2 border-primary-500 bg-primary-50' :
                                'flex-1 py-4 px-6 text-center font-medium text-gray-500 hover:text-primary-600'">Pasien
                            Baru</button>
                        <button
                            x-on:click="activeTab = 'existing-patient'; document.getElementById('queue-status-section').classList.add('hidden')"
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

                        <form id="registration-form" class="space-y-6">
                            <div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-form.input name="nik" id="nik" label="NIK"
                                        placeholder="Masukkan NIK" required />

                                    <x-form.input name="first_name" id="first_name" label="Nama Lengkap"
                                        placeholder="Masukkan Nama Lengkap" required />
                                    <x-form.datepicker name="birth" id="birth" label="Tanggal Lahir"
                                        placeholder="Pilih tanggal lahir" />
                                    <x-form.select name="gender" id="gender" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin">
                                        <option value="male">Laki Laki</option>
                                        <option value="female">Perempuan</option>
                                    </x-form.select>
                                    <x-form.select name="blood-type" id="blood-type" label="Gol. Darah"
                                        placeholder="Pilih Golongan Darah">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </x-form.select>
                                    <x-form.input name="religion" id="religion" label="Agama"
                                        placeholder="Masukkan Agama" />
                                    <x-form.select name="marital-status" id="marital-status" label="Status"
                                        placeholder="Pilih Status">
                                        <option value="single">Belum Menikah</option>
                                        <option value="married">Menikah</option>
                                        <option value="divorced">Cerai</option>
                                        <option value="widowed">Janda/Duda</option>
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
                                        placeholder="Pilih tanggal periksa" />
                                    <x-form.select name="penjamin" id="penjamin" label="Penjamin"
                                        placeholder="Pilih penjamin">
                                        <option value="x">Contoh 1</option>
                                        <option value="y">Contoh 2</option>
                                    </x-form.select>
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
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Pasien Lama</h2>
                            <p class="text-gray-600">Silakan isi formulir di bawah ini untuk mendaftar sebagai pasien
                                lama. Semua informasi dijaga kerahasiaan dan keamanannya.</p>
                        </div>

                        <form id="login-form">

                            <div class="space-y-4">
                                <x-form.input name="nik" id="nik" label="NIK"
                                    placeholder="Masukkan NIK" required />

                                <x-form.input name="first_name" id="first_name" label="Nama Lengkap"
                                    placeholder="Masukkan Nama Lengkap" required />

                                <x-form.datepicker name="tgl-periksa" id="tgl-periksa" label="Tanggal Periksa"
                                    placeholder="Pilih tanggal periksa" />

                                <x-form.select name="penjamin" id="penjamin" label="Penjamin"
                                    placeholder="Pilih penjamin">
                                    <option value="x">Contoh 1</option>
                                    <option value="y">Contoh 2</option>
                                </x-form.select>

                                <x-form.select name="dokter" id="dokter" label="Dokter"
                                    placeholder="Pilih dokter">
                                    <option value="x">Contoh 1</option>
                                    <option value="y">Contoh 2</option>
                                </x-form.select>
                            </div>

                            <div class="mt-6">
                                <x-form.button type="submit"
                                    class="w-full transition duration-300">
                                    Daftar Sekarang
                                </x-form.button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Queue Status Section (Hidden by default) -->
                <div id="queue-status-section" class="hidden bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 md:p-8">
                        <div class="flex flex-col md:flex-row items-center justify-between mb-8">
                            <div class="flex items-center mb-4 md:mb-0">
                                <div
                                    class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mr-4 pulse">
                                    <i class="fas fa-user-clock text-primary-600 text-2xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">Your Queue Status</h2>
                                    <p class="text-gray-600">Last updated: <span id="last-updated">May 11, 2023 10:05
                                            AM</span></p>
                                </div>
                            </div>
                            <button id="refresh-queue-button"
                                class="bg-primary-50 hover:bg-primary-100 text-primary-600 px-4 py-2 rounded-md font-medium transition duration-300 flex items-center">
                                <i class="fas fa-sync-alt mr-2"></i> Refresh
                            </button>
                        </div>

                        <div class="bg-primary-50 rounded-lg p-6 mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="text-center">
                                    <p class="text-gray-600 mb-1">Your Position</p>
                                    <div class="text-4xl font-bold text-primary-600">#3</div>
                                    <p class="text-sm text-gray-500 mt-1">in line</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-600 mb-1">Estimated Wait Time</p>
                                    <div class="text-4xl font-bold text-primary-600">15</div>
                                    <p class="text-sm text-gray-500 mt-1">minutes</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-gray-600 mb-1">Department</p>
                                    <div class="text-xl font-bold text-primary-600">General Medicine</div>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Sarah Johnson</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Current Department Wait Times</h3>
                            <div class="space-y-4">
                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-800">General Medicine</h4>
                                            <p class="text-sm text-gray-600">7 patients waiting</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <span class="queue-status-indicator queue-status-medium"></span>
                                                <span class="text-sm font-medium">25 min wait</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Pediatrics</h4>
                                            <p class="text-sm text-gray-600">3 patients waiting</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <span class="queue-status-indicator queue-status-low"></span>
                                                <span class="text-sm font-medium">10 min wait</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Cardiology</h4>
                                            <p class="text-sm text-gray-600">12 patients waiting</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <span class="queue-status-indicator queue-status-high"></span>
                                                <span class="text-sm font-medium">45 min wait</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition duration-300">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Dermatology</h4>
                                            <p class="text-sm text-gray-600">5 patients waiting</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center">
                                                <span class="queue-status-indicator queue-status-medium"></span>
                                                <span class="text-sm font-medium">20 min wait</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Estimated Consultation Duration</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-2">General Consultation</h4>
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-primary-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Approximately <span class="font-medium">15-20
                                                    minutes</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-2">Specialist Consultation</h4>
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user-md text-primary-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Approximately <span class="font-medium">20-30
                                                    minutes</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-center">
                            <button id="back-to-portal"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 rounded-md font-medium transition duration-300">
                                Back to Patient Portal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Alpine.js sudah diimpor di resources/js/app.js -->
</x-home-layout>
