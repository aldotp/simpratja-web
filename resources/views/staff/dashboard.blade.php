<x-dashboard-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <x-ui.breadcrumb rounded="true" :items="[
            ['label' => 'Staff'],
            [
                'label' => 'Dashboard',
                'url' => '/dashboard',
            ],
        ]" />

        <!-- Welcome Card -->
        <x-ui.card class="border border-primary-200 shadow-lg overflow-hidden animate-fade-in mt-4">
            <div class="relative">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-primary-200 rounded-full -mr-16 -mt-16">
                </div>
                <div class="absolute bottom-0 left-0 w-16 h-16 md:w-32 md:h-32 bg-primary-300 rounded-full -ml-8 -mb-8">
                </div>

                <div class="relative z-10 p-6 md:p-8">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between w-full">
                        <!-- Welcome Message Section -->
                        <div class="mb-6 md:mb-0 animate-slide-right animate-delay-100">
                            <div class="flex items-center">
                                <div class="mr-4 bg-primary-100 rounded-full p-3">
                                    <i class="fas fa-hand-sparkles text-primary-600 text-2xl welcome-icon"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl font-bold text-gray-800" id="greeting">Good morning,
                                    </h2>
                                    <h1 class="text-2xl md:text-3xl font-bold text-primary-700" id="user-name">
                                        {{ auth()->user()->detail->name }}</h1>
                                </div>
                            </div>
                            <p class="text-gray-600 mt-3">Welcome to your staff dashboard. Here's an overview of our
                                healthcare facility's current status.</p>
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="mt-8 pt-6 border-t border-gray-100 animate-slide-up animate-delay-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Overview Statistics</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Patient Count Card -->
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Total Patients</p>
                                        <h4 class="text-2xl font-bold text-gray-900 mt-1">{{ $patientCount }}</h4>
                                    </div>
                                    <div class="bg-primary-100 p-3 rounded-full">
                                        <i class="fas fa-users text-primary-600 text-xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Visit Count Card -->
                            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600">Total Visits</p>
                                        <h4 class="text-2xl font-bold text-gray-900 mt-1">{{ $visitCount }}</h4>
                                    </div>
                                    <div class="bg-primary-100 p-3 rounded-full">
                                        <i class="fas fa-calendar-check text-primary-600 text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Section -->
                    <div class="mt-8 pt-6 border-t border-gray-100 animate-slide-up animate-delay-300">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <a href="{{ route('staff.patients.index') }}"
                                class="action-button flex flex-col items-center justify-center bg-white hover:bg-primary-50 border border-gray-200 rounded-lg p-4 transition-all">
                                <div class="bg-primary-100 rounded-full p-2 mb-2">
                                    <i class="fas fa-hospital-user text-primary-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Data Pasien</span>
                            </a>

                            <a href="{{ route('staff.visits.index') }}"
                                class="action-button flex flex-col items-center justify-center bg-white hover:bg-primary-50 border border-gray-200 rounded-lg p-4 transition-all">
                                <div class="bg-primary-100 rounded-full p-2 mb-2">
                                    <i class="fas fa-calendar-check text-primary-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Data Kunjungan</span>
                            </a>

                            <a href="{{ route('staff.medical-records.index') }}"
                                class="action-button flex flex-col items-center justify-center bg-white hover:bg-primary-50 border border-gray-200 rounded-lg p-4 transition-all">
                                <div class="bg-primary-100 rounded-full p-2 mb-2">
                                    <i class="fas fa-notes-medical text-primary-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Rekam Medis</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </x-ui.card>
    </div>
    @push('scripts')
        @vite('resources/js/greetings.js')
    @endpush
</x-dashboard-layout>
