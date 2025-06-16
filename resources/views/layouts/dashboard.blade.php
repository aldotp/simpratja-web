@extends('layouts.app')

@section('main')
    <main class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }" x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
        <script>
            if (localStorage.getItem('sidebar-expanded') == 'true') {
                document.querySelector('main').classList.add('sidebar-expanded');
            } else {
                document.querySelector('main').classList.remove('sidebar-expanded');
            }
        </script>

        <!-- Page wrapper -->
        <div class="flex h-dvh overflow-hidden">

            <x-app.sidebar variant="v1" />

            <!-- Content area -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden" x-ref="contentarea">

                <x-app.header-dashboard variant="v1" />

                <div class="grow">
                    {{ $slot }}
                </div>

            </div>

            <!-- Logout Confirmation Modal -->
            <x-dialog.modal id="logout-confirmation-modal" title="{{ __('Konfirmasi Logout') }}" size="sm" centered>
                <p class="text-gray-600 dark:text-gray-400">{{ __('Apakah Anda yakin ingin keluar dari aplikasi?') }}</p>

                <x-slot name="footer">
                    <button type="button"
                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                        data-modal-hide="logout-confirmation-modal">
                        {{ __('Batal') }}
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                            {{ __('Ya, Keluar') }}
                        </button>
                    </form>
                </x-slot>
            </x-dialog.modal>

        </div>
    </main>
@endsection
