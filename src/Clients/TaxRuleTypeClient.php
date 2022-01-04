<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\TaxModel;
use Flooris\ShopwareApiIntegration\Models\TaxRuleTypeModel;

class TaxRuleTypeClient extends AbstractBaseClient
{
    const ZIP_CODE_RANGE = 'zip_code_range';
    const ZIP_CODE = 'zip_code';
    const INDIVIDUAL_STATES = 'individual_states';
    const ENTIRE_COUNTRY = 'entire_country';

    public function modelClass(): string
    {
        return TaxRuleTypeModel::class;
    }

    public function listModelClass(): string
    {
        return TaxRuleTypeModel::class;
    }

    public function baseUri(): string
    {
        return 'tax-rule-type';
    }

    public function showUri(): string
    {
        return 'tax-rule-type/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list(int $limit = 25, int $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->tax(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->tax(limit: null, paginated: false);
    }
}
