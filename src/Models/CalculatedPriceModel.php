<?php

namespace Flooris\ShopwareApiIntegration\Models;

use stdClass;

class CalculatedPriceModel
{
    public int|float $price;
    public int|float $taxRate;
    public int|float $taxAmount;
    public float $priceWithoutTax;

    public function __construct(?stdClass $response)
    {
        if ($response) {
            $this->handleResponse($response->data);
        }
    }

    public function handleResponse(stdClass $response): void
    {
        $this->price           = $response->calculatedTaxes[0]->price;
        $this->taxRate         = $response->calculatedTaxes[0]->taxRate;
        $this->taxAmount       = $response->calculatedTaxes[0]->tax;
        $this->priceWithoutTax = (float)$this->price - $this->taxAmount;
    }
}
