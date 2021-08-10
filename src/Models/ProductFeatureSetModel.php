<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class ProductFeatureSetModel extends AbstractModel
{
    public string $id;
    public ?string $name;
    public ?string $description;
    public array $features;

    public function handleResponse(stdClass $response): void
    {
        $this->id          = $response->id;
        $this->name        = $response->name;
        $this->description = $response->description;
        $this->features    = collect($response->features)->map(function (stdClass $feature) {
            return new FeatureModel($feature);
        })->toArray();
    }
}
