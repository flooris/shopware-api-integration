<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\SalesChannelModel;

class SalesChannelClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return SalesChannelModel::class;
    }

    public function listModelClass(): string
    {
        return SalesChannelModel::class;
    }

    public function baseUri(): string
    {
        return 'sales-channel';
    }

    public function showUri(): string
    {
        return 'sales-channel/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->salesChannel(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->salesChannel(limit: null, paginated: false);
    }
}
