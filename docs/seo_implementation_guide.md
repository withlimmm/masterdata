# Panduan Implementasi & Optimasi SEO (Google Lighthouse 97-100)
## Rakira Digital Nusantara

Dokumen ini menjelaskan dasar teori, fungsi, manfaat, serta implementasi teknis optimasi SEO yang telah diterapkan pada website Company Profile Rakira Digital. Panduan ini juga memberikan pedoman bagi tim pengembang dan konten kreator untuk mempertahankan nilai SEO tetap berada pada skor **97-100** di Google Lighthouse.

---

## 1. Fungsi Utama SEO (Search Engine Optimization)
SEO bertujuan untuk membuat halaman website lebih mudah ditemukan, dipahami, dan direindeks oleh robot mesin pencari seperti Googlebot.

* **Trafik Organik Berkelanjutan**: Mendatangkan pengunjung berkualitas secara konsisten tanpa biaya iklan berbayar (Pay-Per-Click).
* **Meningkatkan Kepercayaan (Trust)**: Website yang menduduki peringkat atas pada pencarian organik Google secara alami dianggap lebih kredibel oleh calon klien.
* **Meningkatkan Conversion Rate**: Dengan menargetkan kata kunci komersial berniat tinggi (*high-intent*), trafik yang datang adalah calon pelanggan yang siap membeli jasa/layanan Anda.

---

## 2. Struktur Optimasi yang Telah Diimplementasikan

Berikut adalah rincian teknis perbaikan SEO yang telah diterapkan pada layout template utama (`main`, `default`, `premium`) serta halaman konten:

### A. Deskripsi Tautan Aksesibel (Unique Link Accessibility)
* **Masalah**: Lighthouse mendeteksi teks tautan generik berulang seperti *"Baca Artikel"*, *"Lihat Detail"*, atau tautan ikon sosial media kosong sebagai nilai negatif (skor SEO turun ke ~92).
* **Solusi**: Penambahan atribut `aria-label` yang dinamis di setiap tombol dan tautan yang berulang:
  ```html
  <!-- Contoh pada kartu blog -->
  <a href="{{ route('blog.show', $article->slug) }}" 
     aria-label="Baca Artikel: {{ $article->title }}" 
     class="group">
      Baca Artikel
  </a>
  ```
  Ini membantu pembaca layar (*screen reader*) dan robot Google untuk memahami tujuan akhir dari tautan tersebut secara mandiri tanpa bergantung pada elemen sekitar.

### B. Structured Data (JSON-LD Organization Schema)
* **Fungsi**: Membantu Google mengidentifikasi entitas organisasi, nama merek, logo resmi, dan jalur komunikasi WhatsApp secara formal.
* **Lokasi**: Disisipkan pada bagian `<head>` seluruh layout menggunakan sintaks yang aman dari konflik *compiler* Blade:
  ```html
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "Organization",
    "name": "{{ $settings->company_name ?? 'Rakira Digital Nusantara' }}",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('images/logo-rakira.png') }}",
    "contactPoint": {
      "@@type": "ContactPoint",
      "telephone": "+{{ $settings->phone ?? '6287868184742' }}",
      "contactType": "customer service"
    }
  }
  </script>
  ```

### C. Tag Canonical Dinamis
* **Fungsi**: Menghindari sanksi konten duplikat (*duplicate content penalty*) dari Google dengan mendeklarasikan URL tunggal yang sah untuk setiap halaman.
* **Lokasi**: Terpasang di `<head>` layout:
  ```html
  <link rel="canonical" href="{{ url()->current() }}">
  ```

### D. Meta Description dan Kata Kunci Relevan
Setiap halaman kini dibekali Meta Tag yang unik untuk memikat calon pengunjung dari hasil pencarian Google:
* **Halaman Blog**: Menggunakan kata kunci informatif (*cara membuat website bisnis, biaya pembuatan aplikasi mobile, tren desain web terbaru*).
* **Halaman Layanan**: Menargetkan kata kunci transaksional (*jasa pembuatan website company profile, jasa pembuatan aplikasi android ios, jasa pembuatan web app kustom*).

---

## 3. Cara Mempertahankan Skor SEO 97-100 (Best Practices)

Ketika tim konten atau admin menambahkan postingan blog baru, portofolio baru, atau membuat halaman tambahan baru di CMS, pastikan untuk mengikuti aturan berikut:

### A. Penulisan Konten Blog & Portofolio
1. **Gunakan Hierarchy Heading yang Benar**:
   * Halaman hanya boleh memiliki satu `<h1>` (biasanya judul halaman/artikel).
   * Gunakan `<h2>` untuk sub-topik utama, dan `<h3>` untuk sub-topik di dalamnya secara runtut. Jangan melompati tingkat (misal dari `<h2>` langsung ke `<h4>`).
2. **Alt Text pada Gambar**:
   * Selalu isi kolom deskripsi gambar (*alt text*) saat mengunggah gambar artikel/portofolio di CMS. Gunakan deskripsi yang merepresentasikan gambar tersebut (misal: *alt="Proyek Website E-Commerce Toko Baju"*).

### B. Menghindari Tautan Kosong
Jika Anda membuat tautan ikon sosial media baru di footer atau bagian lainnya, pastikan tautan tersebut memiliki nama yang dapat diakses:
```html
<!-- BENAR (Lolos Audit Lighthouse) -->
<a href="https://instagram.com/..." aria-label="Instagram Rakira Digital">
    <i class="fab fa-instagram"></i>
</a>

<!-- SALAH (Membuat Skor SEO Turun) -->
<a href="https://instagram.com/...">
    <i class="fab fa-instagram"></i>
</a>
```

### C. Melakukan Audit Berkala
Untuk memverifikasi kualitas website secara berkelanjutan:
1. Buka website di Google Chrome menggunakan mode **Incognito** (agar ekstensi browser Anda tidak mengganggu hasil audit).
2. Tekan `F12` untuk membuka *Developer Tools*, lalu pilih tab **Lighthouse**.
3. Pilih kategori **SEO** (dan **Accessibility**), lalu klik **Analyze page load**.
