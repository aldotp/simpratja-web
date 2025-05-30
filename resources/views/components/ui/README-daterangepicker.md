# Komponen UI Date Range Picker

Komponen date range picker yang dinamis berdasarkan Flowbite untuk digunakan di berbagai konteks dalam aplikasi Simpratja Web.

## Penggunaan

```blade
<x-ui.daterangepicker
    id="date-filter"
    name="date_filter"
    label="Filter Berdasarkan Tanggal"
    startLabel="Tanggal Mulai"
    endLabel="Tanggal Akhir"
    startPlaceholder="Pilih tanggal mulai"
    endPlaceholder="Pilih tanggal akhir"
    :startValue="request('date_filter_start', '')"
    :endValue="request('date_filter_end', '')"
/>
```

## Props

| Prop               | Tipe    | Default                 | Deskripsi                                                                                                        |
| ------------------ | ------- | ----------------------- | ---------------------------------------------------------------------------------------------------------------- |
| `name`             | string  | `''`                    | Nama dasar untuk input. Input awal akan menjadi `{name}_start` dan input akhir akan menjadi `{name}_end`         |
| `id`               | string  | `''`                    | ID untuk wrapper date range picker. Input awal akan menjadi `{id}-start` dan input akhir akan menjadi `{id}-end` |
| `label`            | string  | `''`                    | Label utama untuk komponen date range picker                                                                     |
| `startLabel`       | string  | `'Tanggal Mulai'`       | Label untuk input tanggal mulai                                                                                  |
| `endLabel`         | string  | `'Tanggal Akhir'`       | Label untuk input tanggal akhir                                                                                  |
| `startPlaceholder` | string  | `'Pilih tanggal mulai'` | Placeholder untuk input tanggal mulai                                                                            |
| `endPlaceholder`   | string  | `'Pilih tanggal akhir'` | Placeholder untuk input tanggal akhir                                                                            |
| `startValue`       | string  | `''`                    | Nilai awal untuk input tanggal mulai                                                                             |
| `endValue`         | string  | `''`                    | Nilai awal untuk input tanggal akhir                                                                             |
| `required`         | boolean | `false`                 | Apakah input wajib diisi                                                                                         |
| `disabled`         | boolean | `false`                 | Apakah input dinonaktifkan                                                                                       |
| `helpText`         | string  | `''`                    | Teks bantuan yang ditampilkan di bawah input                                                                     |
| `class`            | string  | `''`                    | Kelas tambahan untuk wrapper date range picker                                                                   |

## Contoh Penggunaan dengan Filter

```blade
<form action="{{ route('staff.history.index') }}" method="GET" class="mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="w-full md:w-2/3">
            <x-ui.daterangepicker
                id="visit-date-filter"
                name="visit_date"
                label="Filter Berdasarkan Tanggal"
                startLabel="Tanggal Mulai"
                endLabel="Tanggal Akhir"
                startPlaceholder="Pilih tanggal mulai"
                endPlaceholder="Pilih tanggal akhir"
                :startValue="request('visit_date_start', '')"
                :endValue="request('visit_date_end', '')"
            />
        </div>
        <div class="flex items-end w-full md:w-1/3">
            <x-form.button type="submit" class="w-full md:w-auto">
                <i class="fas fa-filter mr-2"></i> Filter
            </x-form.button>
            @if(request('visit_date_start') || request('visit_date_end'))
                <a href="{{ route('staff.history.index') }}" class="ml-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    <i class="fas fa-times"></i> Reset
                </a>
            @endif
        </div>
    </div>
</form>
```

## Penggunaan di Controller

```php
public function index(Request $request) {
    $filters = [];

    // Apply date range filter if provided
    if ($request->has('visit_date_start') && $request->filled('visit_date_start')) {
        $filters['start_date'] = $request->visit_date_start;
    }

    if ($request->has('visit_date_end') && $request->filled('visit_date_end')) {
        $filters['end_date'] = $request->visit_date_end;
    }

    $data = $this->service->getAll($filters);
    return view('your.view', compact('data'));
}
```

## Penggunaan di Repository

```php
public function getAll($filters = [])
{
    $query = Model::query();

    // Filter by date range if provided
    if (!empty($filters['start_date'])) {
        $query->where('date_field', '>=', $filters['start_date']);
    }

    if (!empty($filters['end_date'])) {
        $query->where('date_field', '<=', $filters['end_date']);
    }

    return $query->get();
}
```
