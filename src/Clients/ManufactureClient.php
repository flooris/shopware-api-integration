<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\ManufactureModel;

class ManufactureClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return ManufactureModel::class;
    }

    public function listModelClass(): string
    {
        return ManufactureModel::class;
    }

    public function baseUri(): string
    {
        return 'product-manufacturer';
    }

    public function showUri(): string
    {
        return 'product-manufacturer/%s';
    }

    public function associations(): ?array
    {
        return [

        ];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->products(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->manufacturers(limit: null, paginated: false);
    }

    public function create(
        ?string $id = null,
        string  $name,
        string  $description,
        bool $wantsResponse = true
    ): ?ManufactureModel
    {
        $response = $this->shopwareApi->connector()->post($this->baseUri(), [
            'id'          => $id,
            'name'        => $name,
            'description' => $description,
        ], [], [
            '_response' => $wantsResponse,
        ]);

        if(!$wantsResponse){
            return null;
        }

        return new $this->modelClass($response->data ?? $response);
    }

    public function update(string $id, string $name, string $description, bool $wantsResponse = false): ?ManufactureModel
    {
        $response = $this->shopwareApi->connector()->patch($this->showUri(), [
            'id'          => $id,
            'name'        => $name,
            'description' => $description,
        ], [$id], [
            '_response' => $wantsResponse,
        ]) ?? null;

        if(!$wantsResponse){
            return null;
        }

        return new $this->modelClass($response->data ?? $response);
    }
}
