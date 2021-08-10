<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\OrderModel;

class OrderClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return OrderModel::class;
    }

    public function listModelClass(): string
    {
        return OrderModel::class;
    }

    public function baseUri(): string
    {
        return 'order';
    }

    public function showUri(): string
    {
        return 'order/%s';
    }

    public function associations(): ?array
    {
        return [
            'addresses',
            'billingAddress',
            'currency',
            'deliveries',
            'documents',
            'orderCustomer',
            'salesChannel',
            'transactions',
            'lineItems',
        ];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->order(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->order(limit: null, paginated: false);
    }
}
