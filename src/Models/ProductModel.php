<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Illuminate\Support\Collection;

class ProductModel extends AbstractModel
{
    public string $id;
    public string $versionId;
    public ?string $parentId;
    public ?string $taxId;
    public string $sku;
    public ?string $name;
    public ?string $description;
    public array $availablePropertyIds;
    public array $properties;
    public array $customFields;
    public array $prices;
    public ?Collection $media;
    public $featureSet;
    public ?string $featureSetId;
    public ?array $optionIds;
    public ?array $options;
    public ?array $categoryTree;
    public ?array $categories;
    public ?array $tagIds;
    public ?array $tags;

    public function handleResponse(stdClass $response): void
    {
        $this->id                   = $response->id;
        $this->versionId            = $response->versionId;
        $this->parentId             = $response->parentId;
        $this->taxId                = $response->taxId;
        $this->sku                  = $response->productNumber;
        $this->name                 = $response->name ?? $response->translated?->name;
        $this->description          = $response->description ?? $response->translated?->description;
        $this->featureSet           = $response->featureSet;
        $this->featureSetId         = $response->featureSetId;
        $this->availablePropertyIds = $response->propertyIds ?? [];
        $this->properties           = $response->properties ?? [];
        $this->customFields         = $response->customFields ? (array)$response->customFields : (array)$response->translated?->customFields;
        $this->optionIds            = $response->optionIds;
        $this->options              = $response->options;
        $this->categoryTree         = $response->categoryTree;
        $this->categories           = $response->categories;
        $this->tagIds               = $response->tagIds;
        $this->tags                 = $response->tags;
    }
}
