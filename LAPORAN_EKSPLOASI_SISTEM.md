# LAPORAN EKSPLOASI SISTEM: Datapedia + Student Corner

## 1. IDENTITAS SISTEM

| Atribut | Nilai |
|---------|-------|
| **Nama** | Datapedia + Student Corner Integrated Platform |
| **Framework** | Laravel 12 (PHP ^8.2) |
| **Template** | Blade |
| **CSS** | Tailwind CSS 3.4.17 + DaisyUI 5.0.35 + Custom Design System |
| **Build Tool** | Vite 6.2.4 |
| **JS** | AlpineJS 3.4.2 (Breeze only) + Vanilla JS |
| **Database** | MySQL (Laravel Eloquent) |
| **Auth** | Laravel Breeze (customized) + Spatie Permission |
| **Chart** | Chart.js 4.5.0 |
| **WYSIWYG** | TinyMCE 8.3.1 (lokal) |
| **Excel** | Maatwebsite Excel / PhpSpreadsheet |
| **PDF** | Barryvdh Laravel DomPDF |
| **RBAC** | Spatie Laravel Permission 6.17 |
| **AI/NLP** | OpenAI SDK + SastrawiJS |

---

## 2. TUJUAN SISTEM

Platform layanan digital statistik terpadu yang berfungsi sebagai:
- **Knowledge & Service Hub** untuk edukasi dan pelayanan statistik
- Pusat konsultasi statistik (online/offline) dengan penjadwalan
- Pusat pembelajaran statistik digital melalui artikel, video, infografis
- Manajemen program magang mahasiswa secara digital
- Manajemen program riset kolaboratif
- Gamifikasi pembelajaran melalui kuis dan tantangan bulanan
- Alat bantu statistik interaktif (kalkulator, simulasi, visualisasi data)
- Kanal informasi publik (FAQ, maklumat, survei kepuasan)

**Integrasi terbaru:** Student Corner telah digabungkan ke dalam Datapedia sebagai satu sistem dengan login tunggal, menggunakan satu database.

---

## 3. ARSITEKTUR AUTHENTICATION & AUTHORIZATION

### 3.1 Multi-Guard System
Sistem memiliki **3 guard** autentikasi yang berbeda:

| Guard | Model | Tabel | Mechanism | Keterangan |
|-------|-------|-------|-----------|------------|
| `web` | `User` | `users` | Laravel Auth | User publik / mahasiswa |
| `admin` | `Admin` | `admins` | Laravel Auth + Spatie | Admin dengan role-based access |
| `konsultan` | `konsultan` | `konsultans` | Session-based (legacy) | Login konsultan via session |

### 3.2 Role-Based Access Control (RBAC)

**Admin Roles (Spatie Permission):**
| Role | Akses Modul |
|------|-------------|
| `admin` | Semua modul |
| `operator` | Konten edukasi + kuis |
| `operator magang` | Program magang + presensi |
| `operator kepegawaian` | Program magang + presensi + wilayah BPS |

**User Roles (custom `roles` table):**
- Role terhubung ke `users` via `role_id`
- Terpisah dari Spatie roles untuk menghindari konflik guard

### 3.3 Middleware Custom
| Middleware | Fungsi |
|------------|--------|
| `Authenticate` | Redirect ke login admin/user berdasarkan prefix URL |
| `CheckAdminRole` | Cek role admin menggunakan Spatie Permission |
| `LoggedInAdmin` | Cek auth guard `admin` |
| `LoggedInKonsultan` | Cek session `login_konsultan` |
| `LoggedInUser` | Cek auth guard `web` |
| `LoginCheckAdmin` | Cek session `loginStatus` (legacy) |
| `LoginCheckUser` | Cek session `login_user` dan `user_id` (legacy) |
| `SessionTimeout` | Timeout session 12 jam (43200 detik) |
| `DetectMobileWebview` | Deteksi parameter `mobile` di request |

---

## 4. STRUKTUR DATABASE

### 4.1 Tabel Utama (80+ Migration)

