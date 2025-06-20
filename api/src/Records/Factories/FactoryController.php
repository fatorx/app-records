<?php

namespace App\Records\Factories;

use App\Base\Environment\ConfigValues;
use App\Base\External\Database;
use App\Base\Http\Request;
use App\Records\Controllers\IndexController;
use App\Records\Controllers\RecordsController;
use App\Records\Controllers\UsersController;

class FactoryController
{
    const string CONTROLLER_NOT_FOUND = 'controller %s not found'; 
    
    private FactoryService $factoryService;
    
    private array $routes;
    
    private ConfigValues $configValues;
    
    private Request $request;
    
    public function __construct(ConfigValues $configValues) 
    {
        $this->configValues   = $configValues;
        $connection           = new Database($configValues);
        $this->factoryService = new FactoryService($connection);
    
        $this->config();
    }
    
    public function config(): void
    {
        $this->routes = [
            '/' => function() {
                $controller = $this->getIndexController();
                return $controller->getInfo();
            },
            '/users' => function() {
                $controller = $this->getUserController();
                return $controller->getList();
            },
            '/records' => function() {
                $movement = $this->request->getQueryString('movement');
            
                $controller = $this->getRecordController();
                return $controller->getRanking($movement);
            },
        ];
    }
    
    public function getIndexController(): IndexController
    {
        return new IndexController($this);
    }
    
    public function getUserController(): UsersController
    {
        $userService = $this->factoryService->getServiceUser();
        
        return new UsersController($userService);
    }

    public function getRecordController(): RecordsController
    {
        $recordService = $this->factoryService->getRecordService();
        
        return new RecordsController($recordService);
    }
    
    public function getControllers():array
    {
        return array_keys($this->routes);    
    }
    
    public function getInfoConfig(): array
    {
        return [
            'host' => $this->configValues->getApp()
        ];
    }
    
    public function execute(Request $request): array
    {
        $this->request = $request;
        
        $uri = $this->request->getRequestUri();
        
        if (array_key_exists($uri, $this->routes)) {
            return $this->routes[$uri]();
        }
        
        return [
            'message' => sprintf(self::CONTROLLER_NOT_FOUND, $uri),
            'code'    => 404,
            'available_controllers' => $this->getControllers(),
        ];
    }
}