# Datapedia + Student Corner — Versi Integrasi Satu Pintu

Proyek ini adalah hasil penggabungan Datapedia dan Student Corner dengan Datapedia sebagai sistem utama.

## Perubahan Utama Versi Ini

### 1. Login satu pintu

Login Student Corner sudah dinonaktifkan sebagai login terpisah.

Akses login sekarang:

- Admin: `/admin/loginAdmin`
- User: `/loginUser`

Alias yang disediakan agar middleware Laravel tetap aman:

- `/admin/login` akan diarahkan ke `/admin/loginAdmin`
- `/login` akan diarahkan ke `/loginUser`
- `/register` akan diarahkan ke `/registerUser`

Route auth bawaan Breeze/Student Corner tidak lagi dipakai di `routes/web.php`.

### 2. Student Corner menjadi fitur utama Datapedia

Student Corner tidak lagi ditempatkan sebagai sistem sendiri di `/admin/student-corner`.

Route admin sekarang menjadi modul langsung di dalam admin Datapedia:

- `/admin/konten-edukasi/subjek-materi`
- `/admin/konten-edukasi/artikel`
- `/admin/konten-edukasi/video-pembelajaran`
- `/admin/konten-edukasi/infografis`
- `/admin/program-magang/informasi-magang`
- `/admin/program-magang/pendaftaran-magang`
- `/admin/program-riset/informasi-riset`
- `/admin/program-riset/pendaftaran-riset`
- `/admin/kuis-dan-tantangan/kuis-reguler`
- `/admin/kuis-dan-tantangan/kuis-tantangan-bulanan`
- `/admin/pengaturan-presensi`
- `/admin/wilayah-bps`

Route publik fitur Student Corner juga menjadi fitur langsung Datapedia:

- `/konten-edukasi`
- `/konten-edukasi/{slug}`
- `/program-magang/informasi-magang`
- `/program-magang/daftar-magang`
- `/program-magang/presensi`
- `/program-riset/informasi-riset`
- `/program-riset/daftar-riset`
- `/kuis-dan-tantangan-bulanan`
- `/kalkulator-statistik`
- `/visualisasi-data`
- `/simulasi-statistik`

Route lama `/student-corner` hanya menjadi redirect ke bagian literasi statistik di halaman utama Datapedia.

### 3. Database satu sistem

Database tetap satu:

```env
DB_DATABASE=digistat_datapedia
```

Tabel `users` dan `admins` tidak dibuat dobel. Kolom tambahan Student Corner dimasukkan ke tabel Datapedia melalui migration integrasi:

```text
2026_05_26_000001_merge_student_corner_columns.php
```

Tabel fitur Student Corner ditambahkan sebagai tabel modul Datapedia, seperti:

- `subjek_materis`
- `artikels`
- `video_pembelajarans`
- `infografis`
- `informasi_magangs`
- `pendaftaran_magangs`
- `presensi_magangs`
- `log_harian_magang_users`
- `informasi_risets`
- `pendaftaran_risets`
- `kuis_regulers`
- `soal_kuis_regulers`
- `hasil_kuis_regulers`
- `periodes`
- `kuis_tantangan_bulanans`
- `pengaturan_presensi`
- `wilayah_bps`

### 4. Menu utama Datapedia

Halaman utama Datapedia sudah ditambahkan section **Literasi Statistik** yang mengarah ke:

- Konten Edukasi
- Program Magang
- Kolaborasi Riset
- Kuis dan Tantangan
- Kalkulator Statistik
- Visualisasi Data
- Simulasi Statistik

Navbar publik Datapedia juga sudah ditambahkan akses ke Edukasi, Alat Statistik, Kuis, Magang, dan Riset.

### 5. Admin Datapedia

Sidebar admin Datapedia sudah ditambahkan menu:

- Edukasi Statistik
- Program Magang
- Program Riset
- Kuis & Alat Statistik

View admin Student Corner yang sebelumnya memakai layout sendiri sudah diarahkan ke layout admin Datapedia agar tidak terasa sebagai sistem terpisah.

## Cara Menjalankan

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

## Akun Default Seeder

Admin utama:

```text
Email: admin@example.com
Password: password
```

Operator tambahan:

```text
operator@example.com / password
operator.magang@example.com / password
operator.kepegawaian@example.com / password
```

## Catatan

Jika environment lokal belum memiliki ekstensi PHP DOM, beberapa perintah package tertentu dapat memunculkan error `Class "DOMDocument" not found`. Untuk production/local yang lengkap, aktifkan ekstensi PHP DOM/XML.

## Update Final: Integrasi Fitur Student Corner ke Datapedia

Perubahan pada versi ini:

1. Menu **Tools** pada navbar Datapedia diganti menjadi **Alat Statistik**.
   - `/alat-statistik` = halaman utama Alat Statistik
   - `/kalkulator-statistik` = Kalkulator Statistik
   - `/visualisasi-data` = Visualisasi Data
   - `/simulasi-statistik` = Simulasi Statistik

2. Menu **Riset** sudah ditambahkan ke navbar utama Datapedia.
   - `/program-riset/informasi-riset` = Informasi Riset
   - `/program-riset/arsip-karya-kolaborasi-riset` = Arsip Karya Riset
   - `/program-riset/daftar-riset` = Pendaftaran Riset, memakai login user Datapedia

3. Dashboard admin Datapedia sudah ditambah bagian **Fitur Utama Datapedia dari Student Corner** untuk mengelola:
   - Subjek Materi
   - Artikel Edukasi
   - Video Pembelajaran
   - Infografis
   - Informasi Magang
   - Pendaftar Magang
   - Informasi Riset
   - Pendaftar Riset
   - Kuis Reguler
   - Tantangan Bulanan
   - Pengaturan Presensi
   - Wilayah BPS

4. Sidebar admin Datapedia sudah ditambah menu Program Riset lengkap:
   - Informasi Riset
   - Pendaftar Riset
   - Riset Diterima
   - Riset Ditolak
   - Riwayat Riset

5. Student Corner tidak berdiri sebagai sistem terpisah. Fiturnya sudah masuk sebagai modul utama Datapedia dan tetap menggunakan login Datapedia satu pintu.

Catatan: jika muncul error `Class "DOMDocument" not found`, aktifkan ekstensi PHP XML/DOM terlebih dahulu, misalnya `php-xml`.
