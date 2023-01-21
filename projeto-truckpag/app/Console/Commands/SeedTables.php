<?php

namespace App\Console\Commands;

use App\Http\Services\SeedTableService;
use Illuminate\Console\Command;

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
        $products = explode("\n", $this->seedTableService->requestApi());
        $this->seedTableService->addProducts($products);
        $this->seedTableService->requestFile();
        return Command::SUCCESS;
    }
}