| Domain | Tabel | Jumlah |
|--------|-------|--------|
| **Autentikasi** | `users`, `admins`, `konsultans`, `roles`, `sessions` | 5 |
| **Spatie Permission** | `permissions`, `roles` (spatie), `model_has_permissions`, `model_has_roles`, `role_has_permissions` | 5 |
| **Konten Edukasi** | `subjek_materis`, `artikels`, `sub_judul_artikels`, `detail_sub_judul_artikels`, `video_pembelajarans`, `infografis`, `artikel_dibacas`, `video_dilihats`, `infografis_dilihats` | 9 |
| **Kuis Reguler** | `kuis_regulers`, `soal_kuis_regulers`, `opsi_soal_kuis_regulers`, `hasil_kuis_regulers`, `jawaban_kuis_regulers` | 5 |
| **Kuis Tantangan Bulanan** | `periodes`, `kuis_tantangan_bulanans`, `soal_kuis_tantangan_bulanans`, `opsi_soal_kuis_tantangan_bulanans`, `hasil_kuis_tantangan_bulanans`, `jawaban_tantangan_bulanans` | 6 |
| **Program Magang** | `informasi_magangs`, `pendaftaran_magangs`, `log_harian_magang_users`, `presensi_magangs`, `wilayah_bps`, `pengaturan_presensi` | 6 |
| **Program Riset** | `informasi_risets`, `pendaftaran_risets` | 2 |
| **Konsultasi** | `konsultasi_klik`, `janjitemu`, `jadwal` | 3 |
| **Kepegawaian** | `bidang_keahlians`, `bidang_keahlian_konsultan`, `petugas_harian`, `petugas_berprestasi`, `jam_operasionals` | 5 |
| **Statistik Layanan** | `layanan_perpustakaan`, `layanan_produk_statistik`, `layanan_konsultasi`, `layanan_rekomendasi`, `layanan_pojok_statistik`, `layanan_website` | 6 |
| **CMS/Website** | `layanans`, `faqs`, `maklumats`, `standars`, `footer_items`, `survei_layanan` | 6 |
| **Notifikasi & Audit** | `notifikasi_wa`, `audit_logs` | 2 |
| **System** | `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` | 5 |

### 4.2 Relasi Database Utama

```
users ──► roles (custom)
users ──► hasil_kuis_regulers ──► kuis_regulers
users ──► hasil_kuis_tantangan_bulanans ──► kuis_tantangan_bulanans ──► periodes
users ──► pendaftaran_magangs ──► log_harian_magang_users
users ──► pendaftaran_magangs ──► presensi_magangs
users ──► pendaftaran_risets
users ──► artikel_dibacas ──► artikels ──► subjek_materis
users ──► video_dilihats ──► video_pembelajarans ──► subjek_materis
users ──► infografis_dilihats ──► infografis ──► subjek_materis
users ──► janjitemu ──► jadwal ──► konsultans
users ──► konsultasi_klik

admins ──► wilayah_bps
admins ──► audit_logs

konsultans ──► bidang_keahlians (many-to-many via pivot)
konsultans ──► petugas_harian
konsultans ──► petugas_berprestasi
konsultans ──► jadwal

wilayah_bps ──► pengaturan_presensi
wilayah_bps ──► pendaftaran_magangs
```

---

## 5. MODUL-MODUL UTAMA DAN FUNGSINYA

### MODUL 1: KONSULTASI STATISTIK
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| Form Konsultasi | `konsultasiController` | `konsultasiKlik` | Record klik, redirect ke WhatsApp |
| Janji Temu | `janjitemuController` | `janjitemu` | CRUD janji temu user |
| Jadwal Admin | `jadwalController` | `jadwal` | Assign konsultan, approve, kirim Zoom, tolak |
| Konsultan | `konsultanController` | `konsultan` | CRUD konsultan, bidang keahlian, status |
| Status Konsultan | `konsultanStatusController` | `konsultan` | Update status (tersedia/tidak tersedia) |
| Jadwal Konsultan | `konsultanJadwalController` | `jadwal` | Lihat jadwal yang login |

### MODUL 2: KONTEN EDUKASI (Learning Management)
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| Subjek Materi | `Admin/SubjekMateriController` | `SubjekMateri` | CRUD kategori materi |
| Artikel | `Admin/ArtikelController` | `Artikel` | CRUD artikel dengan slug |
| Subjudul Artikel | `Admin/SubJudulArtikelController` | `SubJudulArtikel` | CRUD subjudul per artikel |
| Detail Subjudul | `Admin/DetailSubJudulArtikelController` | `DetailSubJudulArtikel` | CRUD konten per subjudul (text, embed, gambar) |
| Video | `Admin/VideoPembelajaranController` | `VideoPembelajaran` | CRUD video dengan embed link |
| Infografis | `Admin/InfografisController` | `Infografis` | CRUD infografis (gambar + file) |
| Tampil Publik | `KontenEdukasiController` | - | Menampilkan konten, tracking progres belajar |
| Progres Belajar | - | `ArtikelDibaca`, `VideoDilihat`, `InfografisDilihat` | Tracking user engagement |

