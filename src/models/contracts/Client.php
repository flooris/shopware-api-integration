<?php

namespace Flooris\FloorisShopwareApiIntegration\models\contracts;

use Flooris\FloorisShopwareApiIntegration\ShopwareApi;

interface Client extends BaseClient
{
    public function __construct(ShopwareApi $shopwareApi, ?string $modelclass = null, ?string $listModelclass = null);
}
