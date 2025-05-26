<?php

namespace App\Imports;

use App\Models\Color;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ColorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Color([
            'name' => $row['name'],
            'hex_code' => $row['hex_code'],
        ]);
    }
}
