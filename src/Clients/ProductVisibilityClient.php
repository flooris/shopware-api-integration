<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\ProductVisibilityModel;

class ProductVisibilityClient extends AbstractBaseClient
{

    public function modelClass(): string
    {
        return ProductVisibilityModel::class;
    }

    public function listModelClass(): string
    {
        return ProductVisibilityModel::class;
    }

    public function baseUri(): string
    {
        return 'product-visibility';
    }

    public function showUri(): string
    {
        return 'product-visibility/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->productVisibility(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->productVisibility(limit: null, paginated: false);
    }

    public function findByProductId(string $id): Collection
    {
        return $this->all()->where('productId', $id);
    }

    public function create(Collection $products, Collection $saleChannels, int $visibility = 30): bool
    {
        $products->each(function ($product) use ($saleChannels, $visibility) {
            $saleChannels->each(function ($saleChannel) use ($product, $visibility) {
                $data = [
                    'productId'        => $product->id,
                    'productVersionId' => $product->parentId,
                    'salesChannelId'   => $saleChannel->id,
                    'visibility'       => $visibility,
                ];
                $this->getShopwareApi()
                    ->connector()
                    ->post($this->baseUri(), $data, [], ['_response' => true]);
            });
        });

        return true;
    }
}
