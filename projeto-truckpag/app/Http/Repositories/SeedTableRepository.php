<?php 

namespace App\Http\Repositories;

use App\Models\ExportedFile;

class SeedTableRepository {

    public function getAllFiles()
    {
        return ExportedFile::all();
    }
    public function addFiles(array $productsFiles)
    {
        foreach ($productsFiles as $productFile) {
            ExportedFile::create(['name' => $productFile]);
        };
        return true; 
    }
}