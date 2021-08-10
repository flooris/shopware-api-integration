<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\PropertyGroupModel;

class PropertyGroupClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PropertyGroupModel::class;
    }

    public function baseUri(): string
    {
        return 'property-group';
    }

    public function showUri(): string
    {
        return 'property-group/%s';
    }

    public function listModelClass(): string
    {
        return PropertyGroupModel::class;
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->propertyGroups(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->propertyGroups(limit: null, paginated: false);
    }
}
