<?php

namespace RecordsTest\DTO;

use App\Records\DTO\MovementDTO;
use PHPUnit\Framework\TestCase;

class MovementDTOTest extends TestCase
{
    /**
     * @covers \App\Records\DTO\MovementDTO::setMovementName
     * @covers \App\Records\DTO\MovementDTO::setUserName
     * @covers \App\Records\DTO\MovementDTO::setPersonalRecordUser
     * @covers \App\Records\DTO\MovementDTO::setPersonalRecordDate
     * @covers \App\Records\DTO\MovementDTO::setPosition
     * @covers \App\Records\DTO\MovementDTO::jsonSerialize
     */
    public function testMovementDTOJsonSerialization()
    {
        $dto = new MovementDTO();
        $dto->setMovementName('Deadlift');
        $dto->setUserName('Joao');
        $dto->setPersonalRecordUser(180);
        $dto->setPersonalRecordDate('2021-01-02 00:00:00.0');
        $dto->setPosition(1);

        $expectedJson = [
            'movement_name'        => 'Deadlift',
            'user_name'            => 'Joao',
            'personal_record_user' => 180,
            'personal_record_date' => '2021-01-02 00:00:00.0',
            'position'             => 1,
        ];

        $this->assertEquals($expectedJson, $dto->jsonSerialize());

        $this->assertEquals(json_encode($expectedJson), json_encode($dto));
    }

    /**
     * @covers \App\Records\DTO\MovementDTO::jsonSerialize
     */
    public function testMovementDTOWithDefaultValues()
    {
        $dto = new MovementDTO();

        $expectedJson = [
            'movement_name'        => '',
            'user_name'            => '',
            'personal_record_user' => 0,
            'personal_record_date' => '',
            'position'             => 0,
        ];

        $this->assertEquals($expectedJson, $dto->jsonSerialize());
    }
}
