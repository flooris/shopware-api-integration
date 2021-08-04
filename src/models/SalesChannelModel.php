<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


class SalesChannelModel extends AbstractModel
{
    public string $id;
    public string $name;

    function handleResponse(): void
    {
        $response   = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id   = $response->id;
        $this->name = $response->name;
    }
}
