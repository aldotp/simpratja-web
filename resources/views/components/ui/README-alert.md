# Komponen Alert

Komponen alert digunakan untuk menampilkan pesan notifikasi kepada pengguna. Komponen ini mendukung berbagai tipe alert dan dapat menampilkan pesan tunggal maupun jamak.

## Penggunaan Dasar

```blade
<x-ui.alert type="success" message="Data berhasil disimpan" />
```

## Tipe Alert

Komponen ini mendukung 4 tipe alert:

-   `success` - Untuk pesan keberhasilan
-   `error` - Untuk pesan kesalahan
-   `warning` - Untuk pesan peringatan
-   `info` - Untuk pesan informasi (default)

```blade
<x-ui.alert type="success" message="Operasi berhasil" />
<x-ui.alert type="error" message="Terjadi kesalahan" />
<x-ui.alert type="warning" message="Peringatan penting" />
<x-ui.alert type="info" message="Informasi tambahan" />
```

## Alert dengan Multiple Messages

Untuk menampilkan beberapa pesan sekaligus, gunakan parameter `messages` dengan array:

```blade
<x-ui.alert
    type="error"
    :messages="[
        'Email tidak valid',
        'Password minimal 8 karakter',
        'Username sudah digunakan'
    ]"
/>
```

## Alert yang Dapat Ditutup (Dismissible)

Untuk membuat alert yang dapat ditutup oleh pengguna:

```blade
<x-ui.alert
    type="warning"
    message="Peringatan penting yang dapat ditutup"
    :dismissible="true"
/>
```

## Penggunaan dengan Session Flash Messages

Contoh penggunaan dengan session flash messages:

```blade
<x-ui.alert type="success" :message="session('success')" />
<x-ui.alert type="error" :message="session('error')" />
```

Atau untuk multiple error messages dari validasi:

```blade
@if ($errors->any())
    <x-ui.alert type="error" :messages="$errors->all()" />
@endif
```
