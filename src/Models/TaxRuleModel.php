<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class TaxRuleModel extends AbstractModel
{
    public string $id;

    public function handleResponse(stdClass $response): void
    {
        $this->id = $response->id;
    }
}
