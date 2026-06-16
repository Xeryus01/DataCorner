<?php

namespace App\Services;

use App\Models\PendaftaranRiset;
use App\Models\InformasiRiset;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

/**
 * Service layer untuk domain Program Riset.
 */
class ResearchService
{
    /**
     * Mendaftar riset oleh user.
     */
    public function register(array $data, int $userId): PendaftaranRiset
    {
        $pendaftaran = new PendaftaranRiset();
        $pendaftaran->user_id = $userId;
        $pendaftaran->informasi_riset_id = $data['informasi_riset_id'];
        $pendaftaran->judul_riset = $data['judul_riset'];
        $pendaftaran->deskripsi = $data['deskripsi'] ?? null;
        $pendaftaran->instansi = $data['instansi'] ?? null;
        $pendaftaran->status = 'diproses';

        // Upload proposal
        if (isset($data['proposal'])) {
            $pendaftaran->proposal = $data['proposal']->store('pendaftaran-riset/proposal', 'public');
        }

        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Verifikasi pendaftaran riset (diterima) oleh admin.
     */
    public function accept(int $pendaftaranId): PendaftaranRiset
    {
        $pendaftaran = PendaftaranRiset::findOrFail($pendaftaranId);
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Verifikasi pendaftaran riset (ditolak) oleh admin.
     */
    public function reject(int $pendaftaranId): PendaftaranRiset
    {
        $pendaftaran = PendaftaranRiset::findOrFail($pendaftaranId);
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Menyelesaikan pendaftaran riset.
     */
    public function complete(int $pendaftaranId): PendaftaranRiset
    {
        $pendaftaran = PendaftaranRiset::findOrFail($pendaftaranId);
        $pendaftaran->status = 'selesai';
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Upload laporan riset oleh peserta.
     */
    public function uploadReport(int $pendaftaranId, $file): PendaftaranRiset
    {
        $pendaftaran = PendaftaranRiset::findOrFail($pendaftaranId);
        $pendaftaran->laporan_riset = $file->store('pendaftaran-riset/laporan', 'public');
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Upload sertifikat riset oleh admin.
     */
    public function uploadCertificate(int $pendaftaranId, $file): PendaftaranRiset
    {
        $pendaftaran = PendaftaranRiset::findOrFail($pendaftaranId);
        $pendaftaran->sertifikat = $file->store('pendaftaran-riset/sertifikat', 'public');
        $pendaftaran->save();
        return $pendaftaran;
    }

    /**
     * Mendapatkan informasi riset aktif.
     */
    public function getActivePrograms()
    {
        return InformasiRiset::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Mendapatkan arsip karya riset yang sudah selesai.
     */
    public function getArchivedWorks()
    {
        return PendaftaranRiset::where('status', 'selesai')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    /**
     * Mendapatkan statistik pendaftaran riset.
     */
    public function getRegistrationStats(): array
    {
        $total = PendaftaranRiset::count();
        $accepted = PendaftaranRiset::where('status', 'diterima')->count();
        $rejected = PendaftaranRiset::where('status', 'ditolak')->count();
        $pending = PendaftaranRiset::where('status', 'diproses')->count();
        $completed = PendaftaranRiset::where('status', 'selesai')->count();

        return compact('total', 'accepted', 'rejected', 'pending', 'completed');
    }
}