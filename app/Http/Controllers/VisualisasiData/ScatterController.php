<?php

namespace App\Http\Controllers\VisualisasiData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ScatterController extends Controller
{
    public function scatter()
    {
        return view('visualisasi-data.scatter');
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
            'numericColumns' => $columnAnalysis['numeric'],
            'categoricalColumns' => $columnAnalysis['categorical'],
            'columnTypes' => $columnAnalysis['types']
        ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'x_column' => 'required|string',
            'y_column' => 'required|string',
            'data' => 'required|array',
        ]);

        $data = collect($request->data);
        $xCol = $request->x_column;
        $yCol = $request->y_column;

        $points = $data->map(function ($row) use ($xCol, $yCol) {
            $x = $this->convertToNumeric($row[$xCol] ?? null);
            $y = $this->convertToNumeric($row[$yCol] ?? null);
            return ($x !== null && $y !== null) ? ['x' => $x, 'y' => $y] : null;
        })->filter()->values();

        if ($points->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => 'Tidak ada data numerik yang cocok untuk scatter plot'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'points' => $points
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
            $values = collect($data)->pluck($column)->filter(function ($value) {
                return $value !== null && $value !== '';
            });

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
        $value = trim((string)$value);

        if (is_numeric($value)) {
            return (float)$value;
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

        return is_numeric($cleaned) ? (float)$cleaned : null;
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
        $headers = [];

        if (($handle = fopen($filePath, 'r')) !== false) {
            $headers = fgetcsv($handle);

            $headers = array_map(function ($header) {
                return trim(str_replace("\xEF\xBB\xBF", '', $header));
            }, $headers);

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
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        $data = [];
        $headers = [];

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

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
