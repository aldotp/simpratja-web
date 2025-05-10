<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-primary-700">Simpratja</a>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-8">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 font-medium">Home</a>
            <a href="#about" class="text-gray-700 hover:text-primary-600 font-medium">About</a>
            <a href="#" class="text-gray-700 hover:text-primary-600 font-medium">Queue</a>
        </nav>

        <div class="flex items-center space-x-4">
            <a href="#"
                class="hidden md:block border border-primary-600 text-primary-600 hover:bg-primary-50 px-6 py-2 rounded-md transition duration-300">Login</a>
            <a href="#"
                class="hidden md:block bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-md transition duration-300">Portal</a>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200">
        <div class="container mx-auto px-4 py-2 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-primary-600 font-medium">Home</a>
            <a href="#about" class="block py-2 text-gray-700 hover:text-primary-600 font-medium">About</a>
            <a href="#" class="block py-2 text-gray-700 hover:text-primary-600 font-medium">Queue</a>
            <a href="#" class="block py-2 text-primary-600 font-medium">Login</a>
        </div>
    </div>
</header>
