<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class PropertyGroupModel extends AbstractModel
{
    public string $id;
    public string $name;

    public function handleResponse(stdClass $response): void
    {
        $this->id   = $response->id;
        $this->name = $response->name ?? $response->translated?->name;
    }
}
