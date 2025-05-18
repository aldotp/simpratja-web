import { Modal } from 'flowbite';
/**
     * Dialog Manager - Provides utility functions for managing modals and toasts
     */
document.addEventListener('DOMContentLoaded', function() {
    window.DialogManager = {
        /**
         * Show a modal dialog
         * @param {string} id - The ID of the modal to show
         */
        showModal: function(id) {
            const modalElement = document.getElementById(id);
            if (modalElement) {
                const modal = new Modal(modalElement);
                modal.show();
                return modal;
            }
            console.error('Modal with ID ' + id + ' not found');
            return null;
        },

        /**
         * Hide a modal dialog
         * @param {string} id - The ID of the modal to hide
         */
        hideModal: function(id) {
            const modalElement = document.getElementById(id);
            if (modalElement) {
                const modal = new Modal(modalElement);
                modal.hide();
                return modal;
            }
            console.error('Modal with ID ' + id + ' not found');
            return null;
        },

        /**
         * Show a toast notification
         * @param {Object} options - Toast options
         * @param {string} options.message - The message to display
         * @param {string} [options.type='default'] - Toast type (default, success, error, warning, info)
         * @param {string} [options.position='bottom-right'] - Toast position
         * @param {number} [options.duration=5000] - Duration in milliseconds, 0 for persistent
         * @param {string} [options.title] - Optional toast title
         * @param {string} [options.id] - Optional toast ID (auto-generated if not provided)
         */
        showToast: function(options) {
            const id = options.id || 'toast-' + Math.random().toString(36).substr(2, 9);
            const type = options.type || 'default';
            const position = options.position || 'bottom-right';
            const duration = options.duration !== undefined ? options.duration : 5000;
            const title = options.title || '';
            const message = options.message || '';

            // Posisi kelas
            const positionClasses = {
                'top-right': 'top-5 right-5',
                'top-left': 'top-5 left-5',
                'bottom-right': 'bottom-5 right-5',
                'bottom-left': 'bottom-5 left-5'
            } [position] || 'bottom-5 right-5';

            // Tipe kelas
            const typeClasses = {
                'default': 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800',
                'success': 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
                'error': 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
                'warning': 'text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200',
                'info': 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200'
            } [type] || 'text-gray-500 bg-white dark:text-gray-400 dark:bg-gray-800';

            // Ikon berdasarkan tipe
            const icons = {
                    'default': '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
                    'success': '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>',
                    'error': '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.5 11.5a1 1 0 0 1-2 0v-4a1 1 0 0 1 2 0v4Zm0 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z"/></svg>',
                    'warning': '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>',
                    'info': '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>'
                } [type] ||
                '<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/></svg>';

            // Cek apakah toast dengan ID yang sama sudah ada
            let toastElement = document.getElementById(id);

            // Jika sudah ada, hapus dulu
            if (toastElement) {
                toastElement.remove();
            }

            // Buat elemen toast baru
            toastElement = document.createElement('div');
            toastElement.id = id;
            toastElement.className =
                `fixed z-50 flex items-center w-full max-w-xs p-4 rounded-lg shadow ${typeClasses} ${positionClasses}`;
            toastElement.setAttribute('role', 'alert');

            // Isi HTML toast
            toastElement.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8">
                    ${icons}
                </div>
                <div class="ml-3 text-sm font-normal">
                    ${title ? `<span class="mb-1 text-sm font-semibold text-gray-900 dark:text-white">${title}</span>` : ''}
                    <div class="text-sm font-normal">${message}</div>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#${id}" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            `;

            // Tambahkan ke body
            document.body.appendChild(toastElement);

            // Inisialisasi dismiss button dengan Flowbite
            const dismissButton = toastElement.querySelector('[data-dismiss-target]');
            if (dismissButton) {
                dismissButton.addEventListener('click', function() {
                    toastElement.classList.add('hidden');
                    setTimeout(() => {
                        toastElement.remove();
                    }, 300);
                });
            }

            // Auto-hide setelah durasi tertentu
            if (duration > 0) {
                setTimeout(() => {
                    if (toastElement && document.body.contains(toastElement)) {
                        toastElement.classList.add('hidden');
                        setTimeout(() => {
                            toastElement.remove();
                        }, 300);
                    }
                }, duration);
            }

            return {
                id: id,
                element: toastElement,
                hide: function() {
                    toastElement.classList.add('hidden');
                    setTimeout(() => {
                        toastElement.remove();
                    }, 300);
                }
            };
        },

        /**
         * Hide a toast notification
         * @param {string} id - The ID of the toast to hide
         */
        hideToast: function(id) {
            const toastElement = document.getElementById(id);
            if (toastElement) {
                toastElement.classList.add('hidden');
                setTimeout(() => {
                    toastElement.remove();
                }, 300);
                return true;
            }
            return false;
        }
    };
});
