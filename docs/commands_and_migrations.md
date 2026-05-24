# Panduan Perintah & Deployment

Dokumen ini adalah *cheat sheet* atau catatan pengingat berisi perintah-perintah penting (terutama *Artisan Commands*) yang harus Anda jalankan pada sistem Company Profile ini agar seluruh perubahan mitigasi yang telah dibuat dapat berfungsi penuh.

---

## 1. Migrasi Database (Wajib Dijalankan Sekarang)
Karena sebelumnya kita telah menambahkan kolom untuk manajemen peran (`role`) dan kolom khusus SEO (`meta_title`, `meta_description`, `meta_keywords`), Anda wajib menyelaraskan struktur *database* Anda dengan perintah berikut:

**Jalankan di Terminal / CMD:**
```bash
php artisan migrate
```
*Efek: Tabel `users`, `articles`, `pages`, dan `portfolios` akan otomatis terbarui tanpa menghapus data lama.*

---

## 2. Pembersihan Log Aktivitas (Opsional / Berkala)
Sistem ini menggunakan fitur `Prunable` untuk mencegah pembengkakan data pada tabel `activity_logs`. Agar log yang usianya lebih dari 30 hari dihapus secara otomatis, jalankan perintah berikut:

**Jalankan di Terminal / CMD:**
```bash
php artisan model:prune
```
💡 **Tips untuk Server Production:** Anda bisa mendaftarkan perintah ini di *Cron Job* cPanel/Server Linux Anda agar dieksekusi setiap hari secara otomatis.

---

## 3. Cadangan Sistem (Backup System)
Kita telah berhasil membuat perintah *native* untuk melakukan *backup* mandiri. Perintah ini akan menyatukan *database* SQL dan semua gambar yang pernah diunggah (di folder `storage/app/public`) menjadi satu file ZIP.

**Jalankan di Terminal / CMD:**
```bash
php artisan system:backup
```
*Hasil backup bisa Anda temukan di folder `storage/app/backups`.*

---

## 4. Rencana Pemasangan Package Lanjutan (Untuk Masa Depan)
Jika sewaktu-waktu aplikasi ini ingin ditingkatkan lagi keamanan dan performanya (Level 2 Gaps), Anda dapat menginstal *package* pihak ketiga via Composer:

1. **Untuk Keamanan Login (2FA):**
   ```bash
   composer require laravel/fortify
   ```
2. **Untuk Optimasi & Auto-Resize Gambar:**
   ```bash
   composer require intervention/image
   ```
   *(Setelah diinstal, logika penyimpanan gambar pada controller perlu sedikit disesuaikan).*
