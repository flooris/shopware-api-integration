<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class CurrencyModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $nameShort;
    public string $symbol;

    function handleResponse(): void
    {
        $response   = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id   = $response->id;
        $this->name = $response->name;
        $this->nameShort = $response->shortName;
        $this->symbol = $response->symbol;
    }
}
