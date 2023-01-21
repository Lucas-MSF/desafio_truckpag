<?php

namespace App\Http\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\SeedTableRepository;

class SeedTableService
{

    private $seedTableRepository;
    private $productRepository;

    public function __construct()
    {
        $this->seedTableRepository = new SeedTableRepository;
        $this->productRepository =  new ProductRepository;
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
            if ($product->run === 0) return;

            $path = "/var/www/html/desafio_truckpag/projeto-truckpag/public/storage/";
            $client->request('GET', "https://challenges.coode.sh/food/data/json/$product->name", [
                'sink' => $path . $product->name
            ]);

            $gz = gzopen($path . $product->name, 'r');
            $fp = fopen($path . "arquivoExtraido.json", 'w');
            while ($string = gzread($gz, 4096)) {
                fwrite($fp, $string, strlen($string));
            }
            fclose($fp);
            gzclose($gz);

            $fh = fopen($path . 'arquivoExtraido.json', 'rb');
            $content = [];
            for ($i = 0; $i < 2; $i++) {
                $line = fgets($fh);
                if ($line !== false) {
                    $content[] = json_decode($line);
                }
            }
            fclose($fh);

            
            foreach ($content as $newProduct) {
                $this->productRepository->add($this->mountData($newProduct));
            }
            $product->update(['run' => 0]);
            unlink(public_path('storage/' . $product->name));
            unlink(public_path('storage/arquivoExtraido.json'));

            
        });
    }
    private function mountData($product)
    {
        $data = [
            "code" => str_replace('"', "", $product->code),
            "status" => "published",
            "imported_t" => Carbon::now()->subHours(3)->format('Y/m/d H:i:s'),
            "url" => $product->url,
            "creator" => $product->creator,
            "created_t" => $product->created_t,
            "last_modified_t" => $product->last_modified_t,
            "product_name" => $product->product_name,
            "quantity" => $product->quantity,
            "brands" => $product->brands,
            "categories" => $product->categories,
            "labels" => $product->labels,
            "cities" => $product->cities,
            "purchase_places" => $product->purchase_places,
            "stores" =>  $product->stores,
            "ingredients_text" => $product->ingredients_text,
            "traces" => $product->traces,
            "serving_size" => $product->serving_size,
            "serving_quantity" => $product->serving_quantity,
            "nutriscore_score" => $product->nutriscore_score,
            "nutriscore_grade" => $product->nutriscore_grade,
            "main_category" => $product->main_category,
            "image_url" => $product->image_url
        ];
        return $data;
    }
}
