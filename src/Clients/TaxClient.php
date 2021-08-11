<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\TaxModel;

class TaxClient extends AbstractBaseClient
{

    public function modelClass(): string
    {
        return TaxModel::class;
    }

    public function listModelClass(): string
    {
        return TaxModel::class;
    }

    public function baseUri(): string
    {
        return 'tax';
    }

    public function showUri(): string
    {
        return 'tax/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->tax(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->tax(limit: null, paginated: false);
    }
}
