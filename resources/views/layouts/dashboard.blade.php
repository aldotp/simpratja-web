@extends('layouts.app')

@section('main')
    <main
        class="font-inter antialiased bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400"
        :class="{ 'sidebar-expanded': sidebarExpanded }"
        x-data="{ sidebarOpen: false, sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true' }"
        x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
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
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden"
                x-ref="contentarea">

                <x-app.header-dashboard variant="v1" />

                <div class="grow">
                    {{ $slot }}
                </div>

            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
@endpush
