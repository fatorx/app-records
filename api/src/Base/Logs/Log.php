<?php

namespace App\Base\Logs;

use Datetime;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Throwable;

trait Log
{
    public function addLog(Throwable $e, string $prefix = 'warning_' , int $level = Logger::WARNING): void
    {
        $date = new Datetime();

        $log = new Logger('App');
        $hourControl = $date->format('Y-m-d-H');
        $fileName = $prefix . $hourControl.'.txt';

        $pathLogs = getcwd() . '/../data/logs/';
        $log->pushHandler(new StreamHandler($pathLogs . $fileName, $level));

        $message = sprintf("%s - %s | %s", $e->getFile(), $e->getLine(), $e->getMessage());
        
        $headers = getallheaders();
        $clientIp = ($headers['X-Forwarded-For'] ?? 'NO IP');
        $log->error($clientIp . ' - ' . $message);
    }
}
