<?php

namespace App\Http\Controllers\VisualisasiData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PieChartController extends Controller
{
    public function index()
    {
        return view('visualisasi-data.pie');
    }

    public function uploadData(Request $request)
    {
        $request->validate([
            'data_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        $file = $request->file('data_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        $data = $this->parseDataFile(storage_path('app/public/' . $filePath));

        // Validasi: pastikan ada data dan baris pertama sebagai header
        if (empty($data) || empty($data[0]) || !is_array($data[0])) {
            return response()->json([
                'success' => false,
                'error' => 'File tidak sesuai format. Pastikan baris pertama berisi nama kolom.'
            ]);
        }

        $headers = array_keys($data[0]);

        // Validasi tambahan: minimal ada 2 kolom header
        if (count(array_filter($headers)) < 2) {
            return response()->json([
                'success' => false,
                'error' => 'Header kolom terlalu sedikit atau tidak terbaca dengan benar.'
            ]);
        }

        $columnAnalysis = $this->analyzeColumns($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'columns' => $headers,
            'categoricalColumns' => $columnAnalysis['categorical'],
            'numericColumns' => $columnAnalysis['numeric'],
            'columnTypes' => $columnAnalysis['types']
        ]);
    }

    public function generatePieChart(Request $request)
    {
        $request->validate([
            'column' => 'required|string',
            'data' => 'required|array',
        ]);

        $column = $request->column;
        $data = collect($request->data);

        $allValues = $data->pluck($column)
            ->filter(fn($value) => $value !== null && $value !== '')
            ->map(fn($value) => trim($value))
            ->values();

        if ($allValues->isEmpty()) {
            return response()->json([
                'error' => 'Tidak ada data dalam kolom yang dipilih.'
            ], 400);
        }

        $frequencies = $allValues->countBy();
        $sortedFrequencies = $frequencies->sortDesc();

        $maxCategories = 20;
        if ($sortedFrequencies->count() > $maxCategories) {
            $sortedFrequencies = $sortedFrequencies->take($maxCategories);
        }

        $labels = $sortedFrequencies->keys()->values();
        $values = $sortedFrequencies->values();

        return response()->json([
            'success' => true,
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    private function analyzeColumns($data)
    {
        if (empty($data)) {
            return ['numeric' => [], 'categorical' => [], 'types' => []];
        }

        $columns = array_keys($data[0]);
        $numericColumns = [];
        $categoricalColumns = [];
        $columnTypes = [];

        foreach ($columns as $column) {
            $values = collect($data)->pluck($column)->filter(fn($value) => $value !== null && $value !== '');

            $numericCount = 0;
            $totalCount = $values->count();

            foreach ($values as $value) {
                if ($this->convertToNumeric($value) !== null) {
                    $numericCount++;
                }
            }

            $numericPercentage = $totalCount > 0 ? ($numericCount / $totalCount) * 100 : 0;

            if ($numericPercentage >= 80) {
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
        $value = trim($value);

        if (is_numeric($value)) {
            return (float) $value;
        }

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

        if (is_numeric($cleaned)) {
            return (float) $cleaned;
        }

        return null;
    }

    private function parseDataFile($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if ($extension === 'csv') {
            return $this->parseCsv($filePath);
        } else {
            return $this->parseExcel($filePath);
        }
    }

    private function parseCsv($filePath)
    {
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle);
            $headers = array_map(fn($header) => trim(str_replace("\xEF\xBB\xBF", '', $header)), $headers);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($headers)) {
                    $cleanRow = array_map('trim', $row);
                    $data[] = array_combine($headers, $cleanRow);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    private function parseExcel($filePath)
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        $headers = [];
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $headers[] = trim($worksheet->getCell($col . '1')->getCalculatedValue());
        }

        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = [];
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $rowData[] = $worksheet->getCell($col . $row)->getCalculatedValue();
            }

            if (count($rowData) === count($headers)) {
                $data[] = array_combine($headers, $rowData);
            }
        }

        return $data;
    }
}
