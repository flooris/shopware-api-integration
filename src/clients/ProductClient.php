<?php


namespace Flooris\FloorisShopwareApiIntegration\clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\FloorisShopwareApiIntegration\models\ProductModel;
use Flooris\FloorisShopwareApiIntegration\models\ProductListModel;

class ProductClient extends AbstractBaseClient
{
    public function createVariants(array $optionIds, string $productId, int $stock = 0)
    {
        $data = $this->getShopwareApi()->connector()->bulk()->update([
            [
                "parentId"      => $productId,
                "stock"         => $stock,
                "productNumber" => strval(time()),
                "options"       => collect($optionIds)->map(function (string $id) {
                    return ["id" => $id];
                })->toArray(),
            ],
        ]);
        return $data->data[0]->result[0]->entities->product[0];
    }

    public function variants(): Collection
    {
        return $this->getShopwareApi()
            ->search()
            ->products(limit: null, paginated: false)
            ->filter(function (ProductListModel $product) {
                return $product->parentId;
            });
    }


    public function findBySku(string $searchTerm): ?ProductModel
    {
        $result = $this->getShopwareApi()
            ->search()
            ->products(term: $searchTerm, limit: 1, paginated: false);

        if($result->isEmpty()){
            return null;
        }

        return $result->first();
    }

    public function modelClass(): string
    {
        return ProductModel::class;
    }

    public function listModelClass(): string
    {
        return ProductListModel::class;
    }

    public function baseUri(): string
    {
        return "product";
    }

    public function showUri(): string
    {
        return "product/%s";
    }

    public function associations(): ?array
    {
        return [
            "properties",
            "prices",
            "categories",
            "visibilities",
            "cover",
            "options",
            "prices"
        ];
    }

    function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->products(limit: $limit, page: $page);
    }

    function all(): Collection
    {
        return $this->getShopwareApi()->search()->products(limit: null, paginated: false);
    }

    public function create(
        string $name,
        string $description,
        string $sku,
        int $purchasePrice,
        int $price,
        string $currencyId = "b7d2554b0ce847cd82f3ac9bd1c0dfca",
        string $taxId = "11686f273b5248aa989f911cd41fcd2a",
        $stock = 1,
        array $rawProductData = [],
    )
    {
        $response = $this->getShopwareApi()->connector()->post($this->baseUri(), array_merge([
            "name"           => $name,
            "description"    => $description,
            "active"         => true,
            "productNumber"  => $sku,
            "stock"          => $stock,
            "taxId"          => $taxId,
            "price"          => [
                [
                    "currencyId" => $currencyId,
                    "gross"      => $price,
                    "linked"     => false,
                    "net"        => $price,
                ],
            ],
            "purchasePrices" => [
                [
                    "currencyId" => $currencyId,
                    "gross"      => $purchasePrice,
                    "linked"     => false,
                    "net"        => $purchasePrice,
                ],
            ],
        ], $rawProductData), [], [
            "_response" => true,
        ]);
        $response = isset($response->data) ? $response->data : $response;

        return new $this->modelClass($this, $response);
    }

    public function updateCategory(Collection $products, Collection $categories): stdClass
    {
        $payload = $products->map(function (ProductListModel $product) use ($categories) {
            return [
                "id"         => $product->id,
                "categories" => $categories->map(function ($category) {
                    return [
                        "id" => $category->id,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return $this->updateBulk($payload);
    }

    public function updateBulk(array $payload, string $entity = "product"): stdClass
    {
        return $this->getShopwareApi()->connector()->bulk()->update($payload, $entity);
    }

    public function update(string $id, array $changes): ProductModel
    {
        $response = $this->getShopwareApi()
            ->connector()
            ->patch($this->showUri(), $changes, [$id], ["_response" => true]);

        return new $this->modelClass($this, $response);
    }
}
