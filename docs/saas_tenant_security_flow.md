# Dokumentasi Gatekeeper & Security Flow (SaaS)

Dokumen ini menjelaskan alur keamanan (*Security Flow*) dan mekanisme *Gatekeeper* yang melindungi data Master Data SaaS Anda, khususnya terkait **Pembatasan Akses Berdasarkan Masa Aktif Langganan (Subscription)**.

---

## 1. Relasi User ke Tenant (Master Company)

Agar aplikasi dapat membedakan mana user milik perusahaan A dan mana yang milik B, tabel `users` telah diperbarui melalui *Migration* agar memiliki relasi langsung ke `mst_companies`.

- **Kolom Baru:** `company_id` (Tipe: `UUID`, Relasi ke `mst_companies(id)`)
- **Prefix Data Master Database:**
  - `PKG-` untuk Package Code
  - `CMP-` untuk Company Code
  - `CFG-` untuk Config Code
- **Logika Relasional (User.php):**
  ```php
  public function company() {
      return $this->belongsTo(Company::class, 'company_id');
  }
  ```

Dengan struktur ini, Super Admin (`company_id = null`) bisa melihat semua data, sedangkan Karyawan Tenant (`company_id = 'uuid-perusahaan'`) hanya terkait dengan perusahaannya.

---

## 2. Gatekeeper: Middleware `CheckTenantSubscription`

Ini adalah "Satpam Utama" yang berdiri di pintu masuk aplikasi Laravel (Panel Dashboard/API).

### Cara Kerja (Alur Intersepsi):
1. **User Login:** User memasukkan kredensial dan sistem *Auth* bawaan memvalidasi password.
2. **Middleware Beraksi:** Sebelum masuk ke rute yang dilindungi (seperti `/admin/dashboard`), sistem akan melewati *Alias Middleware* `tenant.active` (`CheckTenantSubscription.php`).
3. **Pengecekan Kondisi:**
   - Middleware memanggil relasi `$user->company->subscription_expired_at`.
   - **Kondisi Expired:** Jika statusnya `expired` ATAU tanggal kedaluwarsanya kurang dari/sama dengan hari ini (`now()`).
   - **Kondisi Suspended:** Jika statusnya di-banned secara manual (`suspended`).
4. **Eksekusi:**
   Jika kondisi batas waktu tercapai, Middleware secara otomatis akan melakukan `Auth::logout()` dan mengarahkan (*redirect*) user kembali ke halaman Login dengan pesan error *"Masa berlangganan perusahaan Anda telah habis"*.

**Kode Registrasi (bootstrap/app.php):**
```php
$middleware->alias([
    'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
    'tenant.active' => \App\Http\Middleware\CheckTenantSubscription::class,
]);
```

---

## 3. Automasi Cron Job: Scheduler Kedaluwarsa

Agar sistem tidak bergantung pada klik manual admin (dan menekan human-error), sistem otomatis mengecek status langganan setiap tengah malam.

- **Nama Command:** `tenant:check-expired` (di file `CheckExpiredSubscriptions.php`).
- **Jadwal (routes/console.php):** `Schedule::command('tenant:check-expired')->dailyAt('00:00');`
- **Cara Kerja:**
  Skrip akan melakukan *Query Database* untuk mencari semua `mst_companies` yang masih `active` namun tanggal `subscription_expired_at` <= hari ini. Untuk setiap data yang ditemukan, sistem langsung menimpa status langganan menjadi `expired`.

### Keuntungan Arsitektur Ini:
1. **Rapi:** Anda tidak perlu mengecek tanggal kedaluwarsa berulang-ulang di dalam setiap *Controller*. Cukup pasangkan *Middleware* `tenant.active` pada grup *Route* Anda.
2. **Zero Leakage:** Jika ada karyawan perusahaan mencoba mengakses API *endpoint* rahasia dengan aplikasi eksternal seperti *Postman*, Middleware akan memblokirnya karena kedaluwarsa.
3. **Terotomatisasi:** Server akan mengeksekusi *Cron Job* secara konstan di *background*, memastikan status *database* sinkron dengan tanggal *real-time*.
