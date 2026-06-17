<?php

namespace Database\Seeders;

use App\Models\faq;
use App\Models\User;
use App\Models\Admin;
use App\Models\layanan;
use App\Models\Artikel;
use App\Models\jadwal;
use App\Models\Role as CustomRole;
use App\Models\standar;
use App\Models\maklumat;
use App\Models\petugas;
use App\Models\Infografis;
use App\Models\konsultan;
use App\Models\SubjekMateri;
use App\Models\SurveiLayanan;
use App\Models\BidangKeahlian;
use App\Models\FooterItem;
use App\Models\JamOperasional;
use App\Models\PetugasBerprestasi;
use App\Models\WilayahBps;
use App\Models\PengaturanPresensi;
use App\Models\VideoPembelajaran;
use App\Models\konsultasiKlik;
use App\Models\KuisReguler\KuisReguler;
use App\Models\KuisReguler\SoalKuisReguler;
use App\Models\TantanganBulanan\Periode;
use App\Models\TantanganBulanan\KuisTantanganBulanan;
use App\Models\TantanganBulanan\SoalTantanganBulanan;
use App\Models\InformasiMagang;
use App\Models\InformasiRiset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as SpatieRole;

class ComprehensiveSeeder extends Seeder
{
    public function run(): void
    {
        // ============= WILAYAH BPS =============
        $wilayah = WilayahBps::firstOrCreate(
            ['kode_wilayah' => '1900000'],
            ['nama_wilayah' => 'Provinsi Kepulauan Bangka Belitung', 'tingkat_wilayah' => 'Provinsi']
        );
        WilayahBps::firstOrCreate(
            ['kode_wilayah' => '1971000'],
            ['nama_wilayah' => 'Kota Pangkalpinang', 'tingkat_wilayah' => 'Kota']
        );
        WilayahBps::firstOrCreate(
            ['kode_wilayah' => '1972000'],
            ['nama_wilayah' => 'Kabupaten Bangka', 'tingkat_wilayah' => 'Kabupaten']
        );

        // ============= SPATIE ROLES (admin guard) =============
        $roleNames = ['admin', 'operator', 'operator magang', 'operator kepegawaian'];
        foreach ($roleNames as $roleName) {
            SpatieRole::firstOrCreate(['name' => $roleName, 'guard_name' => 'admin']);
        }

        // ============= CUSTOM ROLES (user guard) =============
        $roleUser = CustomRole::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $roleKonsultan = CustomRole::firstOrCreate(['name' => 'konsultan', 'guard_name' => 'web']);

        // ============= ADMIN ACCOUNTS =============
        $accounts = [
            ['nama' => 'Admin', 'email' => 'admin@example.com', 'username' => 'admin', 'role' => 'admin', 'password' => 'password'],
            ['nama' => 'Operator Konten Edukasi', 'email' => 'operator@example.com', 'username' => 'operator', 'role' => 'operator', 'password' => 'password'],
            ['nama' => 'Operator Magang', 'email' => 'operator.magang@example.com', 'username' => 'operator_magang', 'role' => 'operator magang', 'password' => 'password'],
            ['nama' => 'Operator Kepegawaian', 'email' => 'operator.kepegawaian@example.com', 'username' => 'operator_kepegawaian', 'role' => 'operator kepegawaian', 'password' => 'password'],
        ];
        foreach ($accounts as $account) {
            $admin = Admin::updateOrCreate(
                ['email' => $account['email']],
                ['nama' => $account['nama'], 'username' => $account['username'], 'password' => Hash::make($account['password']), 'wilayah_bps_id' => $wilayah->id]
            );
            $admin->syncRoles($account['role']);
        }

        // ============= USERS =============
        $users = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@example.com', 'no_hp' => '6281234567890', 'password' => 'password'],
            ['nama' => 'Ani Lestari', 'email' => 'ani@example.com', 'no_hp' => '6281234567891', 'password' => 'password'],
            ['nama' => 'Rizki Pratama', 'email' => 'rizki@example.com', 'no_hp' => '6281234567892', 'password' => 'password'],
        ];
        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                ['nama' => $u['nama'], 'no_hp' => $u['no_hp'], 'password' => Hash::make($u['password']), 'role_id' => $roleUser->id]
            );
        }

        // ============= KONSULTAN =============
        $konsultans = [
            ['nama' => 'Dr. Ahmad Fauzi', 'email' => 'ahmad@example.com', 'posisi' => 'Statistisi Ahli', 'status' => 'tersedia'],
            ['nama' => 'Siti Nurhaliza, M.Stat', 'email' => 'siti@example.com', 'posisi' => 'Statistisi Muda', 'status' => 'tersedia'],
            ['nama' => 'Rudi Hermawan', 'email' => 'rudi@example.com', 'posisi' => 'Analis Data', 'status' => 'tidak tersedia', 'alasan' => 'Cuti'],
        ];
        foreach ($konsultans as $k) {
            konsultan::updateOrCreate(
                ['email' => $k['email']],
                ['nama' => $k['nama'], 'posisi' => $k['posisi'], 'status' => $k['status'], 'password' => Hash::make('password')]
            );
        }

        // ============= FAQ =============
        if (faq::count() === 0) {
            $faqs = [
                ['judul' => 'Bagaimana cara mendaftar konsultasi statistik?', 'deskripsi' => 'Anda dapat mendaftar melalui website Datapedia dengan login menggunakan nomor HP yang terdaftar. Setelah login, pilih menu Konsultasi dan isi form yang tersedia.'],
                ['judul' => 'Apakah layanan ini gratis?', 'deskripsi' => 'Ya, layanan konsultasi statistik dasar gratis untuk masyarakat umum. Untuk layanan tertentu seperti produk statistik berbayar, dikenakan biaya sesuai ketentuan.'],
                ['judul' => 'Bagaimana cara mendaftar magang?', 'deskripsi' => 'Buka halaman Program Magang, pilih periode yang sedang dibuka, lalu klik Daftar Magang. Upload CV, surat permohonan, dan dokumen pendukung lainnya.'],
                ['judul' => 'Apa itu kuis tantangan bulanan?', 'deskripsi' => 'Kuis tantangan bulanan adalah kompetisi kuis statistik yang diadakan setiap bulan. Peserta dengan skor tertinggi akan masuk leaderboard dan mendapatkan sertifikat.'],
                ['judul' => 'Kapan jam operasional layanan?', 'deskripsi' => 'Layanan buka setiap hari Senin-Jumat pukul 08:00-16:00 WIB. Untuk layanan online 24 jam tersedia melalui website dan WhatsApp.'],
            ];
            foreach ($faqs as $f) {
                faq::create($f);
            }
        }

        // ============= LAYANAN 24 JAM =============
        if (layanan::count() === 0) {
            $layananData = [
                ['judul' => 'Konsultasi Statistik', 'deskripsi' => 'Layanan konsultasi tatap muka dan online untuk kebutuhan data statistik Anda.', 'link' => '#konsultasi', 'gambar' => 'layanan/konsultasi.png'],
                ['judul' => 'Perpustakaan Digital', 'deskripsi' => 'Akses koleksi buku dan publikasi statistik secara digital.', 'link' => '#perpustakaan', 'gambar' => 'layanan/perpustakaan.png'],
                ['judul' => 'Pojok Statistik', 'deskripsi' => 'Ruang belajar statistik yang nyaman dan dilengkapi fasilitas pendukung.', 'link' => '#pojok-statistik', 'gambar' => 'layanan/pojok.png'],
            ];
            foreach ($layananData as $l) {
                layanan::create($l);
            }
        }

        // ============= MAKLUMAT =============
        if (maklumat::count() === 0) {
            maklumat::create(['judul' => 'Maklumat Pelayanan', 'file' => 'maklumat/maklumat-pelayanan.pdf']);
        }

        // ============= STANDAR =============
        if (standar::count() === 0) {
            $standars = [
                ['judul' => 'Waktu Penyelesaian', 'gambar' => 'standar/waktu.png'],
                ['judul' => 'Biaya Layanan', 'gambar' => 'standar/biaya.png'],
                ['judul' => 'Sarana Pengaduan', 'gambar' => 'standar/pengaduan.png'],
            ];
            foreach ($standars as $s) {
                standar::create($s);
            }
        }

        // ============= JAM OPERASIONAL =============
        if (JamOperasional::count() === 0) {
            $jams = [
                ['keterangan_hari' => 'Senin - Kamis', 'jam_mulai' => '08:00', 'jam_selesai' => '16:00'],
                ['keterangan_hari' => 'Jumat', 'jam_mulai' => '08:00', 'jam_selesai' => '16:30'],
                ['keterangan_hari' => 'Sabtu - Minggu', 'jam_mulai' => '00:00', 'jam_selesai' => '00:00'],
            ];
            foreach ($jams as $j) {
                JamOperasional::create($j);
            }
        }

        // ============= BIDANG KEAHLIAN =============
        if (BidangKeahlian::count() === 0) {
            $bidangs = [
                ['nama_bidang' => 'Statistik Sosial', 'status' => 'aktif'],
                ['nama_bidang' => 'Statistik Ekonomi', 'status' => 'aktif'],
                ['nama_bidang' => 'Statistik Produksi', 'status' => 'aktif'],
                ['nama_bidang' => 'Data Science', 'status' => 'aktif'],
                ['nama_bidang' => 'Sensus dan Survei', 'status' => 'aktif'],
            ];
            foreach ($bidangs as $b) {
                BidangKeahlian::create($b);
            }
        }

        // ============= INFORMASI MAGANG =============
        if (InformasiMagang::count() === 0) {
            InformasiMagang::create([
                'deskripsi' => 'Informasi magang ini memberikan gambaran program magang dan persyaratan yang dibutuhkan.',
                'persyaratan' => 'Calon peserta harus berstatus mahasiswa atau fresh graduate dan memiliki motivasi tinggi.',
                'benefit' => 'Peserta akan mendapatkan pengalaman kerja, sertifikat, dan referensi dari program.',
                'info_kontak' => 'Hubungi tim magang melalui email magang@example.com atau telepon 021-1234567.',
                'status' => 'aktif',
            ]);
        }

        // ============= INFORMASI RISET =============
        if (InformasiRiset::count() === 0) {
            InformasiRiset::create([
                'judul' => 'Kolaborasi Riset Mandiri',
                'deskripsi' => 'Informasi riset ini menjelaskan peluang kolaborasi riset dengan institusi kami.',
                'persyaratan' => 'Tim riset harus memiliki proposal yang jelas dan relevan dengan bidang statistik atau data.',
                'benefit' => 'Kolaborasi riset akan memberikan akses data, bimbingan, dan publikasi bersama.',
                'info_kontak' => 'Hubungi tim riset melalui email riset@example.com atau telepon 021-7654321.',
                'status' => 'aktif',
            ]);
        }

        // ============= SUBJEK MATERI =============
        if (SubjekMateri::count() === 0) {
            $subjeks = [
                ['slug' => 'statistik-dasar', 'judul' => 'Statistik Dasar', 'deskripsi' => 'Pengenalan konsep dasar statistik untuk pemula', 'gambar' => 'subjek/statistik-dasar.png'],
                ['slug' => 'statistik-inferensial', 'judul' => 'Statistik Inferensial', 'deskripsi' => 'Metode analisis data dengan pendekatan inferensial', 'gambar' => 'subjek/statistik-inferensial.png'],
                ['slug' => 'analisis-regresi', 'judul' => 'Analisis Regresi', 'deskripsi' => 'Teknik analisis hubungan antar variabel', 'gambar' => 'subjek/regresi.png'],
            ];
            foreach ($subjeks as $s) {
                SubjekMateri::create($s);
            }
        }

        // ============= FOOTER ITEM =============
        if (FooterItem::count() === 0) {
            $footers = [
                ['section' => 'tentang', 'title' => 'Tentang BPS', 'url' => 'https://bps.go.id', 'is_active' => true],
                ['section' => 'tentang', 'title' => 'Kebijakan Privasi', 'url' => '#privacy', 'is_active' => true],
                ['section' => 'tentang', 'title' => 'Syarat & Ketentuan', 'url' => '#terms', 'is_active' => true],
            ];
            foreach ($footers as $f) {
                FooterItem::create($f);
            }
        }

        // ============= SURVEI LAYANAN =============
        if (SurveiLayanan::count() === 0) {
            SurveiLayanan::create(['tahun' => 2026, 'link' => 'https://forms.google.com/survei-layanan-2026', 'is_active' => true]);
        }

        // ============= PETUGAS =============
        $konsultanTersedia = konsultan::where('status', 'tersedia')->first();
        if ($konsultanTersedia && petugas::count() === 0) {
            petugas::create(['konsultan_id' => $konsultanTersedia->id, 'tanggal' => now()->toDateString()]);
        }

        // ============= PETUGAS BERPRESTASI =============
        if (PetugasBerprestasi::count() === 0 && $konsultanTersedia) {
            PetugasBerprestasi::create(['konsultan_id' => $konsultanTersedia->id, 'triwulan' => 1, 'tahun' => 2026, 'nilai' => 95]);
        }

        // ============= PENGATURAN PRESENSI =============
        if (PengaturanPresensi::count() === 0) {
            PengaturanPresensi::create([
                'wilayah_bps_id' => $wilayah->id,
                'lat_kantor' => null, 'long_kantor' => null, 'radius_kantor' => 100,
                'jam_masuk_mulai' => '08:00:00', 'jam_masuk_selesai' => '09:00:00',
                'jam_pulang_mulai' => '17:00:00', 'toleransi_telat' => 0, 'is_active' => false,
            ]);
        }

        // ============= KONSULTASI KLIK (DATA STATISTIK) =============
        if (konsultasiKlik::count() === 0 && User::first()) {
            $user = User::first();
            $posisis = ['pelajar_mahasiswa', 'asn', 'karyawan_swasta', 'peneliti', 'wiraswasta'];
            $instansis = ['Universitas Bangka Belitung', 'Dinas Pendidikan', 'BPS', 'Lembaga Riset', 'Swasta'];
            for ($m = 1; $m <= 6; $m++) {
                $count = rand(1, 5);
                for ($j = 0; $j < $count; $j++) {
                    konsultasiKlik::create([
                        'users_id' => $user->id,
                        'clicked_at' => "2026-{$m}-" . rand(1, 28),
                        'data_diminta' => 'Data Statistik',
                        'posisi' => $posisis[array_rand($posisis)],
                        'instansi' => $instansis[array_rand($instansis)],
                        'keperluan_data' => 'Penelitian',
                        'memiliki_akun' => 'ya',
                    ]);
                }
            }
        }

        echo "\n✅ ComprehensiveSeeder selesai!\n";
    }
}