<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class FeatureModel
{
    public string $name;
    public ?string $id;
    public string $type;
    public ?int $position;

    public function __construct(stdClass $response)
    {
        $this->name     = $response->name;
        $this->id       = $response->id;
        $this->type     = $response->type;
        $this->position = $response->position;
    }
}