### MODUL 3: PROGRAM MAGANG
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| Informasi Magang | `Admin/InformasiMagangController` | `InformasiMagang` | CRUD info magang |
| Pendaftaran | `Admin/PendaftaranMagangController` | `PendaftaranMagang` | CRUD pendaftaran, upload CV, surat, verifikasi status |
| Presensi | `PresensiMagangController` | `PresensiMagang` | GPS-based check-in/check-out, radius kantor, status terlambat |
| Log Harian | `LogHarianMagangController` | `LogHarianMagangUser` | CRUD log harian, verifikasi admin, export PDF |
| Pengaturan Presensi | `Admin/PengaturanPresensiController` | `PengaturanPresensi` | Atur koordinat kantor, radius, jam kerja per wilayah |
| Wilayah BPS | `Admin/WilayahBpsController` | `WilayahBps` | CRUD wilayah BPS |

### MODUL 4: PROGRAM RISET
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| Informasi Riset | `Admin/InformasiRisetController` | `InformasiRiset` | CRUD info riset |
| Pendaftaran | `Admin/PendaftaranRisetController` | `PendaftaranRiset` | CRUD pendaftaran, upload dokumen, verifikasi, sertifikat |

### MODUL 5: KUIS & GAMIFIKASI
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| Kuis Reguler | `Admin/KuisReguler/KuisRegulerController` | `KuisReguler` | CRUD kuis |
| Soal Kuis Reguler | `Admin/KuisReguler/SoalKuisRegulerController` | `SoalKuisReguler` | CRUD soal + opsi pilihan ganda, import Excel |
| Tantangan Bulanan | `Admin/KuisTantangan/TantanganBulananController` | `KuisTantanganBulanan` | CRUD tantangan dengan periode |
| Soal Tantangan | `Admin/KuisTantangan/SoalTantanganBulananController` | `SoalKuisTantanganBulanan` | CRUD soal tantangan, import Excel |
| Periode | `Admin/KuisTantangan/PeriodeController` | `Periode` | Kelola periode dan leaderboard |
| Quiz Engine Publik | `KuisDanTantanganController` | - | Kerjakan soal, timer, submit, skor, grade A-E, riwayat |

### MODUL 6: ALAT STATISTIK
| Komponen | Controller | Fungsi |
|----------|------------|--------|
| Kalkulator | Closure routes | Mean, median, modus, kombinasi, permutasi, standar deviasi, kuartil, odds, probabilitas, persentil, ukuran sampel |
| Visualisasi Data | `LineChartController`, `PieChartController`, `HistogramController`, `BoxPlotController`, `ScatterController` | Upload CSV/Excel → generate grafik interaktif |
| Simulasi Statistik | `SimulasiSlovinController`, `SamplingSimulationController`, `DistribusiNormalController` | Kalkulator Slovin, random sampling, Z-Score/CDF/PDF |

### MODUL 7: INFORMASI & SURVEI
| Komponen | Controller | Model | Fungsi |
|----------|------------|-------|--------|
| FAQ | `faqController` | `faq` | CRUD FAQ |
| Maklumat | `maklumatController` | `maklumat` | CRUD maklumat |
| Standar | `standarController` | `standar` | CRUD standar pelayanan |
| Layanan | `layananController` | `layanan` | CRUD layanan |
| Petugas Harian | `petugasController` | `petugas` | Jadwal petugas mingguan, export PDF |
| Petugas Berprestasi | `PetugasBerprestasiController` | `PetugasBerprestasi` | CRUD petugas berprestasi per triwulan |
| Survei Layanan | `Admin/SurveiLayananController` | `SurveiLayanan` | CRUD link survei per tahun |
| Footer | `Admin/FooterItemController` | `FooterItem` | CRUD footer items (link, PDF, image) |
| Jam Operasional | `JamOperasionalController` | `JamOperasional` | CRUD jam operasional |
| Bidang Keahlian | `BidangKeahlianController` | `BidangKeahlian` | CRUD bidang keahlian konsultan |

