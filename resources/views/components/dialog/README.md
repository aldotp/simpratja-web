# Komponen Dialog dan Toast

Komponen ini menyediakan implementasi modal dialog dan toast notification yang dinamis menggunakan Flowbite untuk proyek Laravel.

## Komponen yang Tersedia

1. **Modal Dialog** - `<x-dialog.modal>`
2. **Toast Notification** - `<x-dialog.toast>`
3. **Dialog Manager** - `<x-dialog.dialog-manager>` (Utilitas JavaScript)

## Cara Penggunaan

### Modal Dialog

```blade
<x-dialog.modal
    id="myModal"
    title="Judul Modal"
    size="md"
    showCloseButton="true"
    static="false"
    centered="false"
>
    <!-- Konten modal -->
    <p>Ini adalah konten modal</p>

    <!-- Footer (opsional) -->
    <x-slot name="footer">
        <button data-modal-hide="myModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">Batal</button>
        <button data-modal-hide="myModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5 text-center">Konfirmasi</button>
    </x-slot>
</x-dialog.modal>
```

#### Parameter Modal

| Parameter       | Tipe    | Default | Deskripsi                                                       |
| --------------- | ------- | ------- | --------------------------------------------------------------- |
| id              | string  | 'modal' | ID unik untuk modal                                             |
| title           | string  | ''      | Judul modal                                                     |
| size            | string  | 'md'    | Ukuran modal (xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl) |
| showCloseButton | boolean | true    | Menampilkan tombol close di header                              |
| static          | boolean | false   | Jika true, modal tidak dapat ditutup dengan klik di luar        |
| centered        | boolean | false   | Jika true, modal akan diposisikan di tengah layar               |

### Toast Notification

```blade
<!-- Menggunakan komponen blade -->
<x-dialog.toast
    id="myToast"
    type="success"
    message="Operasi berhasil!"
    title="Sukses"
    dismissible="true"
    position="bottom-right"
    duration="5000"
    show="true"
/>

<!-- Menggunakan JavaScript API -->
<script>
    // Pastikan sudah menyertakan dialog-manager
    // <x-dialog.dialog-manager />

    // Menampilkan toast
    DialogManager.showToast({
        type: 'success', // default, success, error, warning, info
        message: 'Operasi berhasil dilakukan!',
        title: 'Sukses', // opsional
        position: 'bottom-right', // top-right, top-left, bottom-right, bottom-left
        duration: 5000 // dalam milidetik, 0 untuk persisten
    });

    // Menyembunyikan toast berdasarkan ID
    DialogManager.hideToast('toast-id');
</script>
```

#### Parameter Toast

| Parameter   | Tipe    | Default          | Deskripsi                                                      |
| ----------- | ------- | ---------------- | -------------------------------------------------------------- |
| id          | string  | 'toast-{uniqid}' | ID unik untuk toast                                            |
| type        | string  | 'default'        | Tipe toast (default, success, error, warning, info)            |
| message     | string  | ''               | Pesan toast                                                    |
| title       | string  | ''               | Judul toast (opsional)                                         |
| dismissible | boolean | true             | Jika true, toast dapat ditutup dengan tombol close             |
| position    | string  | 'bottom-right'   | Posisi toast (top-right, top-left, bottom-right, bottom-left)  |
| duration    | number  | 5000             | Durasi tampil dalam milidetik, 0 untuk persisten               |
| show        | boolean | false            | Jika true, toast akan langsung ditampilkan saat halaman dimuat |

### Dialog Manager

Dialog Manager adalah utilitas JavaScript yang menyediakan API untuk mengelola modal dan toast secara programatis.

```blade
<!-- Sertakan dialog manager di layout atau halaman Anda -->
<x-dialog.dialog-manager />

<script>
    // Menampilkan modal
    DialogManager.showModal('modal-id');

    // Menyembunyikan modal
    DialogManager.hideModal('modal-id');

    // Menampilkan toast (lihat contoh di atas)
    const toast = DialogManager.showToast({ ... });

    // Menyembunyikan toast
    DialogManager.hideToast(toast.id);
</script>
```

## Contoh Penggunaan

Lihat file `example.blade.php` untuk contoh lengkap penggunaan komponen dialog dan toast.

## Catatan

-   Pastikan Flowbite sudah diinstal dan dikonfigurasi dengan benar di proyek Laravel Anda.
-   Komponen ini dirancang untuk bekerja dengan Tailwind CSS.
-   Untuk menggunakan JavaScript API, pastikan Anda menyertakan `<x-dialog.dialog-manager />` di layout atau halaman Anda.
