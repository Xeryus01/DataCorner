<?php

namespace App\Imports;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\TantanganBulanan\SoalKuisTantanganBulanan;
use App\Models\TantanganBulanan\OpsiSoalKuisTantanganBulanan;

class SoalTantanganBulananImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    public $idKuis;
    public $fileSoal;
    public $imageMap;
    public $uploadBatchId;

    public function __construct($idKuis, $fileSoal, $imageMap, $uploadBatchId)
    {
        $this->idKuis = $idKuis;
        $this->fileSoal = $fileSoal;
        $this->imageMap = $imageMap;
        $this->uploadBatchId = $uploadBatchId;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $soal = new SoalKuisTantanganBulanan();
            $soal->id_kuis_tantangan_bulanan = $this->idKuis;
            $soal->file_soal = $this->fileSoal;
            $soal->upload_batch_id = $this->uploadBatchId;
            $soal->soal = $row['soal'] ?? '';
            $soal->tipe_soal = $row['tipe_soal'] ?? 'Isian Singkat';
            $soal->jawaban = $soal->tipe_soal === 'Isian Singkat' ? Str::lower($row['jawaban']) : $row['jawaban'];
            $soal->gambar = !empty($row['gambar']) && isset($this->imageMap[$row['gambar']])
                ? $this->imageMap[$row['gambar']]
                : null;
            $soal->save();

            if (strtolower($soal->tipe_soal) === 'pilihan ganda') {
                foreach (['A', 'B', 'C', 'D'] as $label) {
                    $key = 'opsi_' . strtolower($label);
                    if (!empty($row[$key])) {
                        OpsiSoalKuisTantanganBulanan::create([
                            'id_soal_tantangan' => $soal->id,
                            'label' => $label,
                            'teks_opsi' => $row[$key],
                        ]);
                    }
                }
            }
        }
    }
}
