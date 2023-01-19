<?php 

namespace App\Http\Repositories;

use App\Models\Product;
use Carbon\Carbon;

class ProductRepository {
    public function getAll() :object
    {
        return Product::all();
    }
    public function add(array $data) :object
    {
        $data['imported_t'] = Carbon::parse($data['imported_t'])->format('Y-m-d H:i:s');   
        return Product::create($data);
    }
    public function findProductByCode(int $code) :object
    {
        return Product::where('code', $code);
    }
    public function update(Product $product, array $data)
    {
        return $product->update($data);
    }
    public function delete($product)
    {
        return $product->update(['status' => 'trash']);
    }
   
}