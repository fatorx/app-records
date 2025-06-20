<?php

namespace App\Base\Environment;

class Config
{
    public const array FIELDS = [
        'APP',
        'APP_PORT',
        'ENVIRONMENT',
        'DB_USER',
        'DB_PASSWORD',
        'DB_HOST',
        'DB_NAME',
        'REMOTE_ADDR',
    ];
    
    /**
     * @param $name
     * @return string|array|false
     */
    public static function env($name): string|array|false
    {
        return !isset($_ENV[$name]) ? getenv($name) : $_ENV[$name];
    }
    
    public static function getValues(): ConfigValues
    {
        $configValues = new ConfigValues();
        
        $configValues->setApp(Config::env('APP'));
        $configValues->setAppPort(Config::env('APP_PORT'));
        $configValues->setEnvironment(Config::env('ENVIRONMENT'));
        $configValues->setDbUser(Config::env('DB_USER'));
        $configValues->setDbPassword(Config::env('DB_PASSWORD'));
        $configValues->setDbHost(Config::env('DB_HOST'));
        $configValues->setDbName(Config::env('DB_NAME'));
        $configValues->setRemoteAddr(Config::env('REMOTE_ADDR'));
        
        return $configValues;
    }
}
