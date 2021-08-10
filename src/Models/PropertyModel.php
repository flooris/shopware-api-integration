<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class PropertyModel extends AbstractModel
{
    public string $id;
    public string $name;
    public array $options;

    public function handleResponse(stdClass $response): void
    {
        $this->id      = $response->id;
        $this->name    = $response->name;
        $this->options = $response->options;
    }
}
