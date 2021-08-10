<?php

namespace Flooris\ShopwareApiIntegration\Models\Contracts;


interface BaseModel
{
    public function clientClass(): string;

    public function getClient();

    public function find(string $id): Model;
}
