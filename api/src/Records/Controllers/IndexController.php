<?php

namespace App\Records\Controllers;

use App\Records\Factories\FactoryController;

readonly class IndexController
{
    public function __construct(
        private FactoryController $factoryController,
    ) {}
    
    /**
     * @return array
     */
    public function getInfo(): array
    {
        return [
            'action' => 'index.getInfo',
            'config' => $this->factoryController->getInfoConfig(),
            'available_controllers' => $this->factoryController->getControllers(),
        ];
    }
}