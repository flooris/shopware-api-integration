<?php

namespace Flooris\ShopwareApiIntegration\Models\Contracts;

use stdClass;

interface Model extends BaseModel
{
    public function __construct(Client $client, ?stdClass $response = null);
}
