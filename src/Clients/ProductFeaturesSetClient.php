<?php

namespace Flooris\ShopwareApiIntegration\Clients;

use stdClass;
use Illuminate\Support\Collection;
use Flooris\ShopwareApiIntegration\Models\FeatureModel;
use Flooris\ShopwareApiIntegration\Models\ProductFeatureSetModel;

class ProductFeaturesSetClient extends AbstractBaseClient
{
    public function modelClass(): string
    {
        return ProductFeatureSetModel::class;
    }

    public function listModelClass(): string
    {
        return ProductFeatureSetModel::class;
    }

    public function baseUri(): string
    {
        return 'product-feature-set';
    }

    public function showUri(): string
    {
        return 'product-feature-set/%s';
    }

    public function associations(): ?array
    {
        return [];
    }

    public function list($limit = 25, $page = 1): stdClass
    {
        return $this->getShopwareApi()->search()->productFeatureSet(limit: $limit, page: $page);
    }

    public function all(): Collection
    {
        return $this->getShopwareApi()->search()->productFeatureSet(limit: null, paginated: false);
    }

    public function create(string $name, string $description, array $features)
    {
        return $this->getShopwareApi()->connector()->post($this->baseUri(), [
            'name'        => $name,
            'description' => $description,
            'features'    => $features,
        ]);
    }
}
