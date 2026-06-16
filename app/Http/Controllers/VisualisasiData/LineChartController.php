<?php

namespace App\Http\Controllers\VisualisasiData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LineChartController extends Controller
{
    public function linechart()
    {
        // view: resources/views/visualisasi-data/linechart.blade.php
        return view('visualisasi-data.line-chart');
    }

    public function uploadData(Request $request)
    {
        $request->validate([
            'data_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        $file = $request->file('data_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Parse CSV/Excel
        $data = $this->parseDataFile(storage_path('app/public/' . $filePath));

        // ✅ Validasi #2: harus ada data & baris pertama berisi header
        if (empty($data) || empty($data[0]) || !is_array($data[0])) {
            return response()->json([
                'success' => false,
                'error'   => 'File tidak sesuai format. Pastikan baris pertama berisi nama kolom.'
            ]);
        }

        $headers = array_keys($data[0]);

        // ✅ Validasi #3: minimal 2 header kolom
        if (count(array_filter($headers)) < 2) {
            return response()->json([
                'success' => false,
                'error'   => 'Header kolom terlalu sedikit atau tidak terbaca dengan benar.'
            ]);
        }

        // Analisis tipe kolom (numeric / categorical) – sama seperti histogram
        $columnAnalysis = $this->analyzeColumns($data);

        return response()->json([
            'success'            => true,
            'data'               => $data,
            'columns'            => $headers,
            'numericColumns'     => $columnAnalysis['numeric'],
            'categoricalColumns' => $columnAnalysis['categorical'],
            'columnTypes'        => $columnAnalysis['types'],
        ]);
    }

    public function generate(Request $request)
    {
        // Blade kamu kirim "xColumn" & "yColumn"
        // Kita buat fleksibel agar "x_column" & "y_column" juga diterima.
        $xKey = $request->input('xColumn', $request->input('x_column'));
        $yKey = $request->input('yColumn', $request->input('y_column'));

        $request->validate([
            'data' => 'required|array',
        ]);
        if (!$xKey || !$yKey) {
            return response()->json(['success' => false, 'error' => 'Kolom X dan Y wajib diisi.'], 422);
        }

        $rows = collect($request->data);
        if ($rows->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Data kosong.'], 400);
        }

        // Ambil pasangan (x,y) yang valid
        $pairs = $rows->map(function ($row) use ($xKey, $yKey) {
            $xRaw = $row[$xKey] ?? null;
            $yRaw = $row[$yKey] ?? null;

            $yNum = $this->convertToNumeric($yRaw);
            if ($yNum === null) {
                return null; // butuh Y numerik
            }

            $xLabel = $xRaw;
            $xNum   = null;

            // Coba deteksi tanggal dulu, lalu numerik
            $xDateTs = $this->tryParseDateToTimestamp($xRaw);
            if ($xDateTs !== null) {
                $xNum = $xDateTs;
                // Normalisasi label tanggal (YYYY-MM-DD)
                $xLabel = date('Y-m-d', (int)($xDateTs / 1000));
            } else {
                $xNum = $this->convertToNumeric($xRaw); // bisa null kalau kategori/string
                $xLabel = (string)$xLabel;
            }

            return [
                'x_raw'   => $xRaw,
                'x_label' => $xLabel,
                'x_num'   => $xNum,   // timestamp ms atau numerik, atau null
                'y'       => (float)$yNum,
            ];
        })->filter()->values();

        if ($pairs->isEmpty()) {
            return response()->json(['success' => false, 'error' => 'Tidak ada baris (X,Y) valid. Pastikan Y numerik.'], 400);
        }

        // Tentukan tipe X untuk pengurutan
        $xNumCount  = $pairs->whereNotNull('x_num')->count();
        $totalCount = $pairs->count();
        $sortByXNum = $xNumCount >= (int) ceil(0.8 * $totalCount); // 80% bisa dianggap numerik/timestamp

        if ($sortByXNum) {
            $pairs = $pairs->sortBy('x_num')->values();
        }

        // Siapkan output sesuai Blade: x = categories, y = series values
        $x = $pairs->pluck('x_label')->all();
        $y = $pairs->pluck('y')->all();

        return response()->json([
            'success' => true,
            'x'       => $x,
            'y'       => $y,
        ]);
    }

    // ===== Helpers (disalin dari HistogramController dan disesuaikan) =====

    private function analyzeColumns($data)
    {
        if (empty($data)) {
            return ['numeric' => [], 'categorical' => [], 'types' => []];
        }

        $columns = array_keys($data[0]);
        $numericColumns = [];
        $categoricalColumns = [];
        $columnTypes = [];

        foreach ($columns as $col) {
            $values = collect($data)->pluck($col)->filter(fn($v) => $v !== null && $v !== '');
            $total = $values->count();
            $numericCount = 0;

            foreach ($values as $v) {
                if ($this->convertToNumeric($v) !== null) {
                    $numericCount++;
                }
            }

            $numericPct = $total > 0 ? ($numericCount / $total) * 100 : 0;

            if ($numericPct >= 80) {
                $numericColumns[] = $col;
                $columnTypes[$col] = 'numeric';
            } else {
                $categoricalColumns[] = $col;
                $columnTypes[$col] = 'categorical';
            }
        }

        return [
            'numeric'     => $numericColumns,
            'categorical' => $categoricalColumns,
            'types'       => $columnTypes,
        ];
    }

    private function convertToNumeric($value)
    {
        if ($value === null || $value === '') return null;
        $value = trim((string)$value);

        if (is_numeric($value)) {
            return (float)$value;
        }

        // hapus simbol umum: mata uang, spasi, dll
        $cleaned = preg_replace('/[^\d.,-]/', '', $value);

        // Tangani pemisah ribuan/desimal
        if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
            // anggap koma pemisah ribuan
            $cleaned = str_replace(',', '', $cleaned);
        } elseif (strpos($cleaned, ',') !== false) {
            $parts = explode(',', $cleaned);
            if (count($parts) === 2 && strlen($parts[1]) <= 3) {
                $cleaned = str_replace(',', '.', $cleaned);
            } else {
                $cleaned = str_replace(',', '', $cleaned);
            }
        }

        return is_numeric($cleaned) ? (float)$cleaned : null;
    }

    private function tryParseDateToTimestamp($value)
    {
        // Kembalikan timestamp dalam milidetik jika bisa diparse; kalau tidak, null.
        if ($value === null || $value === '') return null;
        $str = trim((string)$value);

        // Coba beberapa format umum
        $formats = [
            'Y-m-d',
            'd-m-Y',
            'd/m/Y',
            'm/d/Y',
            'Y/m/d',
            'd M Y',
            'M d, Y',
            'Y-m-d H:i:s',
            'd/m/Y H:i:s',
            \DateTime::RFC3339,
        ];

        foreach ($formats as $fmt) {
            $dt = \DateTime::createFromFormat($fmt, $str);
            if ($dt && $dt->format($fmt) === $str) {
                return $dt->getTimestamp() * 1000;
            }
        }

        // Fallback strtotime
        $ts = strtotime($str);
        if ($ts !== false) {
            return $ts * 1000;
        }

        return null;
    }

    private function parseDataFile($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        if ($extension === 'csv') {
            return $this->parseCsv($filePath);
        }
        return $this->parseExcel($filePath);
    }

    private function parseCsv($filePath)
    {
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle);
            if ($headers === false) {
                fclose($handle);
                return $data;
            }
            // bersihkan header (BOM, spasi)
            $headers = array_map(fn($h) => trim(str_replace("\xEF\xBB\xBF", '', (string)$h)), $headers);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($headers)) {
                    $clean = array_map(fn($c) => is_string($c) ? trim($c) : $c, $row);
                    $data[] = array_combine($headers, $clean);
                }
            }
            fclose($handle);
        }
        return $data;
    }

    private function parseExcel($filePath)
    {
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $data = [];
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // headers di baris 1
        $headers = [];
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $headers[] = trim((string)$sheet->getCell($col . '1')->getCalculatedValue());
        }

        // data mulai baris 2
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = [];
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $rowData[] = $sheet->getCell($col . $row)->getCalculatedValue();
            }
            if (count($rowData) === count($headers)) {
                $data[] = array_combine($headers, $rowData);
            }
        }

        return $data;
    }
}
