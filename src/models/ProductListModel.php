<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use Illuminate\Support\Collection;

class ProductListModel extends AbstractModel
{
    public string $id;
    public string $parentVersionId;
    public ?string $parentId;
    public string $sku;
    public ?string $name;
    public ?string $description;
    public array $availablePropertyIds;
    public array $customFields;
    public ?Collection $media;
    public array $categories;
    public ?array $optionIds;

    function handleResponse(): void
    {
        $this->id                   = $this->response->id;
        $this->parentVersionId      = $this->response->parentVersionId;
        $this->parentId             = $this->response->parentId;
        $this->sku                  = $this->response->productNumber;
        $this->name                 = $this->response->name;
        $this->description          = $this->response->description;
        $this->availablePropertyIds = isset($response->propertyIds) ? $response->propertyIds : [];
        $this->customFields         = (array)$this->response->customFields;
        $this->categories           = $this->response->categories;
        $this->optionIds            = $this->response->optionIds;
    }

    public function product(): contracts\Model
    {
        return $this->getClient()->getShopwareApi()->products()->find($this->id);
    }
}
