<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class PaymentMethodModel extends AbstractModel
{
    public string $id;

    public string $name;
    public string $distinguishableName;
    public ?string $description;
    public int $position;
    public bool $active;
    public bool $afterOrderEnabled;
    public ?string $updatedAt;
    public string $createdAt;


    public function handleResponse(stdClass $response): void
    {
        $this->id                  = $response->id;
        $this->distinguishableName = $response->distinguishableName;
        $this->description         = $response->description;
        $this->position            = $response->position;
        $this->active              = $response->active;
        $this->afterOrderEnabled   = $response->afterOrderEnabled;
        $this->updatedAt           = $response->updatedAt;
        $this->createdAt           = $response->createdAt;
    }
}
