<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;


use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\ProductVisibilityModel;

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
        return "product-visibility";
    }

    public function showUri(): string
    {
        return "product-visibility/%s";
    }

    public function associations(): ?array
    {
        return [];
    }

    function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->productVisibility(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->productVisibility(limit: null, paginated: false);
    }

    public function findByProduct(string $id): Collection
    {
        return $this->all()->where('productId', $id);
    }

    public function create(Collection $products, Collection $saleChannels): bool
    {
        $products->each(function ($product) use ($saleChannels) {
            $saleChannels->each(function ($saleChannel) use ($product) {
                $data        = [
                    "productId"        => $product->id,
                    "productVersionId" => $product->parentId,
                    "salesChannelId"   => $saleChannel->id,
                    "visibility"       => 30,
                ];
                $postRequest = $this->getShopwareApi()
                    ->connector()
                    ->post($this->baseUri(), $data, [], ["_response" => true]);
            });
        });

        return true;
    }
}
