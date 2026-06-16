<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    /**
     * Get the appropriate MONTH function based on database driver
     * 
     * @param string $column The column name
     * @return string SQL expression for extracting month
     */
    public static function monthExpression($column)
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            return "CAST(strftime('%m', {$column}) AS INTEGER)";
        }
        
        return "MONTH({$column})";
    }

    /**
     * Get the appropriate YEAR function based on database driver
     * 
     * @param string $column The column name
     * @return string SQL expression for extracting year
     */
    public static function yearExpression($column)
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            return "strftime('%Y', {$column})";
        }
        
        return "YEAR({$column})";
    }

    /**
     * Get available years from a table column
     * Works with both MySQL and SQLite
     * 
     * @param string $table Table name
     * @param string $column Column name (default: created_at)
     * @return array Array of years
     */
    public static function getAvailableYears($table, $column = 'created_at')
    {
        $driver = DB::connection()->getDriverName();
        
        if ($driver === 'sqlite') {
            $yearExpression = "strftime('%Y', {$column})";
        } else {
            $yearExpression = "YEAR({$column})";
        }
        
        $years = DB::table($table)
            ->selectRaw("{$yearExpression} as tahun")
            ->whereNotNull($column)
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->map(fn($year) => (int) $year)
            ->toArray();
        
        return !empty($years) ? $years : [(int) date('Y')];
    }
}
