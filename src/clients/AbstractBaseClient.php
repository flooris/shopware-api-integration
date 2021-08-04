<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\ShopwareApi;
use Flooris\FloorisShopwareApiIntegration\models\contracts\Model;
use Flooris\FloorisShopwareApiIntegration\models\contracts\Client;

abstract class AbstractBaseClient implements Client
{
    protected string $modelClass;
    protected ?string $listModelClass;
    protected ShopwareApi $shopwareApi;

    public function __construct(ShopwareApi $shopwareApi, ?string $modelClass = null, ?string $modelListClass = null)
    {
        $this->setShopwareApi($shopwareApi);
        $this->setModelClass($modelClass);
    }

    abstract public function modelClass(): string;

    abstract public function listModelClass(): string;

    abstract public function baseUri(): string;

    abstract public function showUri(): string;

    abstract public function associations(): ?array;

    private function setModelClass(?string $modelClass): void
    {
        $modelClassToSet  = $modelClass ?? $this->modelClass();
        $this->modelClass = $modelClassToSet;
    }

    private function setListModelClass(?string $listModelClass): void
    {
        $listModelClassToSet  = $listModelClass ?? $this->listModelClass();
        $this->listModelClass = $listModelClassToSet;
    }

    private function setShopwareApi(ShopwareApi $shopwareApi): void
    {
        $this->shopwareApi = $shopwareApi;
    }

    public function getShopwareApi(): ShopwareApi
    {
        return $this->shopwareApi;
    }

    public function find(string $id): Model
    {
        return $this->getShopwareApi()->search()->custom(client: $this, ids: $id)->first();
    }

    abstract function list(int $limit = 25, int $page = 1): stdClass;

    abstract function all(): Collection;
}
