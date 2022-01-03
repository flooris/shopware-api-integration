<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use Flooris\ShopwareApiIntegration\ShopwareApi;
use Flooris\ShopwareApiIntegration\Models\CalculatedPriceModel;

class CalculatedTaxClient
{
    public function __construct(protected ShopwareApi $shopwareApi, protected ?string $modelClass = null, protected ?string $modelListClass = null)
    {
        $this->setModelClass($modelClass);
    }

    public function calculatePrice(string $currencyId, float|int $grossPrice, string $taxId, string $output = 'gross'): CalculatedPriceModel
    {
        return new $this->modelClass($this->getShopwareApi()->connector()->post($this->baseUri(), [
            'currencyId' => $currencyId,
            'output'     => $output,
            'price'      => $grossPrice,
            'taxId'      => $taxId,
        ]));
    }

    private function setModelClass(?string $modelClass): void
    {
        $this->modelClass = $modelClass ?? $this->modelClass();
    }

    public function getShopwareApi(): ShopwareApi
    {
        return $this->shopwareApi;
    }

    public function modelClass(): string
    {
        return CalculatedPriceModel::class;
    }

    public function baseUri(): string
    {
        return '_action/calculate-price';
    }
}
