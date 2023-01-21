<?php

namespace App\Http\Repositories;

use App\Models\ExportedFile;
use Illuminate\Support\Facades\DB;

class SeedTableRepository
{

    public function getAllFiles()
    {
        return DB::transaction(function (){
            return ExportedFile::all();
        });
    }
    public function addFiles(array $productsFiles)
    {
        foreach ($productsFiles as $productFile) {
            ExportedFile::create(['name' => $productFile]);
        };
        return true;
    }
  
}
