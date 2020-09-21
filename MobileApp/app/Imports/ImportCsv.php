<?php

namespace App\Imports;

use App\Animals;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportCsv implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return new Animals([
          'animalName' => $row[0],
          'animalDescription' => $row[1]
        ]);
    }
}
