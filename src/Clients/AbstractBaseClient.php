<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Flooris\ShopwareApiIntegration\ShopwareApi;
use Flooris\ShopwareApiIntegration\Models\Contracts\Model;
use Flooris\ShopwareApiIntegration\Models\Contracts\Client;

abstract class AbstractBaseClient implements Client
{
    public function __construct(protected ShopwareApi $shopwareApi, protected ?string $modelClass = null, protected ?string $modelListClass = null)
    {
        $this->setModelClass($modelClass);
    }

    abstract public function modelClass(): string;

    abstract public function listModelClass(): string;

    abstract public function baseUri(): string;

    abstract public function showUri(): string;

    abstract public function associations(): ?array;

    private function setModelClass(?string $modelClass): void
    {
        $this->modelClass = $modelClass ?? $this->modelClass();
    }

    public function getShopwareApi(): ShopwareApi
    {
        return $this->shopwareApi;
    }

    public function find(string $id): ?Model
    {
        return $this->getShopwareApi()->search()->custom(client: $this, id: $id)->first();
    }

    public function destroy(string $id): bool
    {
        try {
            $this->getShopwareApi()->connector()->delete($this->showUri(), [$id]);
        }catch (GuzzleException $e){
            return false;
        }

        return true;
    }

    abstract public function list(int $limit = 25, int $page = 1): stdClass;

    abstract public function all(): Collection;
}
