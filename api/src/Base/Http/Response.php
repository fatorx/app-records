<?php

namespace App\Base\Http;

class Response
{
    private array $data = [];
    private int   $code = 200;
    
    public function setData(array $data): void
    {
        $this->data = $data;    
    }
    
    public function setCode(int $code): void
    {
        $this->code = $code;
    }
    
    public function endGame($data): void
    {
        header('Content-type: application/json');
        http_response_code(500);
        
        echo json_encode( $data );
        exit();
    }
    
    public function __invoke(): void
    {
        http_response_code($this->code);

        header('Content-type: application/json');
        echo json_encode( $this->data );
    }
}
