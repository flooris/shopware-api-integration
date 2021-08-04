<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\TaxModel;

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
        return "tax";
    }

    public function showUri(): string
    {
        return "tax/%s";
    }

    public function associations(): ?array
    {
        return [];
    }

    function list(int $limit = 25, int $page = 1): stdClass
    {
        return (object)[
            "feature not implemented",
        ];
    }

    function all(): Collection
    {
        return collect($this->getShopwareApi()
            ->connector()
            ->get($this->baseUri())->data)->map(function (stdClass $tax) {
            return new $this->modelClass($this, $tax);
        });
    }
}
