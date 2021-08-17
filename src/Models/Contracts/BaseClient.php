<?php

namespace Flooris\ShopwareApiIntegration\Models\Contracts;


use Flooris\ShopwareApiIntegration\ShopwareApi;

interface BaseClient
{
    public function modelClass(): string;

    public function baseUri(): string;

    public function showUri(): string;

    public function find(string $id): Model;

    public function getShopwareApi(): ShopwareApi;

    public function destroy(string $id): bool;
}
