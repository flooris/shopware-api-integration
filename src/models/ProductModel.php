<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use Illuminate\Support\Collection;

class ProductModel extends AbstractModel
{
    public string $id;
    public string $parentVersionId;
    public ?string $parentId;
    public string $sku;
    public ?string $name;
    public ?string $description;
    public array $availablePropertyIds;
    public array $properties;
    public array $customFields;
    public array $prices;
    public ?Collection $media;
    public ?string $featureSetId;

    function handleResponse(): void
    {
        $response                   = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id                   = $response->id;
        $this->parentVersionId      = $response->parentVersionId;
        $this->parentId             = $response->parentId;
        $this->sku                  = $response->productNumber;
        $this->name                 = $response->name;
        $this->description          = $response->description;
        $this->featureSetId         = $response->featureSetId;
        $this->availablePropertyIds = isset($response->propertyIds) ? $response->propertyIds : [];
        $this->properties           = $response->properties ?? [];
        $this->customFields         = (array)$response->customFields;
        $this->mapProperties();
        $this->setCurrency();
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
            $property = $propsWithOptions->firstWhere("id", $prop->groupId);
            if ($property) {
                return (object)[
                    "groupId"  => $prop->groupId,
                    "optionId" => $prop->id,
                    "name"     => $property->name,
                    "value"    => $prop->name,
                ];
            }
        }, $this->properties);
    }

    private function setCurrency(): void
    {
        $currency = $this->getClient()->getShopwareApi()->search()->currency(limit: null, paginated: false);

       if(isset($this->response->price)){
           $this->prices = collect($this->response->price)->map(function ($price) use ($currency) {
               $currency = $currency->firstWhere("id", $price->currencyId);

               return (object)[
                   "currency"  => $currency,
                   "salePrice" => $price->gross,
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
