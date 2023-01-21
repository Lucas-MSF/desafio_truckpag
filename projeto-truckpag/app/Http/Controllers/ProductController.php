<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $productsRepository;

    public function __construct()
    {
        $this->productsRepository = new ProductRepository;
    }
    public function getAllProducts()
    {
        try {
            return [
                'success' => true,
                'data' => $this->productsRepository->getAll()
            ];
        } catch (\Throwable $th) {
            return ['messages' => $th->getMessage()];
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->productsRepository->add($request->all());
            DB::commit();
            return [
                'success' => true,
                'product' => $product
            ];
            
        } catch (\Throwable $th) {
            return ['messages' => $th->getMessage()];
        }
    }
    public function update(int $code, Request $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->productsRepository->findProductByCode($code)->first();
            $this->productsRepository->update($product, $request->all());   
            DB::commit();
            return [
                'success' => true,
                'product' => $product
            ];
        } catch (\Throwable $th) {
            return ['messages' => $th->getMessage()];
        }
    }
    public function delete(int $code)
    {
        try {
            DB::beginTransaction();
            $product = $this->productsRepository->findProductByCode($code)->first();
            $this->productsRepository->delete($product);   
            DB::commit();
            return [
                'success' => true,
                'product' => $product
            ];
        } catch (\Throwable $th) {
            return ['messages' => $th->getMessage()];
        }
    
    }
    public function getProductByCode(int $code)
    {
        try {
            return [
                'success' => true,
                'data' => $this->productsRepository->findProductByCode($code)->first()
            ];
        } catch (\Throwable $th) {
            return ['messages' => $th->getMessage()];
        }
    }
    //TODO: função de retorno do status do banco
            // function getSystemMemInfo() 
            // $data = explode("\n", file_get_contents("/proc/meminfo"));
            // $meminfo = array();
            // foreach ($data as $line) {
            //     list($key, $val) = explode(":", $line);
            //     $meminfo[$key] = trim($val);
            // }
            // return $meminfo;
            
            // function getUptime()
            // {
            //     $str   = @file_get_contents('/proc/uptime');
            //     $num   = floatval($str);
            //     $secs  = fmod($num, 60);
            //     $num = (int)($num / 60);
            //     $mins  = $num % 60;
            //     $num = (int)($num / 60);
            //     $hours = $num % 24;
            //     $num = (int)($num / 24);
            //     $days  = $num;

            //     return ['days' => $days, 'hours' => $hours, 'mins' => $mins, 'secs' => $secs];
            // }
}
