<?php

namespace App\Services;

use App\Models\janjitemu;
use App\Models\jadwal;
use App\Models\konsultan;
use App\Models\konsultasiKlik;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Service layer untuk domain Konsultasi Statistik.
 * Memisahkan business logic dari controller agar lebih maintainable dan testable.
 */
class ConsultationService
{
    /**
     * Mencatat klik/pengajuan konsultasi baru oleh user.
     */
    public function recordKlik(array $data): konsultasiKlik
    {
        return konsultasiKlik::create([
            'users_id'      => $data['user_id'],
            'clicked_at'    => now(),
            'data_diminta'  => $data['data_diminta'] ?? null,
            'posisi'        => $data['posisi'] ?? null,
            'instansi'      => $data['instansi'] ?? null,
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'keperluan_data' => $data['keperluan_data'] ?? null,
            'memiliki_akun' => $data['memiliki_akun'] ?? 'ya',
        ]);
    }

    /**
     * Membuat janji temu baru oleh user.
     */
    public function createJanjiTemu(array $data, int $userId): janjitemu
    {
        return janjitemu::create([
            'users_id'           => $userId,
            'keperluan'          => $data['keperluan'] ?? null,
            'instansi_lembaga'   => $data['instansi_lembaga'] ?? null,
            'keperluan_data'     => $data['keperluan_data'] ?? null,
            'data_diminta'       => $data['data_diminta'] ?? null,
            'tanggal'            => $data['tanggal'] ?? null,
            'jam'                => $data['jam'] ?? null,
            'jenis'              => $data['jenis'] ?? 'offline',
            'jumlah_orang'       => $data['jumlah_orang'] ?? 1,
            'layanan_dibutuhkan' => $data['layanan_dibutuhkan'] ?? null,
            'status'             => 'menunggu',
        ]);
    }

    /**
     * Membatalkan janji temu oleh user.
     */
    public function cancelJanjiTemu(int $id, ?string $alasan = null): janjitemu
    {
        $janjiTemu = janjitemu::findOrFail($id);
        $janjiTemu->update([
            'status'       => 'dibatalkan',
            'alasan_batal' => $alasan ?? 'Dibatalkan oleh pengguna',
        ]);
        return $janjiTemu;
    }

    /**
     * Menjadwalkan sesi konsultasi dan assign ke konsultan (oleh admin).
     */
    public function schedule(int $janjitemuId, int $konsultanId): jadwal
    {
        return DB::transaction(function () use ($janjitemuId, $konsultanId) {
            // Update status janji temu
            janjitemu::where('id', $janjitemuId)->update(['status' => 'disetujui']);

            // Buat jadwal
            return jadwal::create([
                'janjitemu_id' => $janjitemuId,
                'konsultan_id' => $konsultanId,
            ]);
        });
    }

    /**
     * Menolak janji temu (oleh admin/konsultan).
     */
    public function rejectJanjiTemu(int $id, string $alasan): janjitemu
    {
        $janjiTemu = janjitemu::findOrFail($id);
        $janjiTemu->update([
            'status'       => 'ditolak',
            'alasan_batal' => $alasan,
        ]);
        return $janjiTemu;
    }

    /**
     * Menyimpan zoom link untuk sesi online.
     */
    public function saveZoomLink(int $id, string $zoomLink): janjitemu
    {
        $janjiTemu = janjitemu::findOrFail($id);
        $janjiTemu->update(['zoom_link' => $zoomLink]);
        return $janjiTemu;
    }

    /**
     * Mendapatkan daftar konsultan yang tersedia.
     */
    public function getAvailableConsultants()
    {
        return konsultan::with('bidangKeahlian')
            ->where('status', 'tersedia')
            ->orderBy('nama')
            ->get();
    }

    /**
     * Cek apakah jadwal konsultan bentrok.
     */
    public function isScheduleConflict(int $konsultanId, string $tanggal, string $jam): bool
    {
        return jadwal::where('konsultan_id', $konsultanId)
            ->whereHas('janjitemu', function ($q) use ($tanggal, $jam) {
                $q->where('tanggal', $tanggal)
                  ->where('jam', $jam)
                  ->whereNotIn('status', ['dibatalkan', 'ditolak']);
            })
            ->exists();
    }

    /**
     * Mendapatkan statistik konsultasi bulanan.
     */
    public function getMonthlyStats(int $year): array
    {
        $data = array_fill(0, 12, 0);
        $monthExpr = DB::connection()->getDriverName() === 'sqlite'
            ? "CAST(strftime('%m', clicked_at) AS INTEGER)"
            : "MONTH(clicked_at)";

        $rows = DB::table('konsultasi_klik')
            ->select(DB::raw("{$monthExpr} as bulan"), DB::raw('COUNT(*) as jumlah'))
            ->whereYear('clicked_at', $year)
            ->groupBy(DB::raw($monthExpr))
            ->orderBy('bulan')
            ->get();

        foreach ($rows as $row) {
            $data[(int)$row->bulan - 1] = (int)$row->jumlah;
        }

        return $data;
    }
}