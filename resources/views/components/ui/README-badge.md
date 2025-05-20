# Badge Component

Komponen Badge adalah elemen UI yang digunakan untuk menampilkan status, kategori, atau label singkat. Komponen ini terinspirasi dari desain Flowbite dan diimplementasikan menggunakan Tailwind CSS.

## Penggunaan

```blade
<x-ui.badge>Default Badge</x-ui.badge>
<x-ui.badge variant="success">Success Badge</x-ui.badge>
<x-ui.badge variant="danger" size="lg">Large Danger Badge</x-ui.badge>
<x-ui.badge variant="warning" pill="true">Rounded Warning Badge</x-ui.badge>
<x-ui.badge variant="info" outline="true">Outline Info Badge</x-ui.badge>
```

## Props

| Prop      | Tipe    | Default   | Deskripsi                                                                                                     |
| --------- | ------- | --------- | ------------------------------------------------------------------------------------------------------------- |
| `variant` | string  | `primary` | Menentukan warna badge. Opsi: `primary`, `secondary`, `success`, `danger`, `warning`, `info`, `light`, `dark` |
| `size`    | string  | `md`      | Menentukan ukuran badge. Opsi: `sm`, `md`, `lg`                                                               |
| `pill`    | boolean | `false`   | Jika `true`, badge akan memiliki sudut yang lebih bulat (rounded-full)                                        |
| `outline` | boolean | `false`   | Jika `true`, badge akan memiliki gaya outline dengan latar transparan                                         |

## Contoh Penggunaan

### Badge dengan Warna Berbeda

```blade
<x-ui.badge variant="primary">Primary</x-ui.badge>
<x-ui.badge variant="secondary">Secondary</x-ui.badge>
<x-ui.badge variant="success">Success</x-ui.badge>
<x-ui.badge variant="danger">Danger</x-ui.badge>
<x-ui.badge variant="warning">Warning</x-ui.badge>
<x-ui.badge variant="info">Info</x-ui.badge>
<x-ui.badge variant="light">Light</x-ui.badge>
<x-ui.badge variant="dark">Dark</x-ui.badge>
```

### Badge dengan Ukuran Berbeda

```blade
<x-ui.badge size="sm">Small</x-ui.badge>
<x-ui.badge size="md">Medium</x-ui.badge>
<x-ui.badge size="lg">Large</x-ui.badge>
```

### Badge dengan Gaya Pill

```blade
<x-ui.badge pill="true">Pill Badge</x-ui.badge>
```

### Badge dengan Gaya Outline

```blade
<x-ui.badge outline="true">Outline Badge</x-ui.badge>
```

### Kombinasi Props

```blade
<x-ui.badge variant="success" size="lg" pill="true">Large Pill Success Badge</x-ui.badge>
<x-ui.badge variant="danger" outline="true" size="sm">Small Outline Danger Badge</x-ui.badge>
```

## Kustomisasi Tambahan

Komponen badge juga menerima atribut HTML tambahan yang akan digabungkan dengan kelas yang sudah ada:

```blade
<x-ui.badge class="mr-4 uppercase">Custom Badge</x-ui.badge>
```
