<?php

namespace App\Records\Services;

use App\Base\External\Database;

class MovementService
{
    private Database $connection;

    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }
    
    public function getList(): array
    {
        $sql = "SELECT id, name FROM movement";
        $rs = $this->connection->query($sql);
        
        return $rs->fetchAll();
    }
}