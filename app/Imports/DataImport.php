<?php
// app/Imports/DataImport.php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataImport implements ToArray
{
    public function array(array $array): array
    {
        return $array;
    }
}
