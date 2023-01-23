<?php

namespace App\Http\Repositories;

use App\Models\Log;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DbRepository {
    public function updateRunToFalse($product)
    {
        return $product->update(['run' => 0]);
    }
    public function checkDbReadWrite()
    {
        try {

            $results = DB::select("SELECT 1+1 as result");
            if ($results[0]->result != 2) throw new \Exception("Failed to read the database");

            $product = Product::create(['code' => 'product_test']);
            $results = DB::select("SELECT code FROM products WHERE code = ?", [$product->code]);
            if (empty($results)) {
                throw new \Exception("Failed to write to database");
            }
            $product->delete();
            return "Reading and writing to the database working correctly";
        } catch (\Exception $e) {
            return "Database connection failed: " . $e->getMessage();
        }
    }
    public function lastCronCheck()
    {
        return Log::orderBy('id', 'desc')->pluck('date')->first();
    }
    public function memoryAndTime()
    {
        $data['uptime'] = DB::select("SHOW GLOBAL STATUS LIKE 'Uptime'")[0]->Value;
        $data['uptime'] = number_format((int)$data['uptime'] / 60, 2, '.') . ' min';
        $data['memory'] = DB::select("SHOW GLOBAL STATUS LIKE 'Bytes_received'")[0]->Value;
        $data['memory'] = number_format((int)$data['memory'] / 1e+6, 2, '.') . ' MB';
        return $data;
    }
}