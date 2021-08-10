<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class PropertyOptionModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $parentId;

    public function handleResponse(stdClass $response): void
    {
        $this->id       = $response->id;
        $this->name     = $response->name;
        $this->parentId = $response->groupId;
    }
}
