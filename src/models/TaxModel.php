<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class TaxModel extends AbstractModel
{
    public string $id;
    public string $name;
    public int $taxRate;


    public function handleResponse(): void
    {
        $response      = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id      = $response->id;
        $this->name    = $response->name;
        $this->taxRate = $response->taxRate;
    }
}
