<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Http\Repositories\SeedTableRepository;

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

            unlink(public_path('storage/' . $product->name));
            unlink(public_path('storage/arquivoExtraido.json'));
           
        });
    }
}
