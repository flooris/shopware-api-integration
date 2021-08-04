<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use stdClass;

class FeatureModel
{
    public string $name;
    public ?string $id;
    public string $type;
    public ?int $position;

    public function __construct(stdClass $data)
    {
        $this->name     = $data->name;
        $this->id       = $data->id;
        $this->type     = $data->type;
        $this->position = $data->position;
    }
}
