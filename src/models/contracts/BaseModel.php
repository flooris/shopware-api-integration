<?php

namespace Flooris\FloorisShopwareApiIntegration\models\contracts;


interface BaseModel
{
    public function clientClass(): string;
    public function getClient();
    public function find(string $id): Model;
}
