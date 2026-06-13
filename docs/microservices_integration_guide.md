# Panduan Integrasi Microservices & Sinkronisasi Tenant

Dokumen ini menjelaskan alur kerja dan langkah-langkah teknis untuk menambahkan sistem microservice baru (misalnya Sistem Warehouse/WMS) ke dalam Aplikasi Pusat (Landlord). Tujuannya agar ketika Anda membuat *Tenant Company* baru, data *owner* (pemilik/admin) dapat langsung terkirim dan tersinkronisasi ke database microservice yang dituju (misal: `db_warehouse`).

---

## Konsep Dasar

Aplikasi pusat menggunakan **`vendor_id`** (sebuah UUID) untuk mengenali klien secara unik. Setiap kali sebuah perusahaan (Tenant) baru didaftarkan, sistem akan:
1. Men-*generate* `vendor_id`.
2. Mengecek paket apa yang dilanggan oleh perusahaan tersebut.
3. Melihat kode sistem (*system code*) dari paket tersebut (misal: `SYS-WMS`).
4. Menggunakan `TenantProvisioningService` untuk menyuntikkan data perusahaan dan data admin ke *database* spesifik berdasarkan kode sistem tersebut.

---

## Langkah-langkah Menambah Layanan Baru (Contoh: Warehouse/WMS)

Jika Anda ingin menambahkan layanan baru bernama **Warehouse**, ikuti 4 langkah konfigurasi berikut:

### 1. Konfigurasi Lingkungan (`.env`)
Tambahkan kredensial database untuk layanan Warehouse di file `.env` Anda.

```env
# Koneksi Database untuk Aplikasi Warehouse
DB_WMS_URL=
DB_WMS_HOST=127.0.0.1
DB_WMS_PORT=3306
DB_WMS_DATABASE=db_warehouse
DB_WMS_USERNAME=root
DB_WMS_PASSWORD=
```
*(Catatan: Pastikan database `db_warehouse` sudah Anda buat secara manual di MySQL server Anda).*

### 2. Daftarkan Koneksi di `config/database.php`
Buka file `config/database.php`, lalu temukan bagian `connections`. Tambahkan konfigurasi `mysql_wms` seperti berikut:

```php
'connections' => [
    // ... koneksi lainnya (mysql, mysql_pos, dll)

    'mysql_wms' => [
        'driver' => 'mysql',
        'url' => env('DB_WMS_URL'),
        'host' => env('DB_WMS_HOST', '127.0.0.1'),
        'port' => env('DB_WMS_PORT', '3306'),
        'database' => env('DB_WMS_DATABASE', 'db_warehouse'),
        'username' => env('DB_WMS_USERNAME', 'root'),
        'password' => env('DB_WMS_PASSWORD', ''),
        'unix_socket' => env('DB_WMS_SOCKET', ''),
        'charset' => env('DB_WMS_CHARSET', 'utf8mb4'),
        'collation' => env('DB_WMS_COLLATION', 'utf8mb4_unicode_ci'),
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
    ],
],
```

### 3. Setup Sistem dan Paket di Dashboard Admin
Buka aplikasi pusat Anda melalui browser:
1. Masuk ke menu **System & Admin > Systems**.
2. Buat Sistem Baru dengan **Kode Sistem**: `SYS-WMS`. (Catat kode ini karena sangat penting untuk alur logika).
3. Masuk ke menu **System & Admin > Packages**.
4. Buat Paket Baru (misal: *WMS Basic Plan*) dan pada pilihan **Sistem (Header)**, pilih Sistem Warehouse yang baru saja dibuat.

### 4. Tambahkan Logika Sinkronisasi di Kode
Buka file **`app/Services/TenantProvisioningService.php`**. Di sinilah keajaiban sinkronisasi terjadi.

Temukan *switch case* di dalam fungsi `provision()` dan tambahkan kasus untuk `SYS-WMS`:

```php
switch ($systemCode) {
    case 'SYS-POS':
        self::syncToDatabase('mysql_pos', $company, $adminUser, $rawPassword);
        break;

    // TAMBAHKAN BARIS INI UNTUK WMS
    case 'SYS-WMS':
        self::syncToDatabase('mysql_wms', $company, $adminUser, $rawPassword);
        break;

    default:
        Log::info("Tenant provisioning: System {$systemCode} does not require external DB sync.");
        break;
}
```

### Memahami Cara Kerja `syncToDatabase`
Di dalam file yang sama (`TenantProvisioningService.php`), terdapat fungsi pembantu `syncToDatabase()`. Anda memiliki kebebasan untuk menyesuaikan *query* di dalamnya sesuai dengan tabel yang ada di `db_warehouse`.

Berikut adalah struktur baku yang sudah dibuat:
```php
private static function syncToDatabase(string $connectionName, Company $company, User $adminUser, string $rawPassword)
{
    // Mengarahkan Laravel untuk memakai koneksi db_warehouse (mysql_wms)
    $db = DB::connection($connectionName);

    $db->beginTransaction();
    try {
        // 1. Menyisipkan Data Perusahaan ke db_warehouse
        // Pastikan di db_warehouse Anda ada tabel bernama 'tenants' 
        // atau ubah kata 'tenants' di bawah ini sesuai nama tabel Anda.
        $db->table('tenants')->insert([
            'vendor_id' => $company->vendor_id,  // INI ADALAH KUNCI ISOLASI DATA
            'name' => $company->company_name,
            'domain' => $company->company_domain,
            'status' => $company->subscription_status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Menyisipkan Data Akun Owner (Admin)
        // Pastikan di db_warehouse Anda ada tabel bernama 'users'
        $db->table('users')->insert([
            'vendor_id' => $company->vendor_id,  // Mengaitkan User dengan Tenant-nya
            'name' => $adminUser->name,
            'email' => $adminUser->email,
            'password' => Hash::make($rawPassword), 
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $db->commit();
    } catch (\Exception $e) {
        $db->rollBack();
        throw $e;
    }
}
```

## Kesimpulan Alur
1. Anda membuat "Tenant Company" di Admin.
2. Anda memilih "Package WMS".
3. Laravel secara otomatis membaca bahwa "Package WMS" berinduk pada sistem `SYS-WMS`.
4. Berdasarkan `SYS-WMS`, `TenantProvisioningService` memanggil fungsi `syncToDatabase` menggunakan koneksi `mysql_wms`.
5. Koneksi `mysql_wms` mencari `db_warehouse` sesuai setting `.env`.
6. Data berhasil masuk secara transparan.

*Mekanisme ini dilindungi oleh Try-Catch, sehingga jika `db_warehouse` belum dibuat, layar admin aplikasi pusat tidak akan menampilkan pesan error (hanya akan tersimpan di file `storage/logs/laravel.log`).*