### MODUL 8: ADMIN & REPORTING
| Komponen | Controller | Fungsi |
|----------|------------|--------|
| Dashboard Admin | `Admin/AdminController` | Statistik, artikel populer, video populer, leaderboard |
| Dashboard Datapedia | `dashboardController` | Total count, grafik konsultasi bulanan per posisi |
| Statistik Layanan | `Statistik/*Controller` (6 controllers) | CRUD data statistik perpustakaan, produk, konsultasi, rekomendasi, pojok, website |
| Grafik Posisi | `grafikPosisiController` | Stacked bar konsultasi per posisi per bulan |
| Audit Log | `AuditLogService` | Mencatat semua aktivitas admin (CRUD, verify, login) |
| Data Admin | `Admin/AdminController` | CRUD admin dengan role assignment |

---

## 6. SERVICE LAYER & BUSINESS LOGIC

| Service | Fungsi |
|---------|--------|
| **AuditLogService** | Mencatat aktivitas admin: create, update, delete, verify, reject, login, logout. Simpan data before/after dalam JSON. |
| **ConsultationService** | Business logic konsultasi: record klik, create/cancel janji temu, schedule, reject, zoom link, conflict check, monthly stats. |
| **InternshipService** | Business logic magang: register, accept, reject, complete, upload certificate/report, daily log, verify log, check in/out. |
| **ResearchService** | Business logic riset: register, accept, reject, complete, upload report/certificate. |

---

## 7. FRONTEND ARCHITECTURE

### 7.1 Layout Utama
| Layout | Pengguna | Teknologi |
|--------|----------|-----------|
| `layouts/layout-web.blade.php` | Halaman publik/user | Tailwind + CDN (jQuery, SweetAlert2, Chart.js, Flowbite, AOS, Leaflet) |
| `admin/layout.blade.php` | Halaman admin | Custom CSS inline (modern, ringan) |
| `layouts/app.blade.php` | Auth Breeze | Tailwind + AlpineJS |
| `layouts/guest.blade.php` | Auth guest | Tailwind |

### 7.2 JavaScript Assets
| File | Fungsi |
|------|--------|
| `resources/js/app.js` | Entry point: navbar, smooth scroll, carousel, pagination, AOS, Chart.js, SweetAlert, aksesibilitas |
| `resources/js/user-page.js` | IntersectionObserver, counter, carousel, pagination, chatbot toggle, Chart.js |
| `resources/js/admin/dashboard.js` | Counter animation + stacked bar chart |
| `resources/js/admin/forms.js` | Client-side validation |

### 7.3 CSS Assets
| File | Fungsi |
|------|--------|
| `resources/css/app.css` | Tailwind + custom design system (glassmorphism, navy/blue colors) |
| `resources/css/user-page.css` | Style spesifik halaman user |
| `resources/css/admin/dashboard.css` | Style dashboard admin |

### 7.4 Key Frontend Features
- **Design System**: Glassmorphism, gradasi biru, animasi fade-in
- **Responsive**: Mobile-first, touch-friendly (input 16px mobile, button 44px+)
- **Accessibility**: ARIA labels, semantic HTML, keyboard navigation, kontras > 4.5:1
- **Charts**: Chart.js untuk dashboard dan visualisasi data
- **Maps**: Leaflet untuk presensi GPS
- **Animation**: AOS + IntersectionObserver + CSS transitions
- **Carousel**: SplideJS untuk slider
- **Form Validation**: Vanilla JS custom validation + Laravel server-side
- **WYSIWYG**: TinyMCE lokal untuk editor konten

---

## 8. ROUTING STRUCTURE

### 8.1 File Route
| File | Fungsi |
|------|--------|
| `routes/web.php` | Route utama Datapedia (konsultasi, admin, login, statistik) |
| `routes/student_corner.php` | Route publik modul Student Corner |
| `routes/student_corner_admin.php` | Route admin modul Student Corner (role-based) |
| `routes/auth.php` | Route autentikasi Laravel Breeze (default) |
| `routes/console.php` | Console commands |

