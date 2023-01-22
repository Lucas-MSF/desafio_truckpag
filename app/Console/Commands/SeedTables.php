<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Services\SeedTableService;


class SeedTables extends Command
{
    private $seedTableService;

    public function __construct()
    {
        $this->seedTableService = new SeedTableService;
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seedTables:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para povoar o banco através do JSON';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $products = explode("\n", $this->seedTableService->requestApi());
            $this->seedTableService->addProducts($products);
            $this->seedTableService->addFile();
            $this->seedTableService->createLog('insert data in database');
            return Command::SUCCESS;
        } catch (\Throwable $th) {
            $this->seedTableService->createLog($th->getMessage());
        }
       
    }
}
