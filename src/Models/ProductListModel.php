<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Illuminate\Support\Collection;

class ProductListModel extends AbstractModel
{
    public string $id;
    public string $versionId;
    public ?string $parentId;
    public ?string $taxId;
    public string $sku;
    public ?string $name;
    public ?string $description;
    public array $availablePropertyIds;
    public array $customFields;
    public ?Collection $media;
    public array $categories;
    public ?array $optionIds;

    public function handleResponse(stdClass $response): void
    {
        $this->id                   = $response->id;
        $this->versionId            = $response->versionId;
        $this->parentId             = $response->parentId;
        $this->sku                  = $response->productNumber;
        $this->name                 = $response->name;
        $this->description          = $response->description;
        $this->availablePropertyIds = $response->propertyIds ?? [];
        $this->customFields         = (array)$response->customFields;
        $this->categories           = $response->categories;
        $this->optionIds            = $response->optionIds;
        $this->taxId                = $response->taxId;
    }

    public function product(): Contracts\Model
    {
        return $this->getClient()->getShopwareApi()->product()->find($this->id);
    }
}
