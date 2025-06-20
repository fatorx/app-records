<?php

namespace App\Records\Services;

use App\Base\External\Database;
use App\Records\DTO\MovementDTO;

class RecordService
{
    private Database $connection;

    public function __construct(Database $connection)
    {
        $this->connection = $connection;
    }
    
    public function getList(string|int $movement = 0): array
    {
        $parameters = $this->getParameters($movement);
        $sql        = $this->getSql();
        
        $rs = $this->connection->query($sql, $parameters);
        
        $result = [];
        $fetchAll = $rs->fetchAll();
        
        foreach ($fetchAll as $record) {
            $movement = new MovementDTO();
            $movement->setMovementName($record['movement_name']);
            $movement->setUserName($record['user_name']);
            $movement->setPersonalRecordUser($record['personal_record_user']);
            $movement->setPersonalRecordDate($record['personal_record_date']);
            $movement->setPosition($record['position']);
            
            $result[] = $movement;
        }
        
        return $result;
    }
    
    /**
     * @param int|string $movement
     * @return array
     */
    public function getParameters(int|string $movement): array
    {
        $movementName = '';
        $movementId = 0;

        if (is_numeric($movement)) {
            $movementId = $movement;
        } else if (is_string($movement)) {
            $movementName = $movement;
        }

        return [
            ':movement_name' => $movementName,
            ':movement_id' => $movementId
        ];
    }
    
    public function getSql(): string
    {
        return <<<SQL
            WITH movement_id as (
                select id
                from movement
                where name = :movement_name OR id = :movement_id
            ), personal_records_movement as (
                select id, user_id, movement_id, value, date
                from personal_record
                where movement_id = (SELECT id FROM movement_id)
            ), user_best_personal_record AS (
                SELECT
                    pr.id,
                    pr.user_id,
                    pr.movement_id,
                    pr.value,
                    pr.date,
                    ROW_NUMBER() OVER(
                        PARTITION BY pr.user_id, pr.movement_id 
                        ORDER BY pr.value DESC, pr.date DESC) AS rn
                FROM
                    personal_records_movement pr
            )
            SELECT
                m.name AS movement_name,
                u.name AS user_name,
                ubpr.value AS personal_record_user,
                ubpr.date AS personal_record_date,
                DENSE_RANK() OVER (ORDER BY ubpr.value DESC) AS position
            FROM
                user_best_personal_record ubpr
                    JOIN
                user u ON ubpr.user_id = u.id
                    JOIN
                movement m ON ubpr.movement_id = m.id
            WHERE
                ubpr.rn = (SELECT id FROM movement_id)
            ORDER BY
                personal_record_user DESC,
                personal_record_date;
        SQL;
    }
}