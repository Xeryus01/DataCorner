# PRODUCT REQUIREMENTS DOCUMENT (PRD)
# Datapedia + Student Corner (Integrated Platform)

## 1. Executive Summary

Datapedia merupakan platform layanan data, konsultasi statistik, edukasi statistik, program magang, program riset, kuis edukatif, simulasi statistik, dan pengelolaan konten yang terintegrasi dalam satu sistem berbasis web.

Integrasi Student Corner menjadikan platform ini sebagai pusat pembelajaran statistik dan layanan pengguna yang dikelola oleh BPS.

Dokumen ini disusun sebagai dasar pengembangan, refactoring, modernisasi arsitektur, peningkatan UX/UI, serta roadmap pengembangan jangka panjang.

---

# 2. Product Vision

Menyediakan ekosistem digital terpadu untuk:

- Layanan konsultasi statistik.
- Edukasi statistik digital.
- Program magang mahasiswa.
- Program riset kolaboratif.
- Kuis dan gamifikasi pembelajaran.
- Simulasi statistik interaktif.
- Manajemen konten dan administrasi.

---

# 3. Tujuan Bisnis

## Tujuan Utama

1. Meningkatkan literasi statistik.
2. Mempermudah akses layanan konsultasi.
3. Digitalisasi program magang dan riset.
4. Menyediakan media pembelajaran modern.
5. Menjadi pusat knowledge management statistik.

## KPI Utama

- Jumlah pengguna terdaftar.
- Jumlah artikel dibaca.
- Jumlah video ditonton.
- Jumlah peserta kuis.
- Jumlah pendaftar magang.
- Jumlah pendaftar riset.
- Tingkat kepuasan layanan.
- Jumlah konsultasi berhasil.

---

# 4. User Persona

## Pengunjung Umum

Kebutuhan:
- Membaca artikel.
- Menonton video.
- Melihat infografis.
- Mengakses informasi magang dan riset.

## Mahasiswa

Kebutuhan:
- Mendaftar magang.
- Mendaftar riset.
- Mengikuti kuis.
- Mengelola profil.

## Peneliti

Kebutuhan:
- Mengakses materi.
- Mengajukan riset.
- Mendapatkan referensi statistik.

## Konsultan Statistik

Kebutuhan:
- Mengelola jadwal.
- Menangani konsultasi.
- Melihat riwayat konsultasi.

## Administrator

Kebutuhan:
- Mengelola seluruh modul.
- Monitoring aktivitas.
- Pengelolaan konten.

---

# 5. Scope Produk

## Modul Existing

### A. Home & Informasi

Fitur:
- Landing page.
- Statistik layanan.
- Informasi layanan.
- FAQ.
- Maklumat layanan.
- Profil instansi.
- Tentang aplikasi.

### B. Manajemen User

Fitur:
- Registrasi.
- Login.
- Logout.
- Reset password.
- Verifikasi email OTP.
- Edit profil.
- Riwayat aktivitas.

### C. Konsultasi Statistik

Fitur:
- Pengajuan konsultasi.
- Pemilihan konsultan.
- Jadwal konsultasi.
- Monitoring status.
- Janji temu.
- Riwayat konsultasi.

### D. Dashboard Admin

Fitur:
- Dashboard statistik.
- Manajemen pengguna.
- Manajemen admin.
- Manajemen konsultan.

---

# 6. Modul Edukasi Statistik

## Artikel

Fitur:

- CRUD Artikel
- Kategori/Subjek Materi
- Subjudul Artikel
- Detail Subjudul
- Tracking pembacaan

Data Utama:

- Judul
- Slug
- Ringkasan
- Thumbnail
- Isi Artikel
- Status Publish

## Video Pembelajaran

Fitur:

- CRUD Video
- Embed Youtube
- Tracking viewer

## Infografis

Fitur:

- CRUD Infografis
- Kategori
- Download file

---

# 7. Modul Program Magang

## Informasi Magang

Fitur:

- Pengumuman program
- Status aktif/nonaktif
- Persyaratan
- Timeline

## Pendaftaran Magang

Fitur:

- Form pendaftaran
- Upload dokumen
- Seleksi administrasi
- Status diterima/ditolak