### 8.2 Route Publik Student Corner (`student_corner.php`)
- `/konten-edukasi` — Index subjek materi
- `/konten-edukasi/{slug}` — Detail subjek
- `/konten-edukasi/{subjek_slug}/artikel/{slug}` — Artikel
- `/konten-edukasi/{subjek_slug}/video/{slug}` — Video
- `/infografis/{id}` — Infografis
- `/alat-statistik/*` — Kalkulator
- `/visualisasi-data/*` — Histogram, Scatter, Pie, Line, Box Plot
- `/simulasi-statistik/*` — Slovin, Sampling, Distribusi Normal
- `/kuis-dan-tantangan-bulanan` — Index kuis
- `/profil/{slug}` — Profil user (require auth)
- `/program-magang/*` — Magang, presensi, log harian (require auth)
- `/program-riset/*` — Riset (require auth)
- `/verify-otp` — Verifikasi OTP

### 8.3 Route Admin Student Corner (`student_corner_admin.php`)
Prefix: `admin/`
- `konten-edukasi/subjek-materi` — Subjek Materi
- `konten-edukasi/artikel` — Artikel
- `konten-edukasi/subjudul-artikel` — Subjudul (nested by id_artikel)
- `konten-edukasi/detail-subjudul-artikel` — Detail (nested by id_subjudul)
- `konten-edukasi/video-pembelajaran` — Video
- `konten-edukasi/infografis` — Infografis
- `program-magang/informasi-magang` — Info Magang
- `program-magang/pendaftaran-magang` — Pendaftaran Magang
- `program-riset/informasi-riset` — Info Riset
- `program-riset/pendaftaran-riset` — Pendaftaran Riset
- `kuis-dan-tantangan/kuis-reguler` — Kuis Reguler
- `kuis-dan-tantangan/soal-kuis-reguler` — Soal Kuis Reguler
- `kuis-dan-tantangan/periode` — Periode
- `kuis-dan-tantangan/kuis-tantangan-bulanan` — Tantangan Bulanan
- `kuis-dan-tantangan/soal-kuis-tantangan-bulanan` — Soal Tantangan
- `data-admin` — Admin Management (role:admin only)
- `pengaturan-presensi` — Pengaturan Presensi
- `wilayah-bps` — Wilayah BPS

---

## 9. TEMUAN TEKNIS & TECHNICAL DEBT

### 9.1 Legacy & Dual System Issues
1. **Dual User Model**: Ada `User` (platform utama) dan `akunuser` (jalur konsultasi legacy). Perlu disatukan.
2. **Dual Login System**: Route Breeze (`auth.php`) masih ada tapi di-comment di `web.php`. Login user menggunakan `UserLogin` custom, bukan Breeze.
3. **Dual Role System**: Custom `roles` table untuk user guard dan Spatie Permission untuk admin guard. Migration custom `roles` memiliki check `if (!Schema::hasTable('roles'))` agar tidak bentrok dengan Spatie.
4. **Legacy Session**: Konsultan masih menggunakan session-based auth (`login_konsultan`), bukan Laravel guard.

### 9.2 Naming Convention Issues
- Campuran singular/plural (e.g., `artikels` vs `faq` vs `standars`)
- Campuran Bahasa Indonesia dan Inggris (e.g., `janjitemu` vs `Artikel` vs `VideoPembelajaran`)
- Duplikasi kolom: `konsultans` memiliki `gambar` dan `image` yang mungkin duplikat
- Legacy naming: `users_id` vs `user_id`, `id_artikel` vs `artikel_id`

### 9.3 Database Evolution
- **Konsultan Table**: Kolom `no_hp` ditambah lalu dihapus, `gambar`/`image` duplikat, `keahlian`/`alasan`/`tanggal_tidak_tersedia` ditambah lalu di-drop.
- **Janjitemu**: Kolom `alamat` dan `keperluan` dihapus, digantikan `instansi_lembaga`, `keperluan_data`, `data_diminta`, `jumlah_orang`, `layanan_dibutuhkan`.
- **Konsultasi Klik**: Awalnya hanya `users_id` + `clicked_at`, lalu ditambah form fields, lalu direstruktur.
- **Merge Migration**: `merge_student_corner_columns` menambahkan kolom OTP dan identitas ke `users` dan `admins`.

