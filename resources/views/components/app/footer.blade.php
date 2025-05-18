<!-- Footer Component -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Deskripsi Sistem -->
            <div>
                <h3 class="text-lg font-bold text-primary-700 dark:text-primary-400 mb-4">Simpratja</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Sistem Informasi Manajemen Praktik Dokter Jaga - solusi terpadu untuk pengelolaan layanan kesehatan
                    rawat jalan yang efisien, aman, dan modern.
                </p>
                <div class="flex space-x-4 mt-4">
                    <a href="#"
                        class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"
                        class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#"
                        class="text-gray-500 hover:text-primary-600 dark:text-gray-400 dark:hover:text-primary-400">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold text-primary-700 dark:text-primary-400 mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                            class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">
                            <i class="fas fa-info-circle mr-2"></i> About
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('queue') }}"
                            class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">
                            <i class="fas fa-list-ol mr-2"></i> Queue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}"
                            class="text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400">
                            <i class="fas fa-sign-in-alt mr-2"></i> Login
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-lg font-bold text-primary-700 dark:text-primary-400 mb-4">Contact Us</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-primary-600 dark:text-primary-400 mt-1 mr-3"></i>
                        <span class="text-gray-600 dark:text-gray-300">Jl. Kesehatan No. 123, Jakarta Selatan,
                            Indonesia</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone text-primary-600 dark:text-primary-400 mr-3"></i>
                        <span class="text-gray-600 dark:text-gray-300">+62 21 1234 5678</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope text-primary-600 dark:text-primary-400 mr-3"></i>
                        <span class="text-gray-600 dark:text-gray-300">info@simpratja.com</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-clock text-primary-600 dark:text-primary-400 mr-3"></i>
                        <span class="text-gray-600 dark:text-gray-300">Senin - Sabtu: 08:00 - 20:00</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-200 dark:border-gray-700 mt-8 pt-8 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Simpratja. All rights reserved.
            </p>
        </div>
    </div>
</footer>
