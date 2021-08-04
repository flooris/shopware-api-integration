<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\ShopwareApi;
use Flooris\FloorisShopwareApiIntegration\models\SalesChannelModel;
use Flooris\FloorisShopwareApiIntegration\ShopwareObjectApiAbstract;

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
        return "sales-channel";
    }

    public function showUri(): string
    {
        return "sales-channel/%s";
    }

    public function associations(): ?array
    {
       return [];
    }

    function list(int $limit = 25, int $page = 1): \stdClass
    {
        return $this->getShopwareApi()->search()->salesChannel(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->salesChannel(limit: null, paginated: false);
    }
}
