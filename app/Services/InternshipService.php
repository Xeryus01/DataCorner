<?php

namespace App\Services;

use App\Models\PendaftaranMagang;
use App\Models\InformasiMagang;
use App\Models\LogHarianMagangUser;
use App\Models\PresensiMagang;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Service layer untuk domain Program Magang.
 */
class InternshipService
{
    /**
     * Mendaftar magang oleh user.
     */
    public function register(array $data, int $userId): PendaftaranMagang
    {
        $pendaftaran = new PendaftaranMagang();
        $pendaftaran->user_id = $userId;
        $pendaftaran->informasi_magang_id = $data['informasi_magang_id'];
        $pendaftaran->nama_lengkap = $data['nama_lengkap'];
        $pendaftaran->email = $data['email'] ?? null;
        $pendaftaran->no_hp = $data['no_hp'] ?? null;
        $pendaftaran->universitas = $data['universitas'] ?? null;
        $pendaftaran->jurusan = $data['jurusan'] ?? null;
        $pendaftaran->semester = $data['semester'] ?? null;
        $pendaftaran->alasan = $data['alasan'] ?? null;
        $pendaftaran->status = 'diproses';

        // Upload dokumen wajib
        if (isset($data['cv'])) {
            $pendaftaran->cv = $data['cv']->store('pendaftaran-magang/cv', 'public');
        }
        if (isset($data['surat_permohonan'])) {
            $pendaftaran->surat_permohonan = $data['surat_permohonan']->store('pendaftaran-magang/permohonan', 'public');
        }

        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Verifikasi pendaftaran magang (diterima) oleh admin.
     */
    public function accept(int $pendaftaranId): PendaftaranMagang
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaranId);
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Verifikasi pendaftaran magang (ditolak) oleh admin.
     */
    public function reject(int $pendaftaranId): PendaftaranMagang
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaranId);
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Menyelesaikan pendaftaran magang.
     */
    public function complete(int $pendaftaranId): PendaftaranMagang
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaranId);
        $pendaftaran->status = 'selesai';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Upload sertifikat magang oleh admin.
     */
    public function uploadCertificate(int $pendaftaranId, $file): PendaftaranMagang
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaranId);
        $pendaftaran->sertifikat = $file->store('pendaftaran-magang/sertifikat', 'public');
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Upload laporan magang oleh peserta.
     */
    public function uploadReport(int $pendaftaranId, $file): PendaftaranMagang
    {
        $pendaftaran = PendaftaranMagang::findOrFail($pendaftaranId);
        $pendaftaran->laporan_magang = $file->store('pendaftaran-magang/laporan', 'public');
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Membuat log harian baru oleh peserta magang.
     */
    public function createDailyLog(array $data, int $pendaftaranId): LogHarianMagangUser
    {
        return LogHarianMagangUser::create([
            'pendaftaran_magang_id' => $pendaftaranId,
            'tanggal'               => $data['tanggal'] ?? now()->toDateString(),
            'aktivitas'             => $data['aktivitas'],
            'hasil'                 => $data['hasil'] ?? null,
            'kendala'               => $data['kendala'] ?? null,
            'bukti'                 => isset($data['bukti'])
                ? $data['bukti']->store('log-harian/bukti', 'public')
                : null,
            'status'                => 'menunggu',
        ]);
    }

    /**
     * Verifikasi log harian oleh admin.
     */
    public function verifyDailyLog(int $logId, string $status): LogHarianMagangUser
    {
        $log = LogHarianMagangUser::findOrFail($logId);
        $log->status = $status; // 'disetujui', 'revisi', 'ditolak'
        $log->save();
        return $log;
    }

    /**
     * Presensi masuk oleh peserta magang.
     */
    public function checkIn(array $data, int $pendaftaranId): PresensiMagang
    {
        return PresensiMagang::create([
            'pendaftaran_magang_id' => $pendaftaranId,
            'tanggal'               => $data['tanggal'] ?? now()->toDateString(),
            'jam_masuk'             => $data['jam_masuk'] ?? now()->format('H:i:s'),
            'latitude_masuk'        => $data['latitude'] ?? null,
            'longitude_masuk'       => $data['longitude'] ?? null,
            'foto_masuk'            => isset($data['foto_masuk'])
                ? $data['foto_masuk']->store('presensi/masuk', 'public')
                : null,
        ]);
    }

    /**
     * Presensi pulang oleh peserta magang.
     */
    public function checkOut(int $presensiId, array $data): PresensiMagang
    {
        $presensi = PresensiMagang::findOrFail($presensiId);
        $presensi->jam_pulang = $data['jam_pulang'] ?? now()->format('H:i:s');
        $presensi->latitude_pulang = $data['latitude'] ?? null;
        $presensi->longitude_pulang = $data['longitude'] ?? null;
        $presensi->foto_pulang = isset($data['foto_pulang'])
            ? $data['foto_pulang']->store('presensi/pulang', 'public')
            : null;
        $presensi->save();
        return $presensi;
    }

    /**
     * Mendapatkan informasi magang aktif.
     */
    public function getActivePrograms()
    {
        return InformasiMagang::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mendapatkan statistik pendaftaran magang.
     */
    public function getRegistrationStats(): array
    {
        $total = PendaftaranMagang::count();
        $accepted = PendaftaranMagang::where('status', 'diterima')->count();
        $rejected = PendaftaranMagang::where('status', 'ditolak')->count();
        $pending = PendaftaranMagang::where('status', 'diproses')->count();
        $completed = PendaftaranMagang::where('status', 'selesai')->count();

        return compact('total', 'accepted', 'rejected', 'pending', 'completed');
    }
}