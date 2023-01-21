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

    public function returnStatus()
    {
        try {
            $readAndWriteTest = $this->productsRepository->checkDbReadWrite();
            $lastCronCheck = $this->productsRepository->lastCronCheck();
            $checkMemoryStatusAndOnlineTime = $this->productsRepository->memoryAndTime();
            return [
                'success' => true,
                'messages' => [
                    'db_read_and_write' => $readAndWriteTest,
                    'last_cron_check' => $lastCronCheck,
                    'used_memory' => $checkMemoryStatusAndOnlineTime['memory'],
                    'online_time' => $checkMemoryStatusAndOnlineTime['uptime'],
                ]
            ];
        } catch (\Exception $e) {
            
        }
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
}
