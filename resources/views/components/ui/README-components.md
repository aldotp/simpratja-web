# Komponen UI Simpratja Web

Dokumentasi untuk komponen UI yang tersedia di Simpratja Web. Komponen-komponen ini dirancang berdasarkan referensi dari Flowbite dan dioptimalkan untuk digunakan dengan Tailwind CSS.

## Daftar Komponen

### 1. Card

Komponen card yang dinamis untuk menampilkan konten dalam format kartu.

```blade
<x-ui.card
    title="Judul Card"
    subtitle="Subtitle opsional"
    variant="default"
    size="md"
    imgSrc="/path/to/image.jpg"
    imgAlt="Deskripsi gambar"
    imgPosition="top"
    :footer="$footer"
    hover
    shadow="md"
    rounded="lg"
    border
    horizontal
    class="custom-class"
>
    Konten card di sini
</x-ui.card>
```

#### Props

| Prop          | Tipe    | Default     | Deskripsi                                                                                 |
| ------------- | ------- | ----------- | ----------------------------------------------------------------------------------------- |
| `title`       | string  | `''`        | Judul card                                                                                |
| `subtitle`    | string  | `''`        | Subtitle card                                                                             |
| `variant`     | string  | `'default'` | Variasi warna (`default`, `primary`, `secondary`, `success`, `danger`, `warning`, `info`) |
| `size`        | string  | `'md'`      | Ukuran padding (`sm`, `md`, `lg`, `xl`)                                                   |
| `imgSrc`      | string  | `''`        | URL gambar                                                                                |
| `imgAlt`      | string  | `''`        | Teks alternatif untuk gambar                                                              |
| `imgPosition` | string  | `'top'`     | Posisi gambar (`top`, `bottom`)                                                           |
| `footer`      | mixed   | `false`     | Konten footer (gunakan slot)                                                              |
| `hover`       | boolean | `false`     | Efek hover                                                                                |
| `shadow`      | string  | `'md'`      | Ukuran bayangan (`none`, `sm`, `md`, `lg`, `xl`)                                          |
| `rounded`     | string  | `'lg'`      | Ukuran sudut bulat (`none`, `sm`, `md`, `lg`, `xl`, `full`)                               |
| `border`      | boolean | `false`     | Tampilkan border                                                                          |
| `horizontal`  | boolean | `false`     | Layout horizontal                                                                         |
| `class`       | string  | `''`        | Kelas CSS tambahan                                                                        |

### 2. Breadcrumb

Komponen breadcrumb untuk navigasi hierarki halaman.

```blade
<x-ui.breadcrumb
    :items="[
        ['label' => 'Beranda', 'url' => '/home', 'icon' => '<svg>...</svg>'],
        ['label' => 'Produk', 'url' => '/products'],
        ['label' => 'Detail Produk']
    ]"
    separator="slash"
    variant="default"
    size="md"
    rounded
    class="custom-class"
/>
```

#### Props

| Prop        | Tipe    | Default     | Deskripsi                                                                                               |
| ----------- | ------- | ----------- | ------------------------------------------------------------------------------------------------------- |
| `items`     | array   | `[]`        | Array item breadcrumb dengan format `['label' => 'Label', 'url' => '/url', 'icon' => '<svg>...</svg>']` |
| `separator` | string  | `'slash'`   | Jenis pemisah (`slash`, `chevron`, `dot`)                                                               |
| `variant`   | string  | `'default'` | Variasi warna (`default`, `light`, `dark`)                                                              |
| `size`      | string  | `'md'`      | Ukuran (`sm`, `md`, `lg`)                                                                               |
| `rounded`   | boolean | `false`     | Sudut bulat                                                                                             |
| `class`     | string  | `''`        | Kelas CSS tambahan                                                                                      |

### 3. Table

Komponen tabel yang dinamis dengan slot untuk bagian atas dan pagination.

```blade
<x-ui.table
    striped
    hoverable
    bordered
    size="md"
    variant="default"
    rounded="lg"
    shadow="md"
    responsive
    class="custom-class"
>
    <x-slot name="top">
        <!-- Tombol, pencarian, filter di sini -->
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th>Kolom 1</th>
            <th>Kolom 2</th>
        </tr>
    </x-slot>

    <tr>
        <td>Data 1</td>
        <td>Data 2</td>
    </tr>

    <x-slot name="tfoot">
        <!-- Footer tabel di sini -->
    </x-slot>

    <x-slot name="pagination">
        <!-- Pagination di sini -->
    </x-slot>
</x-ui.table>
```

#### Props

| Prop         | Tipe    | Default     | Deskripsi                                           |
| ------------ | ------- | ----------- | --------------------------------------------------- |
| `striped`    | boolean | `false`     | Baris bergaris-garis                                |
| `hoverable`  | boolean | `true`      | Efek hover pada baris                               |
| `bordered`   | boolean | `false`     | Tampilkan border                                    |
| `size`       | string  | `'md'`      | Ukuran teks (`sm`, `md`, `lg`)                      |
| `variant`    | string  | `'default'` | Variasi warna (`default`, `light`, `dark`)          |
| `rounded`    | string  | `'lg'`      | Ukuran sudut bulat (`none`, `sm`, `md`, `lg`, `xl`) |
| `shadow`     | string  | `'md'`      | Ukuran bayangan (`none`, `sm`, `md`, `lg`, `xl`)    |
| `responsive` | boolean | `true`      | Tabel responsif                                     |
| `class`      | string  | `''`        | Kelas CSS tambahan                                  |

#### Slots

| Slot         | Deskripsi                                        |
| ------------ | ------------------------------------------------ |
| `top`        | Konten di atas tabel (tombol, pencarian, filter) |
| `thead`      | Header tabel                                     |
| `default`    | Konten utama tabel (baris)                       |
| `tfoot`      | Footer tabel                                     |
| `pagination` | Komponen pagination                              |

### 4. Pagination

Komponen pagination untuk navigasi halaman data.

```blade
<x-ui.pagination
    :paginator="$paginator"
    simple
    size="md"
    align="center"
    rounded
    class="custom-class"
/>
```

#### Props

| Prop        | Tipe    | Default    | Deskripsi                            |
| ----------- | ------- | ---------- | ------------------------------------ |
| `paginator` | object  | `null`     | Objek paginator Laravel              |
| `simple`    | boolean | `false`    | Mode sederhana (hanya Prev/Next)     |
| `size`      | string  | `'md'`     | Ukuran (`sm`, `md`, `lg`)            |
| `align`     | string  | `'center'` | Perataan (`left`, `center`, `right`) |
| `rounded`   | boolean | `true`     | Sudut bulat                          |
| `class`     | string  | `''`       | Kelas CSS tambahan                   |

## Demo Komponen

Untuk melihat contoh penggunaan komponen-komponen ini, buka file `components-demo.blade.php`.
