<?php

namespace App\Imports;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Models\KuisReguler\SoalKuisReguler;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\KuisReguler\OpsiSoalKuisReguler;

class SoalKuisRegulerImport implements ToCollection, WithHeadingRow
{
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
            $soal = new SoalKuisReguler();
            $soal->id_kuis_reguler = $this->idKuis;
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
                        OpsiSoalKuisReguler::create([
                            'id_soal_kuis_reguler' => $soal->id,
                            'label' => $label,
                            'teks_opsi' => $row[$key],
                        ]);
                    }
                }
            }
        }
    }
}
