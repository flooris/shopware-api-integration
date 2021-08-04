<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class ProductFeatureSetModel extends AbstractModel
{
    public string $id;
    public ?string $name;
    public ?string $description;
    public array $features;

    function handleResponse(): void
    {
        $response          = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id          = $response->id;
        $this->name        = $response->name;
        $this->description = $response->description;
        $this->features    = collect($response->features)->map(function ( \stdClass$feature){
            return new FeatureModel($feature);
        })->toArray();
    }
}
