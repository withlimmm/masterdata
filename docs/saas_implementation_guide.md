# Panduan Implementasi & Integrasi SaaS Multi-Tenant

Dokumen ini merupakan petunjuk praktis (Developer Guide) tentang bagaimana mengimplementasikan arsitektur keamanan dan Master Data SaaS ke dalam alur kerja (workflow) pengembangan fitur aplikasi klien.

---

## 1. Pemasangan Gatekeeper di Rute Aplikasi (Routing)

Untuk mengamankan halaman klien dari penyewa yang masa langganannya sudah habis, kita hanya perlu "membungkus" rute-rute (*links*) tersebut dengan alias Middleware `tenant.active`.

**Contoh Implementasi pada `routes/web.php` atau `routes/api.php`:**

```php
// Rute Publik (Bebas diakses siapa saja, tidak perlu filter tenant)
Route::get('/', [LandingPageController::class, 'index']);

// Rute Klien/Tenant (Hanya bisa diakses jika sudah login DAN langganan aktif)
Route::middleware(['auth', 'tenant.active'])->group(function () {
    
    // Semua halaman di dalam blok ini dilindungi oleh Gatekeeper
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);
    Route::get('/admin/products', [ProductController::class, 'index']);
    Route::post('/admin/products/create', [ProductController::class, 'store']);
    
});
```

Hanya dengan membungkus rute di dalam grup tersebut, Middleware `CheckTenantSubscription` otomatis bekerja menjaga pintu masuk aplikasi.

---

## 2. Simulasi Alur Kerja di Lapangan (Real-World Scenario)

Mari kita asumsikan simulasi alur kerja berikut untuk memahami mesin sistem SaaS ini:

1. **Pendaftaran (Onboarding):** Perusahaan "PT Kopi Senja" berlangganan SaaS selama 1 bulan. Super Admin (`rakiradigitalcp`) membuatkan data di tabel `mst_companies` dan mengatur `subscription_expired_at` pada **4 Juli 2026**.
2. **Kondisi Normal (Aktif):** Selama bulan Juni, setiap kali Admin PT Kopi Senja *login* dan mengklik menu `/admin/products`, Middleware `tenant.active` mencegat, memvalidasi bahwa tanggal hari ini masih di bawah 4 Juli, dan mengizinkan akses.
3. **Masa Kritis (Tengah Malam 4 Juli):** Pada jam 00:00, **Cron Job** (`tenant:check-expired`) berjalan otomatis di server. Skrip mendeteksi tanggal langganan sudah lewat, lalu secara otomatis mengubah status Kopi Senja di database menjadi `expired`.
4. **Pemblokiran (Banned):** Pagi harinya jam 08:00, Admin PT Kopi Senja mencoba masuk. Middleware mencegatnya, melihat statusnya `expired`, membatalkan *session login* (Logout paksa), dan mengembalikan Admin ke halaman Login dengan peringatan: 
   > [!WARNING]
   > *"Masa berlangganan perusahaan Anda telah habis. Silakan hubungi Super Admin."*

---

## 3. Penyesuaian Sistem Saat Membuat Fitur Untuk Klien

Ketika men-develop antarmuka (UI) dan fitur backend (CRUD) untuk klien, ada **2 penyesuaian wajib** (SOP) yang harus selalu diterapkan:

### A. Penyesuaian Tampilan Dinamis (White-Labeling)
Karena ini adalah SaaS, PT Kopi Senja dan PT Adidas menggunakan basis kode (*codebase*) yang sama, namun identitas visual mereka harus berbeda. Di file *view* (seperti Blade), kita memanggil data konfigurasi dari tabel `mst_companies_config` milik tenant yang sedang login.

```html
<!-- Menampilkan Logo Klien Secara Dinamis -->
<img src="{{ auth()->user()->company->config->cfg_app_logo }}" alt="Logo Klien">

<!-- Mengubah Warna Tema Klien Secara Dinamis dengan Inline CSS atau Root Variable -->
<style>
    :root {
        --primary-color: {{ auth()->user()->company->config->cfg_primary_color }};
        --secondary-color: {{ auth()->user()->company->config->cfg_secondary_color }};
    }
</style>
```

### B. Isolasi Data (Data Filtering)
Ini adalah aturan paling kritis. Agar Admin PT Kopi Senja tidak bisa melihat data transaksi milik PT Adidas, **setiap *Query Database* harus difilter berdasarkan `company_id`**.

```php
// ❌ CONTOH SALAH (Semua produk dari semua perusahaan akan tercampur)
$products = Product::all(); 

// ✅ CONTOH BENAR (Hanya mengambil produk spesifik milik perusahaannya sendiri)
$products = Product::where('company_id', auth()->user()->company_id)->get();
```

> [!TIP]
> **Peningkatan di Masa Depan (Global Scope):**
> Ke depannya, kita dapat membuat filter `where('company_id', ...)` ini bekerja secara gaib (otomatis) menggunakan fitur **Global Scope** di Laravel. Dengan *Global Scope*, *developer* bisa menulis `Product::all()` namun Laravel di belakang layar otomatis menyisipkan `WHERE company_id = ...`.

---

**Kesimpulan SOP Development:**
Dengan fondasi Master Data ini, tugas pengembangan fitur (Katalog, Kasir, Laporan) menjadi terstandarisasi. Anda hanya perlu:
1. Menambahkan kolom `company_id` di setiap tabel operasional baru.
2. Membungkus rute dengan Middleware `tenant.active`.
3. Memastikan *Query Database* selalu menyertakan filter `$user->company_id`.
