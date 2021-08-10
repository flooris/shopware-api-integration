<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class ProductVisibilityModel extends AbstractModel
{
    public string $id;
    public string $productId;

    public function handleResponse(stdClass $response): void
    {
        $this->id        = $response->id;
        $this->productId = $response->productId;
    }
}
