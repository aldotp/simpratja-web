# Komponen UI Card

Komponen card yang dinamis berdasarkan Flowbite untuk digunakan di berbagai konteks dalam aplikasi Simpratja Web.

## Cara Penggunaan

```blade
<x-ui.card
    title="Judul Card"
    subtitle="Subjudul card"
    variant="default"
    size="md"
    imgSrc="/path/to/image.jpg"
    imgAlt="Deskripsi gambar"
    imgPosition="top"
    hover="true"
    shadow="md"
    rounded="lg"
    border="true"
    horizontal="false"
    class="custom-class"
>
    Konten card di sini...

    <x-slot name="footer">
        Konten footer di sini...
    </x-slot>
</x-ui.card>
```

## Properti

| Properti      | Tipe    | Default     | Deskripsi                                                                                      |
| ------------- | ------- | ----------- | ---------------------------------------------------------------------------------------------- |
| `title`       | string  | `''`        | Judul card                                                                                     |
| `subtitle`    | string  | `''`        | Subjudul card                                                                                  |
| `variant`     | string  | `'default'` | Variasi warna card (`default`, `primary`, `secondary`, `success`, `danger`, `warning`, `info`) |
| `size`        | string  | `'md'`      | Ukuran padding card (`sm`, `md`, `lg`, `xl`)                                                   |
| `imgSrc`      | string  | `''`        | URL gambar                                                                                     |
| `imgAlt`      | string  | `''`        | Teks alternatif untuk gambar                                                                   |
| `imgPosition` | string  | `'top'`     | Posisi gambar (`top`, `bottom`)                                                                |
| `footer`      | boolean | `false`     | Menampilkan bagian footer                                                                      |
| `hover`       | boolean | `false`     | Efek hover pada card                                                                           |
| `shadow`      | string  | `'md'`      | Ukuran bayangan (`none`, `sm`, `md`, `lg`, `xl`)                                               |
| `rounded`     | string  | `'lg'`      | Ukuran radius sudut (`none`, `sm`, `md`, `lg`, `xl`, `full`)                                   |
| `border`      | boolean | `false`     | Menampilkan border pada card                                                                   |
| `horizontal`  | boolean | `false`     | Layout horizontal (gambar di samping)                                                          |
| `class`       | string  | `''`        | Kelas CSS tambahan                                                                             |

## Slot

-   `default`: Konten utama card
-   `footer`: Konten footer card (opsional)

## Contoh Penggunaan

Untuk melihat contoh penggunaan komponen card dengan berbagai variasi, lihat file `card-demo.blade.php`.
