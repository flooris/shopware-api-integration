<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Flooris\ShopwareApiIntegration\Models\Contracts\Model;
use Flooris\ShopwareApiIntegration\Models\Contracts\Client;

abstract class AbstractModel implements Model
{
    public function __construct(?stdClass $response = null)
    {
        if ($response) {
            $this->handleResponse($response->data ?? $response);
        }
    }

    abstract public function handleResponse(stdClass $response): void;
}
