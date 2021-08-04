<?php

namespace Flooris\FloorisShopwareApiIntegration\models\contracts;


use Flooris\FloorisShopwareApiIntegration\ShopwareApi;

interface BaseClient
{
    public function modelClass(): string;

    public function baseUri(): string;

    public function showUri(): string;

    public function find(string $id): Model;

    public function getShopwareApi(): ShopwareApi;
}
