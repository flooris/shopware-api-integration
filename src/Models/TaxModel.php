<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class TaxModel extends AbstractModel
{
    public string $id;
    public string $name;
    public int|float $taxRate;


    public function handleResponse(stdClass $response): void
    {
        $this->id      = $response->id;
        $this->name    = $response->name ?? $response->translated?->name;
        $this->taxRate = $response->taxRate;
    }
}
