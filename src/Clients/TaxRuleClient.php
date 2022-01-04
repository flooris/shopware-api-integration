<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\TaxRuleModel;

class TaxRuleClient extends AbstractBaseClient
{

    public function modelClass(): string
    {
        return TaxRuleModel::class;
    }

    public function listModelClass(): string
    {
        return TaxRuleModel::class;
    }

    public function baseUri(): string
    {
        return 'tax-rule';
    }

    public function showUri(): string
    {
        return 'tax-rule/%s';
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

    public function create(string $id, string $countryId, string $taxId, float $taxRate, string $taxRuleTypeId): void
    {
        $this->getShopwareApi()->connector()->post($this->baseUri(), [
            "countryId"     => $countryId,
            "id"            => $id,
            "taxId"         => $taxId,
            "taxRate"       => $taxRate,
            "taxRuleTypeId" => $taxRuleTypeId,
        ]);
    }
}
