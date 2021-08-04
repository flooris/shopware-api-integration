<?php


namespace Flooris\FloorisShopwareApiIntegration\models;

class ProductVisibilityModel extends AbstractModel
{
    public string $id;
    public string $productId;

    function handleResponse(): void
    {
        $response        = isset($this->response->data) ? $this->response->data : $this->response;
        $this->id        = $response->id;
        $this->productId = $response->productId;
    }
}
