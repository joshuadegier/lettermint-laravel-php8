<?php

namespace Lettermint\Laravel\Sdk\Endpoints;

use Lettermint\Laravel\Sdk\Client\HttpClient;

abstract class Endpoint
{
    protected HttpClient $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
}
