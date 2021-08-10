<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\CustomerModel;

class CustomerClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return CustomerModel::class;
    }

    public function baseUri(): string
    {
        return 'customer';
    }

    public function showUri(): string
    {
        return 'customer/%s';
    }

    public function listModelClass(): string
    {
        return CustomerModel::class;
    }

    public function associations(): ?array
    {
        return [
            'addresses',
            'defaultBillingAddress',
            'defaultPaymentMethod',
            'defaultShippingAddress',
            'group',
            'lastPaymentMethod',
            'requestedGroup',
            'salesChannel',
            'salutation',
            'tags',
        ];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->customers(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->customers(limit: null, paginated: false);
    }
}
