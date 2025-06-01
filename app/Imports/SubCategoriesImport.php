<?php

namespace App\Imports;

use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubCategoriesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new SubCategory([
            'category_id' => $row['category_id'],
            'name' => $row['name'],
            'gender' => $row['gender'],
        ]);
    }
}
