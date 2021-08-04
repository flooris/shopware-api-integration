<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\PropertyGroupModel;

class PropertyGroupClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PropertyGroupModel::class;
    }

    public function baseUri(): string
    {
        return "property-group";
    }

    public function showUri(): string
    {
        return "property-group/%s";
    }

    public function listModelClass(): string
    {
        return PropertyGroupModel::class;
    }

    public function associations(): ?array
    {
        return [];
    }

    function list($limit = 25, $page = 1): \stdClass
    {
        return $this->getShopwareApi()->search()->propertyGroups(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->propertyGroups(limit: null, paginated: false);
    }
}
