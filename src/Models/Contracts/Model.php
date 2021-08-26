<?php

namespace Flooris\ShopwareApiIntegration\Models\Contracts;

use stdClass;

interface Model extends BaseModel
{
    public function __construct(?stdClass $response = null);
}
