<?php

namespace App\Base\Http;

interface IRequest
{
    public function getRequestUri(): string;

    public function getQueryString(string $name, $returnDefault = 0): string;
}
