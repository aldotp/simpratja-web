<x-home-layout>
    <!-- Queue Display Section -->
    <section class="min-h-[80vh] flex items-center justify-center py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="p-8 md:p-12">
                        <div class="text-center mb-8">
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Current Queue Number</h1>
                            <p class="text-gray-500 mt-2">Last updated: <span id="last-updated">May 17, 2023 11:09
                                    AM</span></p>
                        </div>

                        <div class="flex flex-col items-center justify-center">
                            <div class="relative mb-8">
                                <div
                                    class="w-48 h-48 md:w-64 md:h-64 bg-primary-50 rounded-full flex items-center justify-center queue-pulse">
                                    <div
                                        class="w-40 h-40 md:w-56 md:h-56 bg-white rounded-full flex items-center justify-center">
                                        <span id="queue-number"
                                            class="queue-number text-6xl md:text-8xl font-bold text-primary-600">42</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                                <x-form.button id="refresh-button">
                                    <i class="fas fa-sync-alt mr-2"></i> Refresh
                                </x-form.button>
                                <x-form.button variant="outline" id="download-receipt-button">
                                    <i class="fas fa-download mr-2"></i>Download Queue Receipt
                                </x-form.button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Auto-refresh notice -->
                <div class="text-center mt-6 text-gray-500 text-sm">
                    <p>Queue number updates automatically every 30 seconds</p>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Queue Number Update
        const queueNumber = document.getElementById('queue-number');
        const lastUpdated = document.getElementById('last-updated');
        const refreshButton = document.getElementById('refresh-button');

        // Function to update the queue number
        function updateQueueNumber() {
            // Show loading state
            refreshButton.disabled = true;
            refreshButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Refreshing...';

            // Simulate API call delay
            setTimeout(() => {
                // Generate a random number between 1 and 99 for demo purposes
                // In a real application, this would be fetched from a server
                const newNumber = Math.floor(Math.random() * 99) + 1;

                // Update the queue number with animation
                queueNumber.style.transform = 'scale(0.8)';
                queueNumber.style.opacity = '0.5';

                setTimeout(() => {
                    queueNumber.textContent = newNumber.toString().padStart(2, '0');
                    queueNumber.style.transform = 'scale(1)';
                    queueNumber.style.opacity = '1';
                }, 300);

                // Update last updated time
                const now = new Date();
                const formattedDate = now.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit'
                });
                lastUpdated.textContent = formattedDate;

                // Reset button state
                refreshButton.disabled = false;
                refreshButton.innerHTML = '<i class="fas fa-sync-alt mr-2"></i> Refresh';
            }, 1000);
        }

        // Manual refresh button
        refreshButton.addEventListener('click', updateQueueNumber);

        // Auto-refresh every 30 seconds
        setInterval(updateQueueNumber, 30000);

        // Initial transition for the queue number
        queueNumber.style.transition = 'transform 0.3s ease, opacity 0.3s ease';

        // Download Queue Receipt Functionality
        const downloadReceiptButton = document.getElementById('download-receipt-button');

        downloadReceiptButton.addEventListener('click', () => {
            // Show loading state
            downloadReceiptButton.disabled = true;
            downloadReceiptButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating...';

            setTimeout(() => {
                generateQueueReceipt();

                // Reset button state
                downloadReceiptButton.disabled = false;
                downloadReceiptButton.innerHTML =
                    '<i class="fas fa-download mr-2"></i> Download Queue Receipt';
            }, 1000);
        });

        function generateQueueReceipt() {
            // Get current queue number and timestamp
            const currentQueueNumber = queueNumber.textContent;
            const currentTimestamp = lastUpdated.textContent;
            const now = new Date();
            const formattedDate = now.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            const formattedTime = now.toLocaleTimeString('id-ID', {
                hour: 'numeric',
                minute: '2-digit',
                hour12: false
            });

            // Generate registration number format: REG/1/YYYY-MM-DD/1
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const regNumber = `REG/1/${year}-${month}-${day}/1`;

            // Sample patient data (in a real app, this would come from a database)
            const patientName = 'Slamet';
            const rmNumber = '01234567';
            const address = 'Jl. Bantarsari';

            // Create form data to send to the server
            const formData = new FormData();
            formData.append('queueNumber', currentQueueNumber);
            formData.append('regNumber', regNumber);
            formData.append('patientName', patientName);
            formData.append('rmNumber', rmNumber);
            formData.append('address', address);
            formData.append('registerDate', formattedDate);
            formData.append('examDate', formattedDate);

            // Send request to generate PDF
            fetch('/generate-receipt-pdf', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.blob();
                })
                .then(blob => {
                    // Create a download link and trigger the download
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `Antrian-${currentQueueNumber}-${year}${month}${day}.pdf`;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                })
                .catch(error => {
                    console.error('Error generating PDF:', error);
                    alert('Terjadi kesalahan saat mencetak antrian. Silakan coba lagi.');
                })
                .finally(() => {
                    // Reset button state
                    downloadReceiptButton.disabled = false;
                    downloadReceiptButton.innerHTML = '<i class="fas fa-download mr-2"></i> Download Queue Receipt';
                });
        }
    </script>
</x-home-layout>
