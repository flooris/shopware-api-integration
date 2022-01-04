<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\LocaleModel;
use Flooris\ShopwareApiIntegration\Models\CountryModel;
use Flooris\ShopwareApiIntegration\Models\CurrencyModel;
use Flooris\ShopwareApiIntegration\Models\LanguageModel;

class LocaleClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return LocaleModel::class;
    }

    public function baseUri(): string
    {
        return 'locale';
    }

    public function showUri(): string
    {
        return 'locale/%s';
    }

    public function listModelClass(): string
    {
        return LocaleModel::class;
    }

    public function associations(): ?array
    {
        return ['languages'];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->language(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->language(limit: null, paginated: false);
    }
}
