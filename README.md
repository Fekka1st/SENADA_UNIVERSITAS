# Sistem Senada Universitas

Sistem Senada (Sistem Informasi Navigasi Data) adalah sebuah platform manajemen data berbasis web yang dirancang khusus untuk mengelola, mengarsipkan, dan memonitor seluruh administrasi kerja sama di tingkat universitas maupun instansi. Sistem ini mendigitalisasi alur kerja sama dengan mengubah dokumen fisik (hardcopy) menjadi arsip digital (softcopy) yang terstruktur, aman, dan mudah ditelusuri.

Lebih dari sekadar repositori penyimpanan, Senada mengakomodasi alur verifikasi dokumen kemitraan yang komprehensif—mulai dari tahap Nota Kesepahaman (MoU), Perjanjian Kerja Sama (MoA), hingga Implementasi Kerja Sama (IA). Melalui manajemen hak akses pengguna yang terintegrasi, sistem ini juga menyediakan fitur analitik dan pelaporan otomatis untuk menunjang proses perhitungan dan pencapaian Indikator Kinerja Utama (IKU), sehingga pimpinan atau pemangku kepentingan dapat mengevaluasi efektivitas setiap jalinan kerja sama secara real-time.


## 🚧 Status Pengembangan (Progress Tracker)

Aplikasi ini masih dalam tahap pengembangan aktif. Berikut adalah peta jalan (roadmap) penyelesaian fitur:

### Tahap 1: Core Architecture & Database
- [x] Desain skema database relasional (MoU, MoA, IA, Mitra) # ADA PERUBAHAN LAGI JADI MUNGKIN ROMBAK LAGI
- [x] Setup autentikasi dan pembagian Role (Prodi, Admin, Pimpinan, Rektor)
- [x] Integrasi Relasi Polimorfik untuk sistem *upload* satu pintu (`lampiran_berkas`)

### Tahap 2: Modul Manajemen Dokumen
- [x] CRUD Modul Rencana Pengajuan
- [x] CRUD Modul Berkas MoU (Tingkat Universitas)
- [x] Fitur Auto-Calculate durasi tanggal aktif dokumen
- [x] CRUD Modul Berkas MoA (Tingkat Fakultas)
- [ ] Sistem *Approval* & Verifikasi berjenjang (Draft -> Admin -> Pimpinan)
- [ ] CRUD Modul Berkas IA (Tingkat Program Studi)

### Tahap 3: Fitur Pendukung & Laporan
- [ ] CRUD Modul Mitra (Data institusi rekanan)
- [x] Integrasi GeoMitra (Peta sebaran lokasi mitra) 
- [ ] Modul Digital Repository
- [ ] Modul Laporan & Export Data (PDF/Excel)
- [ ] Executive Dashboard untuk Rektor (Grafik, Pie Chart, dan Statistik IKU)

---

## 🚀 Fitur Utama (Core Features)

* **Manajemen Dokumen Berjenjang:** Struktur relasi hierarkis logis dari tingkat universitas hingga implementasi teknis (MoU ➔ MoA ➔ IA).
* **Rencana Pengajuan:** Modul pencatatan usulan atau draf kerja sama sebelum memasuki tahap formalisasi.
* **Manajemen Mitra & GeoMitra:** Basis data instansi partner yang terintegrasi dengan pemetaan visual interaktif untuk melihat sebaran lokasi mitra (Lokal, Nasional, Internasional).
* **Digital Repository:** Sistem pengarsipan dengan fitur pencarian global (*Global Search*) khusus untuk menyimpan dan mendigitalkan dokumen kerja sama fisik (*offline*) masa lampau.

## 🔐 Sistem Verifikasi & Hak Akses (Role-Based Access Control)

Sistem ini menerapkan alur persetujuan bertingkat yang transparan dari pengajuan hingga pengesahan:
* **Prodi (Pengusul):** Menginput draf MoA/IA, merinci usulan kegiatan, dan merevisi dokumen.
* **Admin Fakultas (Reviewer):** Memverifikasi kelengkapan administrasi dan meneruskan dokumen valid ke pimpinan.
* **Fakultas / Pimpinan (Verifikator Final):** Mengambil keputusan akhir (*Approve/Reject*) untuk pengesahan legalitas MoA dan IA.
* **Rektor (Executive View):** Akses *read-only* tingkat tinggi yang berfokus pada pantauan statistik dan capaian kerja sama.

## 📊 Executive Dashboard & Pelaporan

* **Visualisasi Data Interaktif:** Dasbor pimpinan menampilkan angka *highlight*, grafik kinerja antarfakultas, dan *pie chart* status dokumen (Aktif, Menunggu, Kedaluwarsa).
* **Laporan Kinerja Indikator (IKU):** Pemantauan produktivitas untuk mengukur MoU yang paling banyak menghasilkan kegiatan riil (IA).
* **Ekspor Data Terstruktur:** Rekapitulasi kerja sama yang dapat difilter berdasarkan tahun, jenis, dan status untuk kebutuhan cetak atau audit.

## ⚙️ Automasi & Optimasi Sistem (*Under the Hood*)

* **Auto-Calculate Durasi:** Sistem otomatis mengkalkulasi `tanggal_mulai` dan `tanggal_berakhir` tepat saat pimpinan memberikan persetujuan (*Approve*).
* **Polymorphic File Management:** Penyimpanan seluruh lampiran berkas ke dalam satu tabel terpusat untuk mencegah redundansi tabel dan menerapkan prinsip DRY (*Don't Repeat Yourself*).
* **Dynamic UI Rendering:** Tampilan antarmuka yang adaptif, menyembunyikan atau menampilkan elemen (seperti tombol *download* dokumen final) berdasarkan status *approval* dokumen secara *real-time*.

<p align="center">
  <i>Status Pengembangan: <b>Tahap Development (50%) dikarenakan ada kerjaan internal sehingga progress terhambat</b></i>
</p>

---

## 🚀 Quick Setup (Instalasi Cepat)

### Persyaratan Sistem
Pastikan di perangkat Anda sudah terinstal:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah-langkah Instalasi

1. **Clone repositori**
   Buka terminal, lalu clone repositori ini ke dalam direktori lokal Anda:
   ```bash
   git clone https://github.com/username/sistem-senada.git](https://github.com/Fekka1st/SENADA_UNIVERSITAS.git
   cd SENADA_UNIVERSITAS
   ```

2. **Instal dependensi PHP**
   ```bash
   composer install
   ```

3. **Instal dan build dependensi Frontend**
   ```bash
   npm install
   npm run build
   ```

4. **Setup Environment Variables**
   Salin file konfigurasi bawaan:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan kredensial database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=senada_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database dan Seeding**
   Pastikan Anda sudah membuat database kosong (misal: `senada_db`), lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```

7. **Storage Link **
   ```bash
   php artisan storage:link
   ```

8. **Jalankan Aplikasi**
   Jalankan server *development* lokal:
   ```bash
   php artisan ser
   ```
   Aplikasi sekarang dapat diakses melalui browser di: `http://localhost:8000`
---

## 🛠️ Teknologi yang Digunakan

- **Backend**: [Laravel](https://laravel.com/) (PHP Framework)
- **Frontend**: Blade Templating, Tailwind CSS / Bootstrap, Vite
- **Database**: MySQL