### 9.4 Architecture Concerns
- **Logic di Controller**: Banyak controller memiliki business logic yang berat. Direkomendasikan memindahkan ke service layer atau repository pattern.
- **No API Routes**: Tidak ada `routes/api.php` — semua route berbasis web/server-side rendering.
- **No Livewire**: Tidak ada reactive component framework — semua interaksi via vanilla JS atau page reload.
- **AdminLTE Unused**: AdminLTE masih ada di `public/template/` tapi layout admin aktif tidak menggunakannya.

### 9.5 Security Concerns
- **Geolocation Data**: Presensi menyimpan koordinat GPS lengkap di database (`lat_masuk`, `long_masuk`, `lat_pulang`, `long_pulang`).
- **WhatsApp Integration**: Notifikasi via WhatsApp menggunakan tabel `notifikasi_wa` (pending/sent), bukan API gateway resmi.
- **OTP Custom**: Verifikasi email menggunakan OTP custom, bukan Laravel default email verification.

---

## 10. REKOMENDASI PENGEMBANGAN

### 10.1 Immediate (Stabilisasi)
1. **Standarisasi Naming**: Gunakan konvensi Bahasa Inggris yang konsisten (e.g., `articles` bukan `artikels`, `appointments` bukan `janjitemu`).
2. **Hapus Legacy**: Bersihkan model `akunuser`, controller login legacy, dan middleware session-based yang tidak perlu.
3. **Unifikasi Auth**: Gunakan satu sistem autentikasi Laravel (Breeze atau Fortify) untuk semua guard.
4. **Hapus AdminLTE**: Hapus folder `public/template/` jika tidak digunakan untuk mengurangi ukuran deploy.

### 10.2 Short-term (Operasional)
1. **Notification Center**: Implementasi notifikasi in-app (database-driven) selain WhatsApp.
2. **Status Timeline**: Tambahkan timeline/status log untuk pendaftaran magang/riset (mirip ecommerce order tracking).
3. **Export Enhancements**: Tambahkan export Excel untuk semua modul admin (saat ini hanya PDF untuk log harian).
4. **Filter Lanjutan**: Tambahkan filter, sorting, dan search di semua halaman index admin.

### 10.3 Medium-term (Learning)
1. **Learning Path**: Buat learning path yang menghubungkan subjek materi secara berurutan.
2. **User Dashboard**: Dashboard personal user yang menampilkan progres belajar, kuis yang dikerjakan, dan sertifikat.
3. **Recommendation Engine**: Gunakan `sastrawijs` untuk rekomendasi konten berdasarkan subjek yang sering dibaca.
4. **Leaderboard Expansion**: Leaderboard untuk kuis reguler (bukan hanya tantangan bulanan).

### 10.4 Long-term (Platform)
1. **API Publik**: Buat REST API untuk mobile app atau integrasi pihak ketiga.
2. **Mobile App**: Pertimbangkan PWA (Progressive Web App) atau native app.
3. **SSO Integration**: Integrasi dengan SSO instansi (LDAP, SAML, OAuth).
4. **AI Assistant**: Gunakan `openai` package untuk asisten statistik yang bisa menjawab pertanyaan dan membantu analisis data.
5. **LMS Ringan**: Tambahkan fitur LMS seperti quiz timer, progress tracking, dan sertifikat otomatis.

---

## 11. FILE-FILE PENTING UNTUK DIKETAHUI

| File | Lokasi | Fungsi |
|------|--------|--------|
| `.env` | Root | Konfigurasi environment (database, app key, debug) |
| `.env.cpanel` | Root | Konfigurasi untuk deployment cPanel |
| `composer.json` | Root | Dependensi PHP |
| `package.json` | Root | Dependensi JS/Node |
| `tailwind.config.js` | Root | Konfigurasi Tailwind CSS |
| `vite.config.mjs` | Root | Konfigurasi Vite build |
| `config/auth.php` | Config | Multi-guard configuration |
| `config/permission.php` | Config | Spatie Permission config |
| `config/excel.php` | Config | Maatwebsite Excel config |
| `app/Providers/AppServiceProvider.php` | App | Global view composers, Carbon locale |
| `app/Http/Kernel.php` | App | Middleware registration (pastikan ada) |
| `database/seeders/ComprehensiveSeeder.php` | Database | Seeder utama untuk data awal |

---

*Laporan ini disusun berdasarkan eksplorasi menyeluruh terhadap codebase Datapedia + Student Corner.*
*Dibuat: Juni 2025*
