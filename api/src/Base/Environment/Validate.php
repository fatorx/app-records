<?php

namespace App\Base\Environment;

class Validate
{
    public function check(): bool
    {
        $requiredConfig = Config::FIELDS;
        
        foreach ($requiredConfig as $item) {
            $item = Config::env($item);
            if (! $item) {
                return false;
            }
        }
        
        return true;
    }
}