Status:

- Draft
- Menunggu Verifikasi
- Diterima
- Ditolak
- Selesai

## Log Harian Magang

Fitur:

- Input aktivitas harian
- Upload bukti
- Review pembimbing
- Revisi log

## Presensi Magang

Fitur:

- Presensi masuk
- Presensi pulang
- Riwayat presensi
- Pengaturan presensi

## Sertifikat Magang

Fitur:

- Upload sertifikat
- Download sertifikat

---

# 8. Modul Program Riset

## Informasi Riset

Fitur:

- Informasi program
- Persyaratan
- Jadwal

## Pendaftaran Riset

Fitur:

- Pengajuan riset
- Upload proposal
- Upload laporan
- Verifikasi admin

Status:

- Menunggu
- Diterima
- Ditolak
- Selesai

## Sertifikat Riset

Fitur:

- Upload sertifikat
- Download sertifikat

---

# 9. Modul Kuis dan Tantangan Bulanan

## Kuis Reguler

Fitur:

- Bank soal
- Kategori kuis
- Penilaian otomatis
- Riwayat pengerjaan

## Tantangan Bulanan

Fitur:

- Periode aktif
- Leaderboard
- Ranking peserta
- Penilaian otomatis

## Data Utama

- Soal
- Pilihan jawaban
- Kunci jawaban
- Skor
- Waktu pengerjaan

---

# 10. Modul Simulasi Statistik

Fitur Existing:

- Random Sampling
- Slovin Calculator
- Distribusi Normal

Roadmap:

- Regresi Linear
- Uji Hipotesis
- Korelasi
- ANOVA
- Time Series

---

# 11. Modul Visualisasi Data

Fitur Existing:

- Scatter Plot
- Pie Chart
- Line Chart
- Boxplot

Flow:

Upload Dataset
→ Validasi
→ Generate Grafik
→ Download Hasil

---

# 12. Modul Survei Kepuasan

Fitur:

- Form survei
- Rating layanan
- Kritik dan saran
- Dashboard hasil

---

# 13. Hak Akses Sistem

## Super Admin

Akses penuh.

## Admin

- Kelola konten
- Kelola user
- Kelola magang
- Kelola riset

## Operator Edukasi

- Artikel
- Video
- Infografis

## Operator Magang

- Seleksi magang
- Presensi
- Sertifikat

## Konsultan

- Jadwal
- Status konsultasi

## User

- Konsultasi
- Magang
- Riset
- Kuis

---

# 14. Non Functional Requirements

## Performance

- Response < 3 detik
- PageSpeed > 80

## Security

- CSRF Protection
- Rate Limiting
- Audit Log
- Role Based Access Control
- Encrypted Password

## Scalability

- Redis Cache
- Queue Worker
- File Storage Abstraction

## Availability

- Uptime 99.5%

---

# 15. Integrasi yang Direkomendasikan

## Prioritas Tinggi

- SSO BPS
- Email Notification
- WhatsApp Notification
- Google Analytics

## Prioritas Menengah

- E-Certificate Generator
- OCR Dokumen
- AI Chat Assistant Statistik

---

# 16. Roadmap Pengembangan

## Fase 1

- Refactor UI/UX
- Audit Database
- Audit Role Permission
- Responsive Mobile

## Fase 2

- Notification Center
- Dashboard Personal User
- Advanced Analytics

## Fase 3

- Mobile App
- AI Recommendation Engine
- AI Learning Assistant

## Fase 4

- Learning Management System (LMS)
- Open Data API
- Public Developer API

---

# 17. Technical Debt yang Perlu Dibenahi

1. Standardisasi naming route.
2. Standardisasi role dan permission.
3. Audit duplicate controller.
4. Service layer architecture.
5. Repository pattern.
6. API versioning.
7. Test coverage.
8. Logging terpusat.
9. Monitoring dan observability.
10. Modular architecture.

---

# 18. Success Criteria

Sistem menjadi platform terpadu layanan statistik, edukasi, magang, riset, dan konsultasi yang:
- mudah digunakan,
- scalable,
- aman,
- maintainable,
- siap dikembangkan dalam 3–5 tahun ke depan.
