<?php

namespace App\Base\Http;

use App\Records\Factories\FactoryController;

class Request implements IRequest
{
    private array $server;
    
    public function __construct()
    {
        $this->server = $_SERVER;
    }
    
    public function getRequestUri(): string
    {
        $requestUri = $this->server['REQUEST_URI'] ?? '';
        $path = parse_url($requestUri, PHP_URL_PATH);

        $path = $path ?? '';

        $sanitizedPath = filter_var($path, FILTER_SANITIZE_URL);

        if ($sanitizedPath === false) {
            return '';
        }
        
        if (!empty($sanitizedPath) && $sanitizedPath[0] !== '/') {
            $sanitizedPath = '/' . $sanitizedPath;
        }

        return $sanitizedPath;
    }
    
    public function getQueryString(string $name, $returnDefault = null, ?int $filterType = FILTER_UNSAFE_RAW ): string
    {
        $queryString = $this->server['QUERY_STRING'] ?? '';
        
        if (empty($queryString)) {
            return $returnDefault;
        }
        
        parse_str($queryString, $params);

        if (!isset($params[$name])) {
            return $returnDefault;
        }
        
        $value = $params[$name];

        if ($filterType !== null) {
            $sanitizedValue = filter_var($value, $filterType);
            if ($sanitizedValue === false || $sanitizedValue === null) {
                return $returnDefault;
            }
            return $sanitizedValue;
        }
        
        return $value;
    }
    
    public function process(FactoryController $factoryController): array
    {
        return $factoryController->execute($this);
    }
}
