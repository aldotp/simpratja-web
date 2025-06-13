@push('styles')
    <style>
        .login-bg {
            background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .login-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(22, 101, 52, 0.8) 0%, rgba(16, 185, 129, 0.7) 100%);
            z-index: 1;
        }

        .login-content {
            position: relative;
            z-index: 2;
        }
    </style>
@endpush

<x-home-layout>
    <!-- Login Section -->
    <section class="login-bg min-h-screen flex items-center justify-center py-12 ">
        <div class="login-content container mx-auto px-4">
            <div class="max-w-md mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-8">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-100 rounded-full mb-4">
                            <i class="fas fa-sign-in-alt text-primary-600 text-2xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">Sign in to your account</h1>
                        <p class="text-gray-600 mt-2">Access your healthcare information securely</p>
                    </div>

                    <form id="login-form" method="POST" action="{{ route('login.submit') }}" class="space-y-6">
                        @csrf
                        <div>
                            <x-form.input type="text" id="nik" name="nik" label="NIK"
                                placeholder="Masukkan NIK" required="true" minLength="16" maxLength="16" />
                        </div>

                        <div>
                            <x-form.input type="password" id="password" name="password" label="Password"
                                placeholder="Masukkan password anda" required="true" class="relative" />
                        </div>

                        <div class="flex items-center justify-between">
                            <x-form.checkbox id="remember-me" name="remember-me" label="Remember me" />
                            <a href="password-reset.html" class="text-sm text-primary-600 hover:text-primary-500">Forgot
                                password?</a>
                        </div>

                        <x-form.button type="submit" class="w-full">
                            Sign In
                        </x-form.button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session()->has('toast'))
                const toast = document.getElementById('toast-app');
                if (toast) {
                    // Set toast properties from session
                    const toastData = @json(session('toast'));

                    // Set toast type class
                    const typeClasses = {
                        'default': 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800',
                        'success': 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
                        'error': 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
                        'warning': 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200',
                        'info': 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200'
                    };

                    // Remove all type classes first
                    Object.values(typeClasses).forEach(cls => {
                        cls.split(' ').forEach(c => toast.classList.remove(c));
                    });

                    // Add the appropriate type class
                    const typeClass = typeClasses[toastData.type] || typeClasses['default'];
                    typeClass.split(' ').forEach(c => toast.classList.add(c));

                    // Set message and title
                    const messageEl = toast.querySelector('.text-sm.font-normal');
                    if (messageEl) messageEl.textContent = toastData.message;

                    const titleEl = toast.querySelector('.text-sm.font-semibold');
                    if (titleEl && toastData.title) titleEl.textContent = toastData.title;

                    // Show the toast
                    toast.classList.remove('hidden');

                    // Auto-hide after 5 seconds
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 5000);
                }
            @endif
        });
    </script>
@endpush
