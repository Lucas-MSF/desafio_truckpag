<?php

namespace App\Http\Repositories;

use App\Models\Log;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getAll(): object
    {
        return Product::all();
    }
    public function add(array $data): Product
    {
        return Product::create($data);
    }
    public function findProductByCode(int $code): object
    {
        return Product::where('code', $code);
    }
    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }
    public function delete($product): bool
    {
        return $product->update(['status' => 'trash']);
    }
    public function updateRunToFalse($product)
    {
        return $product->update(['run' => 0]);
    }
    public function checkDbReadWrite()
    {
        try {

            $results = DB::select("SELECT 1+1 as result");
            if ($results[0]->result != 2) throw new \Exception("Falha ao ler o banco de dados");

            $product = Product::create(['code' => 'produto_teste']);
            $results = DB::select("SELECT code FROM products WHERE code = ?", [$product->code]);
            if (empty($results)) {
                throw new \Exception("Falha ao escrever no banco de dados");
            }
            $product->delete();
            return "Leitura e escrita no banco de dados funcionando corretamente!";
        } catch (\Exception $e) {
            return "Falha na conexão com o banco de dados: " . $e->getMessage();
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
