<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium mb-2">Variasi Warna Badge</h3>
        <div class="flex flex-wrap gap-2">
            <x-ui.badge variant="primary">Primary</x-ui.badge>
            <x-ui.badge variant="secondary">Secondary</x-ui.badge>
            <x-ui.badge variant="success">Success</x-ui.badge>
            <x-ui.badge variant="danger">Danger</x-ui.badge>
            <x-ui.badge variant="warning">Warning</x-ui.badge>
            <x-ui.badge variant="info">Info</x-ui.badge>
            <x-ui.badge variant="light">Light</x-ui.badge>
            <x-ui.badge variant="dark">Dark</x-ui.badge>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Ukuran Badge</h3>
        <div class="flex flex-wrap items-center gap-2">
            <x-ui.badge size="sm">Small</x-ui.badge>
            <x-ui.badge size="md">Medium</x-ui.badge>
            <x-ui.badge size="lg">Large</x-ui.badge>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Badge Pill (Rounded)</h3>
        <div class="flex flex-wrap gap-2">
            <x-ui.badge pill="true" variant="primary">Primary Pill</x-ui.badge>
            <x-ui.badge pill="true" variant="success">Success Pill</x-ui.badge>
            <x-ui.badge pill="true" variant="danger">Danger Pill</x-ui.badge>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Badge Outline</h3>
        <div class="flex flex-wrap gap-2">
            <x-ui.badge outline="true" variant="primary">Primary Outline</x-ui.badge>
            <x-ui.badge outline="true" variant="success">Success Outline</x-ui.badge>
            <x-ui.badge outline="true" variant="danger">Danger Outline</x-ui.badge>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Kombinasi Gaya</h3>
        <div class="flex flex-wrap gap-2">
            <x-ui.badge variant="success" size="lg" pill="true">Large Pill Success</x-ui.badge>
            <x-ui.badge variant="warning" outline="true" size="sm">Small Outline Warning</x-ui.badge>
            <x-ui.badge variant="info" pill="true" outline="true">Pill Outline Info</x-ui.badge>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Contoh Penggunaan</h3>
        <div class="flex flex-wrap gap-2">
            <x-ui.badge variant="success" class="capitalize">aktif</x-ui.badge>
            <x-ui.badge variant="danger" class="capitalize">nonaktif</x-ui.badge>
            <x-ui.badge variant="warning" class="capitalize">pending</x-ui.badge>
            <x-ui.badge variant="info" class="capitalize">admin</x-ui.badge>
            <x-ui.badge variant="secondary" class="capitalize">user</x-ui.badge>
        </div>
    </div>
</div>
