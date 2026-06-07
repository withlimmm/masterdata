# Panduan Setup Aplikasi Klien (Microservice POS / App Terpisah)

Jika Anda membangun aplikasi Klien (misalnya aplikasi **Kasir/POS**) di proyek Laravel yang *berbeda* dan memiliki *database* sendiri (Skenario Microservice), Anda wajib menghubungkan aplikasi tersebut dengan Pusat Master Data SaaS kita.

Berikut adalah langkah-langkah implementasi kodenya pada aplikasi Klien (POS):

---

## 1. Siapkan `.env` di Aplikasi Klien

Tambahkan variabel konfigurasi untuk menyimpan URL Master SaaS dan API Key Klien tersebut.

```env
# Di dalam file .env aplikasi POS Klien
SAAS_MASTER_URL="https://rakiradigital.com"
SAAS_API_KEY="masukkan_api_key_dari_dashboard_master_disini"
```

---

## 2. Buat Middleware Pengecekan (Penjaga Gerbang)

Di dalam aplikasi Klien (POS), jalankan perintah:
```bash
php artisan make:middleware VerifySaaSSubscription
```

Buka file `app/Http/Middleware/VerifySaaSSubscription.php` lalu masukkan kode berikut:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class VerifySaaSSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Dapatkan Domain Klien saat ini
        $domain = $request->getHost(); 
        
        // 2. Cek status ke Master Data SaaS (Gunakan Cache 1 jam agar web POS tetap sangat cepat dan tidak membebani server Master)
        $saasStatus = Cache::remember("saas_status_{$domain}", 3600, function () use ($domain) {
            try {
                $response = Http::timeout(3)->get(env('SAAS_MASTER_URL') . '/api/saas/check', [
                    'domain' => $domain,
                    'key'    => env('SAAS_API_KEY'),
                ]);

                if ($response->successful()) {
                    return $response->json();
                }
                
                return ['valid' => false, 'message' => 'Gagal menghubungi server pusat.'];
            } catch (\Exception $e) {
                // Jika server Master mati, beri kelonggaran atau blokir (Sesuai kebijakan bisnis)
                return ['valid' => true, 'message' => 'Bypass sementara karena gangguan jaringan.']; 
            }
        });

        // 3. Eksekusi Pemblokiran Jika Expired
        if (!isset($saasStatus['valid']) || $saasStatus['valid'] === false) {
            // Bisa return view khusus atau abort
            abort(403, 'AKSES DIBLOKIR: Masa langganan aplikasi Anda (' . $domain . ') telah habis atau dibekukan. Silakan hubungi Rakira Digital.');
        }

        // Jika lolos, biarkan Klien menggunakan aplikasi POS
        return $next($request);
    }
}
```

---

## 3. Daftarkan dan Gunakan Middleware

Daftarkan middleware tersebut di `bootstrap/app.php` (Jika Laravel 11) aplikasi POS:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'saas.verify' => \App\Http\Middleware\VerifySaaSSubscription::class,
    ]);
})
```

Terapkan di rute aplikasi Klien (POS) Anda `routes/web.php`:

```php
Route::middleware(['auth', 'saas.verify'])->group(function () {
    Route::get('/dashboard-kasir', [KasirController::class, 'index']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    // Semua fungsi POS Anda ada di dalam sini...
});
```

---

## Bagaimana Alur Kerjanya?
1. Saat kasir toko membuka `pos.rakiradigital.com/dashboard-kasir`, sistem akan menjalankan `VerifySaaSSubscription`.
2. Sistem POS akan menembak API Master Data Anda: `GET https://rakiradigital.com/api/saas/check?domain=pos.rakiradigital.com&key=xxxxx`.
3. Jika jawaban dari API Anda adalah `{"valid": true}`, maka kasir toko bisa lanjut berjualan.
4. Jika jawabannya `{"valid": false}`, layar kasir akan memunculkan layar putih bertuliskan **403 AKSES DIBLOKIR**, memaksa klien toko tersebut untuk segera membayar perpanjangan paket ke Rakira Digital.
5. Caching 1 Jam (`Cache::remember`) sangat penting agar setiap kali si kasir mengklik menu, aplikasi tidak lemot karena harus terus-terusan nge-*ping* server pusat. Server pusat hanya ditanya 1x dalam 1 jam.
