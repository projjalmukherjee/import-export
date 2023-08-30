<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection,ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        return new Customer([
            'name'     => $row['name'],
            'point'    => $row['point'],
            'post_date' => Carbon::parse($row['post_date'])->format('Y-m-d'),
        ]);
    }
}
