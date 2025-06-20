<?php

namespace RecordsTest\Services;

use App\Base\External\Database;
use App\Records\Services\UserService;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private $databaseMock;
    private UserService $userService;

    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(Database::class);
        $this->userService = new UserService($this->databaseMock);
    }

    /**
     * @covers App\Records\Services\UserService::getList
     */
    public function testGetListReturnsAllUsers()
    {
        $mockDbResult = [
            ['id' => 1, 'name' => 'Joao'],
            ['id' => 2, 'name' => 'Jose'],
            ['id' => 3, 'name' => 'Paulo'],
        ];

        $this->databaseMock->expects($this->once())
            ->method('query')
            ->with('SELECT id, name FROM user')
            ->willReturn($this->databaseMock); // query returns $this
        $this->databaseMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($mockDbResult);

        $users = $this->userService->getList();

        $this->assertIsArray($users);
        $this->assertCount(3, $users);
        $this->assertEquals($mockDbResult, $users);
    }

    /**
     * @covers App\Records\Services\UserService::getList
     */
    public function testGetListReturnsEmptyArrayWhenNoUsers()
    {
        $this->databaseMock->expects($this->once())
            ->method('query')
            ->willReturn($this->databaseMock);
        $this->databaseMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $users = $this->userService->getList();

        $this->assertIsArray($users);
        $this->assertEmpty($users);
    }
}