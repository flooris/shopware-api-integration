<?php


namespace Flooris\FloorisShopwareApiIntegration\models;


use Flooris\FloorisShopwareApiIntegration\ShopwareApi;

abstract class ShopwareAbstractModel
{
    public function __construct(private ShopwareApi $shopwareApi, public ?\stdClass $response)
    {
        if ($response){
            $this->handleResponse();
        }
    }

    abstract public function handleResponse(): void;

    public function getShopwareClient():ShopwareApi
    {
     return $this->shopwareApi;
    }
}
