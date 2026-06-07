# Rakira Digital - SaaS & Subscription Architecture
**Status: Production Ready**

Dokumen ini ditujukan untuk **AI Assistant (Prompt Context)** maupun *Developer* yang akan membangun aplikasi klien (seperti Sistem POS, Warehouse, atau Company Profile) yang berada di bawah naungan ekosistem langganan Rakira Digital Nusantara.

## 1. Konsep Dasar Sistem (Master-Node)

Sistem menggunakan arsitektur **Master-Node**.
- **Master Server:** Rakira Digital (Domain: `rakiradigital.com`) bertindak sebagai pusat validasi lisensi SaaS.
- **Node (Client Server):** Aplikasi klien (misal: POS System) yang di-*hosting* di domain berbeda. Node tidak memiliki tabel *subscription* sendiri, melainkan melakukan *remote API call* ke Master Server untuk memvalidasi apakah layanan mereka masih aktif.

## 2. API Endpoint Validation (Dari Sisi Master)

Master Server menyediakan satu *endpoint* publik yang aman:

- **URL:** `GET https://rakiradigital.com/api/saas/check`
- **Query Parameters:**
  - `domain` : String domain aplikasi (contoh: `pos.namaklien.com`)
  - `key` : String API Key yang di-generate dari Rakira CMS (panjang ~64 karakter)
- **Response Format (JSON):**
  ```json
  {
      "valid": true,
      "status": "active",
      "plan": "professional",
      "company": "PT Nama Klien",
      "expires_at": "2026-12-31",
      "days_remaining": 365
  }
  ```

*Kondisi Invalid/Expired:* Jika `valid` bernilai `false`, maka akses sistem klien **HARUS DIBLOKIR**.

---

## 3. Panduan Implementasi di Aplikasi Klien (Instruksi untuk AI / Developer)

Saat Anda (Developer / AI) ditugaskan untuk membuat aplikasi klien baru (seperti POS), Anda **WAJIB** mengimplementasikan logika *SaaS Blocking* berikut:

### Langkah 1: Tambahkan Environment Variables
Tambahkan ke file `.env` di aplikasi klien:
```env
RAKIRA_LICENSE_URL=https://rakiradigital.com
RAKIRA_CLIENT_DOMAIN=domain-klien.com
RAKIRA_LICENSE_KEY=diisi_saat_klien_dibuat_di_rakira
```

### Langkah 2: Buat Middleware `CheckRakiraLicense`
Gunakan Laravel Cache (1 jam) agar aplikasi klien tidak mengalami latensi karena harus *hit API* terus-menerus.

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CheckRakiraLicense
{
    public function handle(Request $request, Closure $next)
    {
        $serverUrl = env('RAKIRA_LICENSE_URL');
        $apiKey = env('RAKIRA_LICENSE_KEY');
        $domain = env('RAKIRA_CLIENT_DOMAIN', $request->getHost());

        // Skip jika belum ada konfigurasi (misal di local environment)
        if (!$serverUrl || !$apiKey) return $next($request);

        // Cache hasil API selama 1 Jam
        $status = Cache::remember('rakira_license_status', 3600, function () use ($serverUrl, $domain, $apiKey) {
            try {
                $response = Http::timeout(5)->get($serverUrl . '/api/saas/check', [
                    'domain' => $domain,
                    'key'    => $apiKey
                ]);
                return $response->successful() ? $response->json() : null;
            } catch (\Exception $e) {
                return 'SERVER_DOWN'; 
            }
        });

        if ($status === 'SERVER_DOWN') return $next($request);

        // BLOKIR AKSES JIKA TIDAK VALID ATAU EXPIRED
        if (!$status || $status['valid'] === false) {
            Cache::forget('rakira_license_status'); 
            
            // Hindari infinite redirect loop
            if (!$request->is('license-expired')) {
                return redirect('/license-expired'); 
            }
        }

        return $next($request);
    }
}
```

### Langkah 3: Terapkan Middleware Berdasarkan Jenis Produk

**A. Untuk Aplikasi Fungsional (POS, ERP, Kasir):**
Matikan seluruh sistem. Pasang Middleware secara **Global** di `bootstrap/app.php` (Laravel 11) atau `app/Http/Kernel.php` agar setiap *route* terproteksi.
```php
$middleware->append(\App\Http\Middleware\CheckRakiraLicense::class);
```

**B. Untuk Company Profile / Web Portofolio:**
Biarkan masyarakat tetap bisa melihat *landing page*. Pasang Middleware **HANYA di Route Group Admin**:
```php
Route::middleware(['auth', \App\Http\Middleware\CheckRakiraLicense::class])
    ->prefix('admin')->group(function () {
        // ... rute CMS klien
});
```

### Langkah 4: Halaman `/license-expired`
Buat rute publik yang menampilkan pesan penangguhan layanan:
```php
Route::get('/license-expired', function () {
    return view('errors.license-expired'); 
});
```
*Tampilkan pesan profesional seperti: "Sistem Ditangguhkan. Masa berlaku langganan Anda telah berakhir. Hubungi Rakira Digital Nusantara."*
