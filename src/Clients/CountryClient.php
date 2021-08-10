<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\CountryModel;
use Flooris\ShopwareApiIntegration\Models\CurrencyModel;

class CountryClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return CountryModel::class;
    }

    public function baseUri(): string
    {
        return 'country';
    }

    public function showUri(): string
    {
        return 'country/%s';
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
        return $this->getShopwareApi()->search()->country(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->country(limit: null, paginated: false);
    }
}
