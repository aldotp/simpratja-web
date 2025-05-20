<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium mb-2">Alert Dasar</h3>
        <x-ui.alert type="info" message="Ini adalah contoh alert informasi dasar" />
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Tipe Alert</h3>
        <x-ui.alert type="success" message="Operasi berhasil dilakukan" />
        <x-ui.alert type="error" message="Terjadi kesalahan saat memproses data" />
        <x-ui.alert type="warning" message="Peringatan: Tindakan ini tidak dapat dibatalkan" />
        <x-ui.alert type="info" message="Informasi tambahan untuk pengguna" />
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Alert dengan Multiple Messages</h3>
        <x-ui.alert type="error" :messages="['Email tidak valid', 'Password minimal 8 karakter', 'Username sudah digunakan']" />
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Alert yang Dapat Ditutup (Dismissible)</h3>
        <x-ui.alert type="warning" message="Peringatan penting yang dapat ditutup oleh pengguna" :dismissible="true" />
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Contoh Penggunaan dengan Session</h3>
        <div class="p-4 border border-dashed rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Contoh kode:</p>
            <pre class="bg-gray-100 p-2 rounded text-sm overflow-x-auto">&lt;x-ui.alert type="success" :message="session('success')" /&gt;
&lt;x-ui.alert type="error" :message="session('error')" /&gt;</pre>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium mb-2">Contoh Penggunaan dengan Validasi Error</h3>
        <div class="p-4 border border-dashed rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Contoh kode:</p>
            <pre class="bg-gray-100 p-2 rounded text-sm overflow-x-auto">
@if ($errors->any())
&lt;x-ui.alert type="error" :messages="$errors - > all()" /&gt;
@endif
</pre>
        </div>
    </div>
</div>
