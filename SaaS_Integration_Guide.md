# Panduan Integrasi Microservice Baru (SaaS Panel Rakira)

## 🏗 Konsep Arsitektur Utama (Wajib Dibaca)
Sistem ini menggunakan arsitektur **Centralized SaaS Provisioning** (Rakira-First Flow). 
Artinya: **Semua pengguna (tenant) WAJIB didaftarkan melalui SaaS Panel (`cprakiradigital`) terlebih dahulu.** 
Aplikasi ujung/Microservice (seperti POS, Flutter, Web Admin, atau WMS) **TIDAK BOLEH** memiliki fitur pendaftaran perusahaan (Register) secara mandiri.

**Alur (Flow) Sistem:**
1. Klien mendaftar / didaftarkan dari SaaS Panel (Rakira).
2. SaaS Panel secara otomatis meng- *inject* data Klien & Akun Admin ke *database* Microservice (misal: *database* POS) melalui `TenantProvisioningService.php`.
3. Setelah *inject* berhasil, barulah Klien bisa melakukan *Login* di aplikasi Microservice (Flutter/Web Admin) menggunakan email & password yang dibuat di Rakira.
4. Semua *request* dari Microservice ke *database* akan diisolasi per-klien menggunakan fitur *Global Scope* di Laravel.

Dokumen di bawah ini menjelaskan bagaimana cara Anda mengintegrasikan aplikasi/sistem baru (misalnya **Sistem WMS**) ke dalam panel Rakira agar mengikuti aturan arsitektur di atas.

---

## 1. Mendaftarkan Kode Sistem Baru (Database SaaS)
Semua paket berlangganan di Rakira terhubung dengan tabel `systems`. Anda harus mendaftarkan sistem baru Anda di sana.
1. Buka *database* `db_digitalnusantara`.
2. Pada tabel `systems`, tambahkan baris baru:
   - `system_code`: `SYS-WMS`
   - `system_name`: `Warehouse Management System`
3. Buat paket berlangganan baru di tabel `packages` yang berelasi ke `system_id` WMS tersebut.

## 2. Mengatur Koneksi Database Microservice
Aplikasi SaaS perlu mengetahui ke mana ia harus melempar data (meng- *inject*) saat ada klien baru yang berlangganan paket WMS.
1. Buka file `.env` di proyek `cprakiradigital`.
2. Tambahkan blok koneksi untuk *database* sistem baru Anda:
   ```env
   DB_CONNECTION_WMS=mysql_wms
   DB_HOST_WMS=127.0.0.1
   DB_PORT_WMS=3306
   DB_DATABASE_WMS=db_warehouse
   DB_USERNAME_WMS=root
   DB_PASSWORD_WMS=
   ```
3. Buka file `config/database.php` di `cprakiradigital` dan tambahkan blok array koneksi baru di bawah `mysql`:
   ```php
   'mysql_wms' => [
       'driver' => 'mysql',
       'host' => env('DB_HOST_WMS', '127.0.0.1'),
       'port' => env('DB_PORT_WMS', '3306'),
       'database' => env('DB_DATABASE_WMS', 'db_warehouse'),
       'username' => env('DB_USERNAME_WMS', 'root'),
       'password' => env('DB_PASSWORD_WMS', ''),
       // ... opsi standar laravel lainnya
   ],
   ```

## 3. Memperbarui Logika Provisioning (TenantProvisioningService.php)
Langkah terakhir adalah memerintahkan sistem Rakira untuk menggunakan koneksi yang baru Anda buat saat mendeteksi `system_code` WMS.
1. Buka file `app/Services/TenantProvisioningService.php`.
2. Pada fungsi `provision()`, temukan blok `switch ($systemCode)`.
3. Tambahkan (atau aktifkan) *case* untuk WMS:
   ```php
   switch ($systemCode) {
       case 'SYS-POS':
           self::syncToDatabase('mysql_pos', $company, $adminUser, $rawPassword);
           break;
       case 'SYS-WMS': // Tambahkan ini!
           self::syncToDatabase('mysql_wms', $company, $adminUser, $rawPassword);
           break;
       // ...
   }
   ```
4. Pastikan struktur tabel (schema) database `db_warehouse` Anda (di proyek WMS) memiliki tabel standar yang akan dituju oleh fungsi `syncToDatabase()`, yaitu: `ms_clients` dan `ms_users`. Jika struktur di WMS berbeda, Anda bisa menduplikasi fungsi `syncToDatabase` menjadi fungsi khusus (misal: `syncToWarehouseDatabase`).

---

**Selesai!** Kini setiap kali ada klien yang membeli paket "WMS Premium" di aplikasi Rakira Anda, data Admin dan Klien-nya akan langsung terlempar masuk ke *database* aplikasi Warehouse Anda secara otomatis!
