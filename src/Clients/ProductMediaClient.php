<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\ProductMediaModel;

class ProductMediaClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return ProductMediaModel::class;
    }

    public function listModelClass(): string
    {
        return ProductMediaModel::class;
    }

    public function baseUri(): string
    {
        return 'product-media';
    }

    public function showUri(): string
    {
        return 'product-media/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->productMedia(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->productMedia(limit: null, paginated: false);
    }

    public function addProductImage(string $productId, string $mediaId): ProductMediaModel
    {
        return new $this->modelClass($this->getShopwareApi()->connector()->post($this->baseUri(), [
            'productId' => $productId,
            'mediaId'   => $mediaId,
        ], [], ['_response' => true]));
    }

    public function findByName(string $name)
    {
        return $this->all()->filter(function ($item) use ($name) {
            return str_contains(strtolower($item->name), strtolower($name));
        })->first();
    }

}
