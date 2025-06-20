<?php

namespace App\Base;

use App\Base\Environment\Config;
use App\Base\Environment\Validate as ValidateEnvironment;
use App\Base\Http\Request;
use App\Base\Http\Response;
use App\Base\Logs\Log;
use App\Records\Factories\FactoryController;
use Throwable;

class EntryPoint
{
    const string ENVIRONMENT_NOT_CONFIG = 'Environment not configured';

    use Log;
    
    private Request $request;
    private Response $response;
    
    public function __construct()
    {   
        $this->request  = new Request();
        $this->response = new Response();
        
        $this->checkEnvironment();
    }
    
    public function checkEnvironment(): void
    {
        $check = new ValidateEnvironment()->check();
        
        if (! $check) {
            $this->response->endGame(['message' => self::ENVIRONMENT_NOT_CONFIG]);
        }
    }
    
    public function run(): Response
    {
        $config  = Config::getValues();
        $code    = 200;
        
        try {
            $factoryController = new FactoryController($config);
            $result = $this->request->process($factoryController);    
        } catch (Throwable $exception) {
            $code = 500;
            
            $message = 'Check Application Log';
            $this->addLog($exception, 'application_');
            
            if ($config->getEnvironment() == 'dev') {
                $message = 'Error: ' . $exception->getMessage();
            }
            
            $result = [
                'message' => $message,
            ];
        }

        if (isset($result['code'])) {
            $code = $result['code'];
            unset($result['code']);
        }
        
        $this->response->setData($result);
        $this->response->setCode($code);
        
        return $this->response;
    }
}