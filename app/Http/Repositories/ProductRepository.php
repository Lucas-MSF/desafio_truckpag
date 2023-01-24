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
}
