<?php

namespace App\Http\Controllers\VisualisasiData;

use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class HistogramController extends Controller
{
    public function histogram()
    {
        return view('visualisasi-data.histogram');
    }

    public function uploadData(Request $request)
    {
        $request->validate([
            'data_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        $file = $request->file('data_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName, 'public');

        // Parse CSV/Excel data
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

        // Analyze columns to determine which are numeric
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

    public function generateHistogram(Request $request)
    {
        $request->validate([
            'column' => 'required|string',
            'data' => 'required|array',
            'bins' => 'nullable|integer|min:5|max:50'
        ]);

        $column = $request->column;
        $data = collect($request->data);
        $bins = $request->bins ?? 10;

        // Get all non-empty values from the column
        $allValues = $data->pluck($column)
            ->filter(function ($value) {
                return $value !== null && $value !== '';
            })
            ->map(function ($value) {
                return trim($value);
            })
            ->values();

        if ($allValues->isEmpty()) {
            return response()->json([
                'error' => 'No data found in selected column'
            ], 400);
        }

        // Check if data is numeric or categorical
        $numericValues = $allValues->map(function ($value) {
            return $this->convertToNumeric($value);
        })->filter(function ($value) {
            return $value !== null && is_numeric($value);
        });

        $isNumeric = $numericValues->count() / $allValues->count() >= 0.8; // 80% threshold

        if ($isNumeric) {
            // Generate numeric histogram
            return $this->generateNumericHistogram($numericValues, $bins);
        } else {
            // Generate categorical histogram
            return $this->generateCategoricalHistogram($allValues);
        }
    }

    private function generateNumericHistogram($values, $bins)
    {
        $values = $values->map(function ($value) {
            return (float)$value;
        });

        $min = $values->min();
        $max = $values->max();

        // Handle case where all values are the same
        if ($min == $max) {
            $histogram = [[
                'x' => $min,
                'y' => $values->count(),
                'range' => $min . ' - ' . $max
            ]];
        } else {
            $binWidth = ($max - $min) / $bins;
            $histogram = [];

            for ($i = 0; $i < $bins; $i++) {
                $binStart = $min + ($i * $binWidth);
                $binEnd = $min + (($i + 1) * $binWidth);

                $count = $values->filter(function ($value) use ($binStart, $binEnd, $i, $bins) {
                    if ($i === $bins - 1) {
                        return $value >= $binStart && $value <= $binEnd;
                    }
                    return $value >= $binStart && $value < $binEnd;
                })->count();

                $histogram[] = [
                    'x' => round($binStart + ($binWidth / 2), 2),
                    'y' => $count,
                    'range' => round($binStart, 2) . ' - ' . round($binEnd, 2)
                ];
            }
        }

        return response()->json([
            'success' => true,
            'histogram' => $histogram,
            'type' => 'numeric'
        ]);
    }

    private function generateCategoricalHistogram($values)
    {
        // Count frequency of each category
        $frequencies = $values->countBy();

        // Sort by frequency (descending) or alphabetically
        $sortedFrequencies = $frequencies->sortByDesc(function ($count) {
            return $count;
        });

        // Limit to top categories if too many
        $maxCategories = 20;
        if ($sortedFrequencies->count() > $maxCategories) {
            $sortedFrequencies = $sortedFrequencies->take($maxCategories);
        }

        $histogram = [];
        foreach ($sortedFrequencies as $category => $count) {
            $histogram[] = [
                'x' => $category,
                'y' => $count,
                'range' => $category
            ];
        }

        return response()->json([
            'success' => true,
            'histogram' => $histogram,
            'type' => 'categorical'
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

            if ($numericPercentage >= 80) { // 80% or more values are numeric
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
        // Remove whitespace
        $value = trim($value);

        // Check if already numeric
        if (is_numeric($value)) {
            return (float)$value;
        }

        // Remove common non-numeric characters (thousands separators, currency symbols)
        $cleaned = preg_replace('/[^\d.,-]/', '', $value);

        // Handle different decimal separators
        if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
            // Both comma and dot present - assume comma is thousands separator
            $cleaned = str_replace(',', '', $cleaned);
        } elseif (strpos($cleaned, ',') !== false) {
            // Only comma present - could be decimal separator
            $parts = explode(',', $cleaned);
            if (count($parts) == 2 && strlen($parts[1]) <= 3) {
                // Likely decimal separator
                $cleaned = str_replace(',', '.', $cleaned);
            } else {
                // Likely thousands separator
                $cleaned = str_replace(',', '', $cleaned);
            }
        }

        // Check if the cleaned value is numeric
        if (is_numeric($cleaned)) {
            return (float)$cleaned;
        }

        return null;
    }

    private function getDataTypes($values)
    {
        $types = [];
        foreach ($values as $value) {
            if (is_numeric($value)) {
                $types[] = 'numeric';
            } elseif (is_string($value)) {
                $types[] = 'string';
            } else {
                $types[] = gettype($value);
            }
        }
        return implode(', ', array_unique($types));
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
            // Get headers
            $headers = fgetcsv($handle);

            // Clean headers (remove BOM, trim whitespace)
            $headers = array_map(function ($header) {
                return trim(str_replace("\xEF\xBB\xBF", '', $header));
            }, $headers);

            while (($row = fgetcsv($handle)) !== false) {
                if (count($row) === count($headers)) {
                    // Clean row data
                    $cleanRow = array_map(function ($cell) {
                        return trim($cell);
                    }, $row);

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
        $headers = [];

        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();

        // Get headers from first row
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $headers[] = trim($worksheet->getCell($col . '1')->getCalculatedValue());
        }

        // Get data from remaining rows
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = [];
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $cellValue = $worksheet->getCell($col . $row)->getCalculatedValue();
                $rowData[] = $cellValue;
            }

            if (count($rowData) === count($headers)) {
                $data[] = array_combine($headers, $rowData);
            }
        }

        return $data;
    }
}
