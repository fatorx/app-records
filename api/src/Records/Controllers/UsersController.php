<?php

namespace App\Records\Controllers;

use App\Records\Services\UserService;

readonly class UsersController
{
    public function __construct(
        private UserService $userService
    ) {}
    
    /**
     * @return array
     */
    public function getList(): array
    {
        return [
            'method' => 'users.getList',
            'data' => [
                'users' => $this->userService->getList()
            ]
        ];
    }
}