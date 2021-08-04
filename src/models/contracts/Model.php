<?php

namespace Flooris\FloorisShopwareApiIntegration\models\contracts;

interface Model extends BaseModel
{
    public function __construct(Client $client,  ?\stdClass $response = null);
}
