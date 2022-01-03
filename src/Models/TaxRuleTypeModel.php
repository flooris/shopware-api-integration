<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class TaxRuleTypeModel extends AbstractModel
{
    public string $id;
    public string $typeName;
    public string $technicalName;
    public int $position;
    public int|float $taxRate;


    public function handleResponse(stdClass $response): void
    {
        $this->id            = $response->id;
        $this->typeName      = $response->typeName ?? $response->translated?->typeName;
        $this->technicalName = $response->technicalName;
        $this->position      = $response->position;
    }
}
