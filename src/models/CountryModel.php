<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class CountryModel extends AbstractModel
{
    public string $id;
    public string $name;
    public string $iso;

    function handleResponse(): void
    {
        $response   = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id   = $response->id;
        $this->name = $response->name;
        $this->iso  = $response->iso;
    }
}
