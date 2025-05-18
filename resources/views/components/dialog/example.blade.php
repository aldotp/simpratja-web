{{-- Contoh penggunaan komponen dialog dan toast --}}

<div class="p-6 space-y-6">
    <h2 class="text-2xl font-bold">Contoh Komponen Dialog</h2>

    <div class="space-y-4">
        <h3 class="text-xl font-semibold">Modal Dialog</h3>

        <div class="space-y-2">
            <button data-modal-target="exampleModal" data-modal-toggle="exampleModal"
                class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                Buka Modal Standar
            </button>

            <button data-modal-target="largeModal" data-modal-toggle="largeModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Buka Modal Besar
            </button>

            <button data-modal-target="centeredModal" data-modal-toggle="centeredModal"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                Buka Modal Tengah
            </button>

            <button data-modal-target="staticModal" data-modal-toggle="staticModal"
                class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                Buka Modal Static
            </button>
        </div>

        <h3 class="text-xl font-semibold mt-6">Toast Notifications</h3>

        <div class="space-y-2">
            <button
                onclick="DialogManager.showToast({type: 'success', message: 'Operasi berhasil dilakukan!', title: 'Sukses'})"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                Tampilkan Toast Sukses
            </button>

            <button
                onclick="DialogManager.showToast({type: 'error', message: 'Terjadi kesalahan saat memproses permintaan.', title: 'Error'})"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                Tampilkan Toast Error
            </button>

            <button
                onclick="DialogManager.showToast({type: 'warning', message: 'Peringatan: Tindakan ini tidak dapat dibatalkan.', title: 'Peringatan'})"
                class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition-colors">
                Tampilkan Toast Warning
            </button>

            <button
                onclick="DialogManager.showToast({type: 'info', message: 'Informasi penting yang perlu Anda ketahui.', title: 'Info'})"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Tampilkan Toast Info
            </button>

            <button
                onclick="DialogManager.showToast({type: 'default', message: 'Notifikasi standar.', position: 'top-right'})"
                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                Tampilkan Toast Default (Kanan Atas)
            </button>

            <button
                onclick="const toast = DialogManager.showToast({type: 'info', message: 'Toast ini tidak akan hilang otomatis.', duration: 0, position: 'top-left'}); window.persistentToast = toast;"
                class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Tampilkan Toast Persisten
            </button>

            <button onclick="if(window.persistentToast) { DialogManager.hideToast(window.persistentToast.id); }"
                class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                Sembunyikan Toast Persisten
            </button>
        </div>
    </div>
</div>

{{-- Modal Standar --}}
<x-dialog.modal id="exampleModal" title="Modal Standar">
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Ini adalah contoh modal standar dengan ukuran default (md).
    </p>
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Modal ini memiliki header dengan judul dan tombol close, serta body content ini.
    </p>

    <x-slot name="footer">
        <button data-modal-hide="exampleModal" type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
        <button data-modal-hide="exampleModal" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
    </x-slot>
</x-dialog.modal>

{{-- Modal Besar --}}
<x-dialog.modal id="largeModal" title="Modal Besar" size="xl">
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Ini adalah contoh modal dengan ukuran besar (xl).
    </p>
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Modal ini memiliki lebih banyak ruang untuk konten yang lebih kompleks atau formulir yang lebih panjang.
    </p>

    <x-slot name="footer">
        <button data-modal-hide="largeModal" type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
        <button data-modal-hide="largeModal" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
    </x-slot>
</x-dialog.modal>

{{-- Modal Tengah --}}
<x-dialog.modal id="centeredModal" title="Modal Tengah" centered="true">
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Ini adalah contoh modal yang diposisikan di tengah layar.
    </p>
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Modal ini cocok untuk pesan penting yang perlu mendapat perhatian pengguna.
    </p>

    <x-slot name="footer">
        <button data-modal-hide="centeredModal" type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
        <button data-modal-hide="centeredModal" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
    </x-slot>
</x-dialog.modal>

{{-- Modal Static --}}
<x-dialog.modal id="staticModal" title="Modal Static" static="true">
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Ini adalah contoh modal static yang tidak dapat ditutup dengan mengklik di luar modal.
    </p>
    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
        Modal ini cocok untuk konfirmasi penting yang memerlukan tindakan eksplisit dari pengguna.
    </p>

    <x-slot name="footer">
        <button data-modal-hide="staticModal" type="button"
            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
        <button data-modal-hide="staticModal" type="button"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konfirmasi</button>
    </x-slot>
</x-dialog.modal>

{{-- Contoh Toast --}}
<x-dialog.toast id="example-toast" type="success" message="Ini adalah contoh toast yang dibuat dengan komponen."
    title="Contoh Toast" show="true" />
