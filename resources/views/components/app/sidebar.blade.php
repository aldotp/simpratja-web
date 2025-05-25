<div class="min-w-fit">
    <!-- Sidebar backdrop (mobile only) -->
    <div class="fixed inset-0 bg-gray-900/30 z-40 lg:hidden lg:z-auto transition-opacity duration-200"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak></div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="flex lg:flex! flex-col absolute z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 h-[100dvh] overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:w-64! shrink-0 bg-white dark:bg-gray-800 p-4 transition-all duration-200 ease-in-out {{ $variant === 'v2' ? 'border-r border-gray-200 dark:border-gray-700/60' : 'rounded-r-2xl shadow-xs' }}"
        :class="sidebarOpen ? 'max-lg:translate-x-0' : 'max-lg:-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false">

        <!-- Sidebar header -->
        <div class="flex justify-between mb-10 pr-3 sm:px-2">
            <!-- Close button -->
            <button class="lg:hidden text-gray-500 hover:text-gray-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>
                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>
            <!-- Logo -->
            <a class="block" href="#">
                <svg class="fill-primary-600" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                    <path
                        d="M31.956 14.8C31.372 6.92 25.08.628 17.2.044V5.76a9.04 9.04 0 0 0 9.04 9.04h5.716ZM14.8 26.24v5.716C6.92 31.372.63 25.08.044 17.2H5.76a9.04 9.04 0 0 1 9.04 9.04Zm11.44-9.04h5.716c-.584 7.88-6.876 14.172-14.756 14.756V26.24a9.04 9.04 0 0 1 9.04-9.04ZM.044 14.8C.63 6.92 6.92.628 14.8.044V5.76a9.04 9.04 0 0 1-9.04 9.04H.044Z" />
                </svg>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">Pages</span>
                </h3>
                <ul class="mt-3">
                    @php
                        // Get current user role
                        $userRole = auth()->check() ? auth()->user()->role : null;
                    @endphp

                    <!-- Begin Role-based Menu -->
                    @if ($userRole == 'admin')
                        <!-- Admin Menu -->
                        <!-- Dashboard -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['dashboard'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('admin.dashboard') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i class="fa-solid fa-house fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Users -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['users'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['users'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('admin.users.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i class="fa-solid fa-users fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Users</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Dokter -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['doctors'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['doctors'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('admin.doctors.index') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i
                                            class="fa-solid fa-user-doctor fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Doctors</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Reports -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['reports'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['reports'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('admin.reports.index') }}">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-file-lines fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Reports</span>
                                </div>
                            </a>
                        </li>
                    @elseif($userRole == 'staff')
                        <!-- Petugas/Staff Menu -->
                        <!-- Dashboard -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['dashboard'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('staff.dashboard') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i class="fa-solid fa-house fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Pasien -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['patients'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['patients'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('staff.patients.index') }}">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-user-group fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pasien</span>
                                </div>
                            </a>
                        </li>
                        <!-- Visits -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['visits'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['visits'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('staff.visits.index') }}">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-notes-medical fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Kunjungan</span>
                                </div>
                            </a>
                        </li>
                        <!-- History Visits -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['history-visits'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['history-visits'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('staff.history-visits') }}">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-hospital-user fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Riwayat
                                        Kunjungan</span>
                                </div>
                            </a>
                        </li>
                        <!-- Medical Records -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['medical-records'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['medical-records'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-paperclip fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Catatan
                                        Rekam Medis</span>
                                </div>
                            </a>
                        </li>
                        <!-- Feedbacks -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['feedbacks'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['feedbacks'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-paper-plane fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Feedback
                                        Pasien</span>
                                </div>
                            </a>
                        </li>
                    @elseif($userRole == 'docter')
                        <!-- Dokter Menu -->
                        <!-- Dashboard -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['dashboard'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('doctor.dashboard') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i class="fa-solid fa-house fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Visits -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['visits'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['visits'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('doctor.visits.index') }}">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-hospital-user fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Data
                                        Kunjungan</span>
                                </div>
                            </a>
                        </li>
                        <!-- Riwayat Pasien -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['medicines'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['medicines'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('doctor.medicines.index') }}">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-pills fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Data
                                        Obat</span>
                                </div>
                            </a>
                        </li>
                    @elseif($userRole == 'leader')
                        <!-- Pimpinan Menu -->
                        <!-- Dashboard -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['dashboard'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('leader.dashboard') }}">
                                <div class="flex items-center justify-between">
                                    <div class="grow flex items-center">
                                        <i class="fa-solid fa-house fill-current text-gray-400 dark:text-gray-500"></i>
                                        <span
                                            class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <!-- Laporan -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['reports'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['reports'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('leader.reports.index') }}">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-file fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Data
                                        Laporan</span>
                                </div>
                            </a>
                        </li>
                        <!-- Feedbacks -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['feedbacks'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['feedbacks'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="{{ route('leader.feedbacks.index') }}">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-paper-plane fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Feedback
                                        Pasien</span>
                                </div>
                            </a>
                        </li>
                    @else
                        <!-- Default Menu for Guest or Unknown Role -->
                        <!-- Dashboard -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['dashboard'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['dashboard'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#">
                                <div class="flex items-center">
                                    <i class="fa-solid fa-house fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Dashboard</span>
                                </div>
                            </a>
                        </li>
                        <!-- Login -->
                        <li
                            class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['login'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif">
                            <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['login'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                                href="#">
                                <div class="flex items-center">
                                    <i
                                        class="fa-solid fa-right-to-bracket fill-current text-gray-400 dark:text-gray-500"></i>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Login</span>
                                </div>
                            </a>
                        </li>
                    @endif
                    <!-- End Role-based Menu -->
                </ul>
            </div>
            <!-- More group -->
            {{-- <div>
                <h3 class="text-xs uppercase text-gray-400 dark:text-gray-500 font-semibold pl-3">
                    <span class="hidden lg:block lg:sidebar-expanded:hidden 2xl:hidden text-center w-6"
                        aria-hidden="true">•••</span>
                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:block">More</span>
                </h3>
                <ul class="mt-3">
                    <!-- Settings -->
                    <li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-linear-to-r @if (in_array(Request::segment(2), ['settings'])) {{ 'from-primary-600/[0.12] dark:from-primary-600/[0.24] to-primary-600/[0.04]' }} @endif"
                        x-data="{ open: {{ in_array(Request::segment(2), ['settings']) ? 1 : 0 }} }">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition @if (!in_array(Request::segment(2), ['settings'])) {{ 'hover:text-gray-900 dark:hover:text-white' }} @endif"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="shrink-0 fill-current @if (in_array(Request::segment(2), ['settings'])) {{ 'text-primary-600' }}@else{{ 'text-gray-400 dark:text-gray-500' }} @endif"
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 16 16">
                                        <path
                                            d="M10.5 1a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2h-1.145a3.502 3.502 0 0 1-6.71 0H1a1 1 0 0 1 0-2h6.145A3.502 3.502 0 0 1 10.5 1ZM9 4.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM5.5 9a3.502 3.502 0 0 1 3.355 2.5H15a1 1 0 1 1 0 2H8.855a3.502 3.502 0 0 1-6.71 0H1a1 1 0 1 1 0-2h1.145A3.502 3.502 0 0 1 5.5 9ZM4 12.5a1.5 1.5 0 1 0 3 0 1.5 1.5 0 0 0-3 0Z"
                                            fill-rule="evenodd" />
                                    </svg>
                                    <span
                                        class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Settings</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 @if (in_array(Request::segment(2), ['settings'])) {{ 'rotate-180' }} @endif"
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-8 mt-1 @if (!in_array(Request::segment(2), ['settings'])) {{ 'hidden' }} @endif"
                                :class="open ? 'block!' : 'hidden'">
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My
                                            Account</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">My
                                            Notifications</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Connected
                                            Apps</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Plans</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Billing
                                            & Invoices</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0">
                                    <a class="block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate"
                                        href="#">
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Give
                                            Feedback</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div> --}}
        </div>

        <!-- Expand / collapse button -->
        <div class="pt-3 hidden lg:inline-flex 2xl:hidden justify-end mt-auto">
            <div class="w-12 pl-4 pr-3 py-2">
                <button
                    class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors"
                    @click="sidebarExpanded = !sidebarExpanded">
                    <span class="sr-only">Expand / collapse sidebar</span>
                    <i
                        class="fa-solid fa-chevron-right fill-current text-gray-400 dark:text-gray-500 sidebar-expanded:rotate-180"></i>
                </button>
            </div>
        </div>

    </div>
</div>
