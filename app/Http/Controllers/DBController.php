<?php

namespace App\Http\Controllers;

use App\Http\Repositories\DbRepository;
use Illuminate\Http\Request;

class DBController extends Controller
{
    private $dbRepository;

    public function __construct()
    {
        $this->dbRepository = new DbRepository;
    }
    public function returnStatus()
    {
        try {
            $readAndWriteTest = $this->dbRepository->checkDbReadWrite();
            $lastCronCheck = $this->dbRepository->lastCronCheck();
            $checkMemoryStatusAndOnlineTime = $this->dbRepository->memoryAndTime();
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
}
