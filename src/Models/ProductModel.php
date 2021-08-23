<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;
use Illuminate\Support\Collection;

class ProductModel extends AbstractModel
{
    public string $id;
    public string $versionId;
    public ?string $parentId;
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
    public ?array $categoryTree;
    public ?array $categories;
    public ?array $tagIds;
    public ?array $tags;

    public function handleResponse(stdClass $response): void
    {
        $this->id                   = $response->id;
        $this->versionId            = $response->versionId;
        $this->parentId             = $response->parentId;
        $this->sku                  = $response->productNumber;
        $this->name                 = $response->name;
        $this->description          = $response->description;
        $this->featureSet           = $response->featureSet;
        $this->featureSetId         = $response->featureSetId;
        $this->availablePropertyIds = $response->propertyIds ?? [];
        $this->properties           = $response->properties ?? [];
        $this->customFields         = (array)$response->customFields;
        $this->optionIds            = $response->optionIds;
        $this->categoryTree         = $response->categoryTree;
        $this->categories           = $response->categories;
        $this->tagIds               = $response->tagIds;
        $this->tags                 = $response->tags;
        $this->mapProperties();
        $this->setCurrency($response);
    }

    private function mapProperties(): void
    {
        if (empty($this->properties)) {
            return;
        }

        $propsWithOptions = $this->getClient()
            ->getShopwareApi()
            ->search()
            ->properties(limit: null, paginated: false);

        $this->properties = array_map(function ($prop) use ($propsWithOptions) {
            $property = $propsWithOptions->firstWhere('id', $prop->groupId);
            if ($property) {
                return (object)[
                    'groupId'  => $prop->groupId,
                    'optionId' => $prop->id,
                    'name'     => $property->name,
                    'value'    => $prop->name,
                ];
            }
        }, $this->properties);
    }

    private function setCurrency(stdClass $response): void
    {
        $currency = $this->getClient()->getShopwareApi()->search()->currency(limit: null, paginated: false);

        if (isset($response->price)) {
            $this->prices = collect($response->price)->map(function ($price) use ($currency) {
                $currency = $currency->firstWhere('id', $price->currencyId);

                return (object)[
                    'currency'  => $currency,
                    'salePrice' => $price->gross,
                ];
            })->toArray();
        }

        if (empty($this->prices)) {
            if (! $this->parentId) {
                return;
            }
            $parentProduct = $this->getClient()->find($this->parentId);
            if ($parentProduct) {
                $this->prices = $parentProduct->prices;
            }
        }
    }
}
