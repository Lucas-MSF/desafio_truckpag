<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;
use App\Http\Repositories\SeedTableRepository;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use ZipArchive;

class SeedTableService
{

    private $seedTableRepository;

    public function __construct()
    {
        $this->seedTableRepository = new SeedTableRepository;
    }

    public function requestApi()
    {
        return HTTP::get('https://challenges.coode.sh/food/data/json/index.txt')->body();
    }
    public function addProducts(array $products)
    {
        $newProducts = [];
        foreach ($products as $product) {
            $productsDataBase = $this->seedTableRepository->getAllFiles()->pluck('name')->toArray();
            dd($productsDataBase);
            if (in_array($product, $productsDataBase)) continue;
            $newProducts[] = $product;
        }
        array_pop($newProducts);
        return $this->seedTableRepository->addFiles($newProducts);
    }
    public function requestFile()
    {
        $client = new Client();

        $productsDataBase = $this->seedTableRepository->getAllFiles();
        $productsDataBase->map(function ($product) use ($client) {
            if ($product->run === 1) return;

            $client->request('GET', "https://challenges.coode.sh/food/data/json/$product->name", [
                'sink' => "/var/www/html/desafio_truckpag/projeto-truckpag/public/storage/$product->name"
            ]);
        });
    }
}
