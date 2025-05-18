# Komponen UI Chart

Komponen chart yang dinamis menggunakan ApexCharts untuk visualisasi data dalam aplikasi Simpratja Web.

## Cara Penggunaan

```blade
<x-ui.chart
    type="line"
    :series="[
        ['name' => 'Series 1', 'data' => [30, 40, 35, 50, 49, 60, 70]],
        ['name' => 'Series 2', 'data' => [20, 35, 40, 45, 55, 65, 75]],
    ]"
    :labels="['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul']"
    title="Judul Chart"
    subtitle="Subjudul chart"
    xaxisTitle="Sumbu X"
    yaxisTitle="Sumbu Y"
    height="350"
    width="100%"
    :colors="['#4F46E5', '#10B981']"
    enableAnimation="true"
    enableDataLabels="false"
    enableLegend="true"
    enableGrid="true"
    enableTooltip="true"
    enableZoom="false"
    stacked="false"
    horizontal="false"
    theme="light"
    class="custom-class"
/>
```

## Properti

| Properti           | Tipe    | Default    | Deskripsi                                                                |
| ------------------ | ------- | ---------- | ------------------------------------------------------------------------ |
| `id`               | string  | `uniqid()` | ID unik untuk chart                                                      |
| `type`             | string  | `'line'`   | Tipe chart (`line`, `area`, `bar`, `pie`, `donut`, `radar`, `polarArea`) |
| `height`           | number  | `350`      | Tinggi chart dalam piksel                                                |
| `width`            | string  | `'100%'`   | Lebar chart (bisa dalam piksel atau persentase)                          |
| `options`          | array   | `[]`       | Opsi kustom untuk ApexCharts (akan di-merge dengan opsi default)         |
| `series`           | array   | `[]`       | Data series untuk chart                                                  |
| `labels`           | array   | `[]`       | Label untuk chart (digunakan untuk pie, donut, dll)                      |
| `colors`           | array   | `[]`       | Array warna kustom untuk series                                          |
| `title`            | string  | `''`       | Judul chart                                                              |
| `subtitle`         | string  | `''`       | Subjudul chart                                                           |
| `xaxisTitle`       | string  | `''`       | Judul untuk sumbu X                                                      |
| `yaxisTitle`       | string  | `''`       | Judul untuk sumbu Y                                                      |
| `enableAnimation`  | boolean | `true`     | Mengaktifkan animasi pada chart                                          |
| `enableDataLabels` | boolean | `false`    | Menampilkan label data pada chart                                        |
| `enableLegend`     | boolean | `true`     | Menampilkan legenda chart                                                |
| `enableGrid`       | boolean | `true`     | Menampilkan grid pada chart                                              |
| `enableTooltip`    | boolean | `true`     | Mengaktifkan tooltip saat hover                                          |
| `enableZoom`       | boolean | `false`    | Mengaktifkan fitur zoom dan toolbar                                      |
| `stacked`          | boolean | `false`    | Membuat chart bertumpuk (untuk bar dan area chart)                       |
| `horizontal`       | boolean | `false`    | Membuat chart horizontal (untuk bar chart)                               |
| `theme`            | string  | `'light'`  | Tema chart (`light`, `dark`)                                             |
| `class`            | string  | `''`       | Kelas CSS tambahan                                                       |

## Format Data Series

Format data series berbeda tergantung pada tipe chart:

### Untuk Line, Area, Bar, Radar

```php
[
    ['name' => 'Series 1', 'data' => [30, 40, 35, 50, 49, 60, 70]],
    ['name' => 'Series 2', 'data' => [20, 35, 40, 45, 55, 65, 75]],
]
```

### Untuk Pie, Donut, PolarArea

```php
[44, 55, 13, 43, 22]
```

## Contoh Penggunaan

Untuk melihat contoh penggunaan lengkap, silakan lihat file `chart-demo.blade.php`.

## Integrasi dengan Tema

Komponen chart secara otomatis beradaptasi dengan tema aplikasi (light/dark). Ketika pengguna mengubah tema, chart akan diperbarui sesuai dengan tema yang dipilih.

## Responsivitas

Chart secara default responsif dan akan menyesuaikan ukurannya dengan kontainer induknya. Anda dapat menggunakan properti `width` dan `height` untuk mengontrol ukuran chart.

## Kustomisasi Lanjutan

Untuk kustomisasi lanjutan, Anda dapat menggunakan properti `options` untuk meneruskan opsi konfigurasi ApexCharts tambahan yang akan di-merge dengan opsi default.

```blade
<x-ui.chart
    type="line"
    :series="[
        ['name' => 'Series 1', 'data' => [30, 40, 35, 50, 49, 60, 70]],
    ]"
    :options="[
        'stroke' => [
            'curve' => 'smooth',
            'width' => 2,
        ],
        'markers' => [
            'size' => 4,
        ],
    ]"
/>
```

Untuk dokumentasi lengkap tentang opsi ApexCharts, silakan kunjungi [dokumentasi resmi ApexCharts](https://apexcharts.com/docs/options/).
