<?php

namespace App\Records\DTO;

use JsonSerializable;

class MovementDTO implements JsonSerializable
{
    private string $movementName = '';
    private string $userName = '';
    private int    $personalRecordUser = 0;
    private string $personalRecordDate = '';
    private int    $position = 0;
    
    public function setMovementName(string $movementName): void
    {
        $this->movementName = $movementName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function setPersonalRecordUser(int $personalRecordUser): void
    {
        $this->personalRecordUser = $personalRecordUser;
    }

    public function setPersonalRecordDate(string $personalRecordDate): void
    {
        $this->personalRecordDate = $personalRecordDate;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }
    
    public function jsonSerialize(): array
    {
        return [
            'movement_name'        => $this->movementName,
            'user_name'            => $this->userName,
            'personal_record_user' => $this->personalRecordUser,
            'personal_record_date' => $this->personalRecordDate,
            'position'             => $this->position,
        ];
    }
}