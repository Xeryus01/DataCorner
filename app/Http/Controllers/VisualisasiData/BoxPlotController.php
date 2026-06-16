<?php

namespace App\Http\Controllers\VisualisasiData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class BoxPlotController extends Controller
{
    public function boxplot()
    {
        return view('visualisasi-data.boxplot');
    }

    public function uploadData(Request $request)
    {
        // Validasi file seperti histogram
        $request->validate([
            'data_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        $file = $request->file('data_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Parse
        $data = $this->parseDataFile(storage_path('app/public/' . $filePath));

        // Validasi 2: harus ada data & baris pertama header
        if (empty($data) || empty($data[0]) || !is_array($data[0])) {
            return response()->json([
                'success' => false,
                'error' => 'File tidak sesuai format. Pastikan baris pertama berisi nama kolom.'
            ]);
        }

        $headers = array_keys($data[0]);

        // Validasi 3: minimal 2 header kolom
        if (count(array_filter($headers)) < 1) {
            return response()->json([
                'success' => false,
                'error' => 'File harus memiliki minimal 1 kolom data.'
            ]);
        }

        $columnAnalysis = $this->analyzeColumns($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'columns' => $headers,
            'numericColumns' => $columnAnalysis['numeric'],
            'categoricalColumns' => $columnAnalysis['categorical'],
            'columnTypes' => $columnAnalysis['types']
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'column' => 'required|string',
            'data'   => 'required|array'
        ]);

        $column = $request->input('column');
        $rows = collect($request->data);

        // Pastikan kolom ada
        $first = $rows->first();
        if (!is_array($first) || !array_key_exists($column, $first)) {
            return response()->json(['success' => false, 'error' => 'Kolom tidak ditemukan pada data.'], 422);
        }

        // Ambil nilai numerik
        $values = $rows->pluck($column)
            ->filter(fn($v) => $v !== null && $v !== '')
            ->map(fn($v) => $this->convertToNumeric($v))
            ->filter(fn($v) => $v !== null)
            ->map(fn($v) => (float) $v)
            ->values();

        if ($values->count() < 3) {
            return response()->json(['success' => false, 'error' => 'Data numerik terlalu sedikit untuk box plot (min 3).']);
        }

        // Hitung lima angka (min, Q1, median, Q3, max)
        $sorted = $values->sort()->values();
        $min    = $sorted->first();
        $max    = $sorted->last();
        $q1     = $this->percentile($sorted, 25);
        $median = $this->percentile($sorted, 50);
        $q3     = $this->percentile($sorted, 75);

        $series = [[
            'x' => 'All Data',
            'y' => [round($min, 2), round($q1, 2), round($median, 2), round($q3, 2), round($max, 2)]
        ]];

        return response()->json([
            'success' => true,
            'series'  => $series
        ]);
    }

    // ===== Helpers (copy dari Histogram, sebagian dipakai) =====

    private function analyzeColumns($data)
    {
        if (empty($data)) return ['numeric' => [], 'categorical' => [], 'types' => []];

        $columns = array_keys($data[0]);
        $numericColumns = [];
        $categoricalColumns = [];
        $columnTypes = [];

        foreach ($columns as $column) {
            $values = collect($data)->pluck($column)->filter(fn($v) => $v !== null && $v !== '');
            $total = $values->count();
            $numericCount = 0;

            foreach ($values as $v) {
                if ($this->convertToNumeric($v) !== null) $numericCount++;
            }

            $numericPct = $total > 0 ? ($numericCount / $total) * 100 : 0;

            if ($numericPct >= 80) {
                $numericColumns[] = $column;
                $columnTypes[$column] = 'numeric';
            } else {
                $categoricalColumns[] = $column;
                $columnTypes[$column] = 'categorical';
            }
        }

        return [
            'numeric' => $numericColumns,
            'categorical' => $categoricalColumns,
            'types' => $columnTypes
        ];
    }

    private function convertToNumeric($value)
    {
        if ($value === null || $value === '') return null;
        $value = trim((string)$value);

        if (is_numeric($value)) return (float) $value;

        $cleaned = preg_replace('/[^\d.,-]/', '', $value);

        if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
            $cleaned = str_replace(',', '', $cleaned);
        } elseif (strpos($cleaned, ',') !== false) {
            $parts = explode(',', $cleaned);
            if (count($parts) == 2 && strlen($parts[1]) <= 3) {
                $cleaned = str_replace(',', '.', $cleaned);
            } else {
                $cleaned = str_replace(',', '', $cleaned);
            }
        }

        return is_numeric($cleaned) ? (float) $cleaned : null;
    }

    private function percentile($sortedCollection, $percent)
    {
        // $sortedCollection harus sudah diurutkan (Collection of floats)
        $n = $sortedCollection->count();
        if ($n === 0) return null;

        $rank = ($percent / 100) * ($n - 1);
        $low  = (int) floor($rank);
        $high = (int) ceil($rank);
        if ($low === $high) {
            return $sortedCollection[$low];
        } else {
            $w = $rank - $low; // linear interpolation
            return $sortedCollection[$low] * (1 - $w) + $sortedCollection[$high] * $w;
        }
    }

    private function parseDataFile($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        return $extension === 'csv' ? $this->parseCsv($filePath) : $this->parseExcel($filePath);
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

            $headers = array_map(fn($h) => trim(str_replace("\xEF\xBB\xBF", '', (string)$h)), $headers);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) !== count($headers)) continue;
                $clean = array_map(fn($c) => is_string($c) ? trim($c) : $c, $row);
                $data[] = array_combine($headers, $clean);
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

        $headers = [];
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $headers[] = trim((string)$sheet->getCell($col . '1')->getCalculatedValue());
        }

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
