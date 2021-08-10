<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class CountryModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $iso;

    public function handleResponse(stdClass $response): void
    {
        $this->id   = $response->id;
        $this->name = $response->name;
        $this->iso  = $response->iso;
    }
}
