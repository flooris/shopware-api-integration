<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\CurrencyModel;

class CurrencyClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return CurrencyModel::class;
    }

    public function baseUri(): string
    {
        return 'currency';
    }

    public function showUri(): string
    {
        return 'currency/%s';
    }

    public function listModelClass(): string
    {
        return CurrencyModel::class;
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->currency(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->currency(limit: null, paginated: false);
    }
}
