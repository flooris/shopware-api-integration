<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Illuminate\Support\Collection;

class ManufactureModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $description;

    public function handleResponse(stdClass $response): void
    {
        $this->id          = $response->id;
        $this->name        = $response->name;
        $this->description = $response->description ?? "";
    }
}
