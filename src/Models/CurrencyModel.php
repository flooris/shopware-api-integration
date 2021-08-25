<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class CurrencyModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $nameShort;
    public string $symbol;

    public function handleResponse(stdClass $response): void
    {
        $this->id        = $response->id;
        $this->name      = $response->name ?? $response->translated?->name;
        $this->nameShort = $response->shortName ?? $response->translated?->shortName;
        $this->symbol    = $response->symbol;
    }
}
