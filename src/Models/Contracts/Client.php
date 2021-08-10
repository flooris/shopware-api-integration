<?php

namespace Flooris\ShopwareApiIntegration\Models\Contracts;

use Flooris\ShopwareApiIntegration\ShopwareApi;

interface Client extends BaseClient
{
    public function __construct(ShopwareApi $shopwareApi, ?string $modelClass = null, ?string $listModelClass = null);
}
