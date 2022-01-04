<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\PaymentMethodModel;

class PaymentMethodClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return PaymentMethodModel::class;
    }

    public function listModelClass(): string
    {
        return PaymentMethodModel::class;
    }

    public function baseUri(): string
    {
        return 'payment-method';
    }

    public function showUri(): string
    {
        return 'payment-method/%s';
    }

    public function associations(): ?array
    {
        return [];
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
        int $grossPrice,
        ?int $netPrice,
        string $currencyId,
        string $taxId,
        int $stock = 1,
        array $rawProductData = [],
    )
    {
        $linkedprices = $netPrice === null;

        if ($netPrice === null) {
            $netPrice = $this->getShopwareApi()
                ->calculatedTax()
                ->calculateNetPrice($currencyId, $grossPrice, $taxId)->priceWithoutTax;
        }

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
                    'linked'     => $linkedprices,
                    'net'        => $netPrice,
                ],
            ],
        ], $rawProductData), [], [
            '_response' => true,
        ]);
        $response = $response->data ?? $response;

        return new $this->modelClass($response);
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

        return new $this->modelClass($response);
    }
}
