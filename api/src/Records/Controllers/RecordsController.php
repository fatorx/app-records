<?php

namespace App\Records\Controllers;

use App\Records\Services\RecordService;

readonly class RecordsController
{
    public function __construct(
        private RecordService $recordService
    ) {}
    
    public function getRanking(string|int $movement): array
    {
        $movements = $this->recordService->getList($movement);
        
        return [
            'action' => 'records.getRanking',
            'code'   => count($movements) === 0 ? 404 : 200,
            'data'   => [
                'movements' => $movements
            ]
        ];    
    }
}