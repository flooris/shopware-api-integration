<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\CountryModel;
use Flooris\ShopwareApiIntegration\Models\CurrencyModel;
use Flooris\ShopwareApiIntegration\Models\LanguageModel;

class LanguageClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return LanguageModel::class;
    }

    public function baseUri(): string
    {
        return 'language';
    }

    public function showUri(): string
    {
        return 'language/%s';
    }

    public function listModelClass(): string
    {
        return LanguageModel::class;
    }

    public function associations(): ?array
    {
        return ['locale'];
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
