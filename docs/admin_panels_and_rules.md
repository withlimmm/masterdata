# Aturan Sistem, Panel, dan Struktur Menu

Dokumen ini menjelaskan aturan bisnis (Business Rules), struktur panel admin, dan tata letak menu pada sistem Company Profile.

---

## 1. Aturan Sistem (Business Rules & Logic)

Sistem ini memiliki beberapa aturan otomatis dan validasi untuk memastikan integritas data dan keamanan aplikasi.

### A. Aturan Visibilitas Konten Publik
- **Ulasan (Reviews):** Ulasan yang di-*submit* oleh pengunjung melalui form publik secara otomatis akan berstatus `pending`. Admin harus mengubah statusnya menjadi `approved` agar ulasan tersebut tampil di halaman Beranda.
- **Klien & Mitra (Clients):** Hanya entitas klien dengan status `active` yang logonya akan tampil di *marquee* atau daftar klien di halaman publik.
- **Layanan (Services):** Layanan harus berstatus `active` untuk muncul di halaman publik dan form pilihan konsultasi.
- **Halaman Statis/FAQ (Pages):** Hanya halaman yang berstatus `published` yang akan ditampilkan kepada pengunjung.
- **Artikel Blog:** Ditampilkan berurutan dari yang paling baru (*latest*). Jika pengunjung memfilter kategori, hanya artikel dengan *slug* kategori yang sesuai yang akan muncul.

### B. Validasi Input Pengunjung
- **Form Konsultasi:**
  - Wajib mengisi: Nama Lengkap, Email, Nomor WhatsApp, dan Layanan yang dituju.
  - Setiap pesan masuk otomatis diatur dengan status `unread` di *database*.
- **Form Ulasan (Testimonial):**
  - Wajib mengisi: Nama, Rating (skala 1-5), dan Komentar.
  - Input akan disaring dan dibersihkan dari potensi injeksi skrip.

---

## 2. Struktur Panel Admin

Panel Admin (CMS) digunakan oleh pemilik sistem untuk mengelola seluruh data yang tampil di *front-end*.

### Komponen Utama Panel
1. **Dashboard (Ringkasan Analitik):**
   - Menampilkan total entitas penting (Jumlah Pesan belum dibaca, Jumlah Artikel, Portofolio, dan Klien).
   - Menampilkan aktivitas terbaru.
2. **Data Tables (Tabel Daftar Data):**
   - Setiap modul memiliki antarmuka tabel yang menampilkan daftar data (misal: Daftar Artikel).
   - Dilengkapi tombol Aksi: **View** (Lihat detail), **Edit** (Ubah data), dan **Delete** (Hapus dengan peringatan konfirmasi).
3. **Form Input (Create/Edit):**
   - Memiliki *text-editor* (WYSIWYG) untuk kolom deskripsi atau konten artikel/portofolio.
   - Mendukung fitur *upload* gambar dengan *preview* untuk thumbnail, logo, dan foto tim.

---

## 3. Struktur Menu (Navigation)

### A. Menu Utama (Public Navigation)
Ini adalah menu yang dapat diakses oleh pengunjung di bagian *header* website:
1. **Beranda (`/`)** - Menampilkan *hero section*, klien, cuplikan layanan, FAQ, dan form *review*.
2. **Layanan (`/layanan`)** - Menampilkan daftar layanan lengkap.
3. **Portofolio (`/portofolio`)** - Menampilkan galeri proyek kerja yang difilter berdasarkan kategori.
4. **Tentang Kami (`/tentang-kami`)** - Menampilkan profil perusahaan dan struktur anggota tim.
5. **Blog (`/blog`)** - Halaman kumpulan artikel dan berita perusahaan.

### B. Menu Sidebar (Admin Navigation)
Ini adalah menu yang tampil di bagian kiri (atau atas) pada halaman *Dashboard* Admin:
1. **Dashboard** (`/admin/dashboard`) - Ringkasan statistik.
2. **Master Data**
   - **Kategori** (`/admin/categories`) - Mengelola kategori untuk Artikel & Portofolio.
   - **Tim** (`/admin/teams`) - Mengelola data anggota tim (Tentang Kami).
   - **Klien** (`/admin/clients`) - Mengelola daftar klien & mitra.
   - **Proyek Klien** (`/admin/client-projects`) - Mengelola proyek spesifik dari klien.
3. **Konten Website**
   - **Layanan** (`/admin/services`) - Mengelola daftar layanan perusahaan.
   - **Portofolio** (`/admin/portfolios`) - Mengelola karya/proyek yang sudah selesai.
   - **Artikel** (`/admin/articles`) - Mengelola blog post/berita.
   - **Halaman & FAQ** (`/admin/pages` & `/admin/faqs`) - Mengelola daftar pertanyaan umum.
4. **Interaksi Publik**
   - **Pesan Konsultasi** (`/admin/messages`) - Inbox pesan masuk dari pengunjung.
   - **Ulasan Klien** (`/admin/reviews`) - Moderasi testimonial (Pending / Approved).
5. **Pengaturan**
   - **Pengaturan Perusahaan** (`/admin/settings`) - Mengubah teks, nomor WA, logo, link sosial media perusahaan (White-label settings).
