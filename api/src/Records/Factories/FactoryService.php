<?php

namespace App\Records\Factories;

use App\Base\External\Database;
use App\Records\Services\RecordService;
use App\Records\Services\UserService;

class FactoryService
{
    private Database $connection;
    
    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }
    
    public function getServiceUser(): UserService
    {
        return new UserService($this->connection);
    }

    public function getRecordService(): RecordService
    {
        return new RecordService($this->connection);
    }
}