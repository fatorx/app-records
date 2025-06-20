<?php

namespace RecordsTest\Services;

use App\Base\External\Database;
use App\Records\Services\MovementService;
use PHPUnit\Framework\TestCase;

class MovementServiceTest extends TestCase
{
    private $databaseMock;
    private MovementService $movementService;

    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(Database::class);
        $this->movementService = new MovementService($this->databaseMock);
    }

    /**
     * @covers \App\Records\Services\MovementService::getList
     */
    public function testGetListReturnsAllMovements()
    {
        $mockDbResult = [
            ['id' => 1, 'name' => 'Deadlift'],
            ['id' => 2, 'name' => 'Back Squat'],
            ['id' => 3, 'name' => 'Bench Press'],
        ];

        $this->databaseMock->expects($this->once())
            ->method('query')
            ->with('SELECT id, name FROM movement')
            ->willReturn($this->databaseMock); // query returns $this
        $this->databaseMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn($mockDbResult);

        $movements = $this->movementService->getList();

        $this->assertIsArray($movements);
        $this->assertCount(3, $movements);
        $this->assertEquals($mockDbResult, $movements);
    }

    /**
     * @covers \App\Records\Services\MovementService::getList
     */
    public function testGetListReturnsEmptyArrayWhenNoMovements()
    {
        $this->databaseMock->expects($this->once())
            ->method('query')
            ->willReturn($this->databaseMock);
        $this->databaseMock->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $movements = $this->movementService->getList();

        $this->assertIsArray($movements);
        $this->assertEmpty($movements);
    }
}