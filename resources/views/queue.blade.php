<x-home-layout>
    <!-- Queue Display Section -->
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Check Your Queue Status</h1>
                    <p class="text-gray-600">Enter your National Identification Number (NIK) and Registration Number to
                        check your current position in the queue.</p>
                </div>

                <x-ui.card>
                    <form id="queue-status-form" class="space-y-6" x-data="{ nik: '', registration_number: '' }"
                        @submit.prevent="getQueueStatus()">
                        <x-form.input type="text" id="nik" name="nik" label="NIK" x-model="nik"
                            placeholder="Masukkan NIK" required="true" />

                        <x-form.input type="text" id="registration_number" name="registration_number"
                            x-model="registration_number" label="Nomor Registrasi"
                            placeholder="Masukkan nomor registrasi" required="true" />

                        <x-form.button class="w-full" type="submit">
                            <i class="fas fa-search mr-2"></i> Check Queue Status
                        </x-form.button>
                    </form>
                </x-ui.card>

                <!-- Loading Indicator (Initially Hidden) -->
                <div id="loading-indicator" class="hidden flex justify-center items-center py-8">
                    <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
                    <span class="ml-4 text-gray-600">Retrieving your queue status...</span>
                </div>

                <!-- Queue Status Results (Initially Hidden) -->
                <div id="queue-status-results" class="hidden mt-8">
                    <x-ui.card>
                        <div class="text-center mb-6">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">Informasi Antrian Anda</h2>
                            <p class="text-gray-500 text-sm">Tanggal: <span id="examination-date"></span></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <!-- Nomor Antrian Anda -->
                            <div class="text-center">
                                <p class="text-sm text-gray-500 mb-2">Nomor Antrian Anda</p>
                                <div
                                    class="bg-primary-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto">
                                    <span id="queue-number" class="text-3xl font-bold text-primary-700"></span>
                                </div>
                            </div>

                            <!-- Status Antrian -->
                            <div class="text-center">
                                <p class="text-sm text-gray-500 mb-2">Status</p>
                                <div class="bg-gray-100 rounded-lg p-3 flex items-center justify-center mx-auto">
                                    <span id="visit-status" class="text-lg font-medium text-gray-800"></span>
                                </div>
                            </div>

                            <!-- Dokter -->
                            <div class="text-center">
                                <p class="text-sm text-gray-500 mb-2">Dokter</p>
                                <div class="bg-gray-100 rounded-lg p-3 flex items-center justify-center mx-auto">
                                    <span id="doctor-name" class="text-lg font-medium text-gray-800"></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nama Pasien</h3>
                                <p id="patient-name" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">NIK</h3>
                                <p id="patient-nik" class="text-gray-800 font-medium"></p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-500">Nomor Registrasi</h3>
                                <p id="registration-number" class="text-gray-800 font-medium"></p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6" id="notes">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p id="status-message" class="text-sm text-blue-700">
                                        Jika nomor antrian anda belum tersedia, silahkan tunggu sekitar 5-10 menit untuk
                                        mendapatkan nomor antrian.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div>
                            <x-form.button id="download-button" type="button" variant="primary" class="w-full"
                                onclick="downloadReceiptQueue()">
                                <i class="fas fa-download mr-2"></i> Download Receipt
                            </x-form.button>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script type="module">
            import {
                getQueueNumber
            } from '{{ Vite::asset('resources/js/api.js') }}';

            // Form Elements
            const nikInput = document.getElementById('nik');
            const registrationInput = document.getElementById('registration_number');

            // Display Elements
            const loadingIndicator = document.getElementById('loading-indicator');
            const queueStatusResults = document.getElementById('queue-status-results');
            const downloadButton = document.getElementById('download-button');

            // Result Elements
            const examinationDate = document.getElementById('examination-date');
            const queueNumber = document.getElementById('queue-number');
            const visitStatus = document.getElementById('visit-status');
            const doctorName = document.getElementById('doctor-name');
            const patientName = document.getElementById('patient-name');
            const patientNik = document.getElementById('patient-nik');
            const registrationNumber = document.getElementById('registration-number');
            const notes = document.getElementById('notes');

            // Form Validation
            nikInput.addEventListener('input', function() {
                // Only allow digits
                this.value = this.value.replace(/[^\d]/g, '');

                // Limit to 16 digits
                if (this.value.length > 16) {
                    this.value = this.value.slice(0, 16);
                }
            });

            // Form Submission
            window.getQueueStatus = async function() {
                const nik = nikInput.value.trim();
                const regNumber = registrationInput.value.trim();

                // Show loading indicator
                loadingIndicator.classList.remove('hidden');
                queueStatusResults.classList.add('hidden');

                try {
                    // Make API request
                    const data = await getQueueNumber(nik, regNumber);

                    // Hide loading indicator
                    loadingIndicator.classList.add('hidden');

                    if (data.status === 'success') {
                        // Update UI with data
                        updateQueueStatus(data.data);

                        // Show results
                        queueStatusResults.classList.remove('hidden');
                    }
                } catch (error) {
                    // Hide loading indicator
                    loadingIndicator.classList.add('hidden');
                }
            }

            // Download Receipt Button
            window.downloadReceiptQueue = function() {
                const nik = nikInput.value.trim();
                const regNumber = registrationInput.value.trim();
                // Redirect to export receipt endpoint
                window.location.href =
                    `/export-receipt?nik=${encodeURIComponent(nik)}&registration_number=${encodeURIComponent(regNumber)}`;
            }

            /**
             * Update the queue status UI with data from API
             * @param {Object} data - The data from API
             */
            function updateQueueStatus(data) {
                // Format date for display
                const date = new Date(data.visit_examination_date);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                // Update UI elements
                examinationDate.textContent = formattedDate;
                queueNumber.textContent = data.visit_queue_number || '-';

                // Translate status for display
                let statusText = 'Menunggu';
                if (data.visit_status === 'queue') statusText = 'Dalam Antrian';
                if (data.visit_status === 'called') statusText = 'Dipanggil';
                if (data.visit_status === 'done') statusText = 'Selesai';
                if (data.visit_status === 'register') statusText = 'Terdaftar';

                visitStatus.textContent = statusText;

                // Hide download button by default
                downloadButton.classList.add('hidden');

                // Show download button only if status is NOT 'register'
                if (data.visit_status !== 'register') {
                    notes.classList.add('hidden');
                    downloadButton.classList.remove('hidden');
                }

                doctorName.textContent = data.docter_name || '-';
                patientName.textContent = data.patient_name || '-';
                patientNik.textContent = data.patient_nik || '-';
                registrationNumber.textContent = data.visit_registration_number || '-';
            }
        </script>
    @endpush
</x-home-layout>
