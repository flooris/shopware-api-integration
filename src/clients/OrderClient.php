<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\OrderModel;

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
        return "order";
    }

    public function showUri(): string
    {
        return "order/%s";
    }

    public function associations(): ?array
    {
        return [
            "addresses",
            "billingAddress",
            "currency",
            "deliveries",
            "documents",
            "orderCustomer",
            "salesChannel",
            "transactions",
            "lineItems"
        ];
    }

    function list(int $limit = 25, int $page = 1): stdClass
    {
        return (object)[
            "feature not implemented",
        ];
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->order(limit: null, paginated: false);
    }
}
