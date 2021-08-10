<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\ProductModel;
use Flooris\ShopwareApiIntegration\Models\ProductListModel;

class ProductClient extends AbstractBaseClient
{
    public function createVariants(array $optionIds, string $productId, int $stock = 0)
    {
        $data = $this->getShopwareApi()->connector()->bulk()->update([
            [
                'parentId'      => $productId,
                'stock'         => $stock,
                'productNumber' => (string)time(),
                'options'       => collect($optionIds)->map(function (string $id) {
                    return ['id' => $id];
                })->toArray(),
            ],
        ]);

        return $data->data[0]->result[0]->entities->product[0];
    }

    public function variants(): Collection
    {
        return $this->getShopwareApi()->search()->addQuery('or', 'not', [
            [
                'field' => 'product.optionIds',
                'type'  => 'equals',
                'value' => null,
            ],
            [
                'field' => 'product.parentId',
                'type'  => 'equals',
                'value' => null,
            ],
        ],
        )->products(limit: null, paginated: false);
    }


    public function findBySku(string $searchTerm): ?ProductModel
    {
        $result = $this->getShopwareApi()
            ->search()
            ->products(term: $searchTerm, limit: 1, paginated: false);

        if ($result->isEmpty()) {
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
        return 'product';
    }

    public function showUri(): string
    {
        return 'product/%s';
    }

    public function associations(): ?array
    {
        return [
            'categories',
            'cover',
            'options',
            'prices',
            'prices',
            'properties',
            'visibilities',
        ];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->products(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->products(limit: null, paginated: false);
    }

    public function create(
        string $name,
        string $description,
        string $sku,
        int    $grossPrice,
        ?int   $netPrice,
        string $currencyId,
        string $taxId,
        int    $stock = 1,
        array  $rawProductData = [],
    )
    {
        /**
         * @todo Add linked price to this.
         * There is an endpoint available to calculate this, incase it doesn't calculate it when it's linked
         * api/_action/calculate-price
         * Fields:
         *  - currencyId
         *  - output
         *  - price
         *  - taxId
         */
        $response = $this->getShopwareApi()->connector()->post($this->baseUri(), array_merge([
            'name'          => $name,
            'description'   => $description,
            'active'        => true,
            'productNumber' => $sku,
            'stock'         => $stock,
            'taxId'         => $taxId,
            'price'         => [
                [
                    'currencyId' => $currencyId,
                    'gross'      => $grossPrice,
                    'linked'     => false,
                    'net'        => $netPrice,
                ],
            ],
        ], $rawProductData), [], [
            '_response' => true,
        ]);
        $response = $response->data ?? $response;

        return new $this->modelClass($this, $response);
    }

    public function updateCategory(Collection $products, Collection $categories): stdClass
    {
        $payload = $products->map(function (ProductListModel $product) use ($categories) {
            return [
                'id'         => $product->id,
                'categories' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return $this->updateBulk($payload);
    }

    public function updateBulk(array $payload, string $entity = 'product'): stdClass
    {
        return $this->getShopwareApi()->connector()->bulk()->update($payload, $entity);
    }

    public function update(string $id, array $changes): ProductModel
    {
        $response = $this->getShopwareApi()
            ->connector()
            ->patch($this->showUri(), $changes, [$id], ['_response' => true]);

        return new $this->modelClass($this, $response);
    }
}
