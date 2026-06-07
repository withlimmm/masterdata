# Panduan Penjelasan Sistem SaaS Multi-Tenant

Dokumen ini disusun sebagai panduan presentasi untuk menjelaskan arsitektur sistem SaaS (Software as a Service) Multi-Tenant kepada atasan, tim bisnis, atau pemangku kepentingan (*stakeholder*) secara mudah dan terstruktur.

---

## 1. Konsep Dasar Arsitektur (Single Database)

Sistem SaaS Multi-Tenant yang kita bangun menggunakan pendekatan arsitektur **Single Database, Row-Level Isolation** (Satu Database, Isolasi Tingkat Baris).

### Apakah Butuh Banyak Database atau File `.env`?
**TIDAK.** Seluruh sistem ini (baik untuk otoritas pusat maupun untuk ribuan klien ke depannya) beroperasi hanya menggunakan:
- **1 Database Utama**
- **1 *Source Code* Aplikasi**
- **1 Konfigurasi Lingkungan (`.env`)**

**Pertanyaan Umum:** *"Kalau semua Klien gabung di 1 database, bukannya data kasir/artikel Klien A dan Klien B nanti bisa bocor dan tercampur aduk?"*
**Jawaban:** *"Tidak akan terjadi. Di setiap tabel data (produk, artikel, transaksi, user), sistem memiliki kolom identitas bernama `company_id`. Aplikasi kita dilengkapi dengan filter tingkat tinggi (Global Scope `BelongsToCompany`). Begitu Klien A login, aplikasi secara otomatis mencegat dan memodifikasi semua perintah ke database menjadi: 'Hanya tampilkan dan simpan data yang `company_id`-nya milik Klien A'. Isolasi data dijamin 100% aman dan kedap bocor."*

**Keuntungan Bisnis:** 
- Biaya *server cloud* jauh lebih murah (efisiensi infrastruktur).
- Pemeliharaan (seperti *Backup Data*) cukup dilakukan di satu tempat.
- Pembaruan fitur baru dapat dinikmati oleh semua Klien secara serentak tanpa perlu meng-*update* aplikasi satu per satu.

---

## 2. Cara Kerja Subdomain & Master Data

Anggaplah domain otoritas pusat kita adalah `rakiradigital.com`.

### Langkah A: Master Data (Otoritas Pusat)
Tim Rakira Digital (sebagai *Super Admin*) login ke halaman dasbor pusat. Jika ada pesanan langganan baru, tim hanya perlu mendaftarkan:
1. Nama Perusahaan Klien (misal: Toko Budi).
2. Paket Berlangganan (Basic / Pro / Enterprise) yang mendikte batas maksimal entitas (*limit quota*).
3. Tanggal Jatuh Tempo (*Expired Date*).
4. Subdomain Klien (misal: `budi.rakiradigital.com` atau `pos.rakiradigital.com`).

### Langkah B: Deteksi Otomatis (Tenant Middleware)
Saat Klien mengetikkan `pos.rakiradigital.com` di *browser*, sistem aplikasi langsung menangkap URL tersebut dan memverifikasinya ke Master Data: *"Ini domain siapa? Oh, milik Toko Budi!"*. Aplikasi akan mengubah lingkungannya (wujud, warna, data) secara spesifik dan mengunci diri hanya untuk Toko Budi.

### Langkah C: Penjaga Gerbang Langganan (Subscription Gatekeeper)
Sebelum dasbor terbuka, sistem mengecek masa aktif klien tersebut. Jika hari ini sudah melewati tanggal jatuh tempo, Toko Budi akan diblokir seketika dan dialihkan ke halaman pemberitahuan: *"Masa Langganan Anda Telah Habis, silakan hubungi tim Rakira Digital"*.

---

## 3. Integrasi Aplikasi yang Berbeda (Studi Kasus: CMS vs Mesin POS/Kasir)

Atasan mungkin akan bertanya: *"rakiradigital.com ini kan wujud utamanya sistem CMS (Company Profile). Bagaimana caranya `pos.rakiradigital.com` bisa memiliki wujud aplikasi mesin Kasir (POS) padahal cuma pakai 1 Database dan 1 source code?"*

Sistem Master Data ini sudah dirancang secara modular dan mendukung **2 Skenario Integrasi**:

### Skenario A (Monolith / Sistem Tergabung)
Modul aplikasi Kasir (POS) dibangun dan digabungkan di dalam *source code* CMS yang sama. 
- **Sistem Kerjanya:** Saat URL diakses, sistem melihat tipe paket Klien di Master Data. *"Jika paketnya 'Company Profile', arahkan ke tampilan CMS. Jika paketnya 'POS Kasir', alihkan otomatis ke tampilan menu Kasir."*

### Skenario B (Microservice / API Terpisah) -> *Sangat Disarankan untuk Sistem POS Skala Besar*
Aplikasi CMS (SaaS kita) dan Aplikasi POS Kasir adalah dua perangkat lunak yang **terpisah total**.
- Aplikasi POS memiliki database dan kode sendiri di *server* lain. 
- **Sistem Kerjanya:** Aplikasi CMS SaaS kita bertindak sebagai **Pusat Otak Master Data (Biling Utama)**. Setiap kali pengguna POS login, aplikasi POS tersebut diwajibkan "*mengetuk pintu*" aplikasi CMS kita secara tersembunyi via API. CMS kita akan menjawab: *"Status: Aktif, boleh lanjut jualan"* atau *"Status: Blokir, langganan belum dibayar"*.

---

### Kesimpulan Presentasi
Arsitektur ini memungkinkan Rakira Digital memonopoli pengelolaan *Subscription* (Langganan) Klien secara terpusat. Pendaftaran klien baru sangat **Instan**. Tidak ada lagi *setup server*, *install database*, atau *coding* berulang untuk klien baru. Cukup satu "Klik" Simpan di Dasbor Super Admin, *subdomain* Klien langsung online dan siap digunakan berbisnis detik itu juga.
