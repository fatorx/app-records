<?php

namespace App\Base\External;

use App\Base\Environment\ConfigValues;
use App\Base\Logs\Log;
use PDO;
use PDOException;
use PDOStatement;

class Database
{
    use Log;
    
    private PDO $pdo;
    
    private PDOStatement $stmt;
    
    private string $dsn;
    
    private string $username;
    
    private string $password;
    
    public function __construct(ConfigValues $configValues)
    {
        $this->dsn = "mysql:host={$configValues->getDbHost()};dbname={$configValues->getDbName()}";
        
        $this->username = $configValues->getDbUser();
        $this->password = $configValues->getDbPassword();
        
        $this->connect();
    }
    
    private function connect(): void
    {
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        
        try {
            $this->pdo = new PDO($this->dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->addLog($e, 'database_');
        }
    }
    
    public function query($sql, $params = []): static
    {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($params);
        } catch (PDOException $e) {
            $this->addLog($e, 'database_');
        }
        return $this;
    }
    
    public function fetch(): array
    {
        return $this->stmt->fetch();
    }
    
    public function fetchAll(): array
    {
        return $this->stmt->fetchAll();
    }
}